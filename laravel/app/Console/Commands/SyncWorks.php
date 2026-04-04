<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncWorks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'works:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '画像ディレクトリ(public/img/members)を巡回し、ファイル名規則に従ってDBのworksを同期します';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $baseDir = public_path('img/members');
        if (!File::isDirectory($baseDir)) {
            $this->error("画像ディレクトリが見つかりません: {$baseDir}");
            return Command::FAILURE;
        }

        $directories = File::directories($baseDir);
        $synced = 0;

        $this->info('作品ディレクトリの同期を開始します...');

        foreach ($directories as $dir) {
            $slug = basename($dir);

            // メンバーが未登録の場合は自動で登録（最低限の情報で）
            $memberId = DB::table('members')->where('slug', $slug)->value('id');
            if (!$memberId) {
                DB::table('members')->insert([
                    'slug' => $slug,
                    'display_name' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $memberId = DB::table('members')->where('slug', $slug)->value('id');
                $this->info("新しいメンバーを自動登録しました: {$slug}");
            }

            $images = File::files($dir);
            foreach ($images as $image) {
                $ext = strtolower($image->getExtension());
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'txt', 'pdf', 'md'])) {
                    continue;
                }

                $fileBase = $image->getFilenameWithoutExtension();
                $parsedInfo = $this->parseWorkFilename($fileBase, $slug);
                $workSlug = $parsedInfo['slug'];
                $workTitle = $parsedInfo['title'];
                $workType = $parsedInfo['type'] ?? '0'; // デフォルトはイラスト(0)
                $isAdult = $parsedInfo['is_adult'] ?? false;

                $workCategoryId = null;
                if ($parsedInfo['category_flag'] !== null) {
                    $categoryName = $parsedInfo['category_flag'] === '0' ? '原作軸' : '現パロ';
                    $workCategoryId = DB::table('categories')
                        ->where('name', $categoryName)
                        ->where('type', $workType)
                        ->value('id');
                }

                $assetPath = "img/members/{$slug}/" . $image->getFilename();

                DB::table('works')->upsert(
                    [[
                        'slug' => $workSlug,
                        'member_id' => $memberId,
                        'category_id' => $workCategoryId,
                        'title' => $workTitle,
                        'type' => $workType,
                        'is_adult' => $isAdult,
                        'asset_path' => $assetPath,
                        'summary' => null,
                        'published_at' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]],
                    ['slug'],
                    ['member_id', 'category_id', 'title', 'type', 'is_adult', 'asset_path', 'updated_at']
                );
                $synced++;
            }
        }

        $this->info("同期完了: {$synced}件の作品を処理しました。");
        return Command::SUCCESS;
    }

    /**
     * ファイル名をパースし、各属性を取り出す
     */
    private function parseWorkFilename(string $fileBase, string $memberSlug): array
    {
        // 新形式: {memberSlug}_{number}_{type}_{isAdult}_{categoryFlag}_{titlePart}
        if (preg_match('/^(.+?)_(\\d+?)_([01])_([01])_([01])_(.+)$/u', $fileBase, $m)) {
            return [
                'slug' => "{$memberSlug}_{$m[2]}",
                'type' => $m[3],
                'is_adult' => $m[4] === '1',
                'category_flag' => $m[5],
                'title' => $m[6],
            ];
        }

        // 旧形式: {memberSlug}_{number}_{titlePart}
        if (preg_match('/^(.+?)_(\\d+?)_(.+)$/u', $fileBase, $m)) {
            return [
                'slug' => "{$memberSlug}_{$m[2]}",
                'type' => null,
                'is_adult' => null,
                'category_flag' => null,
                'title' => $m[3],
            ];
        }

        // 想定外形式の場合のフォールバック
        return [
            'slug' => "{$memberSlug}_" . substr(md5($fileBase), 0, 6),
            'type' => null,
            'is_adult' => null,
            'category_flag' => null,
            'title' => $fileBase,
        ];
    }
}
