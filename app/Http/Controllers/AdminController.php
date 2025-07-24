<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\BusinessContact;
use App\Models\BusinessHour;
use App\Models\BusinessCategory;
use App\Models\BusinessAmenityMapping;
use App\Models\BusinessPhoto;
// use App\Models\Category;
use App\Models\Amenity;
use App\Models\User;

class AdminController extends Controller
{


     public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout', 'dashboard']);
    }

        public function login()
    {
        // If already logged in as admin, go to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }

        return view('layouts.pages.login');
    }

    public function logincheck(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            // return redirect()->intended(route('dashboard'));
             return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        return view('layouts.pages.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    //CATEGORY

    // public function category()
    // {
    //         $categories = Category::with('children')
    //         // ->parentCategories()
    //         ->orderBy('category_name')
    //         ->get()
    //         ->map(function($category) {
    //             return [
    //                 'category_id' => $category->category_id,
    //                 'category_name' => $category->category_name,
    //                 'children' => $category->children,
    //                 'is_active' => $category->is_active,
    //                 'actions' => '
    //                     <a href="'.route('admin.categories.edit', $category->category_id).'" class="btn btn-sm btn-primary">
    //                         <i class="fa fa-edit"></i>
    //                     </a>
    //                     <button class="btn btn-sm btn-danger delete-btn" data-id="'.$category->category_id.'">
    //                         <i class="fa fa-trash"></i>
    //                     </button>
    //                 '
    //             ];
    //         });

    //         // dd($categories);

    //     if(request()->ajax()) {
    //         return response()->json([
    //             'data' => $categories
    //         ]);
    //     }

    //     return view('layouts.pages.categoryindex', compact('categories'));
    // }

    public function category()
{
    $categories = Category::with('children')
        ->orderBy('category_name')
        ->get()
        ->map(function($category) {
            return [
                'category_id' => $category->category_id,
                'category_name' => $category->category_name,
                'children' => $category->children,
                'is_active' => $category->is_active,
                'icon_url' => $category->icon_url, // Add this line
                'actions' => '
                    <a href="'.route('admin.categories.edit', $category->category_id).'" class="btn btn-sm btn-primary">
                        Edit
                    </a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="'.$category->category_id.'">
                        Delete
                    </button>
                '
            ];
        });

    if(request()->ajax()) {
        return response()->json([
            'data' => $categories
        ]);
    }

    return view('layouts.pages.categoryindex', compact('categories'));
}

    // public function categorycreate()
    // {
    //     $parentCategories = Category::parentCategories()->active()->get();
    //     // dd($parentCategories);
    //     return view('layouts.pages.categorycreate',compact('parentCategories'));

    // }
    public function categorycreate()
{
    $parentCategories = Category::active()
        ->orderBy('category_name')
        ->get();

    return view('layouts.pages.categorycreate', compact('parentCategories'));
}


    public function categorystore(Request $request)
    {
        // dd($request);
            $validated = $request->validate([
            'parent_category_id' => 'nullable',
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|in:on',
            'child_categories' => 'nullable|array',
            'child_categories.*.name' => 'required_with:child_categories|string|max:255',
            'child_categories.*.description' => 'nullable|string',
        ]);

        // Handle parent category
        $categoryData = [
            'parent_category_id' => $request->parent_category_id,
            'category_name' => $request->category_name,
            'description' => $request->description,
            // 'is_active' => $request->is_active ?? true,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ];

        // dd($categoryData);

        // Upload icon if provided
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('category_icons', 'public');
            $categoryData['icon_url'] = Storage::url($iconPath);
        }

        $parentCategory = Category::create($categoryData);

        // Handle child categories
        if ($request->filled('child_categories')) {
            foreach ($request->child_categories as $child) {
                Category::create([
                    'parent_category_id' => $parentCategory->category_id,
                    'category_name' => $child['name'],
                    'description' => $child['description'] ?? null,
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
        {
            // dd($category);
            // $parentCategories = Category::where('category_id', '=', $category->category_id) // Exclude self from parent options
            //     ->active()
            //     ->get();
            // $childCategories = Category::where('parent_category_id', '=' , $category->category_id)
            // ->active()
            // ->get();

            $parentCategories = Category::where('category_id', '!=', $category->category_id) // Exclude self
                                ->active()
                                ->orderBy('category_name')
                                ->get();

                // dd($parentCategories,$childCategories);
            return view('layouts.pages.categorycreate', [
                'category' => $category,
                'parentCategories' => $parentCategories,
                'isEdit' => true
            ]);
        }

        public function update(Request $request, Category $category)
        {
            // dd($request,$category);
            $validated = $request->validate([
                'parent_category_id' => 'nullable',
                'category_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable|in:on'
            ]);
            // dd($validated);
            $category->update([
                'parent_category_id' => $validated['parent_category_id'],
                'category_name' => $validated['category_name'],
                'description' => $validated['description'],
                'is_active' => $request->has('is_active') ? 1 : 0
            ]);

            // Handle icon update
            if ($request->hasFile('icon')) {
                // Delete old icon if exists
                if ($category->icon_url) {
                    Storage::disk('public')->delete(
                        str_replace('/storage/', '', $category->icon_url)
                    );
                }

                $iconPath = $request->file('icon')->store('category_icons', 'public');
                $category->update(['icon_url' => Storage::url($iconPath)]);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully');
        }

    public function destroy(Category $category)
{
    try {
        // Check if category has children
        if ($category->children()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete category with child categories'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error deleting category: ' . $e->getMessage()
        ], 500);
    }
}

    public function searchParentCategories(Request $request)
    {
        $search = $request->input('search');

        // $categories = Category::parentCategories()
        //     ->where('category_name', 'LIKE', "%{$search}%")
        //     ->active()
        //     ->limit(10)
        //     ->get();
        $categories = Category::where('category_name', 'LIKE', "%{$search}%")
            ->active()
            ->limit(10)
            ->get();

        return response()->json($categories);
    }


    // BUSINESS FUNCTIONS
    public function bunsinesadd() {
        $users = User::all();
        $allCategories = Category::all();
        $allAmenities = Amenity::all();

        // Option 1: Use a config file (recommended)
        // Create a config/countries.php file with your countries array
        $countries = config('countries');

        // Option 2: Use a hardcoded array as fallback
        if (empty($countries)) {
            $countries = [
                'US' => 'United States',
                'CA' => 'Canada',
                'GB' => 'United Kingdom',
                // Add more countries as needed
            ];
        }

        return view('layouts.pages.businesadd', compact('users', 'allCategories', 'allAmenities', 'countries'));
    }
}
