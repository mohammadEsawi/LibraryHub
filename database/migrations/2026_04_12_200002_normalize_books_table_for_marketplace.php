<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('books')) {
            DB::statement('ALTER TABLE books RENAME TO books_legacy');
        }

        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->year('published_year');
            $table->integer('pages');
            $table->boolean('published')->default(false);
            $table->boolean('available')->default(true);
            $table->decimal('price', 10, 2)->default(0);
            $table->foreignId('listed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        if (Schema::hasTable('books_legacy')) {
            $legacyBooks = DB::select('SELECT rowid as legacy_id, author_id, category_id, title, published_year, pages, published, created_at, updated_at FROM books_legacy');

            foreach ($legacyBooks as $legacyBook) {
                DB::table('books')->insert([
                    'id' => $legacyBook->legacy_id,
                    'author_id' => $legacyBook->author_id,
                    'category_id' => $legacyBook->category_id,
                    'title' => $legacyBook->title,
                    'published_year' => $legacyBook->published_year,
                    'pages' => $legacyBook->pages,
                    'published' => (bool) $legacyBook->published,
                    'available' => true,
                    'price' => 0,
                    'listed_by_user_id' => null,
                    'created_at' => $legacyBook->created_at,
                    'updated_at' => $legacyBook->updated_at,
                ]);
            }

            Schema::drop('books_legacy');
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropConstrainedForeignId('listed_by_user_id');
            $table->dropColumn(['available', 'price']);
        });
    }
};
