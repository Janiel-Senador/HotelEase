<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; background: #f5f5f5; display: flex; }
        .sidebar { width: 200px; background: #8B4513; min-height: 100vh; color: white; padding: 20px 0; }
        .sidebar-header { padding: 0 20px 20px; font-size: 14px; font-weight: 600; color: #95a5a6; }
        .nav-item { padding: 12px 20px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: background 0.3s; color: #ecf0f1; font-size: 14px; }
        .nav-item:hover { background: #6b3410; }
        .nav-item.active { background: #6b3410; border-left: 3px solid #3498db; }
        .main-content { flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .brand { display:flex; align-items:center; gap:8px; font-weight:700; color:#8B4513 }
        .brand .logo{ width:22px; height:22px; object-fit:contain }
        .header h1 { font-size: 24px; color: #2c3e50; }
        .header-date { display: flex; align-items: center; gap: 10px; color: #7f8c8d; font-size: 14px; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: #3498db; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: relative; }
        .stat-label { font-size: 13px; color: #7f8c8d; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: 700; color: #2c3e50; }
        .stat-icon { position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .icon-red { background: #ffebee; color: #e74c3c; }
        .icon-green { background: #e8f5e9; color: #27ae60; }
        .icon-yellow { background: #fff9e6; color: #f39c12; }
        .icon-blue { background: #e3f2fd; color: #3498db; }
        .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card-title { font-size: 16px; font-weight: 600; color: #2c3e50; margin-bottom: 20px; }
        .chart-container { height: 200px; position: relative; }
        .chart-svg { width: 100%; height: 100%; }
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
        .table-header { display: grid; grid-template-columns: 1fr 1fr 1fr 1.5fr 1fr 0.5fr; padding: 12px 0; border-bottom: 2px solid #ecf0f1; font-size: 13px; color: #7f8c8d; font-weight: 600; }
        .table-row { display: grid; grid-template-columns: 1fr 1fr 1fr 1.5fr 1fr 0.5fr; padding: 15px 0; border-bottom: 1px solid #ecf0f1; align-items: center; font-size: 14px; color: #2c3e50; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500; }
        .status-occupied { background: #e8f5e9; color: #27ae60; }
        .status-available { background: #e3f2fd; color: #3498db; }
        .status-pending { background: #fff9e6; color: #f39c12; }
        .table-actions { display: flex; gap: 8px; }
        .action-btn { width: 24px; height: 24px; border-radius: 4px; border: none; cursor: pointer; background: #ecf0f1; color: #7f8c8d; font-size: 12px; }
        .action-btn:hover { background: #bdc3c7; }
        .empty-state { padding: 20px; text-align: center; color: #95a5a6; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">Admin Panel</div>
        <div class="nav-item active">
            <span>📅</span>
            <span>Reservations</span>
        </div>
        <a href="{{ route('admin.room_management') }}" class="nav-item">
            <span>🛎️</span>
            <span>Room Management</span>
        </a>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div>
            <h1>Hotel Management Dashboard</h1>
            <div class="header-date">
                <span id="currentDate">Today: Dec 20, 2024</span>
            </div>
        </div>
        @php
            $today = \Illuminate\Support\Carbon::today();
            $pendingCount = \App\Models\Booking::where('status','pending')->count();
            $todayCheckins = \App\Models\Booking::whereDate('check_in_date', $today)->where('status', 'confirmed')->count();
            $totalRoomsLimit = config('hotel.room_limit');
            $totalRooms = \App\Models\Room::count();
            $occupiedRooms = \App\Models\Booking::where('status','confirmed')->count();
            $denom = $totalRoomsLimit ?: $totalRooms;
            $occupancyRate = $denom ? round(($occupiedRooms / $denom) * 100) : 0;
            $todayRevenue = \App\Models\Booking::whereDate('check_in_date',$today)->where('status','confirmed')->with('room')->get()->sum(function($b){
                $n = \Illuminate\Support\Carbon::parse($b->check_in_date)->diffInDays(\Illuminate\Support\Carbon::parse($b->check_out_date));
                $price = optional($b->room)->price ?? 0;
                $subtotal = $n * $price;
                $tax = round($subtotal * 0.12);
                return $subtotal + $tax;
            });
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Today's Check-ins</div>
                <div class="stat-value" id="todayCheckins">{{ $todayCheckins }}</div>
                <div class="stat-icon icon-red">🏨</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Occupancy Rate</div>
                <div class="stat-value" id="occupancyRate">{{ $occupancyRate }}%</div>
                <div class="stat-icon icon-green">✓</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Today's Revenue</div>
                <div class="stat-value" id="todayRevenue">₱{{ number_format($todayRevenue, 0) }}</div>
                <div class="stat-icon icon-yellow">💰</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Requests</div>
                <div class="stat-value" id="pendingCount">{{ $pendingCount }}</div>
                <div class="stat-icon icon-blue">🔔</div>
            </div>
        </div>
        <div class="content-grid">
            <div class="card">
                <div class="card-title">Occupancy Rate</div>
                @php
                    $series = [];
                    $labels = [];
                    for($i=6;$i>=0;$i--){
                        $date = \Illuminate\Support\Carbon::today()->subDays($i);
                        $active = \App\Models\Booking::where('status','confirmed')
                            ->whereDate('check_in_date','<=',$date)
                            ->whereDate('check_out_date','>=',$date)
                            ->count();
                        $series[] = $denom ? min(round(($active / $denom) * 100), 100) : 0;
                        $labels[] = $date->format('D');
                    }
                @endphp
                <div class="chart-container">
                    <svg class="chart-svg" id="occupancyChart"></svg>
                </div>
            </div>
            <div class="card">
                <div class="card-title">Pending Requests</div>
                @php($pending = \App\Models\Booking::where('status','pending')->with('room')->orderByDesc('id')->get())
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
                                <form method="POST" action="{{ route('booking.accept', $b) }}">
                                    @csrf
                                    <button class="request-btn btn-accept" type="submit">Accept</button>
                                </form>
                                <form method="POST" action="{{ route('booking.cancel', $b) }}">
                                    @csrf
                                    <button class="request-btn btn-cancel" type="submit">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="card">
                <div class="card-title">Confirmed Bookings</div>
                @php($confirmed = \App\Models\Booking::where('status','confirmed')->with('room')->orderByDesc('id')->get())
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
                                    <a class="action-btn" href="{{ route('dbarea') }}" title="View">👁️</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="application/json" id="seriesData">@json($series)</script>
    <script type="application/json" id="labelsData">@json($labels)</script>
    <script>
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        const data = JSON.parse(document.getElementById('seriesData').textContent);
        const days = JSON.parse(document.getElementById('labelsData').textContent);
        const svg = document.getElementById('occupancyChart');
        const width = svg.clientWidth || 600;
        const height = svg.clientHeight || 200;
        const padding = 40;
        const chartWidth = width - padding * 2;
        const chartHeight = height - padding * 2;
        svg.setAttribute('width', width);
        svg.setAttribute('height', height);
        svg.innerHTML = '';
        svg.innerHTML += `<line x1="${padding}" y1="${height - padding}" x2="${width - padding}" y2="${height - padding}" stroke="#e0e0e0" stroke-width="1"/>`;
        const points = data.map((v,i)=>{ const x = padding + (chartWidth / (data.length - 1)) * i; const y = height - padding - (v / 100) * chartHeight; return {x,y}; });
        let path = `M ${points[0].x} ${points[0].y}`;
        for(let i=1;i<points.length;i++){ path += ` L ${points[i].x} ${points[i].y}`; }
        svg.innerHTML += `<path d="${path}" stroke="#3498db" stroke-width="2" fill="none"/>`;
        points.forEach((p,i)=>{
            svg.innerHTML += `<circle cx="${p.x}" cy="${p.y}" r="4" fill="#3498db"/>`;
            svg.innerHTML += `<text x="${p.x}" y="${height - 10}" text-anchor="middle" font-size="11" fill="#7f8c8d">${days[i]}</text>`;
        });
        for(let i=0;i<=100;i+=20){ const y = height - padding - (i / 100) * chartHeight; svg.innerHTML += `<text x="10" y="${y + 4}" font-size="11" fill="#7f8c8d">${i}</text>`; }
    </script>
</body>
</html>
