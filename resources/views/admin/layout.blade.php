<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
      rel="stylesheet">

<style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family:'Inter',sans-serif;
    }

    body{
       background-color: #0c152a;
    }

    :root{
        --primary:#2563eb;
        --sidebar:#0f172a;
        --sidebar-hover:#1e293b;
        --border:#e5e7eb;
        --text-muted:#64748b;
    }

    /* =========================
       SIDEBAR
    ========================= */

    .sidebar{
        width:260px;
        height:100vh;
        position:fixed;
        top:0;
        left:0;
        background:var(--sidebar);
        display:flex;
        flex-direction:column;
        padding:20px;
        z-index:100;
    }

    .logo{
        display:flex;
        align-items:center;
        gap:12px;
        padding-bottom:25px;
        border-bottom:1px solid rgba(255,255,255,.08);
    }

    .logo-icon{
        width:42px;
        height:42px;
        border-radius:12px;
        background:linear-gradient(
            135deg,
            #2563eb,
            #7c3aed
        );

        display:flex;
        align-items:center;
        justify-content:center;
        color:white;
        font-size:18px;
    }

    .logo h2{
        color:white;
        font-size:18px;
        font-weight:700;
    }

    .logo p{
        color:#94a3b8;
        font-size:12px;
    }

    .menu{
        margin-top:25px;
        flex:1;
    }

    .menu-title{
        color:#64748b;
        font-size:11px;
        text-transform:uppercase;
        letter-spacing:.12em;
        margin-bottom:10px;
        padding-left:12px;
    }

    .menu a{
        display:flex;
        align-items:center;
        gap:12px;
        text-decoration:none;
        color:#cbd5e1;
        padding:12px 14px;
        border-radius:12px;
        margin-bottom:6px;
        transition:.2s;
        font-size:14px;
        font-weight:500;
    }

    .menu a i{
        width:18px;
    }

    .menu a:hover{
        background:var(--sidebar-hover);
        color:white;
        transform:translateX(4px);
    }

    .active{
        background:linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        ) !important;

        color:white !important;
    }

    /* =========================
       PROFILE CARD
    ========================= */

    .profile-card{
        background:#111c31;
        border:1px solid rgba(255,255,255,.06);
        border-radius:14px;
        padding:14px;
        margin-bottom:15px;
    }

    .profile{
        display:flex;
        align-items:center;
        gap:10px;
    }

    .avatar{
        width:42px;
        height:42px;
        border-radius:50%;
        background:#2563eb;
        color:white;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
    }

    .profile h4{
        color:white;
        font-size:14px;
    }

    .profile p{
        color:#94a3b8;
        font-size:12px;
    }

    /* =========================
       LOGOUT
    ========================= */

    .logout-btn{
        width:100%;
        border:none;
        background:#dc2626;
        color:white;
        padding:11px;
        border-radius:10px;
        cursor:pointer;
        transition:.2s;
        font-weight:600;
    }

    .logout-btn:hover{
        background:#b91c1c;
    }

    /* =========================
       MAIN
    ========================= */

    .main{
        margin-left:260px;
        min-height:100vh;
        padding:24px;
    }

    /* =========================
       TOPBAR
    ========================= */
/* =========================
   TOPBAR DARK THEME
========================= */

.topbar{
    background:#111c31;
    border:1px solid #1e293b;
    border-radius:16px;
    padding:16px 20px;
    margin-bottom:20px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    position:sticky;
    top:15px;

    z-index:50;

    box-shadow:
        0 10px 30px rgba(0,0,0,.25);
}

.page-title{
    font-size:20px;
    font-weight:700;
    color:#ffffff;
}

.page-subtitle{
    color:#94a3b8;
    font-size:13px;
    margin-top:2px;
}

.top-actions{
    display:flex;
    align-items:center;
    gap:12px;
}

/* =========================
   SEARCH BOX
========================= */

.search-box{
    position:relative;
}

.search-box input{
    width:260px;
    background:#0f172a;
    color:white;

    border:1px solid #1e293b;
    border-radius:12px;

    padding:10px 14px 10px 38px;
    outline:none;

    transition:.25s;
}

.search-box input::placeholder{
    color:#64748b;
}

.search-box input:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.15);
}

.search-box i{
    position:absolute;
    left:14px;
    top:12px;
    color:#64748b;
}

/* =========================
   ICON BUTTONS
========================= */

.icon-btn{
    width:42px;
    height:42px;

    border-radius:12px;
    border:1px solid #1e293b;

    background:#0f172a;
    color:white;

    cursor:pointer;

    display:flex;
    align-items:center;
    justify-content:center;

    transition:.2s;
}

