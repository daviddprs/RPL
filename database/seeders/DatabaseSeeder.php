<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =============================================
        // USERS - Default accounts for each role
        // =============================================
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@coffeeshop.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Utama',
            'email' => 'kasir@coffeeshop.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Barista Utama',
            'email' => 'barista@coffeeshop.com',
            'password' => Hash::make('password'),
            'role' => 'barista',
        ]);

        User::create([
            'name' => 'Ryan Sheva',
            'email' => 'ryan@pelanggan.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);

        User::create([
            'name' => 'David Prastiansyah',
            'email' => 'david@pelanggan.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);

        // =============================================
        // CATEGORIES
        // =============================================
        $kopi = Category::create(['name' => 'Kopi', 'slug' => 'kopi']);
        $nonKopi = Category::create(['name' => 'Non-Kopi', 'slug' => 'non-kopi']);
        $snack = Category::create(['name' => 'Snack', 'slug' => 'snack']);
        $pastry = Category::create(['name' => 'Pastry', 'slug' => 'pastry']);

        // =============================================
        // MENU ITEMS
        // =============================================

        // Kopi
        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Espresso',
            'description' => 'Espresso klasik yang kaya dan intens, diseduh sempurna dari biji kopi pilihan.',
            'price' => 18000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Americano',
            'description' => 'Espresso yang diencerkan dengan air panas, menghasilkan rasa yang bersih dan bold.',
            'price' => 22000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1551030173-122aabc4489c?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Cappuccino',
            'description' => 'Perpaduan sempurna antara espresso, susu steamed, dan foam susu yang lembut.',
            'price' => 28000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Caramel Latte',
            'description' => 'Latte creamy dengan siraman saus karamel manis yang menggoda.',
            'price' => 32000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1599398054066-846f28917f38?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $kopi->id,
            'name' => 'Mocha',
            'description' => 'Perpaduan mewah espresso, cokelat, dan susu steamed dengan whipped cream.',
            'price' => 35000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?w=600&auto=format&fit=crop&q=80',
        ]);

        // Non-Kopi
        Menu::create([
            'category_id' => $nonKopi->id,
            'name' => 'Matcha Latte',
            'description' => 'Green tea matcha premium Jepang dicampur susu steamed yang creamy.',
            'price' => 30000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $nonKopi->id,
            'name' => 'Cokelat Panas',
            'description' => 'Cokelat premium yang kaya dan lembut, minuman sempurna untuk menemani hari.',
            'price' => 25000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $nonKopi->id,
            'name' => 'Thai Tea',
            'description' => 'Teh Thailand klasik dengan susu kental manis, disajikan dingin menyegarkan.',
            'price' => 22000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=600&auto=format&fit=crop&q=80',
        ]);

        // Snack
        Menu::create([
            'category_id' => $snack->id,
            'name' => 'French Fries',
            'description' => 'Kentang goreng renyah dengan bumbu seasoning pilihan.',
            'price' => 20000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1576107232684-1279f3908594?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $snack->id,
            'name' => 'Chicken Wings',
            'description' => 'Sayap ayam goreng crispy dengan saus BBQ atau saus pedas.',
            'price' => 28000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=600&auto=format&fit=crop&q=80',
        ]);

        // Pastry
        Menu::create([
            'category_id' => $pastry->id,
            'name' => 'Croissant',
            'description' => 'Croissant butter klasik yang renyah di luar dan lembut di dalam.',
            'price' => 18000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=600&auto=format&fit=crop&q=80',
        ]);

        Menu::create([
            'category_id' => $pastry->id,
            'name' => 'Banana Bread',
            'description' => 'Roti pisang homemade yang lembut dengan aroma vanilla.',
            'price' => 15000,
            'is_sold_out' => false,
            'image_path' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=600&auto=format&fit=crop&q=80',
        ]);
    }
}
