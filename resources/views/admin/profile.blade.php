@extends('admin.layout')

@section('title', 'Profile')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
 :root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;

    --bg: #0b1220;
    --card: #111827;

    --border: #1f2937;
    --text: #f3f4f6;
    --muted: #9ca3af;

    --success: #22c55e;
    --danger: #ef4444;
}

/* ================= BODY ================= */
body {
    background: var(--bg);
    color: var(--text);
}

/* ================= CONTAINER ================= */
.profile-container {
    max-width: 920px;
    margin: 0 auto;
    padding: 20px;
}

/* ================= HEADER ================= */
.profile-header {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 22px;
    box-shadow: 0 14px 35px rgba(0,0,0,0.45);
    transition: 0.2s ease;
}

.profile-header:hover {
    transform: translateY(-2px);
}

/* ================= AVATAR ================= */
.avatar-large {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 34px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 10px 20px rgba(59, 130, 246, 0.25);
}

.avatar-preview {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--border);
}

/* ================= PROFILE INFO ================= */
.profile-info h2 {
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
}

.profile-info .role {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    color: #60a5fa;
    background: rgba(59,130,246,0.12);
    margin-bottom: 10px;
}

.profile-info .meta {
    font-size: 13px;
    color: var(--muted);
}

/* ================= CARD ================= */
.card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 22px;
    margin-bottom: 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.35);
}

/* ================= CARD TITLE ================= */
.card-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-title i {
    color: var(--primary);
}

/* ================= FORM GRID ================= */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* ================= LABEL ================= */
label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
}

/* ================= INPUT ================= */
input {
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid var(--border);
    font-size: 14px;
    transition: 0.2s ease;
    outline: none;
    background: #0b1220;
    color: var(--text);
}

input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(59,130,246,0.25);
}

input:disabled {
    background: #0f172a;
    color: var(--muted);
}

/* ================= BUTTONS ================= */
.btn {
    padding: 11px 18px;
    border-radius: 10px;
    border: none;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);
}

