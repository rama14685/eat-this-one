<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dimsum = Category::create(['name' => 'Dimsum Series', 'slug' => 'dimsum-series']);
        $cookies = Category::create(['name' => 'Cookies & Ice Cream', 'slug' => 'cookies-ice-cream']);

        $products = [
            [
                'category_id' => $dimsum->id,
                'name' => 'Siomay Spesial',
                'slug' => 'siomay-spesial',
                'price' => 25000,
                'stock' => 50,
                'description' => 'Siomay lembut isi udang dan daging ayam pilihan.',
                'full_description' => 'Siomay premium dengan isian udang segar dan daging ayam pilihan, dibungkus kulit yang tipis dan lembut. Cocok untuk sarapan atau camilan sore.',
                'size' => '6x5.5 cm',
                'thickness' => '5 cm',
                'topping' => 'Saus kacang, kecap manis',
                'badge' => 'Best Seller',
                'image' => 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=400',
                'is_active' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Hakau Udang',
                'slug' => 'hakau-udang',
                'price' => 30000,
                'stock' => 40,
                'description' => 'Hakau kulit transparan isi udang segar pilihan.',
                'full_description' => 'Hakau dengan kulit transparan yang tipis dan kenyal, berisi udang segar utuh yang manis dan juicy. Teknik memasak dikukus sempurna.',
                'size' => '5x4 cm',
                'thickness' => '4 cm',
                'topping' => 'Saus tiram',
                'badge' => 'Special',
                'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?w=400',
                'is_active' => true,
            ],
            [
                'category_id' => $dimsum->id,
                'name' => 'Dimsum Ayam Jamur',
                'slug' => 'dimsum-ayam-jamur',
                'price' => 22000,
                'stock' => 0,
                'description' => 'Paduan ayam giling dengan jamur shiitake yang gurih.',
                'full_description' => 'Dimsum dengan campuran daging ayam giling halus dan jamur shiitake pilihan, dibungkus kulit wonton yang lembut. Kaya rasa umami.',
                'size' => '5x5 cm',
                'thickness' => '4.5 cm',
                'topping' => 'Minyak wijen',
                'badge' => null,
                'image' => 'https://images.unsplash.com/photo-1541614101331-1a5a3a194e92?w=400',
                'is_active' => true,
            ],
            [
                'category_id' => $cookies->id,
                'name' => 'Butter Cookies Premium',
                'slug' => 'butter-cookies-premium',
                'price' => 45000,
                'stock' => 30,
                'description' => 'Cookies mentega renyah dengan rasa yang kaya dan lumer.',
                'full_description' => 'Butter cookies premium dengan bahan berkualitas tinggi. Renyah di luar dan lumer di dalam. Dikemas dalam toples cantik, cocok untuk hadiah.',
                'size' => '4x4 cm',
                'thickness' => '1.5 cm',
                'topping' => 'Chocolate chips',
                'badge' => 'New',
                'image' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400',
                'is_active' => true,
            ],
            [
                'category_id' => $cookies->id,
                'name' => 'Choco Lava Cookie',
                'slug' => 'choco-lava-cookie',
                'price' => 35000,
                'stock' => 20,
                'description' => 'Cookie coklat dengan isian lava coklat yang meleleh.',
                'full_description' => 'Cookie dengan kulit renyah dan isian lava coklat cair yang meleleh ketika digigit. Dibuat dari dark chocolate premium pilihan.',
                'size' => '6x6 cm',
                'thickness' => '2 cm',
                'topping' => 'Taburan coklat bubuk',
                'badge' => 'Best Seller',
                'image' => 'https://images.unsplash.com/photo-1483695028939-5bb13f8648b0?w=400',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