.icon-btn:hover{
    background:#1e293b;
    transform:translateY(-2px);
}

.relative{
    position:relative;
}

/* =========================
   NOTIFICATION BADGE
========================= */

.notification-badge{
    position:absolute;
    top:-2px;
    right:-2px;

    min-width:18px;
    height:18px;

    background:#ef4444;
    color:white;

    font-size:10px;
    font-weight:700;

    border-radius:999px;

    display:flex;
    align-items:center;
    justify-content:center;

    padding:0 5px;

    border:2px solid #111c31;

    box-shadow:0 2px 8px rgba(0,0,0,.3);

    animation:pulse 2s infinite;
}

@keyframes pulse{
    0%,100%{
        transform:scale(1);
    }
    50%{
        transform:scale(1.1);
    }
}

/* =========================
   NOTIFICATION PANEL
========================= */

.notification-dropdown{
    position:relative;
}

.notification-panel{
    position:absolute;
    top:calc(100% + 8px);
    right:0;

    width:380px;

    background:#111c31;
    border:1px solid #1e293b;

    border-radius:16px;

    box-shadow:
        0 20px 40px rgba(0,0,0,.35);

    z-index:100;
    overflow:hidden;
}

.notification-panel-header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 20px;

    border-bottom:1px solid #1e293b;

    background:#0f172a;
}

.notification-panel-header h4{
    margin:0;
    font-size:15px;
    font-weight:700;
    color:white;
}

.view-all{
    font-size:12px;
    color:#60a5fa;
    text-decoration:none;
    font-weight:600;
}

.view-all:hover{
    color:#93c5fd;
}

.notification-panel-body{
    max-height:360px;
    overflow-y:auto;
}

/* =========================
   NOTIFICATION ITEM
========================= */

.notification-panel-item{
    display:flex;
    align-items:flex-start;
    gap:12px;

    padding:14px 18px;

    border-bottom:1px solid #1e293b;

    text-decoration:none;
    color:inherit;

    transition:.2s;
}

.notification-panel-item:hover{
    background:#1e293b;
}

.notification-panel-item.unread{
    background:rgba(37,99,235,.12);
}

.notification-panel-icon{
    width:36px;
    height:36px;

    border-radius:10px;

    background:rgba(37,99,235,.15);
    color:#60a5fa;

    display:flex;
    align-items:center;
    justify-content:center;

    flex-shrink:0;
    font-size:15px;
}

.notification-panel-content{
    flex:1;
    min-width:0;
}

.notification-panel-title{
    font-size:13px;
    font-weight:600;
    color:white;
    margin-bottom:3px;
}

.notification-panel-message{
    font-size:12px;
    color:#94a3b8;
    line-height:1.4;
}

.notification-panel-time{
    font-size:11px;
    color:#64748b;
    margin-top:4px;
    display:block;
}

.notification-loading,
.notification-empty{
    padding:40px 20px;
    text-align:center;
    color:#94a3b8;
    font-size:13px;
}

/* =========================
   CONTENT ANIMATION
========================= */

.content{
    animation:fadeIn .25s ease;
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(10px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:992px){

    .sidebar{
        width:80px;
    }

    .logo h2,
    .logo p,
    .menu span,
    .profile-info{
        display:none;
    }

    .main{
        margin-left:80px;
    }

    .search-box{
        display:none;
    }
}

</style>

</head>
<body>

<div class="sidebar">

<div class="logo">
    <div class="logo-icon">
        <i class="fa-solid fa-layer-group"></i>
    </div>

    <div>
        <h2>E-Commerce</h2>
        <p>Admin Dashboard</p>
    </div>
</div>

<div class="menu">

    <div class="menu-title">
        Main Menu
    </div>

    <a href="{{ route('admin.dashboard') }}"
       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
        <i class="fa-solid fa-list"></i>
        <span>Categories</span>
    </a>

    <a href="{{ route('admin.products.index') }}"
       class="{{ request()->is('admin/products*') ? 'active' : '' }}">
        <i class="fa-solid fa-box"></i>
        <span>Products</span>
    </a>

    <a href="{{ route('admin.orders.index') }}"
       class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Orders</span>
    </a>

</div>

    <a href="{{ route('admin.profile') }}" class="profile-card" style="text-decoration:none;color:inherit;">

    <div class="profile">

        @if(auth()->user()->avatar_url)
            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="avatar" style="object-fit:cover;">
        @else
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}
            </div>
        @endif

        <div class="profile-info">
            <h4>{{ auth()->user()->name ?? 'Admin' }}</h4>
            <p>Administrator</p>
        </div>

    </div>

    </a>

