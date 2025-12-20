<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MovieCategory;
use Illuminate\Http\Request;

class MovieCategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = MovieCategory::all();

        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil diambil',
            'data' => $categories
        ]);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = MovieCategory::with('movies')->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail kategori berhasil diambil',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'movies' => $category->movies->map(function ($movie) {
                    return [
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'rating' => $movie->rating,
                        'release_year' => $movie->release_year,
                    ];
                })
            ]
        ]);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:100|unique:movie_categories,name',
                'description' => 'nullable|string'
            ]);

            $category = MovieCategory::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $category
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }


    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = MovieCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        try {
            $data = $request->validate([
                'name' => 'required|string|max:100|unique:movie_categories,name,' . $id,
                'description' => 'nullable|string'
            ]);

            $category->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diupdate',
                'data' => $category
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }


    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = MovieCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
