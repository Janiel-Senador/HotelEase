<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body{margin:0;background:#f4f4f6;font-family:Arial,Helvetica,sans-serif;color:#333;display:flex;align-items:center;justify-content:center;min-height:100vh}
        .card{background:#fff;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.1);padding:24px;width:92%;max-width:420px}
        h1{margin:0 0 12px;font-size:20px;color:#8B4513}
        label{display:block;margin:8px 0 6px;font-size:13px}
        input{width:100%;padding:10px;border:1px solid #e2e2e2;border-radius:6px;font-size:14px}
        .btn{width:100%;margin-top:12px;background:#8B4513;color:#fff;border:none;padding:12px;border-radius:8px;cursor:pointer;font-weight:600}
        .error{color:#c0392b;font-size:13px;margin-top:8px}
    </style>
</head>
<body>
<div class="card">
    <h1>Admin Login</h1>
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <label for="username">Username or Email</label>
        <input id="username" name="username" type="text" value="{{ old('username','admin') }}" required />
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required />
        <button class="btn" type="submit">Sign In</button>
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
    </form>
</div>
</body>
</html>
