<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Assignments</title>
    <style>
        :root{ --bg:#0f172a; --card:#111827; --muted:#6b7280; --accent:#8B4513; --text:#e5e7eb }
        body{margin:0;background:linear-gradient(120deg,#0b1225,#151a2f);font-family:Inter,Arial,Helvetica,sans-serif;color:var(--text)}
        .wrap{max-width:1100px;margin:32px auto;padding:0 16px}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .card{background:var(--card);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:18px;box-shadow:0 20px 40px rgba(0,0,0,0.35)}
        .title{font-size:18px;font-weight:700;margin-bottom:12px}
        label{display:block;font-size:13px;color:var(--muted);margin:8px 0 6px}
        input, select{width:100%;padding:10px;border:1px solid rgba(255,255,255,0.08);background:#0b1220;color:var(--text);border-radius:8px}
        .btn{background:var(--accent);color:#fff;border:none;padding:10px 14px;border-radius:10px;cursor:pointer;font-weight:600}
        .th,.tr{display:grid;grid-template-columns:1fr 0.8fr 0.8fr 1fr 1fr 1fr;gap:10px;align-items:center}
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
            <div class="title">Create Service Request</div>
            <form method="POST" action="{{ route('admin.assignments.store') }}">
                @csrf
                <label for="guest_id">Guest ID</label>
                <input id="guest_id" name="guest_id" type="number" required />
                <label for="room_id">Room ID</label>
                <input id="room_id" name="room_id" type="number" required />
                <label for="request_type">Request Type</label>
                <input id="request_type" name="request_type" type="text" placeholder="Housekeeping, Maintenance, etc." required />
                <div style="margin-top:12px"><button class="btn" type="submit">Create</button></div>
            </form>
        </div>
        <div class="card">
            <div class="title">Assignments</div>
            <div class="th">
                <div>Request</div>
                <div>Guest</div>
                <div>Room</div>
                <div>Type</div>
                <div>Status</div>
                <div>Assign / Update</div>
            </div>
            @foreach($assignments as $a)
                <div class="tr">
                    <div>#{{ $a->id }}</div>
                    <div>{{ optional($a->guest)->first_name }} {{ optional($a->guest)->last_name }}</div>
                    <div>{{ optional($a->room)->number }}</div>
                    <div>{{ $a->request_type }}</div>
                    <div>{{ $a->status }} @if($a->staff) ({{ $a->staff->name }}) @endif</div>
                    <div>
                        <form method="POST" action="{{ route('admin.assignments.assign', $a) }}" style="display:grid;grid-template-columns:1fr 0.8fr;gap:8px">
                            @csrf
                            <select name="staff_id">
                                @foreach($staff as $s)
                                    <option value="{{ $s->id }}" @if($a->staff_id===$s->id) selected @endif>{{ $s->name }} ({{ $s->role }})</option>
                                @endforeach
                            </select>
                            <button class="btn secondary" type="submit">Assign</button>
                        </form>
                        <form method="POST" action="{{ route('admin.assignments.status', $a) }}" style="margin-top:6px;display:grid;grid-template-columns:1fr 0.8fr;gap:8px">
                            @csrf
                            <select name="status">
                                @foreach(['open','in_progress','completed','cancelled'] as $st)
                                    <option value="{{ $st }}" @if($a->status===$st) selected @endif>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                            <button class="btn secondary" type="submit">Update</button>
                        </form>
                    </div>
                </div>
            @endforeach
            @if(method_exists($assignments,'links'))
                <div style="margin-top:12px">{{ $assignments->links() }}</div>
            @endif
        </div>
    </div>
</div>
</body>
</html>
