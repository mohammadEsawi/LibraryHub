<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('author_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->year('published_year')->nullable();
            $table->integer('pages')->default(1);
            $table->decimal('proposed_price', 10, 2);
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('approved_book_id')->nullable()->constrained('books')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('author_submissions');
    }
};
