<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;


class UserController extends Controller
{
    /**
     * Get all active categories with their nested structure
     */
    public function index()
    {
        // Get all parent categories (where parent_category_id is null)
        $parentCategories = Category::whereNull('parent_category_id')
            ->where('is_active', 1)
            ->with(['children' => function($query) {
                $query->where('is_active', 1);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $parentCategories
        ]);
    }

    // For Pagination:
    // public function index(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);
    //     $parentCategories = Category::whereNull('parent_category_id')
    //         ->where('is_active', 1)
    //         ->with(['children' => function($query) {
    //             $query->where('is_active', 1);
    //         }])
    //         ->paginate($perPage);

    //     return response()->json([
    //         'success' => true,
    //         'data' => $parentCategories
    //     ]);
    // }

    /**
     * Get a single category with its children
     */
    public function show($id)
    {
        $category = Category::with(['children' => function($query) {
            $query->where('is_active', 1);
        }])->where('category_id', $id)
           ->where('is_active', 1)
           ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }


        public function getByParent($parentId)
    {
        $categories = Category::where('parent_category_id', $parentId)
            ->where('is_active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

        public function search(Request $request)
    {
        $query = $request->input('q');

        $categories = Category::where('category_name', 'like', "%$query%")
            ->where('is_active', 1)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
}
