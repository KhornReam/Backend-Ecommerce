@extends('admin.layout')

@section('title', 'Notifications')

@section('content')

<style>
    .card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,.04);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: #3b82f6;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: .2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
    }

    .btn-outline {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
    }

    .btn-outline:hover {
        background: #f8fafc;
    }

    .notification-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .notification-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        transition: .2s;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item.unread {
        background: #eff6ff;
        margin: 0 -24px;
        padding: 16px 24px;
        border-radius: 0;
    }

    .notification-item.unread:first-child {
        border-radius: 12px 12px 0 0;
    }

    .notification-item.unread:last-child {
        border-radius: 0 0 12px 12px;
    }

    .notification-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .notification-content {
        flex: 1;
        min-width: 0;
    }

    .notification-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .notification-message {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
    }

    .notification-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
        flex-shrink: 0;
    }

    .notification-time {
        font-size: 12px;
        color: #94a3b8;
    }

    .notification-actions {
        display: flex;
        gap: 6px;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: .2s;
    }

    .btn-icon:hover {
        background: #f8fafc;
        color: #374151;
    }

    .btn-icon.danger:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .unread-badge {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #3b82f6;
        margin-top: 6px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 16px;
        font-weight: 500;
        color: #64748b;
        margin-bottom: 8px;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        color: #374151;
    }

    .pagination .current {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    @media (max-width: 640px) {
        .notification-meta {
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
            margin-top: 8px;
        }
    }
</style>

<div class="card">

    <div class="card-header">
        <div class="card-title">
            <i class="fa-solid fa-bell"></i>
            Notifications
        </div>
        <div style="display:flex;gap:8px;align-items:center;">
            <span style="font-size:13px;color:#64748b;">{{ $notifications->total() }} total</span>
            @if($notifications->where('read_at', null)->count() > 0)
                <form action="{{ route('admin.notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        <i class="fa-solid fa-check-double"></i> Mark all read
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if($notifications->isEmpty())
        <div class="empty-state">
            <i class="fa-regular fa-bell-slash"></i>
            <p>No notifications yet</p>
            <span style="font-size:13px;">You're all caught up!</span>
        </div>
    @else
        <div class="notification-list">
            @foreach($notifications as $notification)
                <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}">
                    <div class="notification-icon">
                        @if($notification->data['icon'] ?? 'bell' === 'login')
                            <i class="fa-solid fa-user-check"></i>
                        @else
                            <i class="fa-solid fa-bell"></i>
                        @endif
                    </div>

                    <div class="notification-content">
                        <div class="notification-title">
                            {{ $notification->data['title'] ?? 'Notification' }}
                            @if(!$notification->read_at)
                                <span class="unread-badge" style="display:inline-block;"></span>
                            @endif
                        </div>
                        <div class="notification-message">
                            {{ $notification->data['message'] ?? '' }}
                            @if(isset($notification->data['ip_address']))
                                <br><span style="font-size:11px;color:#94a3b8;">
                                    IP: {{ $notification->data['ip_address'] }} | 
                                    {{ $notification->data['user_agent'] ?? 'Unknown' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="notification-meta">
                        <span class="notification-time">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        <div class="notification-actions">
                            @if(!$notification->read_at)
                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-icon" title="Mark as read">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon danger" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $notifications->links() }}
        </div>
    @endif

</div>

@endsection