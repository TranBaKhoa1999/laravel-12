<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $categories = [
            1 => ['name' => 'Điện thoại', 'image' => 'images/product/dienthoai.jpg'],
            2 => ['name' => 'Laptop', 'image' => 'images/product/laptop.jpg'],
            3 => ['name' => 'Máy tính bảng', 'image' => 'images/product/maytinhbang.jpg'],
        ];

        $products = [];

        foreach ($categories as $categoryId => $category) {
            for ($i = 1; $i <= 10; $i++) {
                $name = "{$category['name']} Sản phẩm $i";
                $products[] = [
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . $i,
                    'description' => "Mô tả cho $name",
                    'price' => rand(5000000, 30000000),
                    'stock' => rand(10, 100),
                    'sku' => strtoupper(Str::random(10)),
                    'image' => $category['image'],
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('products')->insert($products);
    }
}