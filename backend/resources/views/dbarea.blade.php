<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBarea</title>
    <style>
        :root{ --brown:#8B4513; --muted:#f4f4f6; --card:#fff; --radius:8px; font-family:Arial,Helvetica,sans-serif; color:#333 }
        *{ box-sizing:border-box }
        body{ margin:0; background:var(--muted) }
        header{ background:var(--brown); padding:14px 0; color:#fff }
        .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px }
        .brand{ font-weight:700; display:flex; align-items:center; gap:8px }
        .brand .logo{ width:22px; height:22px; object-fit:contain }
        .container{ max-width:1100px; margin:24px auto; padding:0 16px; display:grid; grid-template-columns:1fr; gap:24px }
        .card{ background:var(--card); border-radius:var(--radius); padding:18px; box-shadow:0 4px 12px rgba(0,0,0,0.08) }
        h2{ margin:0 0 12px; font-size:18px }
        table{ width:100%; border-collapse:collapse }
        th,td{ padding:10px; border-bottom:1px solid #eee; text-align:left; font-size:14px }
        th{ background:#fafafa; font-weight:600 }
        .muted{ color:#666; font-size:13px }
        .grid{ display:grid; grid-template-columns:1fr 1fr; gap:24px }
        @media(max-width:800px){ .grid{ grid-template-columns:1fr } }
    </style>
</head>
<body>
<header>
    <div class="nav-inner">
        <div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div>
        <div class="muted" style="margin-left:auto">DBarea</div>
    </div>
</header>
<main class="container">
    <div class="grid">
        <div class="card">
            <h2>Rooms</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Number</th>
                        <th>Type</th>
                        <th>Capacity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Bookings</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($rooms as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->number }}</td>
                        <td>{{ $r->type }}</td>
                        <td>{{ $r->capacity }}</td>
                        <td>₱{{ number_format($r->price, 2) }}</td>
                        <td>{{ $r->status }}</td>
                        <td>{{ $r->bookings_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card">
            <h2>Recent Bookings</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Guest</th>
                        <th>Email</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bookings as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>{{ optional($b->room)->number }} ({{ optional($b->room)->type }})</td>
                        <td>{{ $b->guest_name }}</td>
                        <td>{{ $b->guest_email }}</td>
                        <td>{{ $b->check_in_date }}</td>
                        <td>{{ $b->check_out_date }}</td>
                        <td>{{ $b->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="muted">Showing up to 50 latest bookings</div>
        </div>
    </div>
</main>
</body>
</html>