.btn-primary:hover {
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-outline {
    background: var(--card);
    border: 1px solid var(--border);
    color: var(--text);
}

.btn-outline:hover {
    background: #0f172a;
}

/* ================= ALERT ================= */
.alert {
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.alert-success {
    background: rgba(34,197,94,0.12);
    color: var(--success);
    border: 1px solid rgba(34,197,94,0.25);
}

.alert-error {
    background: rgba(239,68,68,0.12);
    color: var(--danger);
    border: 1px solid rgba(239,68,68,0.25);
}

/* ================= DIVIDER ================= */
.section-divider {
    margin: 20px 0;
    border-top: 1px solid var(--border);
}

/* ================= PASSWORD HELP ================= */
.password-requirements {
    font-size: 12px;
    color: var(--muted);
    margin-top: 6px;
    padding-left: 18px;
}

/* ================= AVATAR UPLOAD ================= */
.avatar-upload-label {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--card);
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

/* ================= STATS ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.stat-item {
    background: #0b1220;
    padding: 14px;
    border-radius: 12px;
    text-align: center;
    border: 1px solid var(--border);
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text);
}

.stat-label {
    font-size: 12px;
    color: var(--muted);
}

/* ================= TABS ================= */
.tabs {
    display: flex;
    gap: 6px;
    background: #0b1220;
    padding: 5px;
    border-radius: 14px;
    margin-bottom: 22px;
    border: 1px solid var(--border);
}

.tab {
    flex: 1;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    cursor: pointer;
    border: none;
    background: transparent;
    transition: 0.2s ease;
}

.tab.active {
    background: var(--card);
    color: var(--primary);
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-container">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fa-solid fa-exclamation-circle"></i>
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="avatar-upload" id="avatarUpload">
            @if($user->avatar_url)
                <img class="avatar-preview" id="avatarPreview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
            @else
                <div class="avatar-large" id="avatarInitials">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
            @endif
            <label class="avatar-upload-label" for="avatarInput">
                <i class="fa-solid fa-camera"></i>
            </label>
            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
        </div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <span class="role">Administrator</span>
            <div class="meta">
                <i class="fa-solid fa-envelope"></i> {{ $user->email }}
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab active" data-tab="profile">Profile</button>
        <button class="tab" data-tab="security">Security</button>
    </div>

    <!-- Profile Tab -->
    <div class="tab-content active" id="tab-profile">
        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-user"></i>
                Profile Information
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label>Role</label>
                        <input type="text" value="Administrator" disabled>
                    </div>

                    <div class="form-group full-width">
                        <label>Profile Photo</label>
                        <div class="avatar-upload" style="width:120px;">
                            @if($user->avatar_url)
                                <img class="avatar-preview" id="avatarPreviewForm" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                            @else
                                <div class="avatar-preview" id="avatarInitialsForm" style="display:flex;align-items:center;justify-content:center;background:#f1f5f9;color:#94a3b8;font-weight:700;font-size:36px;">
                                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                                </div>
                            @endif
                            <label class="avatar-upload-label" for="avatarInputForm">
                                <i class="fa-solid fa-camera"></i>
                            </label>
                            <input type="file" id="avatarInputForm" name="avatar" accept="image/*" style="display:none;" onchange="previewAvatarForm(this)">
                            <p style="font-size:12px;color:#64748b;margin-top:8px;">Click to upload (max 2MB)</p>
                        </div>
                    </div>

                    <div class="form-group full-width" style="display:flex;align-items:end;gap:12px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Tab -->
    <div class="tab-content" id="tab-security">
        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-lock"></i>
                Change Password
            </div>

            <form method="POST" action="{{ route('admin.profile.password') }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required autocomplete="current-password">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" required autocomplete="new-password" minlength="8">
                        <ul class="password-requirements">
                            <li>Minimum 8 characters</li>
                            <li>Mix of letters and numbers</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="form-group full-width" style="display:flex;align-items:end;gap:12px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-key"></i> Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-title">
                <i class="fa-solid fa-shield-halved"></i>
                Account Security
            </div>

            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">{{ $user->orders_count ?? 0 }}</div>
                    <div class="stat-label">Orders Placed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $user->created_at->format('M Y') }}</div>
                    <div class="stat-label">Member Since</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</div>
                    <div class="stat-label">Last Login</div>
                </div>
            </div>
        </div>

        <div class="card" style="border-color: #fecaca;">
            <div class="card-title" style="color: #dc2626;">
                <i class="fa-solid fa-trash"></i>
                Danger Zone
            </div>
            <p style="color:#64748b;margin-bottom:16px;">Once you delete your account, there is no going back. Please be certain.</p>
            <button class="btn btn-danger" onclick="confirmDelete()">
                <i class="fa-solid fa-user-slash"></i> Delete Account
            </button>
        </div>
    </div>

</div>

<script>
    // Tab switching
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.dataset.tab;
            
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById('tab-' + target).classList.add('active');
        });
    });

    function confirmDelete() {
        Swal.fire({
            title: 'Delete Account?',
            text: 'This action cannot be undone. All your data will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Deleted!', 'Your account has been deleted.', 'success');
                // Add actual delete logic here if needed
            }
        });
    }

    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const initials = document.getElementById('avatarInitials');
                const preview = document.getElementById('avatarPreview');
                if (initials) initials.style.display = 'none';
                if (!preview) {
                    const img = document.createElement('img');
                    img.id = 'avatarPreview';
                    img.className = 'avatar-preview';
                    img.src = e.target.result;
                    img.alt = '{{ $user->name }}';
                    document.getElementById('avatarUpload').prepend(img);
                } else {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewAvatarForm(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const initials = document.getElementById('avatarInitialsForm');
                const preview = document.getElementById('avatarPreviewForm');
                if (initials) initials.style.display = 'none';
                if (!preview) {
                    const img = document.createElement('img');
                    img.id = 'avatarPreviewForm';
                    img.className = 'avatar-preview';
                    img.src = e.target.result;
                    img.alt = '{{ $user->name }}';
                    document.getElementById('avatarInputForm').parentElement.prepend(img);
                } else {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection