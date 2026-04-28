@extends('admin.layout')
@section('title', 'Edit Home Section')
@section('page-title', 'Edit Home Section')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.home-sections.index') }}">Home Sections</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    {{-- Left Column: Section Settings --}}
    <div class="col-lg-4 mb-30">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-setting me-2 text-primary"></i>Section Settings</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2" for="title">Section Title</label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg border-0" value="{{ old('title', $homeSection->title) }}" placeholder="e.g. Popular Stores" required>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2" for="key">Section Key (Slug)</label>
                        <input type="text" id="key" name="key" class="form-control form-control-lg border-0" value="{{ old('key', $homeSection->key) }}" placeholder="e.g. popular_stores" required>
                        <small class="text-muted">Unique identifier used in the app</small>
                    </div>

                    <div class="form-group mb-24">
                        <label class="form-label fw-600 mb-2" for="type">Display Type</label>
                        <select id="type" name="type" class="form-select form-select-lg border-0" required>
                            <option value="banner" {{ old('type', $homeSection->type) === 'banner' ? 'selected' : '' }}>Banner (Image Only)</option>
                            <option value="store_list" {{ old('type', $homeSection->type) === 'store_list' ? 'selected' : '' }}>Store List</option>
                            <option value="food_list" {{ old('type', $homeSection->type) === 'food_list' ? 'selected' : '' }}>Food List</option>
                            <option value="service_list" {{ old('type', $homeSection->type) === 'service_list' ? 'selected' : '' }}>Service List</option>
                            <option value="promo" {{ old('type', $homeSection->type) === 'promo' ? 'selected' : '' }}>Promotion Card</option>
                            <option value="custom" {{ old('type', $homeSection->type) === 'custom' ? 'selected' : '' }}>Custom Section</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-24">
                                <label class="form-label fw-600 mb-2">Status</label>
                                <div class="form-check form-switch pt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 pt-10">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm border-0">
                            Update Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Items Management --}}
    <div class="col-lg-8 mb-30">
        <div class="card border-0 shadow-sm mb-30">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-list-ul me-2 text-primary"></i>Items List</h6>
                <button type="button" class="btn btn-sm btn-primary-light" data-bs-toggle="collapse" data-bs-target="#addItemFormCard">
                    <i class="uil uil-plus me-1"></i> Add New Item
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class=">
                            <tr>
                                <th class="ps-4" width="80">Order</th>
                                <th width="100">Image</th>
                                <th>Item Details</th>
                                <th>Type</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($homeSection->items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-muted">{{ $item->order }}</div>
                                </td>
                                <td>
                                    <div class="item-img-container shadow-sm rounded-3 overflow-hidden" style="width:50px; height:50px;">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class= d-flex align-items-center justify-content-center w-100 h-100 text-muted small">N/A</div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-600 text-dark">{{ $item->title ?: 'Untitled Item' }}</div>
                                    <div class="text-muted fs-12">{{ Str::limit($item->subtitle, 40) }}</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-soft-info text-info text-uppercase fs-10 fw-700 px-3">
                                        {{ $item->action_type }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-icon btn-light btn-sm rounded-pill edit-item-btn"
                                            data-item="{{ json_encode($item) }}"
                                            data-url="{{ route('admin.home-sections.items.update', [$homeSection, $item]) }}">
                                            <i class="uil uil-edit-alt text-primary fs-16"></i>
                                        </button>
                                        <form action="{{ route('admin.home-sections.items.destroy', [$homeSection, $item]) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-light btn-sm rounded-pill ms-2" onclick="return confirm('Remove this item?')">
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
                                        <i class="uil uil-layer-group fs-40 d-block mb-3 opacity-25"></i>
                                        <p class="mb-0">No items found in this section</p>
                                        <button class="btn btn-link btn-sm mt-2" data-bs-toggle="collapse" data-bs-target="#addItemFormCard">Add your first item</button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Add Item Form Card (Collapsible) --}}
        <div class="card border-0 shadow-sm collapse" id="addItemFormCard">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="fw-bold mb-0 text-dark"><i class="uil uil-plus-circle me-2 text-success"></i>Add New Item</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.home-sections.items.store', $homeSection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Item Type</label>
                                <select name="action_type" class="form-select border-0 action-type-select" required>
                                    <option value="store">Link to Store</option>
                                    <option value="food">Link to Food Item</option>
                                    <option value="service">Link to Service</option>
                                    <option value="url">External URL</option>
                                    <option value="route">App Route</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Target Selection</label>
                                <select name="action_value" class="form-select border-0 action-value-select" required></select>
                                <input type="text" name="action_value" class="form-control border-0 action-value-input d-none" placeholder="e.g. https://google.com">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Display Title</label>
                                <input type="text" name="title" class="form-control border-0" placeholder="Optional: Overrides target name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Display Subtitle</label>
                                <input type="text" name="subtitle" class="form-control border-0" placeholder="Optional: Overrides target info">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Custom Image</label>
                                <input type="file" name="image" class="form-control border-0" accept="image/*">
                                <small class="text-muted mt-1 d-block fs-11">Recommended: 800x400px. Skip to use target image.</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Order</label>
                                <input type="number" name="order" class="form-control border-0" value="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-label fw-600 mb-2">&nbsp;</div>
                            <button type="submit" class="btn btn-success w-100 shadow-sm border-0">Add Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modern Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold"><i class="uil uil-edit-alt me-2 text-primary"></i>Edit Section Item</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editItemForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Action Type</label>
                                <select name="action_type" id="edit_action_type" class="form-select border-0 action-type-select" required>
                                    <option value="store">Store</option>
                                    <option value="food">Food Item</option>
                                    <option value="service">Service</option>
                                    <option value="url">URL</option>
                                    <option value="route">App Route</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Target Selection</label>
                                <select name="action_value" id="edit_action_value_select" class="form-select border-0 action-value-select" required></select>
                                <input type="text" name="action_value" id="edit_action_value_input" class="form-control border-0 action-value-input d-none">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Title</label>
                                <input type="text" name="title" id="edit_title" class="form-control border-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Subtitle</label>
                                <input type="text" name="subtitle" id="edit_subtitle" class="form-control border-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Image</label>
                                <div id="current_item_image" class="mb-3"></div>
                                <input type="file" name="image" class="form-control border-0" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label fw-600 mb-2">Order</label>
                                <input type="number" name="order" id="edit_order" class="form-control border-0" min="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-light px-4 border-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm border-0">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fw-600 { font-weight: 600; }
    .bg-soft-info { background-color: rgba(0, 184, 212, 0.1); }
    .fs-10 { font-size: 10px; }
    .fs-12 { font-size: 12px; }
    .fs-16 { font-size: 16px; }
    .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
    .form-control:focus, .form-select:focus { box-shadow: none; border: 1px solid var(--color-primary); }
    .btn-primary-light { background-color: rgba(34, 197, 94, 0.1); color: #16A34A; border: none; font-weight: 600; }
    .btn-primary-light:hover { background-color: #22C55E; color: white; }
    .form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
    .form-switch .form-check-input:checked { background-color: #22C55E; border-color: #22C55E; }
    .object-fit-cover { object-fit: cover; }
    .item-img-container { border: 1px solid #f1f2f6; }
</style>
@endpush

@push('scripts')
<script>
    const stores = @json($stores);
    const foodItems = @json($foodItems);
    const services = @json($services);

    function updateTargetInput(container) {
        const typeSelect = container.find('.action-type-select');
        const valueSelect = container.find('.action-value-select');
        const valueInput = container.find('.action-value-input');

        const type = typeSelect.val();
        valueSelect.empty();

        if (['store', 'food', 'service'].includes(type)) {
            valueSelect.removeClass('d-none').prop('required', true).attr('name', 'action_value');
            valueInput.addClass('d-none').prop('required', false).removeAttr('name');

            let items = [];
            if (type === 'store') items = stores;
            else if (type === 'food') items = foodItems;
            else if (type === 'service') items = services;

            items.forEach(item => {
                valueSelect.append(`<option value="${item.id}">${item.name}</option>`);
            });
        } else {
            valueSelect.addClass('d-none').prop('required', false).removeAttr('name');
            valueInput.removeClass('d-none').prop('required', true).attr('name', 'action_value');
        }
    }

    $(document).ready(function() {
        // Initial setup for add form
        updateTargetInput($('form[action*="items"]'));

        $(document).on('change', '.action-type-select', function() {
            updateTargetInput($(this).closest('form'));
        });

        // Edit Item Modal logic
        $('.edit-item-btn').on('click', function() {
            const item = $(this).data('item');
            const url = $(this).data('url');
            const modal = $('#editItemModal');
            const form = $('#editItemForm');

            form.attr('action', url);
            $('#edit_action_type').val(item.action_type);

            // Trigger target input update for modal
            updateTargetInput(form);

            if (['store', 'food', 'service'].includes(item.action_type)) {
                $('#edit_action_value_select').val(item.action_value);
            } else {
                $('#edit_action_value_input').val(item.action_value);
            }

            $('#edit_title').val(item.title);
            $('#edit_subtitle').val(item.subtitle);
            $('#edit_order').val(item.order);

            if (item.image) {
                $('#current_item_image').html(`<img src="/storage/${item.image}" class="rounded-3 shadow-sm" style="width:100px; height:60px; object-fit:cover;">`);
            } else {
                $('#current_item_image').empty();
            }

            modal.modal('show');
        });
    });
</script>
@endpush
