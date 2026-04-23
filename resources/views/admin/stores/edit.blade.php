@extends('admin.layout')
@section('title', 'Edit Store')
@section('page-title', 'Edit Store')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    {{-- Left Column: Store Settings --}}
    <div class="col-lg-4 mb-30">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-shop me-2 text-primary"></i>Store Information</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.stores.update', $store) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2">Store Name</label>
                        <input type="text" name="name" class="form-control form-control-lg border-0" value="{{ old('name', $store->name) }}" required>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2">Phone Number</label>
                        <input type="text" name="phone" class="form-control form-control-lg border-0" value="{{ old('phone', $store->phone) }}" required>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2">Description</label>
                        <textarea name="description" class="form-control border-0" rows="3">{{ old('description', $store->description) }}</textarea>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2">Address</label>
                        <textarea name="address" class="form-control border-0" rows="2" required>{{ old('address', $store->address) }}</textarea>
                    </div>

                    <div class="row g-3 mb-24">
                        <div class="col-6">
                            <label class="form-label fw-600 mb-2">Latitude</label>
                            <input type="number" step="any" name="latitude" class="form-control border-0" value="{{ old('latitude', $store->latitude) }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-600 mb-2">Longitude</label>
                            <input type="number" step="any" name="longitude" class="form-control border-0" value="{{ old('longitude', $store->longitude) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2">Store Image</label>
                        @if($store->image)
                        <div class="mb-3 position-relative d-inline-block w-100">
                            <img src="{{ asset('storage/' . $store->image) }}" class="rounded-3 shadow-sm w-100 h-120 object-fit-cover">
                        </div>
                        @endif
                        <input type="file" class="form-control border-0" name="image" accept="image/*">
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2 d-block">Status</label>
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', $store->is_open) ? 'checked' : '' }}>
                            <label class="form-check-label ms-2" for="is_open">Store is Open</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg border-0 shadow-sm">Update Store</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Food Items Management --}}
    <div class="col-lg-8 mb-30">
        <div class="card border-0 shadow-sm mb-30">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-utensils-alt me-2 text-primary"></i>Store Menu (Food Items)</h6>
                <button type="button" class="btn btn-sm btn-primary-light" data-bs-toggle="collapse" data-bs-target="#addFoodFormCard">
                    <i class="uil uil-plus me-1"></i> Add New Menu
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class=">
                            <tr>
                                <th class="ps-4" width="80">Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($store->foodItems as $food)
                            <tr>
                                <td class="ps-4">
                                    <div class="item-img-container shadow-sm rounded-3 overflow-hidden" style="width:50px; height:50px;">
                                        @if($food->image)
                                            <img src="{{ asset('storage/' . $food->image) }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class= d-flex align-items-center justify-content-center w-100 h-100 text-muted small">N/A</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-600 text-dark">{{ $food->name }}</div>
                                    <div class="text-muted fs-12">{{ Str::limit($food->description, 50) }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">Rp {{ number_format($food->price, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    @if($food->is_available)
                                        <span class="badge rounded-pill bg-soft-success text-success px-3">Available</span>
                                    @else
                                        <span class="badge rounded-pill bg-soft-danger text-danger px-3">Sold Out</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon btn-light btn-sm rounded-pill edit-food-btn" 
                                            data-food="{{ json_encode($food) }}"
                                            data-url="{{ route('admin.stores.food.update', [$store, $food]) }}">
                                            <i class="uil uil-edit-alt text-primary fs-16"></i>
                                        </button>
                                        <form action="{{ route('admin.stores.food.destroy', [$store, $food]) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-light btn-sm rounded-pill ms-2" onclick="return confirm('Delete this menu item?')">
                                                <i class="uil uil-trash-alt text-danger fs-16"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="uil uil-utensils fs-40 d-block mb-3 opacity-25"></i>
                                        <p class="mb-0">No menu items found</p>
                                        <button class="btn btn-link btn-sm mt-2" data-bs-toggle="collapse" data-bs-target="#addFoodFormCard">Add your first menu</button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add Food Form Card (Collapsible) --}}
        <div class="card border-0 shadow-sm collapse" id="addFoodFormCard">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-plus-circle me-2 text-success"></i>Add New Menu Item</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.stores.food.store', $store) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Item Name</label>
                                <input type="text" name="name" class="form-control border-0" placeholder="e.g. Fried Chicken" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Price (Rp)</label>
                                <input type="number" name="price" class="form-control border-0" placeholder="25000" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Description</label>
                                <textarea name="description" class="form-control border-0" rows="2" placeholder="Optional description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Item Image</label>
                                <input type="file" name="image" class="form-control border-0" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Available</label>
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="is_available" value="1" checked>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-label fw-600 mb-2">&nbsp;</div>
                            <button type="submit" class="btn btn-success w-100 border-0 shadow-sm">Save Menu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Food Modal -->
<div class="modal fade" id="editFoodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold"><i class="uil uil-edit-alt me-2 text-primary"></i>Edit Menu Item</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editFoodForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Item Name</label>
                                <input type="text" name="name" id="edit_food_name" class="form-control border-0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Price (Rp)</label>
                                <input type="number" name="price" id="edit_food_price" class="form-control border-0" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Description</label>
                                <textarea name="description" id="edit_food_description" class="form-control border-0" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Image</label>
                                <div id="current_food_image" class="mb-3"></div>
                                <input type="file" name="image" class="form-control border-0" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Available</label>
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="is_available" id="edit_food_available" value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-light px-4 border-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 border-0 shadow-sm">Update Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fw-600 { font-weight: 600; }
    .bg-soft-success { background-color: rgba(34, 197, 94, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .fs-12 { font-size: 12px; }
    .fs-16 { font-size: 16px; }
    .h-120 { height: 120px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
    .btn-primary-light { background-color: rgba(34, 197, 94, 0.1); color: #16A34A; border: none; font-weight: 600; }
    .btn-primary-light:hover { background-color: #22C55E; color: white; }
    .form-control:focus, .form-select:focus { box-shadow: none; border: 1px solid var(--color-primary); }
    .form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
    .form-switch .form-check-input:checked { background-color: #22C55E; border-color: #22C55E; }
    .object-fit-cover { object-fit: cover; }
    .item-img-container { border: 1px solid #f1f2f6; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.edit-food-btn').on('click', function() {
            const food = $(this).data('food');
            const url = $(this).data('url');
            const modal = $('#editFoodModal');
            const form = $('#editFoodForm');

            form.attr('action', url);
            $('#edit_food_name').val(food.name);
            $('#edit_food_price').val(food.price);
            $('#edit_food_description').val(food.description);
            $('#edit_food_available').prop('checked', food.is_available);

            if (food.image) {
                $('#current_food_image').html(`<img src="/storage/${food.image}" class="rounded-3 shadow-sm" style="width:100px; height:60px; object-fit:cover;">`);
            } else {
                $('#current_food_image').empty();
            }

            modal.modal('show');
        });
    });
</script>
@endpush
