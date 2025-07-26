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
use App\Models\Country;
use App\Models\State;
use App\Models\City;
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
        $countries = Country::all(); // Fetch from DB
        return view('layouts.pages.businesadd', compact('users', 'allCategories', 'allAmenities', 'countries'));
    }
    public function getStates($country_id)
    {

        return response()->json(State::where('country_id', $country_id)->get());
    }

    public function getCities($state_id)
    {
        return response()->json(City::where('state_id', $state_id)->get());
    }

    public function bunsinesstore(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'user_id' => 'nullable',
            'description' => 'nullable|string',
            'establishment_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'employee_count' => 'nullable|integer|min:0',
            'ownership_type' => 'nullable|in:sole_proprietorship,partnership,corporation,llc',
            'website_url' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_verified' => 'nullable|in:on',
            'is_claimed' => 'nullable|in:on',

            // Location validation
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'nullable',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_primary' => 'nullable|in:on',

            // Contacts validation
            'contacts' => 'required|array|min:1',
            'contacts.*.contact_type' => 'required|in:phone,email,fax,whatsapp',
            'contacts.*.contact_value' => 'required|string|max:255',
            'contacts.*.is_primary' => 'nullable|in:on',

            // Hours validation
            'hours' => 'nullable|array',
            'hours.*.open_time' => 'nullable|date_format:H:i',
            'hours.*.close_time' => 'nullable|date_format:H:i',
            'hours.*.is_closed' => 'nullable|in:on',

            // Categories validation
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,category_id',
            'primary_category' => 'required',

            // Amenities validation
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,amenity_id',

            // Photos validation
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        // dd($validated);

        // Create the business
        $businessData = [
            'user_id' => $validated['user_id'],
            'business_name' => $validated['business_name'],
            'description' => $validated['description'],
            'establishment_year' => $validated['establishment_year'],
            'employee_count' => $validated['employee_count'],
            'ownership_type' => $validated['ownership_type'],
            'website_url' => $validated['website_url'],
            'is_verified' => $request->has('is_verified'),
            'is_claimed' => $request->has('is_claimed'),
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('business_logos', 'public');
            $businessData['logo_url'] = Storage::url($logoPath);
        }

        $business = Business::create($businessData);

        // Create location
        $location = BusinessLocation::create([
            'business_id' => $business->business_id,
            'address_line1' => $validated['address_line1'],
            'address_line2' => $validated['address_line2'],
            'landmark' => $validated['landmark'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'postal_code' => $validated['postal_code'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_primary' => $request->has('is_primary'),
        ]);

        // Create contacts
        foreach ($validated['contacts'] as $contact) {
            BusinessContact::create([
                'business_id' => $business->business_id,
                'contact_type' => $contact['contact_type'],
                'contact_value' => $contact['contact_value'],
                'is_primary' => isset($contact['is_primary']),
            ]);
        }

        // Create business hours
        // if (isset($validated['hours'])) {
        //     foreach ($validated['hours'] as $day => $hours) {
        //         BusinessHour::create([
        //             'business_id' => $business->business_id,
        //             'day_of_week' => $day,
        //             'open_time' => $hours['open_time'],
        //             'close_time' => $hours['close_time'],
        //             'is_closed' => isset($hours['is_closed']),
        //         ]);
        //     }
        // }
        if (isset($validated['hours'])) {
            foreach ($validated['hours'] as $day => $hours) {
                // Skip if both open_time and close_time are missing and not marked as closed
                $isClosed = isset($hours['is_closed']);

                if (!$isClosed && (!isset($hours['open_time']) || !isset($hours['close_time']))) {
                    continue; // or throw a validation error if this shouldn't happen
                }

                BusinessHour::create([
                    'business_id' => $business->business_id,
                    'day_of_week' => $day,
                    'open_time' => $hours['open_time'] ?? null,
                    'close_time' => $hours['close_time'] ?? null,
                    'is_closed' => $isClosed,
                ]);
            }
        }


        // Create categories
        foreach ($validated['categories'] as $categoryId) {
            BusinessCategory::create([
                'business_id' => $business->business_id,
                'category_id' => $categoryId,
                'is_primary' => ($categoryId == $validated['primary_category']),
            ]);
        }

        // Create amenities
        if (isset($validated['amenities'])) {
            foreach ($validated['amenities'] as $amenityId) {
                BusinessAmenityMapping::create([
                    'business_id' => $business->business_id,
                    'amenity_id' => $amenityId,
                ]);
            }
        }

        // Handle photos upload
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPath = $photo->store('business_photos', 'public');

                BusinessPhoto::create([
                    'business_id' => $business->business_id,
                    'photo_url' => Storage::url($photoPath),
                    'uploaded_by' => auth()->id(),
                    'is_approved' => true,
                ]);
            }
        }

        return redirect()->route('admin.businesses.index')
            ->with('success', 'Business created successfully');
    }

    // public function businesses(Request $request){
    //     // if ($request->ajax()) {
    //     //     $data = Business::with(['location', 'primaryCategory', 'contacts' => function($query) {
    //     //         $query->where('is_primary', true);
    //     //     }])->select('*');

    //     //     return DataTables::of($data)
    //     //         ->addIndexColumn()
    //     //         ->addColumn('action', function($row){
    //     //             $btn = '<a href="'.route('admin.businesses.edit', $row->business_id).'" class="edit btn btn-primary btn-sm">Edit</a>';
    //     //             $btn .= ' <a href="'.route('admin.businesses.show', $row->business_id).'" class="show btn btn-info btn-sm">View</a>';
    //     //             $btn .= ' <button class="delete btn btn-danger btn-sm" data-id="'.$row->business_id.'">Delete</button>';
    //     //             return $btn;
    //     //         })
    //     //         ->addColumn('location', function($row) {
    //     //             return $row->location ?: null;
    //     //         })
    //     //         ->addColumn('primary_contact', function($row) {
    //     //             $primaryContact = $row->contacts->first();
    //     //             return $primaryContact ? $primaryContact->contact_value : null;
    //     //         })
    //     //         ->rawColumns(['action'])
    //     //         ->make(true);
    //     // }
    //     if ($request->ajax()) {
    //         $data = Business::with(['location', 'primaryCategory', 'contacts' => function($query) {
    //             $query->where('is_primary', true);
    //         }])->get();
    //         dd($data);

    //         return response()->json([
    //             'draw' => $request->input('draw'),
    //             'recordsTotal' => Business::count(),
    //             'recordsFiltered' => Business::count(),
    //             'data' => $data->map(function($item, $key) {
    //                 return [
    //                     'DT_RowIndex' => $key + 1,
    //                     'business_name' => $item->business_name,
    //                     'category' => $item->primaryCategory->category_name ?? '',
    //                     'location' => $item->location ? $item->location->city.', '.$item->location->state : '',
    //                     'contact' => $item->contacts->first()->contact_value ?? '',
    //                     'action' => '
    //                         <div class="action-btns">
    //                             <a href="'.route('admin.businesses.edit', $item->business_id).'" class="btn btn-sm btn-primary">
    //                                 <i class="fa fa-edit"></i>
    //                             </a>
    //                             <a href="'.route('admin.businesses.show', $item->business_id).'" class="btn btn-sm btn-info">
    //                                 <i class="fa fa-eye"></i>
    //                             </a>
    //                             <button class="btn btn-sm btn-danger delete-btn" data-id="'.$item->business_id.'">
    //                                 <i class="fa fa-trash"></i>
    //                             </button>
    //                         </div>
    //                     '
    //                 ];
    //             })
    //         ]);
    //     }


    //     return view('layouts.pages.businesslist');
    // }

    public function businesses(Request $request)
{
    if ($request->ajax()) {
        $data = Business::with([
                'location',
                'primaryCategory',
                'contacts' => function($query) {
                    $query->where('is_primary', true);
                }
            ])->get();

        // dd($data);

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => Business::count(),
            'recordsFiltered' => Business::count(),
            'data' => $data->map(function($item, $key) {
                // Safely access relationships with null checks
                $location = $item->location;
                $primaryCategory = $item->primaryCategory;
                $primaryContact = $item->contacts->first();

                return [
                    'DT_RowIndex' => $key + 1,
                    'business_id' => $item->business_id,
                    'logo' => $item->logo_url
                        ? '<img src="'.$item->logo_url.'" class="img-thumbnail" width="50">'
                        : 'No logo',
                    'business_name' => $item->business_name,
                    'category' => $primaryCategory->category_name ?? 'N/A',
                    'location' => $location
                        ? implode(', ', array_filter([$location->city, $location->state]))
                        : 'N/A',
                    'contact' => $primaryContact->contact_value ?? 'N/A',
                    'status' => $this->getStatusBadges($item),
                    'action' => $this->getActionButtons($item)
                ];
            })
        ]);
    }

    return view('layouts.pages.businesslist');
}

protected function getStatusBadges($business)
{
    $badges = [];
    if ($business->is_verified) {
        $badges[] = '<span class="badge bg-success">Verified</span>';
    }
    if ($business->is_claimed) {
        $badges[] = '<span class="badge bg-primary">Claimed</span>';
    }
    return $badges ? implode(' ', $badges) : '<span class="badge bg-secondary">Pending</span>';
}

protected function getActionButtons($business)
{
    return '<div class="btn-group">
        <a href="'.route('admin.businesses.edit', $business->business_id).'" class="btn btn-sm btn-primary">
            <i class="fa fa-edit"></i>
        </a>
        <a href="'.route('admin.businesses.show', $business->business_id).'" class="btn btn-sm btn-info">
            <i class="fa fa-eye"></i>
        </a>
        <button class="btn btn-sm btn-danger delete-btn" data-id="'.$business->business_id.'">
            <i class="fa fa-trash"></i>
        </button>
    </div>';
}

    public function destroybusiness($id){
        $business = Business::findOrFail($id);
        $business->delete();

        return response()->json([
            'message' => 'Business deleted successfully'
        ]);
    }
}
