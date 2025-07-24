@include("layouts.include.header")

<div class="main-content dashboard active_content">
    <div class="page-header">
        <div>
            <h2 class="main-content-title">{{ isset($isEdit) ? 'Edit' : 'Add New' }} Business</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ isset($isEdit) ? 'Edit' : 'Add' }} Business</li>
            </ol>
        </div>
    </div>

    <section class="baiscform_sec">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form_card">
                    <div class="form_cardbody">
                        <form id="businessForm" method="POST"
                              action="{{ isset($isEdit) ? route('admin.businesses.update', $business->business_id) : route('admin.businesses.store') }}"
                              enctype="multipart/form-data">
                            @csrf
                            @if(isset($isEdit))
                                @method('PUT')
                            @endif

                            <!-- Basic Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_name">Business Name *</label>
                                                <input type="text" class="form-control" id="business_name"
                                                       name="business_name" value="{{ $business->business_name ?? old('business_name') }}" required>
                                                @error('business_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_id">Owner/User</label>
                                                <select class="form-control select2-search" id="user_id" name="user_id">
                                                    <option value="">-- Select User --</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ (isset($business) && $business->user_id == $user->id) || old('user_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }} ({{ $user->email }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3">{{ $business->description ?? old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="establishment_year">Establishment Year</label>
                                                <input type="number" class="form-control" id="establishment_year"
                                                       name="establishment_year" min="1800" max="{{ date('Y') }}"
                                                       value="{{ $business->establishment_year ?? old('establishment_year') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="employee_count">Employee Count</label>
                                                <input type="number" class="form-control" id="employee_count"
                                                       name="employee_count" min="0"
                                                       value="{{ $business->employee_count ?? old('employee_count') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="ownership_type">Ownership Type</label>
                                                <select class="form-control" id="ownership_type" name="ownership_type">
                                                    <option value="">-- Select Type --</option>
                                                    <option value="sole_proprietorship" {{ (isset($business) && $business->ownership_type == 'sole_proprietorship') || old('ownership_type') == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                                                    <option value="partnership" {{ (isset($business) && $business->ownership_type == 'partnership') || old('ownership_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                                    <option value="corporation" {{ (isset($business) && $business->ownership_type == 'corporation') || old('ownership_type') == 'corporation' ? 'selected' : '' }}>Corporation</option>
                                                    <option value="llc" {{ (isset($business) && $business->ownership_type == 'llc') || old('ownership_type') == 'llc' ? 'selected' : '' }}>LLC</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website_url">Website URL</label>
                                                <input type="url" class="form-control" id="website_url"
                                                       name="website_url" placeholder="https://example.com"
                                                       value="{{ $business->website_url ?? old('website_url') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="logo">Business Logo</label>
                                                @if(isset($business) && $business->logo_url)
                                                    <div class="mb-3">
                                                        <label>Current Logo:</label>
                                                        <img src="{{ $business->logo_url }}" width="100" class="img-thumbnail">
                                                        <div class="form-check mt-2">
                                                            <input type="checkbox" class="form-check-input" id="remove_logo" name="remove_logo">
                                                            <label class="form-check-label" for="remove_logo">Remove current logo</label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                                                    <label class="custom-file-label" for="logo">Choose file</label>
                                                </div>
                                                <small class="text-muted">Recommended size: 300x300px (PNG, JPG)</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_verified"
                                                           name="is_verified" {{ (isset($business) && $business->is_verified) || old('is_verified') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_verified">Verified</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_claimed"
                                                           name="is_claimed" {{ (isset($business) && $business->is_claimed) || old('is_claimed') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_claimed">Claimed</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Location Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Location Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_line1">Address Line 1 *</label>
                                                <input type="text" class="form-control" id="address_line1"
                                                       name="address_line1" value="{{ $businessLocation->address_line1 ?? old('address_line1') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address_line2">Address Line 2</label>
                                                <input type="text" class="form-control" id="address_line2"
                                                       name="address_line2" value="{{ $businessLocation->address_line2 ?? old('address_line2') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="landmark">Landmark</label>
                                                <input type="text" class="form-control" id="landmark"
                                                       name="landmark" value="{{ $businessLocation->landmark ?? old('landmark') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City *</label>
                                                <input type="text" class="form-control" id="city"
                                                       name="city" value="{{ $businessLocation->city ?? old('city') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="state">State/Province *</label>
                                                <input type="text" class="form-control" id="state"
                                                       name="state" value="{{ $businessLocation->state ?? old('state') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="country">Country *</label>
                                                <select class="form-control" id="country" name="country" required>
                                                    <option value="">-- Select Country --</option>
                                                    @foreach($countries as $code => $name)
                                                        <option value="{{ $code }}"
                                                            {{ (isset($businessLocation) && $businessLocation->country == $code) || old('country') == $code ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="postal_code">Postal Code</label>
                                                <input type="text" class="form-control" id="postal_code"
                                                       name="postal_code" value="{{ $businessLocation->postal_code ?? old('postal_code') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="is_primary">Primary Location</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_primary"
                                                           name="is_primary" {{ (isset($businessLocation) && $businessLocation->is_primary) || old('is_primary') ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_primary">Yes</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control" id="latitude"
                                                       name="latitude" value="{{ $businessLocation->latitude ?? old('latitude') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control" id="longitude"
                                                       name="longitude" value="{{ $businessLocation->longitude ?? old('longitude') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Contact Information</h5>
                                </div>
                                <div class="card-body">
                                    <div id="contactFields">
                                        @if(isset($businessContacts) && count($businessContacts) > 0)
                                            @foreach($businessContacts as $index => $contact)
                                                <div class="contact-item mb-3 p-3 border rounded">
                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <label>Contact Type *</label>
                                                            <select class="form-control" name="contacts[{{ $index }}][contact_type]" required>
                                                                <option value="phone" {{ $contact->contact_type == 'phone' ? 'selected' : '' }}>Phone</option>
                                                                <option value="email" {{ $contact->contact_type == 'email' ? 'selected' : '' }}>Email</option>
                                                                <option value="fax" {{ $contact->contact_type == 'fax' ? 'selected' : '' }}>Fax</option>
                                                                <option value="whatsapp" {{ $contact->contact_type == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Contact Value *</label>
                                                            <input type="text" class="form-control"
                                                                   name="contacts[{{ $index }}][contact_value]"
                                                                   value="{{ $contact->contact_value }}" required>
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-sm btn-danger remove-contact-btn">
                                                                <i class="fa fa-trash"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-row mt-2">
                                                        <div class="col-md-12">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input"
                                                                       id="contact_primary_{{ $index }}"
                                                                       name="contacts[{{ $index }}][is_primary]"
                                                                       {{ $contact->is_primary ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="contact_primary_{{ $index }}">Primary Contact</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="contact-item mb-3 p-3 border rounded">
                                                <div class="form-row">
                                                    <div class="col-md-4">
                                                        <label>Contact Type *</label>
                                                        <select class="form-control" name="contacts[0][contact_type]" required>
                                                            <option value="phone">Phone</option>
                                                            <option value="email">Email</option>
                                                            <option value="fax">Fax</option>
                                                            <option value="whatsapp">WhatsApp</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Contact Value *</label>
                                                        <input type="text" class="form-control" name="contacts[0][contact_value]" required>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-contact-btn">
                                                            <i class="fa fa-trash"></i> Remove
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="form-row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="contact_primary_0" name="contacts[0][is_primary]">
                                                            <label class="custom-control-label" for="contact_primary_0">Primary Contact</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="addContactBtn" class="btn btn-sm btn-primary mt-2">
                                        <i class="fa fa-plus"></i> Add Contact
                                    </button>
                                </div>
                            </div>

                            <!-- Business Hours Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Business Hours</h5>
                                </div>
                                <div class="card-body">
                                    <div id="hoursFields">
                                        @php
                                            $days = [
                                                'monday' => 'Monday',
                                                'tuesday' => 'Tuesday',
                                                'wednesday' => 'Wednesday',
                                                'thursday' => 'Thursday',
                                                'friday' => 'Friday',
                                                'saturday' => 'Saturday',
                                                'sunday' => 'Sunday'
                                            ];
                                        @endphp

                                        @foreach($days as $dayKey => $dayName)
                                            @php
                                                $hours = isset($businessHours) ? $businessHours->firstWhere('day_of_week', $dayKey) : null;
                                            @endphp
                                            <div class="hours-item mb-3 p-3 border rounded">
                                                <div class="form-row">
                                                    <div class="col-md-2">
                                                        <label>{{ $dayName }}</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Open Time</label>
                                                            <input type="time" class="form-control"
                                                                   name="hours[{{ $dayKey }}][open_time]"
                                                                   value="{{ $hours->open_time ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Close Time</label>
                                                            <input type="time" class="form-control"
                                                                   name="hours[{{ $dayKey }}][close_time]"
                                                                   value="{{ $hours->close_time ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-flex align-items-end">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="closed_{{ $dayKey }}"
                                                                   name="hours[{{ $dayKey }}][is_closed]"
                                                                   {{ $hours && $hours->is_closed ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="closed_{{ $dayKey }}">Closed</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Categories & Amenities Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Categories & Amenities</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Business Categories *</label>
                                                <select class="form-control select2-multiple" id="categories"
                                                        name="categories[]" multiple="multiple" required>
                                                    @foreach($allCategories as $category)
                                                        <option value="{{ $category->category_id }}"
                                                            {{ (isset($businessCategories) && $businessCategories->contains('category_id', $category->category_id)) ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Primary Category *</label>
                                                <select class="form-control" id="primary_category" name="primary_category" required>
                                                    <option value="">-- Select Primary Category --</option>
                                                    @foreach($allCategories as $category)
                                                        <option value="{{ $category->category_id }}"
                                                            {{ (isset($businessCategories) && $businessCategories->where('is_primary', true)->first()->category_id == $category->category_id) ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Business Amenities</label>
                                                <select class="form-control select2-multiple" id="amenities"
                                                        name="amenities[]" multiple="multiple">
                                                    @foreach($allAmenities as $amenity)
                                                        <option value="{{ $amenity->amenity_id }}"
                                                            {{ (isset($businessAmenities) && in_array($amenity->amenity_id, $businessAmenities->pluck('amenity_id')->toArray())) ? 'selected' : '' }}>
                                                            {{ $amenity->amenity_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photos Section -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Business Photos</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($businessPhotos) && count($businessPhotos) > 0)
                                        <div class="row mb-4">
                                            @foreach($businessPhotos as $photo)
                                                <div class="col-md-3 mb-3">
                                                    <div class="photo-thumbnail">
                                                        <img src="{{ $photo->photo_url }}" class="img-fluid">
                                                        <div class="photo-actions">
                                                            <button type="button" class="btn btn-sm btn-danger delete-photo-btn"
                                                                    data-photo-id="{{ $photo->photo_id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Upload New Photos</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="photos"
                                                   name="photos[]" multiple accept="image/*">
                                            <label class="custom-file-label" for="photos">Choose files</label>
                                        </div>
                                        <small class="text-muted">You can select multiple files</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <a href="{{ route('admin.businesses.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($isEdit) ? 'Update' : 'Save' }} Business
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include("layouts.include.footer")

<!-- Additional CSS -->
<style>
    .contact-item, .hours-item {
        background-color: #f9f9f9;
        transition: all 0.3s ease;
    }

    .contact-item:hover, .hours-item:hover {
        background-color: #f1f1f1;
    }

    .photo-thumbnail {
        position: relative;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
    }

    .photo-actions {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #ced4da;
    }
</style>

<!-- Additional JavaScript -->
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-search').select2({
        placeholder: "Search...",
        allowClear: true
    });

    $('.select2-multiple').select2();

    // Update file input label
    $('.custom-file-input').on('change', function() {
        let files = $(this)[0].files;
        let fileNames = [];

        for (let i = 0; i < files.length; i++) {
            fileNames.push(files[i].name);
        }

        $(this).next('.custom-file-label').addClass("selected").html(
            files.length > 1 ? `${files.length} files selected` : fileNames[0]
        );
    });

    // Contact fields management
    let contactCount = {{ isset($businessContacts) ? count($businessContacts) : 1 }};

    $('#addContactBtn').click(function() {
        let newContact = `
            <div class="contact-item mb-3 p-3 border rounded">
                <div class="form-row">
                    <div class="col-md-4">
                        <label>Contact Type *</label>
                        <select class="form-control" name="contacts[${contactCount}][contact_type]" required>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>
                            <option value="fax">Fax</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Contact Value *</label>
                        <input type="text" class="form-control" name="contacts[${contactCount}][contact_value]" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-contact-btn">
                            <i class="fa fa-trash"></i> Remove
                        </button>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input"
                                   id="contact_primary_${contactCount}" name="contacts[${contactCount}][is_primary]">
                            <label class="custom-control-label" for="contact_primary_${contactCount}">Primary Contact</label>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#contactFields').append(newContact);
        contactCount++;
    });

    $(document).on('click', '.remove-contact-btn', function() {
        if ($('#contactFields .contact-item').length > 1) {
            $(this).closest('.contact-item').remove();
        } else {
            toastr.warning('At least one contact is required.');
        }
    });

    // Primary category sync with categories
    $('#categories').on('change', function() {
        let selectedCategories = $(this).val();
        let primarySelect = $('#primary_category');

        primarySelect.empty();
        primarySelect.append('<option value="">-- Select Primary Category --</option>');

        if (selectedCategories) {
            $('#categories option').each(function() {
                if ($.inArray(this.value, selectedCategories) !== -1) {
                    primarySelect.append($(this).clone());
                }
            });
        }
    });

    // Form validation
    $('#businessForm').validate({
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

    // Photo deletion
    $(document).on('click', '.delete-photo-btn', function() {
        let photoId = $(this).data('photo-id');
        if (confirm('Are you sure you want to delete this photo?')) {
            $.ajax({
                url: '/admin/businesses/photos/' + photoId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    toastr.success(response.message);
                    $(this).closest('.col-md-3').remove();
                }.bind(this),
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        }
    });
});
</script>
