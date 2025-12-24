<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // ルーティング用キー
            $table->string('display_name');
            $table->string('banner_path')->nullable(); // バナー画像のパス
            $table->text('profile')->nullable();
            $table->json('links')->nullable(); // SNSとかのリンク情報をJSONで保存
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
