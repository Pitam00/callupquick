@include("layouts.include.header")

<div class="main-content dashboard active_content">
    <div class="page-header">
        <div>
            <h2 class="main-content-title">Add New Category</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
            </ol>
        </div>
    </div>

    <section class="baiscform_sec">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form_card">
                    <div class="form_cardbody">
                        <form id="categoryForm" method="POST"
                            action="{{ isset($isEdit) ? route("admin.categories.update", $category->category_id) : route("admin.categories.store") }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($isEdit))
                                @method("PUT")
                            @endif

                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parent_category_search">Parent Category (Optional)</label>
                                        <input type="text" class="form-control" id="parent_category_search"
                                               placeholder="Search for parent category..."
                                               value="{{ $category->parent->category_name ?? '' }}"
                                               autocomplete="off">
                                        <input type="hidden" name="parent_category_id" id="parent_category_id"
                                               value="{{ $category->parent_category_id ?? '' }}">
                                        <div id="parentCategoryResults" class="list-group mt-2" style="display: none;"></div>
                                        <small class="text-muted">Leave empty if this is a main category</small>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parent_category_search">Parent Category (Optional)</label>
                                        <select class="form-control select2-search" id="parent_category_search" name="parent_category_id" style="width: 100%;">
                                            <option value="">-- Select Parent Category --</option>
                                            @foreach($parentCategories as $parent)
                                                <option value="{{ $parent->category_id }}"
                                                    {{ (isset($category) && $category->parent_category_id == $parent->category_id) ? 'selected' : '' }}>
                                                    {{ $parent->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Leave empty if this is a main category</small>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Category Name *</label>
                                        <input type="text" class="form-control" id="category_name"
                                               name="category_name" value="{{ $category->category_name ?? old('category_name') }}" required>
                                        @error('category_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ $category->description ?? old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="icon">Category Icon</label>
                                        @if(isset($category) && $category->icon_url)
                                            <div class="mb-3">
                                                <label>Current Icon:</label>
                                                <img src="{{ $category->icon_url }}" width="50" class="img-thumbnail">
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" class="form-check-input" id="remove_icon" name="remove_icon">
                                                    <label class="form-check-label" for="remove_icon">Remove current icon</label>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="icon" name="icon" accept="image/*">
                                            <label class="custom-file-label" for="icon">Choose file</label>
                                        </div>
                                        <small class="text-muted">Recommended size: 100x100px (PNG, SVG, JPG)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_active"
                                                   name="is_active" {{ (isset($category) && $category->is_active) || old('is_active') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($isEdit) ? 'Update' : 'Save' }} Category
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("layouts.include.footer")
</div>

@include("layouts.include.script")
<!-- Add these CDNs -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
    .child-category-item {
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .child-category-item:hover {
        background-color: #f1f1f1;
    }

    #parentCategoryResults {
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
    }

    #parentCategoryResults .list-group-item {
        cursor: pointer;
    }

    #parentCategoryResults .list-group-item:hover {
        background-color: #f8f9fa;
    }



    /* Add to your style section */
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

.select2-container--open .select2-dropdown--below {
    border-radius: 0 0 0.25rem 0.25rem;
}
</style>

<script>
    $(document).ready(function() {
        let childCount = 0;

        $('.select2-search').select2({
        placeholder: "Search for parent category...",
        allowClear: true,
        width: 'resolve'
    });
     // If editing, pre-select the parent category
     @if(isset($isEdit) && $category->parent_category_id)
        $('#parent_category_search').val('{{ $category->parent_category_id }}').trigger('change');
    @endif


        @if (isset($isEdit) && $category->parent)
            $('#parent_category_search').val('{{ $category->parent->category_name }}');
            $('#parent_category_id').val('{{ $category->parent_category_id }}');
        @endif

        // Add first child category
        // addChildCategory();

        // Parent category search
        $('#parent_category_search').on('input', debounce(function() {
            const search = $(this).val().trim();

            if (search.length < 2) {
                $('#parentCategoryResults').hide().empty();
                return;
            }

            $.ajax({
                url: '{{ route("admin.categories.search") }}',
                type: 'GET',
                data: {
                    search: search
                },
                success: function(response) {
                    const results = $('#parentCategoryResults');
                    results.empty();

                    if (response.length > 0) {
                        response.forEach(function(category) {
                            results.append(`
                            <a href="#" class="list-group-item list-group-item-action"
                               data-id="${category.category_id}">
                                ${category.category_name}
                            </a>
                        `);
                        });
                        results.show();
                    } else {
                        results.hide();
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }, 300));

        // Select parent category
        $(document).on('click', '#parentCategoryResults a', function(e) {
            e.preventDefault();
            const category = $(this);
            $('#parent_category_search').val(category.text());
            $('#parent_category_id').val(category.data('id'));
            $('#parentCategoryResults').hide();
        });

        // Clear parent category when search is cleared
        $('#parent_category_search').on('change', function() {
            if ($(this).val().trim() === '') {
                $('#parent_category_id').val('');
            }
        });

        // Add child category
        $('#addChildCategory').click(addChildCategory);

        // Remove child category
        // $(document).on('click', '.remove-child-btn', function() {
        //     if ($('#childCategoriesContainer').children().length > 1) {
        //         $(this).closest('.child-category-item').remove();
        //         reindexChildCategories();
        //     } else {
        //         toastr.warning('At least one child category is required.');
        //     }
        // });
        // Updated remove child category function
        $(document).on('click', '.remove-child-btn', function() {
            $(this).closest('.child-category-item').remove();
            reindexChildCategories();
        });

        // File input label update
        $('.custom-file-input').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Form validation
        // $('#categoryForm').validate({
        //     rules: {
        //         category_name: {
        //             required: true,
        //             minlength: 2,
        //             maxlength: 255
        //         },
        //         'child_categories[*][name]': {
        //             required: true,
        //             minlength: 2,
        //             maxlength: 255
        //         }
        //     },
        //     messages: {
        //         category_name: {
        //             required: "Please enter category name",
        //             minlength: "Category name must be at least 2 characters long",
        //             maxlength: "Category name must be less than 255 characters"
        //         }
        //     },
        //     errorElement: 'span',
        //     errorPlacement: function(error, element) {
        //         error.addClass('invalid-feedback');
        //         element.closest('.form-group').append(error);
        //     },
        //     highlight: function(element) {
        //         $(element).addClass('is-invalid');
        //     },
        //     unhighlight: function(element) {
        //         $(element).removeClass('is-invalid');
        //     }
        // });
        // Form validation - UPDATED VERSION (make child categories optional)
        $('#categoryForm').validate({
            rules: {
                category_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 255
                }
                // REMOVED the mandatory validation for child categories
            },
            messages: {
                category_name: {
                    required: "Please enter category name",
                    minlength: "Category name must be at least 2 characters long",
                    maxlength: "Category name must be less than 255 characters"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });

        function addChildCategory() {
            const newItem = `
            <div class="child-category-item mb-3 p-3 border rounded">
                <div class="form-row">
                    <div class="col-md-5">
                        <label>Name *</label>
                        <input type="text" class="form-control"
                               name="child_categories[${childCount}][name]" required>
                    </div>
                    <div class="col-md-5">
                        <label>Description</label>
                        <input type="text" class="form-control"
                               name="child_categories[${childCount}][description]">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-child-btn">
                            <i class="fa fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
            $('#childCategoriesContainer').append(newItem);
            childCount++;
        }

        function reindexChildCategories() {
            $('#childCategoriesContainer .child-category-item').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name')
                        .replace(/child_categories\[\d+\]/, `child_categories[${index}]`);
                    $(this).attr('name', name);
                });
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    func.apply(context, args);
                }, wait);
            };
        }


        function updateChildCategoriesUI() {
            if ($('#childCategoriesContainer').children('.child-category-item').length === 0) {
                $('#noChildrenMessage').show();
            } else {
                $('#noChildrenMessage').hide();
            }
        }

        // Update the addChildCategory function
        function addChildCategory() {
            const newItem = `
        <div class="child-category-item mb-3 p-3 border rounded">
            <!-- ... your existing child item HTML ... -->
        </div>
    `;
            $('#childCategoriesContainer').append(newItem);
            childCount++;
            updateChildCategoriesUI();
        }

        // Update the remove handler
        $(document).on('click', '.remove-child-btn', function() {
            $(this).closest('.child-category-item').remove();
            reindexChildCategories();
            updateChildCategoriesUI();
        });
    });
</script>
