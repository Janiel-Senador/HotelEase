<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management</title>
    <style>
        :root{ --bg:#0f172a; --card:#111827; --muted:#6b7280; --accent:#8B4513; --text:#e5e7eb }
        body{margin:0;background:linear-gradient(120deg,#0b1225,#151a2f);font-family:Inter,Arial,Helvetica,sans-serif;color:var(--text)}
        .wrap{max-width:1100px;margin:32px auto;padding:0 16px}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .card{background:var(--card);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:18px;box-shadow:0 20px 40px rgba(0,0,0,0.35)}
        .title{font-size:18px;font-weight:700;margin-bottom:12px}
        label{display:block;font-size:13px;color:var(--muted);margin:8px 0 6px}
        input{width:100%;padding:10px;border:1px solid rgba(255,255,255,0.08);background:#0b1220;color:var(--text);border-radius:8px}
        .btn{background:var(--accent);color:#fff;border:none;padding:10px 14px;border-radius:10px;cursor:pointer;font-weight:600}
        .table{margin-top:8px}
        .th,.tr{display:grid;grid-template-columns:1fr 1fr 1.6fr 1fr 1fr 0.9fr 0.9fr;gap:10px;align-items:center}
        .update-form{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px;margin-top:10px}
        .update-form .btn{grid-column:1/-1}
        .th{font-size:12px;color:var(--muted);padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.07)}
        .tr{padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06)}
        .muted{color:var(--muted);font-size:12px}
        .actions{display:flex;gap:8px}
        .btn.secondary{background:#0b1220;color:#fff;border:1px solid rgba(255,255,255,0.12)}
    </style>
</head>
<body>
<div class="wrap">
    <div class="grid">
        <div class="card">
            <div class="title">Create Staff</div>
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                <label for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" required />
                <label for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" required />
                <label for="email">Email</label>
                <input id="email" name="email" type="email" required />
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required />
                <label for="role">Role</label>
                <input id="role" name="role" type="text" list="roles" placeholder="Front Desk, Housekeeping, Maintenance, Manager" required />
                <datalist id="roles">
                    <option value="Front Desk"></option>
                    <option value="Housekeeping"></option>
                    <option value="Maintenance"></option>
                    <option value="Manager"></option>
                </datalist>
                <div style="margin-top:12px"><button class="btn" type="submit">Create</button></div>
            </form>
        </div>
        <div class="card">
            <div class="title">Staff Accounts</div>
            <div class="th">
                <div>First Name</div>
                <div>Last Name</div>
                <div>Email</div>
                <div>Username</div>
                <div>Role</div>
                <div>Status</div>
                <div>Actions</div>
            </div>
            @forelse($staff as $u)
                <div class="tr">
                    <div>{{ $u->first_name }}</div>
                    <div>{{ $u->last_name }}</div>
                    <div>{{ $u->email }}</div>
                    <div>{{ $u->username }}</div>
                    <div>{{ $u->role }}</div>
                    <div>{{ $u->is_active ? 'Active' : 'Inactive' }}</div>
                    <div class="actions">
                        @if($u->is_active)
                        <form method="POST" action="{{ route('admin.staff.deactivate', $u) }}">@csrf<button class="btn secondary" type="submit">Deactivate</button></form>
                        @else
                        <form method="POST" action="{{ route('admin.staff.activate', $u) }}">@csrf<button class="btn secondary" type="submit">Activate</button></form>
                        @endif
                        <form method="POST" action="{{ route('admin.staff.delete', $u) }}">@csrf<button class="btn secondary" type="submit">Delete</button></form>
                    </div>
                    <div style="grid-column:1/-1; padding-top:10px; border-top:1px solid rgba(255,255,255,0.07)">
                        <form method="POST" action="{{ route('admin.staff.update', $u) }}" class="update-form">
                            @csrf
                            <input name="first_name" type="text" placeholder="First Name" value="{{ $u->first_name }}" /> 
                            <input name="last_name" type="text" placeholder="Last Name" value="{{ $u->last_name }}" />    
                            <input name="email" type="email" placeholder="Email" value="{{ $u->email }}" />
                            <input name="username" type="text" placeholder="Username" value="{{ $u->username }}" />       
                            <input name="role" type="text" placeholder="Role" value="{{ $u->role }}" list="roles" />
                            <input type="hidden" name="is_active" value="{{ $u->is_active ? 1 : 0 }}" />
                            <button class="btn" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="muted" style="padding:12px">No staff accounts yet.</div>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
