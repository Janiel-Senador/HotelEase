<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>My Bookings</title>
<style>
  :root{ --brown:#8B4513;--muted:#f4f4f6 }
  body{margin:0;background:var(--muted);font-family:Arial,Helvetica,sans-serif}
  .nav{background:var(--brown);color:#fff;padding:12px 16px;display:flex;gap:12px;align-items:center}
  .nav a{color:#fff;text-decoration:none}
  .wrap{max-width:1000px;margin:20px auto;padding:0 16px}
  .card{background:#fff;border-radius:10px;box-shadow:0 10px 24px rgba(0,0,0,0.08);padding:16px}
  .table-header{display:grid;grid-template-columns:1fr 1.6fr 1fr 1.2fr 1fr;gap:8px;padding:10px;border-bottom:1px solid #eee;font-weight:700}
  .row{display:grid;grid-template-columns:1fr 1.6fr 1fr 1.2fr 1fr;gap:8px;padding:10px;border-bottom:1px solid #f2f2f2}
  .empty{padding:12px;color:#666}
</style>
</head>
<body>
<div class="nav"><a href="{{ route('home') }}">Home</a><span>›</span><span>My Bookings</span><span style="margin-left:auto">@auth {{ auth()->user()->name }} @endauth</span></div>
<div class="wrap">
  <div class="card">
    <div style="font-weight:700;margin-bottom:8px">Your bookings</div>
    <div class="table-header"><div>Room</div><div>Type</div><div>Status</div><div>Dates</div><div>Payment</div></div>
    @forelse($bookings as $b)
      <div class="row">
        <div>{{ optional($b->room)->number }}</div>
        <div>{{ optional($b->room)->type }}</div>
        <div>{{ $b->status }}</div>
        <div>{{ $b->check_in_date }} → {{ $b->check_out_date }}</div>
        <div>{{ $b->payment_method }}</div>
      </div>
    @empty
      <div class="empty">No bookings yet.</div>
    @endforelse
  </div>
</div>
</body>
</html>
