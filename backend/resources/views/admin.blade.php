<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { scroll-behavior: smooth; }
        html { overflow-x: hidden; }
        html, body { min-height: 100%; }
        body { font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: hsl(275, 53%, 3%); color: #e5e7eb; overflow-y: auto; overflow-x: hidden; text-align: center; }
        canvas { display: inline-block; }
        #dst { position: fixed; inset: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; display: block; }
        canvas#dst:hover { cursor: none; }
        span, a { color: #dedede; padding: 5px 10px; }
        :root{ --primary:#11998e; --secondary:#38ef7d; --white:#fff; --gray:#9b9b9b }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; position: sticky; top: 0; z-index: 2; backdrop-filter: blur(10px); background: rgba(255,255,255,0.06); border-bottom: 1px solid rgba(255,255,255,0.08); }
        .brand { display:flex; align-items:center; gap:8px; font-weight:700; color:#fff; }
        .brand .logo{ width:24px; height:24px; object-fit:contain }
        .nav-buttons { display:flex; gap:10px; padding:6px; border-radius:28px; backdrop-filter: blur(14px); background: rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.12); box-shadow:0 10px 24px rgba(0,0,0,0.25); }
        .glass-btn { position:relative; padding:10px 18px; border-radius:22px; backdrop-filter: blur(12px); background: rgba(255,255,255,0.10); color:#fff; border:1px solid rgba(255,255,255,0.18); cursor:pointer; font-weight:700; letter-spacing:.2px; transition: all .18s ease; }
        .glass-btn:hover { border-color: rgba(255,255,255,0.28); background: rgba(255,255,255,0.16); transform: translateY(-1px); box-shadow:0 8px 18px rgba(0,0,0,0.28); }
        .glass-btn:active { transform: translateY(0); box-shadow:0 6px 14px rgba(0,0,0,0.22); }
        .glass-btn.active { border-color: rgba(255,255,255,0.28); background: rgba(255,255,255,0.16); box-shadow:0 10px 22px rgba(0,0,0,0.30); }
        .glass-btn:focus-visible { outline:none; box-shadow:0 0 0 2px rgba(255,255,255,0.16), 0 0 0 4px rgba(17,153,142,0.6); }
        .dropdown { position: relative; filter: url(#goo); }
        .recursive-menu { position: relative; }
        .menu { list-style: none; display:flex; gap:0; margin:0; padding:0; }
        .menu > li { position: relative; }
        .menu > li > a { display:flex; align-items:center; gap:8px; padding:10px 14px; border-radius:25px; background: rgba(255,255,255,0.1); border:2px solid var(--gray); color:#fff; text-decoration:none; }
        .menu > li > a:hover { border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; }
        .submenu { list-style:none; position:absolute; top:110%; right:0; min-width:220px; padding:16px; border-radius:25px; background:#fff; color:#000; display:none; box-shadow:0 20px 40px rgba(0,0,0,0.35); }
        .submenu li { position:relative; }
        .submenu a { display:block; padding:10px 12px; border-radius:14px; text-decoration:none; color:#000; border:2px solid #fff; }
        .submenu a:hover { border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; }
        .menu > li:hover > .submenu { display:block; animation: drop 300ms ease-out; }
        .submenu .submenu { top:0; left:-105%; }
        .submenu li:hover > .submenu { display:block; }
        @keyframes drop { from { opacity:0; transform:translateY(-6px) } to { opacity:1; transform:translateY(0) } }
        .avatar { width:24px; height:24px; border-radius:50%; background:linear-gradient(90deg,var(--primary),var(--secondary)); display:flex; align-items:center; justify-content:center; color:#000; font-weight:700; }
        /* Reusable glass dropdown for forms */
        .dd { position:relative; filter:url(#goo); }
        .dd__face, .dd__items { background: rgba(255,255,255,0.10); color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:16px; }
        .dd__face { padding:10px 12px; cursor:pointer; display:flex; align-items:center; gap:8px; }
        .dd__face:hover { border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; }
        .dd__items { position:absolute; left:0; top:110%; min-width:240px; padding:10px; display:none; backdrop-filter: blur(16px); background: rgba(17,24,39,0.95); box-shadow:0 24px 48px rgba(0,0,0,0.45); z-index: 2001; }
        .dd-backdrop { position:fixed; inset:0; background:rgba(0,0,0,0.01); z-index:2000; }
        .dd__items.show { display:block; animation: drop 250ms ease-out; }
        .dd__items button { width:100%; text-align:left; padding:10px 12px; border:none; background:transparent; color:#fff; border-radius:12px; cursor:pointer; }
        .dd__items button:hover { border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; border-width:2px; border-style:solid; }
        /* Floating label inputs */
        .form__group { position: relative; padding: 15px 0 0; margin-top: 10px; width: 100%; }
        .form__field { font-family: inherit; width: 100%; border: 0; border-bottom: 2px solid var(--gray); outline: 0; font-size: 1.0rem; color: var(--white); padding: 7px 0; background: transparent; transition: border-color 0.2s; }
        .form__field::placeholder { color: transparent; }
        .form__field:placeholder-shown ~ .form__label { font-size: 1.0rem; cursor: text; top: 20px; }
        .form__label { position: absolute; top: 0; display: block; transition: 0.2s; font-size: 0.9rem; color: var(--gray); }
        .form__field:focus { padding-bottom: 6px; font-weight: 700; border-width: 3px; border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; }
        .form__field:focus ~ .form__label { font-size: 0.9rem; color: var(--primary); font-weight: 700; }
        .form__field:required, .form__field:invalid { box-shadow: none; }
        /* Glassmorphism select */
        .select-glass { appearance: none; -webkit-appearance: none; -moz-appearance: none; background: rgba(255,255,255,0.08); color:#fff; border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:10px 12px; backdrop-filter: blur(10px); cursor:pointer; }
        .select-glass:focus { outline:none; border-image: linear-gradient(to right, var(--primary), var(--secondary)); border-image-slice: 1; }
        .select-glass option { background:#0b1220; color:#fff; }
        .section { max-width:1100px; margin:24px auto; padding:0 16px; }
        .section .card { background: rgba(17,24,39,0.7); border:1px solid rgba(255,255,255,0.08); border-radius:14px; padding:20px; box-shadow:0 20px 40px rgba(0,0,0,0.35); }
        .section-title { font-size:20px; font-weight:700; margin-bottom:14px; }
        .main { transition: filter 0.4s ease; }
        .main.blur { filter: blur(6px); }
        .header-date { color:#cbd5e1; font-size:14px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: rgba(17,24,39,0.7); padding: 20px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); position: relative; border:1px solid rgba(255,255,255,0.08); text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px; min-height:120px; }
        .stat-label { font-size: 13px; color: #94a3b8; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #e5e7eb; }
        .stat-icon { position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .icon-red { background: #ffebee; color: #e74c3c; }
        .icon-green { background: #e8f5e9; color: #27ae60; }
        .icon-yellow { background: #fff9e6; color: #f39c12; }
        .icon-blue { background: #e3f2fd; color: #3498db; }
        .stat-emblem { font-size: 22px; line-height: 1; margin-bottom: 8px; color: #27ae60; }
        .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        #dashboard .content-grid { grid-template-columns: 1fr; justify-items: center; }
        #dashboard .content-grid .card { width: min(900px, 92%); }
        .card-title { font-size: 16px; font-weight: 600; color: #e5e7eb; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; }
        .chart-svg { width: 100%; height: 100%; }
        .muted { color:#94a3b8; }
        .request-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #ecf0f1; }
        .request-item:last-child { border-bottom: none; }
        .request-info h4 { font-size: 14px; color: #2c3e50; margin-bottom: 4px; }
        .request-info p { font-size: 12px; color: #95a5a6; }
        .request-actions { display: flex; gap: 8px; }
        .request-btn { padding: 6px 16px; border-radius: 4px; border: none; cursor: pointer; font-size: 13px; font-weight: 500; }
        .btn-accept { background: #27ae60; color: white; }
        .btn-cancel { background: #e74c3c; color: white; }
        .btn-accept:hover { background: #229954; }
        .btn-cancel:hover { background: #c0392b; }
        .room-table { width: 100%; }
        .table-header { display: grid; grid-template-columns: 0.9fr 1.6fr 0.8fr 0.9fr 1fr 0.9fr 0.9fr; padding: 12px 0; border-bottom: 2px solid rgba(255,255,255,0.12); font-size: 13px; color: #94a3b8; font-weight: 600; }
        .table-row { display: grid; grid-template-columns: 0.9fr 1.6fr 0.8fr 0.9fr 1fr 0.9fr 0.9fr; gap: 10px; padding: 14px; margin: 8px 0; align-items: center; font-size: 15px; color: #fff; background: rgba(17,24,39,0.65); border: 1px solid rgba(255,255,255,0.10); border-radius: 12px; backdrop-filter: blur(12px); }
        .rooms-columns { grid-template-columns: 0.9fr 1.6fr 0.8fr 0.9fr 1fr 0.9fr 0.9fr; }
        .staff-columns { grid-template-columns: 1.6fr 2fr 1fr 1.2fr; align-items: start; }
        .guest-columns { grid-template-columns: 1.6fr 2fr 1.2fr 1fr; align-items: start; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .status-occupied { background: #e8f5e9; color: #27ae60; }
        .status-available { background: #e3f2fd; color: #3498db; }
        .status-pending { background: #fff9e6; color: #f39c12; }
        .table-actions { display: flex; gap: 8px; }
        .action-btn { width: 24px; height: 24px; border-radius: 4px; border: none; cursor: pointer; background: #ecf0f1; color: #7f8c8d; font-size: 12px; }
        .action-btn:hover { background: #bdc3c7; }
        .empty-state { padding: 20px; text-align: center; color: #94a3b8; }
        .toast{position:fixed; top:16px; right:16px; z-index:3; background:rgba(17,24,39,0.85); color:#fff; padding:10px 14px; border-radius:10px; border:1px solid rgba(255,255,255,0.12); backdrop-filter:blur(8px); opacity:0; transform:translateY(-8px); transition: opacity .3s ease, transform .3s ease}
        .toast.show{opacity:1; transform:translateY(0)}
    </style>
</head>
<body>
    <canvas id="dst"></canvas>
    <div class="topbar">
        <div class="brand"></div>
        <div class="nav-buttons">
            <button class="glass-btn" onclick="goSection('#dashboard')">Dashboard</button>
            <button class="glass-btn" onclick="goSection('#rooms')">Rooms</button>
            <button class="glass-btn" onclick="goSection('#room-mgmt')">Room Management</button>
            <button class="glass-btn" onclick="goSection('#staff')">Staffs</button>
            <button class="glass-btn" onclick="goSection('#guests')">Guests</button>
            <button class="glass-btn" onclick="goSection('#history')">History</button>
        </div>
        <div class="dropdown recursive-menu">
            <ul class="menu">
                <li>
                    <a href="#"><div class="avatar">A</div><span>Admin</span></a>
                    <ul class="submenu">
                        <li><a href="#" onclick="goSection('#dashboard')">Dashboard</a></li>
                        <li>
                            <a href="#">Manage</a>
                            <ul class="submenu">
                                <li><a href="#" onclick="goSection('#room-mgmt')">Room Management</a></li>
                                <li><a href="#" onclick="goSection('#rooms')">Rooms</a></li>
                                <li><a href="#" onclick="goSection('#staff')">Staffs</a></li>
                                <li><a href="#" onclick="goSection('#guests')">Guests</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" onclick="logoutSubmit()">Logout</a>
                            <form id="logoutForm" method="POST" action="{{ route('admin.logout') }}" style="display:none">@csrf</form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    @if(session('status'))
        <div class="toast" id="toast">{{ session('status') }}</div>
    @endif
    <div id="main" class="main" style="position:relative; z-index:1;">
        <div id="dashboard" class="section">
            <div class="card">
                <div class="header" style="margin-bottom:16px;">
                    <h1>Dashboard</h1>
                    <div class="header-date"><span id="currentDate">Today</span></div>
                </div>
        @php
            $todayStr = \Illuminate\Support\Carbon::now()->toDateString();
            $totalRoomsLimit = config('hotel.room_limit');
            try {
                $totalRooms = \App\Models\Room::count();
                $activeTodayQ = \App\Models\Booking::whereIn('status', ['confirmed','checked_in'])
                    ->whereDate('check_in_date', '<=', $todayStr)
                    ->whereDate('check_out_date', '>=', $todayStr);
                $todayCheckins = \App\Models\Booking::whereIn('status', ['confirmed','checked_in'])
                    ->whereDate('check_in_date', $todayStr)
                    ->count();
                $activeRoomIds = (clone $activeTodayQ)->pluck('room_id')->filter()->unique();
                $occupiedRooms = $activeRoomIds->count();
                $denom = $totalRoomsLimit ?: $totalRooms;
                $occupancyRate = $denom ? min(round(($occupiedRooms / $denom) * 100), 100) : 0;
                $todayRevenue = (clone $activeTodayQ)->with('room')->get()->sum(function($b){
                    $price = optional($b->room)->price ?? 0;
                    $tax = round($price * 0.12);
                    return $price + $tax;
                });
            } catch (\Throwable $e) {
                $totalRooms = 0;
                $todayCheckins = 0;
                $denom = $totalRoomsLimit ?: 0;
                $occupancyRate = 0;
                $todayRevenue = 0;
            }
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-emblem">🏨</div>
                <div class="stat-label">Today's Check-ins</div>
                <div class="stat-value" id="todayCheckins">{{ $todayCheckins }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-emblem">✓</div>
                <div class="stat-label">Occupancy Rate</div>
                <div class="stat-value" id="occupancyRate">{{ $occupancyRate }}%</div>
            </div>
            <div class="stat-card">
                <div class="stat-emblem" style="color:#f39c12">💰</div>
                <div class="stat-label">Today's Revenue</div>
                <div class="stat-value" id="todayRevenue">₱{{ number_format($todayRevenue, 0) }}</div>
            </div>
        </div>
        <div class="content-grid" style="margin-top:16px;">
            <div class="card">
                <div class="card-title">Occupancy Rate</div>
                @php
                    $series = [];
                    $labels = [];
                    try {
                        for($i=6;$i>=0;$i--){
                            $date = \Illuminate\Support\Carbon::today()->subDays($i);
                            $activeRooms = \App\Models\Booking::whereIn('status', ['confirmed','checked_in'])
                                ->whereDate('check_in_date','<=',$date)
                                ->whereDate('check_out_date','>=',$date)
                                ->pluck('room_id')
                                ->filter()
                                ->unique()
                                ->count();
                            $series[] = $denom ? min(round(($activeRooms / $denom) * 100), 100) : 0;
                            $labels[] = $date->format('D');
                        }
                    } catch (\Throwable $e) {
                        for($i=6;$i>=0;$i--){
                            $date = \Illuminate\Support\Carbon::today()->subDays($i);
                            $series[] = 0;
                            $labels[] = $date->format('D');
                        }
                    }
                @endphp
                <div class="chart-container">
                    <svg class="chart-svg" id="occupancyChart"></svg>
                </div>
            </div>
            
            
        </div>
            </div>
        </div>

        <div id="guests" class="section">
            <div class="card">
                <div class="section-title">Guests</div>
                <div class="content-grid" style="grid-template-columns: 1fr; justify-items: center;">
                    <div class="card" style="width:min(1050px,96%)">
                        <div class="card-title">Guest Accounts</div>
                        <div class="room-table">
                            @php
                                try { $guests = \App\Models\Guest::orderByDesc('id')->get(); } catch (\Throwable $e) { $guests = collect(); }
                            @endphp
                            @forelse($guests as $g)
                                <div class="table-row guest-columns">
                                    <div>
                                        <span>{{ $g->first_name }} {{ $g->last_name }}</span> <span class="muted" style="font-size:12px">/ Name</span>
                                    </div>
                                    <div>
                                        <span>{{ $g->email }}</span> <span class="muted" style="font-size:12px">/ Email</span>
                                    </div>
                                    <div>
                                        <span>{{ $g->username }}</span> <span class="muted" style="font-size:12px">/ Username</span>
                                    </div>
                                    <div>
                                        <span>{{ $g->is_active ? 'Active' : 'Inactive' }}</span> <span class="muted" style="font-size:12px">/ Status</span>
                                    </div>
                                    <div style="display:flex;gap:8px">
                                        @if($g->is_active)
                                        <form method="POST" action="{{ route('admin.guests.deactivate', $g) }}">@csrf<button class="glass-btn" type="submit">Deactivate</button></form>
                                        @else
                                        <form method="POST" action="{{ route('admin.guests.activate', $g) }}">@csrf<button class="glass-btn" type="submit">Activate</button></form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.guests.delete', $g) }}">@csrf<button class="glass-btn" type="submit">Delete</button></form>
                                    </div>
                                    <div style="grid-column:1/-1; margin-top:8px; padding-top:8px; border-top:1px solid rgba(255,255,255,0.12)">
                                        <form method="POST" action="{{ route('admin.guests.update', $g) }}" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;width:100%">
                                            @csrf
                                            <div class="form__group"><input name="first_name" type="text" class="form__field" placeholder="First name" value="{{ $g->first_name }}" /><label class="form__label">First name</label></div>
                                            <div class="form__group"><input name="last_name" type="text" class="form__field" placeholder="Last name" value="{{ $g->last_name }}" /><label class="form__label">Last name</label></div>
                                            <div class="form__group"><input name="email" type="email" class="form__field" placeholder="Email" value="{{ $g->email }}" style="grid-column:1/-1" /><label class="form__label">Email</label></div>
                                            <div class="form__group"><input name="phone_number" type="text" class="form__field" placeholder="Phone number" value="{{ $g->phone_number }}" /><label class="form__label">Phone number</label></div>
                                            <div class="form__group"><input name="address" type="text" class="form__field" placeholder="Address" value="{{ $g->address }}" /><label class="form__label">Address</label></div>
                                            <div class="form__group" style="grid-column:1/-1"><input name="username" type="text" class="form__field" placeholder="Username" value="{{ $g->username }}" /><label class="form__label">Username</label></div>
                                            <select name="is_active" class="select-glass" style="grid-column:1/-1">
                                                <option value="1" @selected($g->is_active)>Active</option>
                                                <option value="0" @selected(!$g->is_active)>Inactive</option>
                                            </select>
                                            <button class="glass-btn" type="submit" style="grid-column:1/-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">No guest accounts yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="room-mgmt" class="section">
            <div class="card">
                <div class="section-title">Room Management</div>
                <div class="content-grid">
                    <div class="card">
                        <div class="card-title">Pending Requests</div>
                        @php
                            try { $pending = \App\Models\Booking::where('status','pending')->with('room')->orderByDesc('id')->get(); } catch (\Throwable $e) { $pending = collect(); }
                        @endphp
                        @if($pending->isEmpty())
                            <div class="empty-state">No pending requests</div>
                        @else
                            @foreach($pending as $b)
                                <div class="request-item">
                                    <div class="request-info">
                                        <h4>{{ $b->guest_name }} - {{ optional($b->room)->number }} ({{ optional($b->room)->type }})</h4>
                                        <p>{{ $b->check_in_date }} → {{ $b->check_out_date }} • {{ $b->status }} • {{ $b->payment_method }}</p>
                                    </div>
                                    <div class="request-actions">
                                        <form method="POST" action="{{ route('booking.accept', $b) }}">@csrf<button class="request-btn btn-accept" type="submit">Accept</button></form>
                                        <form method="POST" action="{{ route('booking.cancel', $b) }}">@csrf<button class="request-btn btn-cancel" type="submit">Cancel</button></form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-title">Confirmed Bookings</div>
                        @php
                            try { $confirmed = \App\Models\Booking::where('status','confirmed')->with('room')->orderByDesc('id')->get(); } catch (\Throwable $e) { $confirmed = collect(); }
                        @endphp
                        <div class="room-table">
                            <div class="table-header">
                                <div>Room</div>
                                <div>Type</div>
                                <div>Status</div>
                                <div>Guest</div>
                                <div>Check-out</div>
                                <div>Actions</div>
                            </div>
                            @if($confirmed->isEmpty())
                                <div class="empty-state">No confirmed bookings</div>
                            @else
                                @foreach($confirmed as $b)
                                    <div class="table-row">
                                        <div>{{ optional($b->room)->number }}</div>
                                        <div>{{ optional($b->room)->type }}</div>
                                        <div><span class="status-badge status-occupied">Occupied</span></div>
                                        <div>{{ $b->guest_name }}</div>
                                        <div>{{ $b->check_out_date }}</div>
                                        <div class="table-actions">
                                            <form method="POST" action="{{ route('admin.booking.delete', $b) }}">
                                                @csrf
                                                <button class="action-btn" type="submit" title="Delete">🗑️</button>
                                            </form>
                                            <a class="action-btn" href="{{ url('/admin/room-management') }}" title="Go to Room Management">↗</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rooms" class="section">
            <div class="card">
                <div class="section-title">Rooms</div>
                <div class="content-grid">
                    <div class="card">
                        <div class="card-title">Add Room</div>
                        <form method="POST" action="{{ route('admin.rooms.store') }}">
                            @csrf
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                <div class="form__group"><input id="room_number" name="number" type="text" inputmode="numeric" pattern="^\d+$" oninput="this.value=this.value.replace(/[^\d]/g,'')" class="form__field" placeholder="Room Number" required /><label for="room_number" class="form__label">Number</label></div>
                                <select name="type" required class="select-glass">
                                    <option>Standard Room</option>
                                    <option>Deluxe Room</option>
                                    <option>Executive Suite</option>
                                    <option>Premium Suite</option>
                                    <option>Family Room</option>
                                    <option>Penthouse Suite</option>
                                </select>
                                <div class="form__group"><input id="room_capacity" name="capacity" type="number" inputmode="numeric" pattern="^\d+$" oninput="this.value=this.value.replace(/[^\d]/g,'')" class="form__field" min="1" placeholder="Capacity" required /><label for="room_capacity" class="form__label">Capacity</label></div>
                                <div class="form__group"><input id="room_price" name="price" type="text" inputmode="decimal" pattern="^\d+(\.\d{0,2})?$" oninput="this.value=this.value.replace(/[^\d\.]/g,'')" class="form__field" placeholder="Price" required /><label for="room_price" class="form__label">Price</label></div>
                                <select name="status" class="select-glass">
                                    <option>available</option>
                                    <option>occupied</option>
                                    <option>maintenance</option>
                                </select>
                                <div class="form__group" style="grid-column:1/-1"><input id="room_desc" name="description" type="text" class="form__field" placeholder="Description" /><label for="room_desc" class="form__label">Description</label></div>
                            </div>
                            <div style="margin-top:12px"><button class="glass-btn" type="submit">Add</button></div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-title">All Rooms</div>
                        <div class="room-table">
                            @php
                                try { $roomsAll = \App\Models\Room::orderBy('number')->get(); } catch (\Throwable $e) { $roomsAll = collect(); }
                            @endphp
                            @foreach($roomsAll as $r)
                                <div class="table-row rooms-columns">
                                    <div><span>{{ $r->number }}</span> <span class="muted" style="font-size:12px">/ No.</span></div>
                                    <div><span>{{ $r->type }}</span> <span class="muted" style="font-size:12px">/ Type</span></div>
                                    <div><span>{{ $r->capacity }}</span> <span class="muted" style="font-size:12px">/ Cap.</span></div>
                                    <div><span>₱{{ number_format($r->price,2) }}</span> <span class="muted" style="font-size:12px">/ Price</span></div>
                                    <div><span>{{ $r->status }}</span> <span class="muted" style="font-size:12px">/ Status</span></div>
                                    <div>
                                        <form method="POST" action="{{ route('admin.rooms.update', $r) }}" style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px;width:100%">
                                            @csrf
                                            <select name="type" class="select-glass" style="grid-column:1/-1">
                                                @foreach(['Standard Room','Deluxe Room','Executive Suite','Premium Suite','Family Room','Penthouse Suite'] as $t)
                                                    <option value="{{ $t }}" @selected($r->type === $t)>{{ $t }}</option>
                                                @endforeach
                                            </select>
                                            <input name="capacity" type="number" inputmode="numeric" pattern="^\d+$" oninput="this.value=this.value.replace(/[^\d]/g,'')" value="{{ $r->capacity }}" />
                                            <input name="price" type="text" inputmode="decimal" pattern="^\d+(\.\d{0,2})?$" oninput="this.value=this.value.replace(/[^\d\.]/g,'')" value="{{ $r->price }}" />
                                            <select name="status" class="select-glass" style="grid-column:1/-1">
                                                @foreach(['available','occupied','maintenance'] as $s)
                                                    <option value="{{ $s }}" @selected($r->status === $s)>{{ $s }}</option>
                                                @endforeach
                                            </select>
                                            <button class="glass-btn" type="submit" style="grid-column:1/-1">Save</button>
                                        </form>
                                    </div>
                                    <div>
                                        <form method="POST" action="{{ route('admin.rooms.delete', $r) }}">@csrf<button class="glass-btn" type="submit">Delete</button></form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="staff" class="section">
            <div class="card">
                <div class="section-title">Staffs</div>
                <div class="content-grid">
                    <div class="card">
                        <div class="card-title">Create Staff</div>
                        <form method="POST" action="{{ route('admin.staff.store') }}">
                            @csrf
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                <div class="form__group"><input id="staff_name" name="name" type="text" class="form__field" placeholder="Name" required /><label for="staff_name" class="form__label">Name</label></div>
                                <div class="form__group"><input id="staff_email" name="email" type="email" class="form__field" placeholder="Email" required /><label for="staff_email" class="form__label">Email</label></div>
                                <div class="form__group" style="grid-column:1/-1"><input id="staff_password" name="password" type="password" class="form__field" placeholder="Password" required /><label for="staff_password" class="form__label">Password</label></div>
                            </div>
                            <div style="margin-top:12px"><button class="glass-btn" type="submit">Create</button></div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-title">Staff Accounts</div>
                        <div class="room-table">
                            @php
                                try { $staff = \App\Models\User::where('is_staff', true)->orderByDesc('id')->get(); } catch (\Throwable $e) { $staff = collect(); }
                            @endphp
                            @forelse($staff as $u)
                                <div class="table-row staff-columns">
                                    <div>
                                        <span>{{ $u->name }}</span> <span class="muted" style="font-size:12px">/ Username</span>
                                    </div>
                                    <div>
                                        <span>{{ $u->email }}</span> <span class="muted" style="font-size:12px">/ Email</span>
                                    </div>
                                    <div>
                                        <span>{{ $u->is_active ? 'Active' : 'Inactive' }}</span> <span class="muted" style="font-size:12px">/ Status</span>
                                    </div>
                                    <div style="display:flex;gap:8px">
                                        @if($u->is_active)
                                        <form method="POST" action="{{ route('admin.staff.deactivate', $u) }}">@csrf<button class="glass-btn" type="submit">Deactivate</button></form>
                                        @else
                                        <form method="POST" action="{{ route('admin.staff.activate', $u) }}">@csrf<button class="glass-btn" type="submit">Activate</button></form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.staff.delete', $u) }}">@csrf<button class="glass-btn" type="submit">Delete</button></form>
                                    </div>
                                    <div style="grid-column:1/-1; margin-top:8px; padding-top:8px; border-top:1px solid rgba(255,255,255,0.12)">
                                        <form method="POST" action="{{ route('admin.staff.update', $u) }}" style="display:grid;grid-template-columns:1fr 1fr;gap:12px;width:100%">
                                            @csrf
                                            <div class="form__group"><input name="name" type="text" class="form__field" placeholder="Name" value="{{ $u->name }}" /><label class="form__label">Name</label></div>
                                            <div class="form__group"><input name="email" type="email" class="form__field" placeholder="Email" value="{{ $u->email }}" /><label class="form__label">Email</label></div>
                                            <div class="form__group" style="grid-column:1/-1"><input name="password" type="password" class="form__field" placeholder="New Password" /><label class="form__label">New Password</label></div>
                                            <select name="is_active" class="select-glass" style="grid-column:1/-1">
                                                <option value="1" @selected($u->is_active)>Active</option>
                                                <option value="0" @selected(!$u->is_active)>Inactive</option>
                                            </select>
                                            <button class="glass-btn" type="submit" style="grid-column:1/-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">No staff accounts yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="history" class="section">
            <div class="card">
                <div class="section-title">Booking History</div>
                <div style="display:flex;gap:10px;margin:8px 0">
                    <button class="glass-btn" type="button" onclick="exportHistoryCSV()">Export CSV</button>
                    <button class="glass-btn" type="button" onclick="exportHistoryPrint()">Export PDF</button>
                    @if(class_exists(\PhpOffice\PhpWord\PhpWord::class))
                        <a class="glass-btn" href="{{ route('admin.history.export.docx') }}">Export DOCX</a>
                    @else
                        <a class="glass-btn" href="{{ route('admin.history.export.doc') }}">Export DOC</a>
                    @endif
                </div>
                <div class="content-grid">
                    <div class="card">
                        <div class="card-title">Accepted</div>
                        @php
                            try { $accepted = \App\Models\Booking::whereIn('status',['confirmed','checked_in'])->with('room')->orderByDesc('id')->limit(20)->get(); } catch (\Throwable $e) { $accepted = collect(); }
                        @endphp
                        @if($accepted->isEmpty())
                            <div class="empty-state">No accepted bookings</div>
                        @else
                            @foreach($accepted as $b)
                                <div class="table-row" style="grid-template-columns:1fr 1.6fr 1fr 1.4fr 1fr">
                                    <div>#{{ $b->id }}</div>
                                    <div>{{ optional($b->room)->number }} • {{ optional($b->room)->type }}</div>
                                    <div>{{ $b->guest_name }}</div>
                                    <div>{{ $b->check_in_date }} → {{ $b->check_out_date }}</div>
                                    <div><span class="status-badge status-occupied">{{ $b->status }}</span></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-title">Cancelled</div>
                        @php
                            try { $cancelled = \App\Models\Booking::where('status','cancelled')->with('room')->orderByDesc('id')->limit(20)->get(); } catch (\Throwable $e) { $cancelled = collect(); }
                        @endphp
                        @if($cancelled->isEmpty())
                            <div class="empty-state">No cancelled bookings</div>
                        @else
                            @foreach($cancelled as $b)
                                <div class="table-row" style="grid-template-columns:1fr 1.6fr 1fr 1.4fr 1fr">
                                    <div>#{{ $b->id }}</div>
                                    <div>{{ optional($b->room)->number }} • {{ optional($b->room)->type }}</div>
                                    <div>{{ $b->guest_name }}</div>
                                    <div>{{ $b->check_in_date }} → {{ $b->check_out_date }}</div>
                                    <div><span class="status-badge status-pending">{{ $b->status }}</span></div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @php($acceptedData = $accepted->map(function($b){ return [
                    'id' => $b->id,
                    'room_number' => optional($b->room)->number,
                    'room_type' => optional($b->room)->type,
                    'guest_name' => $b->guest_name,
                    'check_in_date' => $b->check_in_date,
                    'check_out_date' => $b->check_out_date,
                    'status' => $b->status,
                ]; })->values())
                @php($cancelledData = $cancelled->map(function($b){ return [
                    'id' => $b->id,
                    'room_number' => optional($b->room)->number,
                    'room_type' => optional($b->room)->type,
                    'guest_name' => $b->guest_name,
                    'check_in_date' => $b->check_in_date,
                    'check_out_date' => $b->check_out_date,
                    'status' => $b->status,
                ]; })->values())
                <script type="application/json" id="acceptedData">{{ $acceptedData->toJson() }}</script>
                <script type="application/json" id="cancelledData">{{ $cancelledData->toJson() }}</script>
            </div>
        </div>
    </div>
    <script type="application/json" id="seriesData">@json($series)</script>
    <script type="application/json" id="labelsData">@json($labels)</script>
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style="display:none"><defs><filter id="goo"><feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur"/><feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"/><feBlend in="SourceGraphic" in2="goo"/></filter></defs></svg>
    <script>
        function goSection(id){ const main=document.getElementById('main'); main.classList.add('blur'); document.querySelector(id).scrollIntoView({behavior:'smooth'}); setTimeout(()=>{ main.classList.remove('blur'); }, 600); }
        function logoutSubmit(){ document.getElementById('logoutForm').submit(); }
        function initDD(){
            document.querySelectorAll('.dd').forEach(dd => {
                const face = dd.querySelector('[data-dd-face]');
                const items = dd.querySelector('[data-dd-items]');
                const hidden = dd.querySelector('input[type="hidden"]');
                if(face && items && hidden){
                    face.addEventListener('click', e => {
                        e.stopPropagation();
                        if(!items.classList.contains('show')){
                            const backdrop = document.createElement('div');
                            backdrop.className = 'dd-backdrop';
                            backdrop.addEventListener('click', () => { items.classList.remove('show'); backdrop.remove(); });
                            document.body.appendChild(backdrop);
                        } else {
                            const b = document.querySelector('.dd-backdrop'); if(b) b.remove();
                        }
                        items.classList.toggle('show');
                    });
                    items.querySelectorAll('button[data-value]').forEach(btn => {
                        btn.addEventListener('click', () => {
                            hidden.value = btn.dataset.value;
                            face.textContent = btn.textContent;
                            items.classList.remove('show');
                            const b = document.querySelector('.dd-backdrop'); if(b) b.remove();
                        });
                    });
                    document.addEventListener('click', e => { if(!dd.contains(e.target)) { items.classList.remove('show'); const b = document.querySelector('.dd-backdrop'); if(b) b.remove(); } });
                }
            });
        }
        initDD();
        
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const rawData = JSON.parse(document.getElementById('seriesData').textContent);
        const days = JSON.parse(document.getElementById('labelsData').textContent);
        const svg = document.getElementById('occupancyChart');
        const width = svg.clientWidth || 600;
        const height = svg.clientHeight || 220;
        const padding = 40;
        const chartWidth = Math.max(0, width - padding * 2);
        const chartHeight = Math.max(0, height - padding * 2);
        const data = (Array.isArray(rawData) && rawData.length ? rawData : (Array.isArray(days) ? new Array(days.length).fill(0) : [0]))
            .map(v => { const n = Number(v); return isFinite(n) ? n : 0; });
        const step = data.length > 1 ? (chartWidth / (data.length - 1)) : 0;
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        svg.innerHTML = '';
        svg.innerHTML += `<line x1="${padding}" y1="${height - padding}" x2="${width - padding}" y2="${height - padding}" stroke="#e0e0e0" stroke-width="1"/>`;
        const points = data.map((v,i)=>{
            const x = data.length > 1 ? (padding + step * i) : (padding + chartWidth / 2);
            const y = height - padding - (v / 100) * chartHeight;
            return {x,y};
        });
        if(points.length){
            let path = `M ${points[0].x} ${points[0].y}`;
            for(let i=1;i<points.length;i++){ path += ` L ${points[i].x} ${points[i].y}`; }
            // If single point, draw a small horizontal segment
            if(points.length === 1){ path += ` L ${points[0].x + Math.max(10, chartWidth * 0.1)} ${points[0].y}`; }
            svg.innerHTML += `<path d="${path}" stroke="#3498db" stroke-width="2" fill="none"/>`;
        }
        points.forEach((p,i)=>{
            svg.innerHTML += `<circle cx="${p.x}" cy="${p.y}" r="4" fill="#3498db"/>`;
            if(days && days[i] !== undefined){ svg.innerHTML += `<text x="${p.x}" y="${height - 10}" text-anchor="middle" font-size="11" fill="#7f8c8d">${days[i]}</text>`; }
        });
        for(let i=0;i<=100;i+=20){ const y = height - padding - (i / 100) * chartHeight; svg.innerHTML += `<text x="10" y="${y + 4}" font-size="11" fill="#7f8c8d">${i}</text>`; }
        var oldx = 0;
        var oldy = 0;
        var imageDataDst, imageDataSrc;
        var w = 1024;
        var h = 512;
        var lerp = function(a, b, t) { return (b - a) * (1-Math.exp(-t)) + a; };
        window.onload = function() {
            w = img.width; h = img.height;
            var canvas = document.querySelector('canvas');
            canvas.width = w; canvas.height = h;
            var dst = canvas.getContext('2d');
            dst.drawImage(img, 0, 0, w, h);
            imageDataSrc = dst.getImageData(0, 0, w, h);
            imageDataDst = dst.getImageData(0, 0, w, h);
            var px = 0, py = 320, ti = 0;
            var timer = setInterval(function(){ if(ti++ > 100) clearInterval(timer); updatecanvas(canvas, lerp(0, 900, ti/20), py); }, 16);
            canvas.addEventListener('mousemove', function(evt){ var m = getMousePos(canvas, evt); updatecanvas(canvas, m.x, m.y); }, false);
        };
        var smootherstep = function(t){ return 1 / (Math.exp(-6 * t + 3)) - Math.exp(-3); };
        function getMousePos(canvas, evt){ var rect = canvas.getBoundingClientRect(); return { x: evt.clientX - rect.left, y: evt.clientY - rect.top }; }
        function updatecanvas(canvas, px, py){
            var context = canvas.getContext('2d');
            var r = 100; var xmin = oldx - r; var xmax = oldx + r; if (xmin < 0) xmin = 0; if (xmax > w) xmax = w; var ymin = oldy - r; var ymax = oldy + r; if (ymin < 0) ymin = 0; if (ymax > h) ymax = h;
            for (var y = ymin; y < ymax; y++) { for (var x = xmin; x < xmax; x++) { var index = (x + y * w) << 2; imageDataDst.data[index] = imageDataSrc.data[index++]; imageDataDst.data[index] = imageDataSrc.data[index++]; imageDataDst.data[index] = imageDataSrc.data[index++]; imageDataDst.data[index] = 255; } }
            var dstdata = imageDataDst.data; var srcdata = imageDataSrc.data;
            xmin = px - r; xmax = px + r; ymin = py - r; ymax = py + r; if (xmin < 0) xmin = 0; if (xmax > w) xmax = w; if (ymin < 0) ymin = 0; if (ymax > h) ymax = h;
            var tol = -15; var maxSize = w * (h - 1) + w - 1;
            for (var y2 = ymin; y2 < ymax; y2++) { var index2d = (xmin + y2 * w) << 2; for (var x2 = xmin; x2 < xmax; x2++) {
                var x1 = x2 - px; var y1 = y2 - py; var d = Math.sqrt(x1 * x1 + y1 * y1);
                if (d <= r) { var sc = 1 - smootherstep((r - d) / r); var xx = Math.floor(px + x1 * sc); var yy = Math.floor(py + y1 * sc);
                    if (sc < tol * 0.9 && sc > tol * 1.1) sc = 0.9; else if (sc < tol) sc = 0.1; else sc = 1;
                    var idx = ((xx + yy * w) % maxSize) << 2; dstdata[index2d++] = sc * srcdata[idx + 0]; dstdata[index2d++] = sc * srcdata[idx + 1]; dstdata[index2d++] = sc * srcdata[idx + 2]; index2d++; }
                else { index2d = index2d + 4; }
            } }
            imageDataDst.data = dstdata; context.putImageData(imageDataDst, 0, 0); oldx = px; oldy = py;
        }
        var img = new Image();
        img.src = "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/4QAWRXhpZgAASUkqAAgAAAAAAAAAAAD/4gxYSUNDX1BST0ZJTEUAAQEAAAxITGlubwIQAABtbnRyUkdCIFhZWiAHzgACAAkABgAxAABhY3NwTVNGVAAAAABJRUMgc1JHQgAAAAAAAAAAAAAAAQAA9tYAAQAAAADTLUhQICAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABFjcHJ0AAABUAAAADNkZXNjAAABhAAAAGx3dHB0AAAB8AAAABRia3B0AAACBAAAABRyWFlaAAACGAAAABRnWFlaAAACLAAAABRiWFlaAAACQAAAABRkbW5kAAACVAAAAHBkbWRkAAACxAAAAIh2dWVkAAADTAAAAIZ2aWV3AAAD1AAAACRsdW1pAAAD+AAAABRtZWFzAAAEDAAAACR0ZWNoAAAEMAAAAAxyVFJDAAAEPAAACAxnVFJDAAAEPAAACAxiVFJDAAAEPAAACAx0ZXh0AAAAAENvcHlyaWdodCAoYykgMTk5OCBIZXdsZXR0LVBhY2thcmQgQ29tcGFueQAAZGVzYwAAAAAAAAASc1JHQiBJRUM2MTk2Ni0yLjEAAAAAAAAAAAAAABJzUkdCIElFQzYxOTY2LTIuMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWFlaIAAAAAAAAPNRAAEAAAABFsxYWVogAAAAAAAAAAAAAAAAAAAAAFhZWiAAAAAAAABvogAAOPUAAAOQWFlaIAAAAAAAAGKZAAC3hQAAGNpYWVogAAAAAAAAJKAAAA+EAAC2z2Rlc2MAAAAAAAAAFklFQyBodHRwOi8vd3d3LmllYy5jaAAAAAAAAAAAAAAAFklFQyBodHRwOi8vd3d3LmllYy5jaAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABkZXNjAAAAAAAAAC5JRUMgNjE5NjYtMi4xIERlZmF1bHQgUkdCIGNvbG91ciBzcGFjZSAtIHNSR0IAAAAAAAAAAAAAAC5JRUMgNjE5NjYtMi4xIERlZmF1bHQgUkdCIGNvbG91ciBzcGFjZSAtIHNSR0IAAAAAAAAAAAAAAAAAAAAAAAAAAAAAZGVzYwAAAAAAAAAsUmVmZXJlbmNlIFZpZXdpbmcgQ29uZGl0aW9uIGluIElFQzYxOTY2LTIuMQAAAAAAAAAAAAAALFJlZmVyZW5jZSBWaWV3aW5nIENvbmRpdGlvbiBpbiBJRUM2MTk2Ni0yLjEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHZpZXcAAAAAABOk/gAUXy4AEM8UAAPtzAAEEwsAA1yeAAAAAVhZWiAAAAAAAEwJVgBQAAAAVx/nbWVhcwAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAo8AAAACc2lnIAAAAABDUlQgY3VydgAAAAAAAAQAAAAABQAKAA8AFAAZAB4AIwAoAC0AMgA3ADsAQABFAEoATwBUAFkAXgBjAGgAbQByAHcAfACBAIYAiwCQAJUAmgCfAKQAqQCuALIAtwC8AMEAxgDLANAA1QDbAOAA5QDrAPAA9gD7AQEBBwENARMBGQEfASUBKwEyATgBPgFFAUwBUgFZAWABZwFuAXUBfAGDAYsBkgGaAaEBqQGxAbkBwQHJAdEB2QHhAekB8gH6AgMCDAIUAh0CJgIvAjgCQQJLAlQCXQJnAnECegKEAo4CmAKiAqwCtgLBAssC1QLgAusC9QMAAwsDFgMhAy0DOANDA08DWgNmA3IDfgOKA5YDogOuA7oDxwPTA+AD7AP5BAYEEwQgBC0EOwRIBFUEYwRxBH4EjASaBKgEtgTEBNME4QTwBP4FDQUcBSsFOgVJBVgFZw";
        (function(){
            var t = document.getElementById('toast');
            if(t){
                requestAnimationFrame(function(){ t.classList.add('show'); });
                setTimeout(function(){ t.classList.remove('show'); }, 2000);
                setTimeout(function(){ if(t && t.parentNode){ t.parentNode.removeChild(t); } }, 2400);
            }
        })();
    </script>
    <script>
        function exportHistoryCSV(){
            var a = JSON.parse(document.getElementById('acceptedData').textContent || '[]');
            var c = JSON.parse(document.getElementById('cancelledData').textContent || '[]');
            var rows = [];
            rows.push(['Category','ID','Room Number','Room Type','Guest','Check-in','Check-out','Status']);
            a.forEach(function(r){ rows.push(['Accepted', r.id, r.room_number||'', r.room_type||'', r.guest_name||'', r.check_in_date||'', r.check_out_date||'', r.status||'']); });
            c.forEach(function(r){ rows.push(['Cancelled', r.id, r.room_number||'', r.room_type||'', r.guest_name||'', r.check_in_date||'', r.check_out_date||'', r.status||'']); });
            var csv = rows.map(function(row){ return row.map(function(cell){ var s = String(cell==null?'':cell); if(s.includes(',') || s.includes('"') || s.includes('\n')){ s = '"' + s.replace(/"/g,'""') + '"'; } return s; }).join(','); }).join('\n');
            var blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
            var url = URL.createObjectURL(blob);
            var link = document.createElement('a');
            var dt = new Date();
            var name = 'booking_history_' + dt.toISOString().slice(0,10) + '.csv';
            link.href = url; link.download = name; document.body.appendChild(link); link.click(); document.body.removeChild(link); URL.revokeObjectURL(url);
        }
        function exportHistoryPrint(){
            var sec = document.getElementById('history');
            var win = window.open('', '_blank');
            if(!win){ return; }
            var html = '<!doctype html><html><head><meta charset="utf-8"><title>Booking History</title>'+
                '<style>body{font-family:Inter,Arial,Helvetica,sans-serif;color:#111;padding:20px} .title{font-weight:700;font-size:18px;margin-bottom:10px} .row{display:grid;grid-template-columns:1fr 1.6fr 1fr 1.4fr 1fr;gap:8px;padding:8px;border-bottom:1px solid #ddd} .header{display:grid;grid-template-columns:repeat(7,1fr);gap:6px;font-weight:700;margin:8px 0} .card-title{font-weight:700;margin:12px 0}</style></head><body>';
            html += '<div class="title">Booking History</div>';
            html += sec.querySelector('.content-grid').outerHTML;
            html += '</body></html>';
            win.document.open();
            win.document.write(html);
            win.document.close();
            win.focus();
            win.print();
        }
    (function(){
            var canvas=document.getElementById('dst');
            var ctx=canvas.getContext('2d');
            if(!ctx){return}
            var dpr=window.devicePixelRatio||1;
            var W=0,H=0;
            var particles=[];
            var icons=[];
            var ribbons=[];
            var theme='dark';
            var scrollPos=0;
            function resize(){
                W=canvas.width=Math.ceil(window.innerWidth*dpr);
                H=canvas.height=Math.ceil(window.innerHeight*dpr);
                canvas.style.width=window.innerWidth+'px';
                canvas.style.height=window.innerHeight+'px';
                initScene();
            }
            function initScene(){
                particles=[]; icons=[]; ribbons=[];
                for(var i=0;i<60;i++){ particles.push({x:Math.random()*W,y:Math.random()*H,r:(Math.random()*2+0.6)*dpr,s:0.12+Math.random()*0.5}); }
                var seg=5; var sw=W/seg; var baseY=H*0.58; var types=['bell','key','calendar','bed','receipt'];
                for(var k=0;k<seg;k++){
                    var cx=k*sw+sw*0.5; var cy=baseY+(Math.random()*H*0.06-H*0.03); var sz=(36+Math.random()*18)*dpr;
                    icons.push({type:types[k%types.length],x:cx,y:cy,size:sz,phase:Math.random()*Math.PI*2,speed:0.3+Math.random()*0.25,ax:10*dpr,ay:8*dpr});
                }
                for(var j=0;j<4;j++){ var yb=H*(0.32+0.18*j); ribbons.push({y:yb,amp1:10*dpr,amp2:5*dpr,offset:Math.random()*Math.PI*2,width:2*dpr}); }
            }
            function drawBackground(t){
                var yCenter = H*0.2 - (scrollPos*dpr*0.03);
                var g=ctx.createLinearGradient(0,0,0,H);
                if(theme==='light'){ g.addColorStop(0,'#f7f7fb'); g.addColorStop(1,'#eef2ff'); } else { g.addColorStop(0,'#1a1233'); g.addColorStop(1,'#23153c'); }
                ctx.fillStyle=g; ctx.fillRect(0,0,W,H);
                var rg=ctx.createRadialGradient(W*0.5,yCenter,H*0.06,W*0.5,H*0.5,H*0.85);
                if(theme==='light'){ rg.addColorStop(0,'rgba(247,181,0,0.08)'); rg.addColorStop(1,'rgba(247,181,0,0.0)'); } else { rg.addColorStop(0,'rgba(247,181,0,0.10)'); rg.addColorStop(1,'rgba(247,181,0,0.0)'); }
                ctx.fillStyle=rg; ctx.fillRect(0,0,W,H);
            }
            function drawRibbons(t){
                for(var i=0;i<ribbons.length;i++){
                    var rb=ribbons[i];
                    ctx.lineWidth=rb.width; ctx.shadowColor='rgba(247,181,0,0.5)'; ctx.shadowBlur=10*dpr; ctx.strokeStyle='rgba(247,181,0,0.18)';
                    ctx.beginPath(); var baseY = rb.y - scrollPos*dpr*0.06; ctx.moveTo(0,baseY);
                    for(var x=0;x<=W;x+=8*dpr){ var y=baseY+rb.amp1*Math.sin(x*0.006+t*0.6+rb.offset)+rb.amp2*Math.sin(x*0.013-t*0.4); ctx.lineTo(x,y); }
                    ctx.stroke(); ctx.shadowBlur=0;
                }
            }
            function drawIconShape(type,s){
                if(type==='bell'){ ctx.beginPath(); ctx.arc(0,-s*0.08,s*0.22,0,Math.PI*2); ctx.fill(); ctx.fillRect(-s*0.30,-s*0.02,s*0.60,s*0.40); ctx.beginPath(); ctx.arc(0,-s*0.32,s*0.06,0,Math.PI*2); ctx.fill(); }
                else if(type==='key'){ ctx.beginPath(); ctx.arc(-s*0.20,-s*0.08,s*0.16,0,Math.PI*2); ctx.fill(); ctx.fillRect(-s*0.04,-s*0.10,s*0.46,s*0.12); ctx.fillRect(s*0.30,-s*0.10,s*0.10,s*0.12); }
                else if(type==='calendar'){ ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.54); ctx.clearRect(-s*0.32,-s*0.28,s*0.64,s*0.14); ctx.fillRect(-s*0.32,-s*0.28,s*0.64,s*0.10); }
                else if(type==='bed'){ ctx.fillRect(-s*0.34,-s*0.06,s*0.68,s*0.24); ctx.beginPath(); ctx.arc(-s*0.28,-s*0.12,s*0.10,0,Math.PI*2); ctx.fill(); }
                else { ctx.fillRect(-s*0.28,-s*0.16,s*0.56,s*0.34); ctx.clearRect(-s*0.24,-s*0.12,s*0.48,s*0.10); }
            }
            function drawIcons(t){
                for(var i=0;i<icons.length;i++){
                    var ic=icons[i]; var x=ic.x+Math.sin(t*ic.speed+ic.phase)*ic.ax; var y=ic.y - scrollPos*dpr*0.10 + Math.cos(t*ic.speed*0.8+ic.phase)*ic.ay; var s=ic.size*(0.98+0.02*Math.sin(t*0.9+ic.phase));
                    ctx.save(); ctx.translate(x,y); ctx.fillStyle=theme==='light' ? 'rgba(247,181,0,0.85)' : 'rgba(247,181,0,0.85)'; ctx.shadowColor=theme==='light' ? 'rgba(247,181,0,0.6)' : '#f7b500'; ctx.shadowBlur=14*dpr; drawIconShape(ic.type,s); ctx.restore();
                }
                ctx.shadowBlur=0;
            }
            function drawParticles(){
                for(var i=0;i<particles.length;i++){ var p=particles[i]; ctx.fillStyle='rgba(247,181,0,0.12)'; ctx.beginPath(); ctx.arc(p.x,p.y - scrollPos*dpr*0.02,p.r,0,Math.PI*2); ctx.fill(); p.y-=p.s; if(p.y<-10) p.y=H+10; }
            }
            function render(){ var t=performance.now()/1000; drawBackground(t); drawRibbons(t); drawIcons(t); drawParticles(); requestAnimationFrame(render); }
            window.addEventListener('resize',resize);
            window.addEventListener('scroll',function(){ scrollPos = (window.scrollY||0); });
            resize(); render();
            
            window.onload = null;
        })();
    </script>
</body>
</html>
