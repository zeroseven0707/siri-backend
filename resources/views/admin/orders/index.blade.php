@extends('admin.layout')
@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Orders</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500">All Orders</h6>
            </div>
            <div class="card-body">
                @livewire('orders-table')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@endpush

@push('styles')
@include('admin.partials.table-styles')
<style>
/* Order Status Tabs */
.order-status-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 0;
    margin-bottom: 0;
    list-style: none;
    padding-left: 0;
}
.order-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border: none;
    background: none;
    color: #5a5f7d;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all .2s;
    border-radius: 4px 4px 0 0;
}
.order-tab-btn:hover { color: #EC4899; background: rgba(236,72,153,.05); }
.order-tab-btn.active { color: #EC4899; border-bottom-color: #EC4899; background: rgba(236,72,153,.05); }
.tab-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 20px; height: 20px; padding: 0 5px;
    border-radius: 10px; font-size: 11px; font-weight: 600; color: white;
}
.tab-count--info    { background: #2196f3; }
.tab-count--warning { background: #fa8b0c; }
.tab-count--primary { background: #EC4899; }
.tab-count--success { background: #01b81a; }
.tab-count--danger  { background: #e85347; }
</style>
@endpush
