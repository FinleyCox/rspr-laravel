<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class ImportMembers extends Command
{
    protected $signature = 'members:import {filename?}';
    protected $description = 'CSVからmembers/worksを取り込む';

    public function handle(): int
    {
        $baseDir = public_path('members_csv');
        if (! File::isDirectory($baseDir)) {
            $this->error("CSVディレクトリがありません: {$baseDir}");
            return Command::FAILURE;
        }

        $targetFile = $this->resolveTargetFile($baseDir, $this->argument('filename'));
        if (! $targetFile) {
            $this->info('処理対象のCSVがありません（_done付きは除外）。');
            return Command::SUCCESS;
        }

        $this->info("読込ファイル: {$targetFile}");
        $handle = fopen($targetFile, 'r');
        if ($handle === false) {
            $this->error('CSVを開けませんでした。');
            return Command::FAILURE;
        }

        // 区切り文字はタブ優先で自動判定
        $firstLine = fgets($handle);
        if ($firstLine === false) {
            $this->error('CSVが空です。');
            fclose($handle);
            return Command::FAILURE;
        }
        $delimiter = str_contains($firstLine, "\t") ? "\t" : ',';
        $header = array_map('trim', str_getcsv($firstLine, $delimiter));
        $indexes = array_flip($header);

        $required = ['slug', 'display_name'];
        foreach ($required as $col) {
            if (! isset($indexes[$col])) {
                $this->error("必須ヘッダーが不足しています: {$col}");
                fclose($handle);
                return Command::FAILURE;
            }
        }

        $imported = 0;
        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (count($row) === 1 && trim($row[0]) === '') {
                continue;
            }
            $slug = trim($row[$indexes['slug']] ?? '');
            if ($slug === '') {
                $this->warn('slugが空行をスキップしました。');
                continue;
            }

            $displayName = trim($row[$indexes['display_name']] ?? $slug);
            $bannerPath = trim($row[$indexes['banner_path']] ?? '');
            $categorySlug = isset($indexes['category_slug']) ? trim($row[$indexes['category_slug']] ?? '') : '';
            $categoryId = null;
            if ($categorySlug !== '') {
                $categoryId = DB::table('categories')->where('slug', $categorySlug)->value('id');
                if (! $categoryId) {
                    $this->warn("category_slug が見つかりません: {$categorySlug}（行を継続します）");
                }
            }
            $links = [
                'twitter' => trim($row[$indexes['links_twitter']] ?? ''),
                'pixiv' => trim($row[$indexes['links_pixiv']] ?? ''),
                'site' => trim($row[$indexes['links_site']] ?? ''),
            ];
            $links = array_filter($links); // 空は除外

            DB::transaction(function () use ($slug, $displayName, $bannerPath, $links, $categoryId, &$imported) {
                DB::table('members')->upsert(
                    [[
                        'slug' => $slug,
                        'display_name' => $displayName,
                        'banner_path' => $bannerPath ?: null,
                        'links' => $links ? json_encode($links, JSON_UNESCAPED_UNICODE) : null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]],
                    ['slug'],
                    ['display_name', 'banner_path', 'links', 'updated_at']
                );

                $memberId = DB::table('members')->where('slug', $slug)->value('id');
                if (! $memberId) {
                    throw new RuntimeException("member_id取得に失敗: {$slug}");
                }

                // 画像ディレクトリから自動で作品を登録（illustration=0固定）
                $imgDir = public_path("img/members/{$slug}");
                if (File::isDirectory($imgDir)) {
                    $images = File::files($imgDir);
                    foreach ($images as $image) {
                        $ext = strtolower($image->getExtension());
                        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                            continue;
                        }
                        $fileBase = $image->getFilenameWithoutExtension();
                        $workSlug = Str::slug("{$slug}-{$fileBase}");
                        $assetPath = "img/members/{$slug}/" . $image->getFilename();
                        $workType = '0'; // 0=illustration, 1=novel
                        DB::table('works')->upsert(
                            [[
                                'slug' => $workSlug,
                                'member_id' => $memberId,
                                'category_id' => $categoryId, // CSVで指定があれば上書き
                                'title' => $fileBase,
                                'type' => $workType,
                                'asset_path' => $assetPath,
                                'summary' => null,
                                'published_at' => null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]],
                            ['slug'],
                            ['member_id', 'category_id', 'title', 'type', 'asset_path', 'summary', 'published_at', 'updated_at']
                        );
                    }
                }
                $imported++;
            });
        }
        fclose($handle);

        $donePath = $this->markDone($targetFile);

        $this->info("インポート完了: {$imported}件。ファイルを {$donePath} にリネームしました。");
        return Command::SUCCESS;
    }

    private function resolveTargetFile(string $baseDir, ?string $filename): ?string
    {
        if ($filename) {
            $candidate = Str::endsWith($filename, '.csv') ? $filename : "{$filename}.csv";
            $candidatePath = $baseDir . DIRECTORY_SEPARATOR . $candidate;
            if (! File::exists($candidatePath)) {
                $this->error("指定ファイルが見つかりません: {$candidatePath}");
                return null;
            }
            return $candidatePath;
        }

        $files = collect(File::files($baseDir))
            ->filter(fn ($f) => Str::endsWith($f->getFilename(), '.csv') && ! str_contains($f->getFilename(), '_done'))
            ->sortBy(fn ($f) => $f->getCTime());

        return optional($files->first())->getPathname();
    }

    private function markDone(string $targetFile): string
    {
        // _done.csvへのリネームを行う
        $doneName = preg_replace('/\.csv$/i', '', basename($targetFile)) . '_done.csv';
        $donePath = dirname($targetFile) . DIRECTORY_SEPARATOR . $doneName;
        if (File::exists($donePath)) {
            $donePath = dirname($targetFile) . DIRECTORY_SEPARATOR . $doneName . '_' . now()->format('YmdHis');
        }
        File::move($targetFile, $donePath);
        return $donePath;
    }
}
