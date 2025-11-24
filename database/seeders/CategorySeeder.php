<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Điện thoại', 'description' => 'Các loại điện thoại mới nhất'],
            ['name' => 'Laptop', 'description' => 'Laptop từ các thương hiệu nổi tiếng'],
            ['name' => 'Máy tính bảng', 'description' => 'Máy tính bảng các hãng'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}