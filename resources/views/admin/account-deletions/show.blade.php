@extends('admin.layout')
@section('title', 'Account Deletion Request')
@section('page-title', 'Account Deletion Request')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.account-deletions.index') }}">Account Deletions</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-trash-alt me-2"></i>Request #{{ $accountDeletion->id }}</h6>
                @if($accountDeletion->status === 'pending')
                    <span class="badge badge-round badge-warning"><i class="uil uil-clock me-1"></i>Pending</span>
                @elseif($accountDeletion->status === 'approved')
                    <span class="badge badge-round badge-success"><i class="uil uil-check me-1"></i>Approved</span>
                @else
                    <span class="badge badge-round badge-danger"><i class="uil uil-times me-1"></i>Rejected</span>
                @endif
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">User Name</span>
                            <span class="summary-list__value fw-500">{{ $accountDeletion->user->name ?? 'Deleted User' }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Email</span>
                            <span class="summary-list__value">{{ $accountDeletion->user->email ?? '-' }}</span>
                        </li>
                        @if($accountDeletion->user)
                        <li>
                            <span class="summary-list__title">Phone</span>
                            <span class="summary-list__value">{{ $accountDeletion->user->phone ?? '-' }}</span>
                        </li>
                        @endif
                        <li>
                            <span class="summary-list__title">Deletion Reason</span>
                            <span class="summary-list__value">{{ $accountDeletion->reason }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Status</span>
                            <span class="summary-list__value">
                                @if($accountDeletion->status === 'pending')
                                    <span class="badge badge-round badge-warning">Pending</span>
                                @elseif($accountDeletion->status === 'approved')
                                    <span class="badge badge-round badge-success">Approved</span>
                                @else
                                    <span class="badge badge-round badge-danger">Rejected</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Requested At</span>
                            <span class="summary-list__value">{{ $accountDeletion->created_at->format('d M Y H:i') }}</span>
                        </li>
                        @if($accountDeletion->processed_at)
                        <li>
                            <span class="summary-list__title">Processed At</span>
                            <span class="summary-list__value">{{ $accountDeletion->processed_at->format('d M Y H:i') }}</span>
                        </li>
                        @endif
                    </ul>
                </div>

                @if($accountDeletion->rejection_reason)
                <div class="mt-20 p-15" style="background: rgba(239,68,68,0.08); border-radius: 8px; border-left: 3px solid #EF4444;">
                    <p class="fw-500 color-danger mb-5"><i class="uil uil-times-circle me-1"></i>Rejection Reason</p>
                    <p class="color-dark mb-0">{{ $accountDeletion->rejection_reason }}</p>
                </div>
                @endif

                @if($accountDeletion->status === 'pending')
                <div class="button-group d-flex pt-25 gap-3">
                    <form action="{{ route('admin.account-deletions.approve', $accountDeletion) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this deletion? The user account will be permanently deleted.')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-default btn-squared text-capitalize">
                            <i class="uil uil-check me-1"></i> Approve
                        </button>
                    </form>
                    <button type="button" class="btn btn-danger btn-default btn-squared text-capitalize" onclick="document.getElementById('reject-form').style.display='block'; this.style.display='none'">
                        <i class="uil uil-times me-1"></i> Reject
                    </button>
                </div>

                <div id="reject-form" style="display: none;" class="mt-20">
                    <div class="card" style="border: 1px solid #EF4444;">
                        <div class="card-header" style="background: rgba(239,68,68,0.05);">
                            <h6 class="fw-500 color-danger"><i class="uil uil-times-circle me-2"></i>Reject Request</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.account-deletions.reject', $accountDeletion) }}" method="POST">
                                @csrf
                                <div class="form-group mb-20">
                                    <label class="color-dark fs-14 fw-500 align-center mb-10" for="rejection_reason">Rejection Reason <span class="color-danger">*</span></label>
                                    <textarea id="rejection_reason" name="rejection_reason" class="form-control" rows="3" placeholder="Explain why this request is being rejected..." required></textarea>
                                </div>
                                <div class="button-group d-flex pt-10">
                                    <button type="submit" class="btn btn-danger btn-default btn-squared text-capitalize">
                                        <i class="uil uil-times me-1"></i> Submit Rejection
                                    </button>
                                    <button type="button" class="btn btn-light btn-default btn-squared text-capitalize ms-15" onclick="document.getElementById('reject-form').style.display='none'; document.querySelector('.btn-danger[onclick]').style.display='inline-flex'">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-25">
                    <a href="{{ route('admin.account-deletions.index') }}" class="btn btn-light btn-default btn-squared text-capitalize">
                        <i class="uil uil-arrow-left me-1"></i> Back to Requests
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
                @if($accountDeletion->user)
                <div class="text-center mb-20">
                    <div style="width:60px; height:60px; border-radius:50%; background: linear-gradient(135deg, #22C55E, #16A34A); display:flex; align-items:center; justify-content:center; margin: 0 auto 10px; color:white; font-size:24px; font-weight:600;">
                        {{ substr($accountDeletion->user->name, 0, 1) }}
                    </div>
                    <h6 class="fw-500">{{ $accountDeletion->user->name }}</h6>
                    <p class="color-light fs-13">{{ $accountDeletion->user->email }}</p>
                    @if($accountDeletion->user->phone)
                    <p class="color-light fs-13"><i class="uil uil-phone me-1"></i>{{ $accountDeletion->user->phone }}</p>
                    @endif
                </div>
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Role</span>
                            <span class="summary-list__value">
                                <span class="badge badge-round badge-{{ $accountDeletion->user->role === 'admin' ? 'danger' : ($accountDeletion->user->role === 'driver' ? 'primary' : 'success') }}">
                                    {{ ucfirst($accountDeletion->user->role) }}
                                </span>
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Joined</span>
                            <span class="summary-list__value">{{ $accountDeletion->user->created_at->format('d M Y') }}</span>
                        </li>
                    </ul>
                </div>
                @else
                <div class="text-center py-20">
                    <i class="uil uil-user-times fs-30 color-light d-block mb-10"></i>
                    <p class="color-light">User account has been deleted</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
