<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f1117;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }
 
        /* Grid pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }
 
        /* Purple glow top-left */
        .glow-1 {
            position: fixed;
            top: -180px; left: -180px;
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }
 
        /* Green glow bottom-right */
        .glow-2 {
            position: fixed;
            bottom: -180px; right: -180px;
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(16,185,129,0.09) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }
 
        /* Card */
        .card {
            width: 100%;
            max-width: 420px;
            background: #1a2035;
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.07);
            padding: 2.25rem 2rem;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
        }
 
        /* Top accent line */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 2px;
            background: linear-gradient(90deg, #6366f1, #818cf8, transparent);
            border-radius: 2px;
        }
 
        .brand-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            background: rgba(99,102,241,0.15);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .brand-icon i { font-size: 20px; color: #818cf8; }
 
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 4px;
        }
        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 1.75rem;
        }
 
        /* Alerts */
        .alert {
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }
        .alert i { margin-top: 1px; flex-shrink: 0; }
        .alert.success { background: rgba(16,185,129,0.1);  color: #10b981; border: 1px solid rgba(16,185,129,0.2); }
        .alert.error   { background: rgba(239,68,68,0.1);   color: #f87171; border: 1px solid rgba(239,68,68,0.2); }
        .alert.warning { background: rgba(245,158,11,0.1);  color: #fbbf24; border: 1px solid rgba(245,158,11,0.2); }
 
        /* Role toggle */
        .section-label {
            font-size: 12px;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }
        .role-group {
            display: flex;
            gap: 8px;
            margin-bottom: 1.25rem;
        }
        .role-btn {
            flex: 1;
            height: 40px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.07);
            background: #111827;
            color: #4b5563;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.15s;
        }
        .role-btn i { font-size: 14px; }
        .role-btn:hover {
            border-color: rgba(99,102,241,0.4);
            color: #818cf8;
            background: rgba(99,102,241,0.08);
        }
        .role-btn.active {
            background: rgba(99,102,241,0.15);
            border-color: rgba(99,102,241,0.45);
            color: #818cf8;
        }
 
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.25rem;
        }
        .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.05); }
        .divider-text { font-size: 11px; color: #374151; text-transform: uppercase; letter-spacing: 0.5px; }
 
        /* Fields */
        .field-block { margin-bottom: 1rem; }
        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .field-wrap { position: relative; }
        .field-wrap .f-icon {
            position: absolute;
            left: 11px; top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: #374151;
            pointer-events: none;
        }
        .field-wrap input {
            width: 100%;
            height: 42px;
            padding: 0 12px 0 36px;
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.07);
            background: #111827;
            color: #f1f5f9;
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field-wrap input::placeholder { color: #374151; }
        .field-wrap input:focus {
            border-color: rgba(99,102,241,0.5);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .toggle-pw {
            position: absolute;
            right: 10px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #374151;
            font-size: 14px;
            padding: 0;
            display: flex; align-items: center;
        }
        .toggle-pw:hover { color: #6b7280; }
 
        /* Submit */
        .submit-btn {
            width: 100%;
            height: 44px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity 0.15s, transform 0.1s;
            margin-top: 0.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 24px rgba(99,102,241,0.3);
        }
        .submit-btn:hover { opacity: 0.88; }
        .submit-btn:active { transform: scale(0.985); }
 
        /* Footer links */
        .footer-links {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 1.5rem;
        }
        .footer-links a { color: #374151; text-decoration: none; transition: color 0.15s; }
        .footer-links a:hover { color: #818cf8; }
 
        /* Trust badges */
        .badge-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .badge {
            display: flex; align-items: center; gap: 4px;
            font-size: 11px; color: #374151;
        }
        .badge i { font-size: 11px; color: #10b981; }
        .badge-sep { color: #1f2937; }
    </style>
</head>
<body>
 
<div class="glow-1"></div>
<div class="glow-2"></div>
 
<div class="card">
 
    <div class="brand-icon">
        <i class="fa-solid fa-shield-halved"></i>
    </div>
    <div class="title">Admin portal</div>
    <div class="subtitle">Sign in to continue to your dashboard</div>
 
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif
 
    @if(session('error'))
        <div class="alert error">
            <i class="fa-solid fa-circle-exclamation"></i>
            {{ session('error') }}
        </div>
    @endif
 
    @if($errors->any())
        <div class="alert warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        </div>
    @endif
 
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
 
        <input type="hidden" name="role" id="role-input" value="admin">
 
        <div class="section-label">Select role</div>
        <div class="role-group">
            <button type="button" class="role-btn active" id="btn-admin" onclick="setRole('admin')">
                <i class="fa-solid fa-user-shield"></i> Admin
            </button>
            <button type="button" class="role-btn" id="btn-user" onclick="setRole('user')">
                <i class="fa-solid fa-user"></i> User
            </button>
        </div>
 
        <div class="divider">
            <div class="divider-line"></div>
            <span class="divider-text">credentials</span>
            <div class="divider-line"></div>
        </div>
 
        <div class="field-block">
            <label class="field-label" for="email">Email address</label>
            <div class="field-wrap">
                <i class="fa-solid fa-envelope f-icon"></i>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="admin@company.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
            </div>
        </div>
 
        <div class="field-block">
            <label class="field-label" for="password">Password</label>
            <div class="field-wrap">
                <i class="fa-solid fa-lock f-icon"></i>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pw" onclick="togglePassword()" aria-label="Toggle password visibility">
                    <i class="fa-solid fa-eye" id="eye-icon"></i>
                </button>
            </div>
        </div>
 
        <button type="submit" class="submit-btn">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign in
        </button>
 
    </form>
 
    <div class="footer-links">
        <a href="#">Forgot password?</a>
        <a href="#">Need help?</a>
    </div>
 
    <div class="badge-row">
        <div class="badge"><i class="fa-solid fa-circle-check"></i> Encrypted</div>
        <span class="badge-sep">·</span>
        <div class="badge"><i class="fa-solid fa-circle-check"></i> Secure session</div>
        <span class="badge-sep">·</span>
        <div class="badge"><i class="fa-solid fa-circle-check"></i> Laravel</div>
    </div>
 
</div>
 
<script>
    function setRole(role) {
        document.getElementById('role-input').value = role;
        document.getElementById('btn-admin').classList.toggle('active', role === 'admin');
        document.getElementById('btn-user').classList.toggle('active', role === 'user');
    }
 
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-solid fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fa-solid fa-eye';
        }
    }
</script>
 
</body>
</html>