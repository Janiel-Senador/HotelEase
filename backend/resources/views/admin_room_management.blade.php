<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <style>
        body{margin:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#2c3e50}
        .main{max-width:1100px;margin:24px auto;padding:0 16px}
        .card{background:#fff;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);padding:20px}
        .card-title{font-size:18px;font-weight:600;margin-bottom:16px}
        .table-header{display:grid;grid-template-columns:1fr 1fr 1fr 1.5fr 1fr 0.8fr;gap:12px;padding:12px 0;border-bottom:2px solid #ecf0f1;font-size:13px;color:#7f8c8d;font-weight:600}
        .row{display:grid;grid-template-columns:1fr 1fr 1fr 1.5fr 1fr 0.8fr;gap:12px;padding:12px 0;border-bottom:1px solid #ecf0f1;align-items:center}
        input,select{width:100%;padding:8px;border:1px solid #e0e0e0;border-radius:6px;font-size:13px}
        .actions{display:flex;gap:8px}
        .btn{padding:8px 12px;border:none;border-radius:6px;cursor:pointer;font-size:13px}
        .btn.save{background:#27ae60;color:#fff}
        .btn.cancel{background:#e74c3c;color:#fff}
        .muted{color:#7f8c8d;font-size:12px}
    </style>
</head>
<body>
<div class="main">
    <div class="card">
        <div class="card-title">Room Management</div>
        <div class="table-header">
            <div>Room</div>
            <div>Type</div>
            <div>Status</div>
            <div>Guest</div>
            <div>Check-out</div>
            <div>Actions</div>
        </div>
        @forelse($bookings as $b)
            <form class="row" method="POST" action="{{ route('admin.booking.update', $b) }}">
                @csrf
                <div>{{ optional($b->room)->number }}</div>
                <div>
                    <select name="room_type">
                        @php($types=['Standard Room','Deluxe Room','Executive Suite','Premium Suite','Family Room','Penthouse Suite'])
                        @foreach($types as $t)
                            <option value="{{ $t }}" @selected(optional($b->room)->type === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status">
                        @php($statuses=['pending','confirmed','cancelled','checked_in','checked_out'])
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" @selected($b->status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="text" name="guest_name" value="{{ $b->guest_name }}" />
                </div>
                <div>
                    <input type="date" name="check_out_date" value="{{ $b->check_out_date }}" />
                </div>
                <div class="actions">
                    <button class="btn save" type="submit">Save</button>
                </div>
            </form>
        @empty
            <div class="muted" style="padding:12px">No bookings to manage.</div>
        @endforelse
    </div>
</div>
</body>
</html>

