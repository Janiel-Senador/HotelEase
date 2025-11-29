<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipt</title>
    <style>
        :root{ --brown:#8B4513; --muted:#f4f4f6; --card:#fff; --radius:10px; font-family:Arial,Helvetica,sans-serif; color:#333 }
        body{ margin:0; background:var(--muted); display:flex; align-items:center; justify-content:center; min-height:100vh }
        .wrap{ background:var(--card); border-radius:var(--radius); box-shadow:0 10px 30px rgba(0,0,0,0.1); width:92%; max-width:680px; padding:28px }
        h1{ margin:0 0 8px; font-size:22px; color:var(--brown) }
        .muted{ color:#666; font-size:13px; margin-bottom:18px }
        .grid{ display:grid; grid-template-columns:1fr 1fr; gap:12px }
        .row{ display:flex; justify-content:space-between; margin:6px 0 }
        .label{ color:#666 }
        .value{ font-weight:600 }
        hr{ border:none; border-top:1px dashed #ddd; margin:14px 0 }
        .actions{ display:flex; gap:10px; justify-content:center; margin-top:16px }
        .btn{ background:var(--brown); color:#fff; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; text-decoration:none }
        .btn.secondary{ background:#fff; color:var(--brown); border:1px solid #d6c3b5 }
    </style>
 </head>
 <body>
 <div class="wrap">
    <h1>Booking Submitted</h1>
    <div class="muted">Thank you for trusting HotelEase</div>
    <div class="grid">
        <div>
            <div class="row"><div class="label">Receipt #</div><div class="value">{{ $booking->id }}</div></div>
            <div class="row"><div class="label">Guest</div><div class="value">{{ $booking->guest_name }}</div></div>
            <div class="row"><div class="label">Email</div><div class="value">{{ $booking->guest_email }}</div></div>
            <div class="row"><div class="label">Payment</div><div class="value">{{ $booking->payment_method }}</div></div>
        </div>
        <div>
            <div class="row"><div class="label">Room</div><div class="value">{{ optional($booking->room)->number }} ({{ optional($booking->room)->type }})</div></div>
            <div class="row"><div class="label">Check-in</div><div class="value">{{ $booking->check_in_date }}</div></div>
            <div class="row"><div class="label">Check-out</div><div class="value">{{ $booking->check_out_date }}</div></div>
            <div class="row"><div class="label">Status</div><div class="value">{{ $booking->status }}</div></div>
        </div>
    </div>
    @php($n = \Illuminate\Support\Carbon::parse($booking->check_in_date)->diffInDays(\Illuminate\Support\Carbon::parse($booking->check_out_date)))
    @php($price = optional($booking->room)->price ?? 0)
    @php($subtotal = $n * $price)
    @php($tax = round($subtotal * 0.12))
    @php($total = $subtotal + $tax)
    <hr />
    <div class="row"><div class="label">Nights</div><div class="value">{{ $n }}</div></div>
    <div class="row"><div class="label">Room Price</div><div class="value">₱{{ number_format($price, 2) }}</div></div>
    <div class="row"><div class="label">Taxes & Fees</div><div class="value">₱{{ number_format($tax, 0) }}</div></div>
    <div class="row"><div class="label">Total</div><div class="value">₱{{ number_format($total, 0) }}</div></div>
    <div class="actions">
        <a class="btn" href="{{ route('home') }}">Home</a>
    </div>
 </div>
 </body>
 </html>
