<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <style>
        :root{ --bg:#0f172a; --card:#111827; --muted:#6b7280; --accent:#8B4513; --text:#e5e7eb }
        body{margin:0;background:linear-gradient(120deg,#0b1225,#151a2f);font-family:Inter,Arial,Helvetica,sans-serif;color:var(--text)}
        .wrap{max-width:1100px;margin:32px auto;padding:0 16px}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .card{background:var(--card);border:1px solid rgba(255,255,255,0.06);border-radius:14px;padding:18px;box-shadow:0 20px 40px rgba(0,0,0,0.35)}
        .title{font-size:18px;font-weight:700;margin-bottom:12px}
        label{display:block;font-size:13px;color:var(--muted);margin:8px 0 6px}
        input,select,textarea{width:100%;padding:10px;border:1px solid rgba(255,255,255,0.08);background:#0b1220;color:var(--text);border-radius:8px}
        .btn{background:var(--accent);color:#fff;border:none;padding:10px 14px;border-radius:10px;cursor:pointer;font-weight:600}
        .table{margin-top:8px}
        .th,.tr{display:grid;grid-template-columns:0.8fr 1.5fr 0.8fr 0.8fr 1fr 0.8fr 0.8fr;gap:10px;align-items:center}
        .th{font-size:12px;color:var(--muted);padding:10px 0;border-bottom:1px solid rgba(255,255,255,0.07)}
        .tr{padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.06)}
        .actions{display:flex;gap:8px}
        .btn.secondary{background:#0b1220;color:#fff;border:1px solid rgba(255,255,255,0.12)}
    </style>
</head>
<body>
<div class="wrap">
    <div class="grid">
        <div class="card">
            <div class="title">Add Room</div>
            <form method="POST" action="{{ route('admin.rooms.store') }}">
                @csrf
                <label for="number">Number</label>
                <input id="number" name="number" type="text" required />
                <label for="type">Type</label>
                <select id="type" name="type" required>
                    <option>Standard Room</option>
                    <option>Deluxe Room</option>
                    <option>Executive Suite</option>
                    <option>Premium Suite</option>
                    <option>Family Room</option>
                    <option>Penthouse Suite</option>
                </select>
                <label for="capacity">Capacity</label>
                <input id="capacity" name="capacity" type="number" min="1" required />
                <label for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01" required />
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option>available</option>
                    <option>occupied</option>
                    <option>maintenance</option>
                </select>
                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>
                <div style="margin-top:12px"><button class="btn" type="submit">Add</button></div>
            </form>
        </div>
        <div class="card">
            <div class="title">Rooms</div>
            <div class="th">
                <div>No.</div>
                <div>Type</div>
                <div>Cap.</div>
                <div>Price</div>
                <div>Status</div>
                <div>Update</div>
                <div>Remove</div>
            </div>
            @foreach(\App\Models\Room::orderBy('number')->get() as $r)
                <div class="tr">
                    <div>{{ $r->number }}</div>
                    <div>{{ $r->type }}</div>
                    <div>{{ $r->capacity }}</div>
                    <div>₱{{ number_format($r->price,2) }}</div>
                    <div>{{ $r->status }}</div>
                    <div>
                        <form method="POST" action="{{ route('admin.rooms.update', $r) }}" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px">
                            @csrf
                            <input name="type" type="text" value="{{ $r->type }}" />
                            <input name="capacity" type="number" value="{{ $r->capacity }}" />
                            <input name="price" type="number" step="0.01" value="{{ $r->price }}" />
                            <select name="status" style="grid-column:1/-1">
                                @foreach(['available','occupied','maintenance'] as $s)
                                    <option value="{{ $s }}" @selected($r->status===$s)>{{ $s }}</option>
                                @endforeach
                            </select>
                            <button class="btn" type="submit" style="grid-column:1/-1">Save</button>
                        </form>
                    </div>
                    <div>
                        <form method="POST" action="{{ route('admin.rooms.delete', $r) }}">
                            @csrf
                            <button class="btn secondary" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>

