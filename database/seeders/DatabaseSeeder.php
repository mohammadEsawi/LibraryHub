<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Purchase;
use App\Models\ReadingList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate([
            'role' => 'admin',
        ], [
            'name' => 'Platform Admin',
            'email' => 'mhmd@gmail.com',
            'phone' => '0598032500',
            'role' => 'admin',
            'password' => 'password',
        ]);

        // Create test users
        $reader = User::updateOrCreate([
            'email' => 'reader@libraryhub.test',
        ], [
            'name' => 'Reader User',
            'role' => 'reader',
            'phone' => '0501234567',
            'password' => 'password',
        ]);

        $customer = User::updateOrCreate([
            'email' => 'customer@libraryhub.test',
        ], [
            'name' => 'Customer User',
            'role' => 'customer',
            'phone' => '0509876543',
            'password' => 'password',
        ]);

        $author = User::updateOrCreate([
            'email' => 'author@libraryhub.test',
        ], [
            'name' => 'Author User',
            'role' => 'author',
            'phone' => '0505555555',
            'password' => 'password',
        ]);

        // Create categories
        $categories = Category::factory(8)->create();

        // Create authors
        $authors = Author::factory(20)->create();

        // Create books with variations
        $books = [];
        foreach (range(1, 50) as $i) {
            $isPremium = $i % 3 !== 0; // 2/3 premium, 1/3 free
            $books[] = Book::create([
                'author_id' => $authors->random()->id,
                'category_id' => $categories->random()->id,
                'title' => 'كتاب ' . fake()->sentence(3),
                'published_year' => fake()->year(),
                'pages' => fake()->numberBetween(100, 600),
                'published' => true,
                'available' => true,
                'price' => $isPremium ? fake()->randomFloat(2, 15, 150) : 0,
                'listed_by_user_id' => $admin->id,
                'created_at' => now()->subDays(rand(0, 60)),
            ]);
        }

        // Create purchases for customer
        foreach (range(1, 8) as $i) {
            $book = collect($books)->random();
            if ($book->price > 0) {
                Purchase::create([
                    'user_id' => $customer->id,
                    'book_id' => $book->id,
                    'price_paid' => $book->price,
                    'purchased_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        // Create reading list entries
        foreach (range(1, 12) as $i) {
            ReadingList::create([
                'user_id' => $reader->id,
                'book_id' => collect($books)->random()->id,
                'created_at' => now()->subDays(rand(0, 45)),
            ]);
        }

        // Create additional test users with mixed roles
        User::factory()->count(5)->create(['role' => 'customer']);
        User::factory()->count(3)->create(['role' => 'reader']);
        User::factory()->count(2)->create(['role' => 'author']);
    }
}
