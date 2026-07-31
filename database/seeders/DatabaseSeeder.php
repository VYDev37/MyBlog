<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
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
        User::factory()->create([
            'name' => 'admin ril',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 2
        ]);

        $categories = [
            'Technology',
            'Crypto',
            'Web3',
            'AI',
            'Stocks'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Post::factory(10)->create();
    }
}
