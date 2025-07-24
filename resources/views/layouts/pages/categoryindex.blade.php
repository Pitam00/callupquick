@include("layouts.include.header")

<div class="main-content dashboard active_content">
    <div class="page-header">
        <div>
            <h2 class="main-content-title">Categories List</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Categories</li>
            </ol>
        </div>
        <div>
            <a href="{{ route("admin.categories.create") }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Category
            </a>
        </div>
    </div>

    <section class="baiscform_sec">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form_card">
                    <div class="form_cardbody">
                        <div class="table-responsive">
                            <table id="categoriesTable" class="table table-hover table-bordered w-100">
                                {{-- <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Children</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead> --}}
                                <!-- Update your table header to include the image column -->
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th> <!-- New column -->
                                        <th>Name</th>
                                        <th>Children</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("layouts.include.footer")
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Add these CDNs before your scripts -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

@include("layouts.include.script")

<style>
    #categoriesTable tbody tr td {
        vertical-align: middle;
    }

    .badge-active {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-inactive {
        background-color: #f8d7da;
        color: #842029;
    }

    .children-list {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .children-list li {
        padding: 3px 0;
    }

    .img-thumbnail {
    max-width: 50px;
    max-height: 50px;
    object-fit: cover;
    border-radius: 4px;
}
</style>

{{-- <script>
    $(document).ready(function() {
        var table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route("admin.categories.index") }}",
                type: "GET",
                dataType: "json",
                dataSrc: "data"
            },
            columns: [{
                    data: "category_id"
                },
                {
                    data: "category_name"
                },
                {
                    data: "children",
                    render: function(data, type, row) {
                        if (data.length > 0) {
                            var html = '<ul class="children-list">';
                            data.forEach(function(child) {
                                html += '<li>' + child.category_name + '</li>';
                            });
                            html += '</ul>';
                            return html;
                        }
                        return '—';
                    }
                },
                {
                    data: "is_active",
                    render: function(data, type, row) {
                        return data ?
                            '<span class="badge badge-active">Active</span>' :
                            '<span class="badge badge-inactive">Inactive</span>';
                    }
                },
                {
                    data: "actions",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Delete category
        $(document).on('click', '.delete-btn', function() {
            var categoryId = $(this).data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/admin/categories/' + categoryId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            }
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        // var table = $('#categoriesTable').DataTable({
        //     data: @json($categories),
        //     columns: [{
        //             data: "category_id"
        //         },
        //         {
        //             data: "category_name"
        //         },
        //         {
        //             data: "children",
        //             render: function(data, type, row) {
        //                 if (data && data.length > 0) {
        //                     var html = '<ul class="children-list">';
        //                     data.forEach(function(child) {
        //                         html += '<li>' + child.category_name + '</li>';
        //                     });
        //                     html += '</ul>';
        //                     return html;
        //                 }
        //                 return '—';
        //             }
        //         },
        //         {
        //             data: "is_active",
        //             render: function(data, type, row) {
        //                 return data ?
        //                     '<span class="badge badge-active">Active</span>' :
        //                     '<span class="badge badge-inactive">Inactive</span>';
        //             }
        //         },
        //         {
        //             data: "actions",
        //             orderable: false,
        //             searchable: false
        //         }
        //     ]
        // });
        var table = $('#categoriesTable').DataTable({
            data: @json($categories),
            columns: [{
                    data: "category_id"
                },
                {
                    data: "icon_url",
                    render: function(data, type, row) {
                        return data ?
                            `<img src="${data}" width="50" height="50" class="img-thumbnail">` :
                            '—';
                    }
                },
                {
                    data: "category_name"
                },
                {
                    data: "children",
                    render: function(data, type, row) {
                        if (data && data.length > 0) {
                            var html = '<ul class="children-list">';
                            data.forEach(function(child) {
                                html += '<li>' + child.category_name + '</li>';
                            });
                            html += '</ul>';
                            return html;
                        }
                        return '—';
                    }
                },
                {
                    data: "is_active",
                    render: function(data, type, row) {
                        return data ?
                            '<span class="badge badge-active">Active</span>' :
                            '<span class="badge badge-inactive">Inactive</span>';
                    }
                },
                {
                    data: "actions",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Delete category
        $(document).on('click', '.delete-btn', function() {
            var categoryId = $(this).data('id');
            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: '/admin/categories/' + categoryId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        table.ajax.reload(null,
                            false); // Reload table without resetting paging
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            }
        });
    });
</script>
