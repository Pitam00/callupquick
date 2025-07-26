@include("layouts.include.header")

<div class="main-content dashboard active_content">
    <div class="page-header">
        <div>
            <h2 class="main-content-title">Businesses List</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("dashboard") }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Businesses</li>
            </ol>
        </div>
        <div>
            <a href="{{ route("bunsiness.add") }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Business
            </a>
        </div>
    </div>

    <section class="baiscform_sec">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form_card">
                    <div class="form_cardbody">
                        <div class="table-responsive">
                            <table id="businessesTable" class="table table-hover table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>Business Name</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Contact</th>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

@include("layouts.include.script")

<style>
    #businessesTable tbody tr td {
        vertical-align: middle;
    }

    .badge-verified {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .badge-claimed {
        background-color: #cfe2ff;
        color: #084298;
    }

    .badge-pending {
        background-color: #fff3cd;
        color: #664d03;
    }

    .img-thumbnail {
        max-width: 50px;
        max-height: 50px;
        object-fit: cover;
        border-radius: 4px;
    }

    .action-btns .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        margin: 0 2px;
    }
</style>

<script>
    $(document).ready(function() {
        var table = $('#businessesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.businesses.index') }}",
                type: "GET"
            },
            columns: [
                {data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false},
                {
                    data: "logo_url",
                    name: "logo_url",
                    render: function(data, type, row) {
                        return data ?
                            `<img src="${data}" class="img-thumbnail" alt="Business Logo">` :
                            '<span class="text-muted">No Logo</span>';
                    },
                    orderable: false
                },
                {data: "business_name", name: "business_name"},
                {
                    data: "primary_category.category_name",
                    name: "primaryCategory.category_name",
                    render: function(data, type, row) {
                        return data || '—';
                    }
                },
                {
                    data: "location",
                    name: "location.city",
                    render: function(data, type, row) {
                        if (data) {
                            return `${data.city}, ${data.state}`;
                        }
                        return '—';
                    }
                },
                {
                    data: "primary_contact",
                    name: "contacts.contact_value",
                    render: function(data, type, row) {
                        return data || '—';
                    }
                },
                {
                    data: "status",
                    name: "status",
                    render: function(data, type, row) {
                        var statusHtml = '';
                        if (row.is_verified) {
                            statusHtml += '<span class="badge badge-verified">Verified</span> ';
                        }
                        if (row.is_claimed) {
                            statusHtml += '<span class="badge badge-claimed">Claimed</span> ';
                        }
                        if (!row.is_verified && !row.is_claimed) {
                            statusHtml += '<span class="badge badge-pending">Pending</span>';
                        }
                        return statusHtml;
                    },
                    orderable: false
                },
                {
                    data: "action",
                    name: "action",
                    render: function(data, type, row) {
                        return `
                            <div class="action-btns">
                                <a href="/admin/businesses/${row.business_id}/edit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="/admin/businesses/${row.business_id}" class="btn btn-sm btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${row.business_id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                }
            ],
            order: [[0, 'asc']],
            responsive: true
        });

        // Delete business
        $(document).on('click', '.delete-btn', function() {
            var businessId = $(this).data('id');
            if (confirm('Are you sure you want to delete this business?')) {
                $.ajax({
                    url: '/admin/businesses/' + businessId,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        table.ajax.reload(null, false); // Reload table without resetting paging
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
