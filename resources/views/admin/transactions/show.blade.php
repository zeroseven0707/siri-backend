@extends('admin.layout')
@section('title', 'Transaction Details')
@section('page-title', 'Transaction Details')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-usd-circle me-2"></i>Transaction #{{ $transaction->id }}</h6>
                @if($transaction->status === 'completed')
                    <span class="badge badge-round badge-success">Completed</span>
                @elseif($transaction->status === 'pending')
                    <span class="badge badge-round badge-warning">Pending</span>
                @else
                    <span class="badge badge-round badge-danger">Failed</span>
                @endif
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Transaction ID</span>
                            <span class="summary-list__value fw-500">#{{ $transaction->id }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">User</span>
                            <span class="summary-list__value">
                                <span class="fw-500">{{ $transaction->user->name }}</span>
                                <br><small class="color-light">{{ $transaction->user->email }}</small>
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Type</span>
                            <span class="summary-list__value">
                                @php
                                    $typeColors = ['top_up' => 'success', 'payment' => 'primary', 'refund' => 'warning', 'withdrawal' => 'danger'];
                                    $typeColor = $typeColors[$transaction->type] ?? 'info';
                                @endphp
                                <span class="badge badge-round badge-{{ $typeColor }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                                </span>
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Amount</span>
                            <span class="summary-list__value fw-600 fs-16 color-primary">
                                Rp {{ number_format($transaction->amount) }}
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Payment Method</span>
                            <span class="summary-list__value">{{ $transaction->payment_method ?? '-' }}</span>
                        </li>
                        @if($transaction->description)
                        <li>
                            <span class="summary-list__title">Description</span>
                            <span class="summary-list__value">{{ $transaction->description }}</span>
                        </li>
                        @endif
                        <li>
                            <span class="summary-list__title">Status</span>
                            <span class="summary-list__value">
                                @if($transaction->status === 'completed')
                                    <span class="badge badge-round badge-success">Completed</span>
                                @elseif($transaction->status === 'pending')
                                    <span class="badge badge-round badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-round badge-danger">Failed</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Created At</span>
                            <span class="summary-list__value">{{ $transaction->created_at->format('d M Y H:i:s') }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Updated At</span>
                            <span class="summary-list__value">{{ $transaction->updated_at->format('d M Y H:i:s') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="button-group d-flex pt-25">
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-light btn-default btn-squared text-capitalize">
                        <i class="uil uil-arrow-left me-1"></i> Back to Transactions
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-user me-2"></i>User Info</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-20">
                    <div style="width:60px; height:60px; border-radius:50%; background: linear-gradient(135deg, #EC4899, #A855F7); display:flex; align-items:center; justify-content:center; margin: 0 auto 10px; color:white; font-size:24px; font-weight:600;">
                        {{ substr($transaction->user->name, 0, 1) }}
                    </div>
                    <h6 class="fw-500">{{ $transaction->user->name }}</h6>
                    <p class="color-light fs-13">{{ $transaction->user->email }}</p>
                    @if($transaction->user->phone)
                    <p class="color-light fs-13">{{ $transaction->user->phone }}</p>
                    @endif
                </div>
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Role</span>
                            <span class="summary-list__value">
                                <span class="badge badge-round badge-{{ $transaction->user->role === 'admin' ? 'danger' : ($transaction->user->role === 'driver' ? 'primary' : 'success') }}">
                                    {{ ucfirst($transaction->user->role) }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
