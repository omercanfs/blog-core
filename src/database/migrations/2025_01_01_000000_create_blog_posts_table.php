<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Kategoriler Tablosu
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // SEO URL için
            $table->timestamps();
        });

        // 2. Yazılar Tablosu (Güncel)
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable(); // Resim yolu
            $table->text('content');
            
            // --- YENİ EKLENEN SÜTUN ---
            $table->unsignedBigInteger('view_count')->default(0); // Görüntülenme sayısı (Varsayılan 0)
            // --------------------------

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('blog_categories');
    }
};