<form method="POST" action="{{ route('admin.logout') }}">
    @csrf

    <button class="logout-btn">
        <i class="fa-solid fa-right-from-bracket"></i>
        Logout
    </button>
</form>

</div>

<div class="main">

<div class="topbar">

    <div>
        <div class="page-title">
            @yield('title')
        </div>

        <div class="page-subtitle">
            Manage your store efficiently
        </div>
    </div>

        <div class="top-actions">

        <div class="search-box">
            <i class="fa-solid fa-search"></i>
            <input type="text" placeholder="Search...">
        </div>

        <div class="notification-dropdown" id="notificationDropdown">
            <button class="icon-btn relative" onclick="toggleNotificationDropdown()">
                <i class="fa-regular fa-bell"></i>
                <span class="notification-badge" id="notificationBadge" style="display:none;"></span>
            </button>
            <div class="notification-panel" id="notificationPanel" style="display:none;">
                <div class="notification-panel-header">
                    <h4>Notifications</h4>
                    <a href="{{ route('admin.notifications.index') }}" class="view-all">View all</a>
                </div>
                <div class="notification-panel-body" id="notificationPanelBody">
                    <div class="notification-loading">
                        <i class="fa-solid fa-spinner fa-spin"></i> Loading...
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.profile') }}" class="icon-btn" style="text-decoration:none;">
            <i class="fa-regular fa-user"></i>
        </a>

    </div>

</div>

<div class="content">
    @yield('content')
</div>

</div>

<script>
    // Notification dropdown toggle
    function toggleNotificationDropdown() {
        const panel = document.getElementById('notificationPanel');
        const isHidden = panel.style.display === 'none' || panel.style.display === '';
        
        if (isHidden) {
            panel.style.display = 'block';
            loadNotifications();
        } else {
            panel.style.display = 'none';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('notificationDropdown');
        const panel = document.getElementById('notificationPanel');
        if (dropdown && panel && !dropdown.contains(e.target)) {
            panel.style.display = 'none';
        }
    });

    // Load unread count on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetchUnreadCount();
        
        // Refresh every 30 seconds
        setInterval(fetchUnreadCount, 30000);
    });

    async function fetchUnreadCount() {
        try {
            const response = await fetch('{{ route('admin.notifications.unreadCount') }}');
            const data = await response.json();
            const badge = document.getElementById('notificationBadge');
            
            if (data.count > 0) {
                badge.textContent = data.count > 9 ? '9+' : data.count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        } catch (error) {
            console.error('Failed to fetch notification count:', error);
        }
    }

    async function loadNotifications() {
        const body = document.getElementById('notificationPanelBody');
        
        try {
            const response = await fetch('{{ route('admin.notifications.index') }}?ajax=1');
            const html = await response.text();
            
            // Extract notification items from the full page
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const items = doc.querySelector('.notification-list');
            
            if (items && items.children.length > 0) {
                body.innerHTML = '';
                items.querySelectorAll('.notification-item').forEach(item => {
                    // Create a simplified version for dropdown
                    const clone = createNotificationPanelItem(item);
                    body.appendChild(clone);
                });
            } else {
                body.innerHTML = '<div class="notification-empty">No notifications</div>';
            }
        } catch (error) {
            console.error('Failed to load notifications:', error);
            body.innerHTML = '<div class="notification-empty">Failed to load</div>';
        }
    }

    function createNotificationPanelItem(item) {
        const div = document.createElement('a');
        div.href = '#';
        div.className = 'notification-panel-item' + (item.classList.contains('unread') ? ' unread' : '');
        
        const icon = item.querySelector('.notification-icon i');
        const title = item.querySelector('.notification-title');
        const message = item.querySelector('.notification-message');
        const time = item.querySelector('.notification-time');
        
        div.innerHTML = `
            <div class="notification-panel-icon">
                <i class="${icon ? icon.className : 'fa-solid fa-bell'}"></i>
            </div>
            <div class="notification-panel-content">
                <div class="notification-panel-title">${title ? title.textContent.trim() : 'Notification'}</div>
                <div class="notification-panel-message">${message ? message.textContent.trim() : ''}</div>
                <span class="notification-panel-time">${time ? time.textContent.trim() : ''}</span>
            </div>
        `;
        
        div.onclick = (e) => {
            e.preventDefault();
            window.location.href = '{{ route('admin.notifications.index') }}';
        };
        
        return div;
    }
</script>

</body>
</html>
