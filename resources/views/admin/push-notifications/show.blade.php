@extends('admin.layout')
@section('title', 'Notification Details')
@section('page-title', 'Notification Details')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.push-notifications.index') }}">Push Notifications</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500">{{ $pushNotification->title }}</h6>
                @if($pushNotification->status === 'sent')
                    <span class="badge badge-round badge-success"><i class="uil uil-check me-1"></i>Sent</span>
                @elseif($pushNotification->status === 'scheduled')
                    <span class="badge badge-round badge-warning"><i class="uil uil-clock me-1"></i>Scheduled</span>
                @else
                    <span class="badge badge-round badge-danger"><i class="uil uil-times me-1"></i>Failed</span>
                @endif
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Title</span>
                            <span class="summary-list__value">{{ $pushNotification->title }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Message</span>
                            <span class="summary-list__value">{{ $pushNotification->body }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Target Audience</span>
                            <span class="summary-list__value">
                                @if($pushNotification->target === 'all')
                                    <span class="badge badge-round badge-primary">All Users</span>
                                @elseif($pushNotification->target === 'users')
                                    <span class="badge badge-round badge-info">Customers Only</span>
                                @else
                                    <span class="badge badge-round badge-warning">Drivers Only</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Recipients</span>
                            <span class="summary-list__value">{{ number_format($pushNotification->sent_count ?? 0) }} users</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Status</span>
                            <span class="summary-list__value">
                                @if($pushNotification->status === 'sent')
                                    <span class="badge badge-round badge-success">Sent</span>
                                @elseif($pushNotification->status === 'scheduled')
                                    <span class="badge badge-round badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-round badge-danger">Failed</span>
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">
                                @if($pushNotification->status === 'scheduled') Scheduled For @else Sent At @endif
                            </span>
                            <span class="summary-list__value">
                                @if($pushNotification->sent_at)
                                    {{ $pushNotification->sent_at->format('d M Y H:i') }}
                                @elseif($pushNotification->scheduled_at)
                                    {{ $pushNotification->scheduled_at->format('d M Y H:i') }}
                                @else
                                    -
                                @endif
                            </span>
                        </li>
                        <li>
                            <span class="summary-list__title">Created At</span>
                            <span class="summary-list__value">{{ $pushNotification->created_at->format('d M Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="button-group d-flex pt-25">
                    <a href="{{ route('admin.push-notifications.index') }}" class="btn btn-light btn-default btn-squared text-capitalize">
                        <i class="uil uil-arrow-left me-1"></i> Back to Notifications
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-mobile-android me-2"></i>Notification Preview</h6>
            </div>
            <div class="card-body">
                <div class="p-15" style="background: #f8f9fa; border-radius: 12px;">
                    <div class="d-flex align-items-center mb-10">
                        <div style="width:36px; height:36px; border-radius:8px; background: linear-gradient(135deg, #EC4899, #A855F7); display:flex; align-items:center; justify-content:center; margin-right:10px;">
                            <i class="uil uil-bell" style="color:white; font-size:18px;"></i>
                        </div>
                        <div>
                            <div class="fs-12 color-light">SIRI App</div>
                            @if($pushNotification->sent_at)
                            <div class="fs-12 color-light">{{ $pushNotification->sent_at->diffForHumans() }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="fw-500 color-dark fs-14 mb-5">{{ $pushNotification->title }}</div>
                    <div class="fs-13 color-light">{{ $pushNotification->body }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
