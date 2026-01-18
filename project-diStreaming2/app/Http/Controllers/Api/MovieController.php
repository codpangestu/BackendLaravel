<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // GET /api/movies
    public function index(Request $request)
    {
        $query = Movie::with('category');

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'id');
        $order  = $request->get('order', 'asc');

        $query->orderBy($sortBy, $order);

        $movies = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Data film berhasil diambil',
            'data' => $movies->map(function ($movie) {
                return [
                    'id' => $movie->id,
                    'title' => $movie->title,
                    'description' => $movie->description,
                    'rating' => $movie->rating,
                    'rating_class' => $this->ratingClass($movie->rating),
                    'release_year' => $movie->release_year,
                    'category' => [
                        'id' => $movie->category->id,
                        'name' => $movie->category->name
                    ],
                    'thumbnail' => $this->tmdbThumbnail($movie->thumbnail)
                ];
            })
        ]);
    }

    // sort by Rating
    private function ratingClass($rating)
    {
        if ($rating >= 8.5) {
            return 'Top Rated';
        } elseif ($rating >= 7.0) {
            return 'Popular';
        }
        return 'Regular';
    }

    // helper untuk TMDB thumbnail
    private function tmdbThumbnail($path)
    {
    if (!$path) {
        return null;
    }

    // kalau sudah full URL, langsung return
    if (str_starts_with($path, 'http')) {
        return $path;
    }

    // kalau cuma path TMDB
    return 'https://image.tmdb.org/t/p/w500' . $path;
    }




    // GET /api/movies/{id}
    public function show($id)
    {
        $movie = Movie::with('category')->find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail film berhasil diambil',
            'data' => [
                'id' => $movie->id,
                'title' => $movie->title,
                'description' => $movie->description,
                'rating' => $movie->rating,
                'release_year' => $movie->release_year,
                'category' => [
                    'id' => $movie->category->id,
                    'name' => $movie->category->name,
                ],
                'thumbnail' => $this->tmdbThumbnail($movie->thumbnail)
            ]
        ]);
    }

    // POST /api/movies
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'rating' => 'required|numeric|min:0|max:10',
                'release_year' => 'required|integer|min:1900|max:2030',
                'category_id' => 'required|exists:movie_categories,id',
                'thumbnail' => 'nullable|string'
            ]);

            $movie = Movie::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Film berhasil ditambahkan',
                'data' => $movie
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }


    // PUT /api/movies/{id}
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'rating' => 'required|numeric|min:0|max:10',
                'release_year' => 'required|integer|min:1900|max:2030',
                'category_id' => 'required|exists:movie_categories,id',
                'thumbnail' => 'nullable|string'
            ]);

            $movie->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Film berhasil diupdate',
                'data' => $movie
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }


    // DELETE /api/movies/{id}
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ], 404);
        }

        $movie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil dihapus'
        ]);
    }
}
