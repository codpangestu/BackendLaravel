<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovieCategory;

class MovieCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Action', 'description' => 'Film aksi penuh adrenalin'],
            ['name' => 'Adventure', 'description' => 'Petualangan seru'],
            ['name' => 'Comedy', 'description' => 'Film komedi'],
            ['name' => 'Drama', 'description' => 'Film drama'],
            ['name' => 'Fantasy', 'description' => 'Dunia fantasi'],
            ['name' => 'Horror', 'description' => 'Film horor'],
            ['name' => 'Romance', 'description' => 'Film romantis'],
            ['name' => 'Sci-Fi', 'description' => 'Fiksi ilmiah'],
            ['name' => 'Thriller', 'description' => 'Film menegangkan'],
            ['name' => 'Animation', 'description' => 'Film animasi'],
        ];

        foreach ($categories as $category) {
            MovieCategory::create($category);
        }
    }
}
