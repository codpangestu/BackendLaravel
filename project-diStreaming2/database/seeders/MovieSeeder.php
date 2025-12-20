<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $movies = [
            [
                'title' => 'Fast Strike',
                'description' => 'Aksi kejar-kejaran',
                'rating' => 8.2,
                'release_year' => 2022,
                'category_id' => 1,
                'thumbnail' => 'fast-strike.jpg'
            ],
            [
                'title' => 'Lost Island',
                'description' => 'Petualangan di pulau misterius',
                'rating' => 8.0,
                'release_year' => 2021,
                'category_id' => 2,
                'thumbnail' => 'lost-island.jpg'
            ],
            [
                'title' => 'Laugh Out Loud',
                'description' => 'Komedi segar',
                'rating' => 7.5,
                'release_year' => 2020,
                'category_id' => 3,
                'thumbnail' => 'lol.jpg'
            ],
            [
                'title' => 'Broken Dreams',
                'description' => 'Drama kehidupan',
                'rating' => 8.7,
                'release_year' => 2023,
                'category_id' => 4,
                'thumbnail' => 'broken-dreams.jpg'
            ],
            [
                'title' => 'Magic Realm',
                'description' => 'Dunia sihir',
                'rating' => 8.1,
                'release_year' => 2019,
                'category_id' => 5,
                'thumbnail' => 'magic-realm.jpg'
            ],
            [
                'title' => 'Night Terror',
                'description' => 'Horor tengah malam',
                'rating' => 7.9,
                'release_year' => 2022,
                'category_id' => 6,
                'thumbnail' => 'night-terror.jpg'
            ],
            [
                'title' => 'Love Beyond Time',
                'description' => 'Romantis lintas waktu',
                'rating' => 8.4,
                'release_year' => 2021,
                'category_id' => 7,
                'thumbnail' => 'love-time.jpg'
            ],
            [
                'title' => 'Future World',
                'description' => 'Dunia masa depan',
                'rating' => 8.6,
                'release_year' => 2024,
                'category_id' => 8,
                'thumbnail' => 'future-world.jpg'
            ],
            [
                'title' => 'Silent Chase',
                'description' => 'Kejaran misterius',
                'rating' => 8.0,
                'release_year' => 2020,
                'category_id' => 9,
                'thumbnail' => 'silent-chase.jpg'
            ],
            [
                'title' => 'Happy Pixels',
                'description' => 'Animasi keluarga',
                'rating' => 7.8,
                'release_year' => 2018,
                'category_id' => 10,
                'thumbnail' => 'happy-pixels.jpg'
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
