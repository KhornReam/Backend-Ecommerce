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

@if($notifications->isEmpty())
    <div class="empty-state">
        <i class="fa-regular fa-bell-slash"></i>
        <p>No notifications yet</p>
        <span style="font-size:13px;">You're all caught up!</span>
    </div>
@endif

{{ $notifications->links() }}