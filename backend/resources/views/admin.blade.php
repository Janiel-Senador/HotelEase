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
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Hotel Management Dashboard</h1>
            <div class="header-date">
                <span id="currentDate">Today: Dec 20, 2024</span>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Today's Check-ins</div>
                <div class="stat-value" id="todayCheckins">0</div>
                <div class="stat-icon icon-red">🏨</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Occupancy Rate</div>
                <div class="stat-value" id="occupancyRate">0%</div>
                <div class="stat-icon icon-green">✓</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Today's Revenue</div>
                <div class="stat-value" id="todayRevenue">₱0</div>
                <div class="stat-icon icon-yellow">💰</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Requests</div>
                <div class="stat-value" id="pendingCount">0</div>
                <div class="stat-icon icon-blue">🔔</div>
            </div>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-title">Occupancy Rate</div>
                <div class="chart-container">
                    <svg class="chart-svg" id="occupancyChart"></svg>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Pending Requests</div>
                <div id="pendingRequestsList">
                    <div class="empty-state">No pending requests</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Room Management</div>
            <div class="room-table" id="roomTable">
                <div class="table-header">
                    <div>Room</div>
                    <div>Type</div>
                    <div>Status</div>
                    <div>Guest</div>
                    <div>Check-out</div>
                    <div>Actions</div>
                </div>
                <div class="empty-state">No confirmed bookings</div>
            </div>
        </div>
    </div>

    <script>
        function initStorage() {
            if (!localStorage.getItem('hotelBookings')) {
                localStorage.setItem('hotelBookings', JSON.stringify([]));
            }
            if (!localStorage.getItem('pendingBookings')) {
                localStorage.setItem('pendingBookings', JSON.stringify([]));
            }
            if (!localStorage.getItem('confirmedBookings')) {
                localStorage.setItem('confirmedBookings', JSON.stringify([]));
            }
        }
        function loadPendingBookings() { return JSON.parse(localStorage.getItem('pendingBookings') || '[]'); }
        function loadConfirmedBookings() { return JSON.parse(localStorage.getItem('confirmedBookings') || '[]'); }
        function savePendingBookings(bookings) { localStorage.setItem('pendingBookings', JSON.stringify(bookings)); }
        function saveConfirmedBookings(bookings) { localStorage.setItem('confirmedBookings', JSON.stringify(bookings)); }
        function formatDate(dateString) { if (!dateString) return 'N/A'; const date = new Date(dateString); const month = date.toLocaleString('default', { month: 'short' }); const day = date.getDate(); return `${month} ${day}`; }
        function extractPrice(priceStr) { if (!priceStr) return 0; return parseFloat(priceStr.replace(/[₱,]/g, '')) || 0; }
        function displayPendingRequests() {
            const pending = loadPendingBookings();
            const container = document.getElementById('pendingRequestsList');
            if (pending.length === 0) { container.innerHTML = '<div class="empty-state">No pending requests</div>'; return; }
            let html = '';
            pending.forEach((booking, index) => {
                html += `
                    <div class="request-item">
                        <div class="request-info">
                            <h4>${booking.guest?.name || 'Guest'} - ${booking.room}</h4>
                            <p>${formatDate(booking.checkin)} → ${formatDate(booking.checkout)} • ${booking.nights} nights • ${booking.total}</p>
                        </div>
                        <div class="request-actions">
                            <button class="request-btn btn-accept" onclick="acceptBooking(${index})">Accept</button>
                            <button class="request-btn btn-cancel" onclick="cancelBooking(${index})">Cancel</button>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }
        function displayConfirmedBookings() {
            const confirmed = loadConfirmedBookings();
            const table = document.getElementById('roomTable');
            let html = `
                <div class="table-header">
                    <div>Room</div>
                    <div>Type</div>
                    <div>Status</div>
                    <div>Guest</div>
                    <div>Check-out</div>
                    <div>Actions</div>
                </div>
            `;
            if (confirmed.length === 0) { html += '<div class="empty-state">No confirmed bookings</div>'; }
            else {
                confirmed.forEach((booking, index) => {
                    html += `
                        <div class="table-row">
                            <div>${booking.roomNumber || 'N/A'}</div>
                            <div>${booking.room || 'Standard'}</div>
                            <div><span class="status-badge status-occupied">Occupied</span></div>
                            <div>${booking.guest?.name || 'Guest'}</div>
                            <div>${formatDate(booking.checkout)}</div>
                            <div class="table-actions">
                                <button class="action-btn" onclick="viewBooking(${index})" title="View Details">👁️</button>
                                <button class="action-btn" onclick="deleteConfirmedBooking(${index})" title="Delete">🗑️</button>
                            </div>
                        </div>
                    `;
                });
            }
            table.innerHTML = html;
        }
        function acceptBooking(index) {
            const pending = loadPendingBookings();
            const confirmed = loadConfirmedBookings();
            if (index < 0 || index >= pending.length) return;
            const booking = pending[index];
            if (!booking.roomNumber) { booking.roomNumber = Math.floor(Math.random() * 400) + 101; }
            booking.acceptedAt = new Date().toISOString(); booking.status = 'confirmed';
            confirmed.push(booking); pending.splice(index, 1);
            savePendingBookings(pending); saveConfirmedBookings(confirmed);
            refreshDashboard();
            alert(`Booking accepted for ${booking.guest?.name}!\nRoom ${booking.roomNumber} assigned.`);
        }
        function cancelBooking(index) {
            if (!confirm('Are you sure you want to cancel this booking request?')) return;
            const pending = loadPendingBookings();
            if (index < 0 || index >= pending.length) return;
            pending.splice(index, 1); savePendingBookings(pending);
            refreshDashboard();
            alert('Booking cancelled.');
        }
        function viewBooking(index) {
            const confirmed = loadConfirmedBookings();
            if (index < 0 || index >= confirmed.length) return;
            const booking = confirmed[index];
            alert(`Booking Details:\n\nRoom: ${booking.roomNumber} - ${booking.room}\nGuest: ${booking.guest?.name}\nEmail: ${booking.guest?.email}\nPhone: ${booking.guest?.phone || 'N/A'}\nCheck-in: ${booking.checkin}\nCheck-out: ${booking.checkout}\nNights: ${booking.nights}\nTotal: ${booking.total}\nPayment Method: ${booking.paymentMethod || 'N/A'}\nSpecial Requests: ${booking.guest?.requests || 'None'}`);
        }
        function deleteConfirmedBooking(index) { if (!confirm('Are you sure you want to delete this booking?')) return; const confirmed = loadConfirmedBookings(); confirmed.splice(index, 1); saveConfirmedBookings(confirmed); refreshDashboard(); }
        function updateStats() {
            const pending = loadPendingBookings(); const confirmed = loadConfirmedBookings(); const today = new Date().toISOString().split('T')[0];
            document.getElementById('pendingCount').textContent = pending.length;
            const todayCheckins = confirmed.filter(b => b.checkin === today).length; document.getElementById('todayCheckins').textContent = todayCheckins;
            let todayRevenue = 0; confirmed.forEach(booking => { if (booking.checkin === today) { todayRevenue += extractPrice(booking.total); } }); document.getElementById('todayRevenue').textContent = '₱' + todayRevenue.toLocaleString();
            const totalRooms = 50; const occupiedRooms = confirmed.length; const occupancyRate = Math.round((occupiedRooms / totalRooms) * 100); document.getElementById('occupancyRate').textContent = occupancyRate + '%';
            const now = new Date(); document.getElementById('currentDate').textContent = 'Today: ' + now.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
        function updateChart() {
            const confirmed = loadConfirmedBookings(); const data = []; const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; const today = new Date();
            for (let i = 6; i >= 0; i--) { const date = new Date(today); date.setDate(date.getDate() - i); const dateStr = date.toISOString().split('T')[0]; const activeBookings = confirmed.filter(b => { return b.checkin <= dateStr && b.checkout >= dateStr; }).length; const occupancy = Math.min(Math.round((activeBookings / 50) * 100), 100); data.push(occupancy); }
            drawChart(data, days);
        }
        function drawChart(data = [0,0,0,0,0,0,0], days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) {
            const svg = document.getElementById('occupancyChart'); const width = svg.clientWidth; const height = svg.clientHeight; const padding = 40; const chartWidth = width - padding * 2; const chartHeight = height - padding * 2; svg.innerHTML = ''; svg.innerHTML += `<line x1="${padding}" y1="${height - padding}" x2="${width - padding}" y2="${height - padding}" stroke="#e0e0e0" stroke-width="1"/>`;
            const points = data.map((value,i)=>{ const x = padding + (chartWidth / (data.length - 1)) * i; const y = height - padding - (value / 100) * chartHeight; return { x, y, value }; }); let pathData = `M ${points[0].x} ${points[0].y}`; for (let i = 1; i < points.length; i++) { pathData += ` L ${points[i].x} ${points[i].y}`; } svg.innerHTML += `<path d="${pathData}" stroke="#3498db" stroke-width="2" fill="none"/>`; points.forEach((point,i)=>{ svg.innerHTML += `<circle cx="${point.x}" cy="${point.y}" r="4" fill="#3498db"/>`; svg.innerHTML += `<text x="${point.x}" y="${height - 10}" text-anchor="middle" font-size="11" fill="#7f8c8d">${days[i]}</text>`; }); for (let i = 0; i <= 100; i += 20) { const y = height - padding - (i / 100) * chartHeight; svg.innerHTML += `<text x="10" y="${y + 4}" font-size="11" fill="#7f8c8d">${i}</text>`; }
        }
        function refreshDashboard() { displayPendingRequests(); displayConfirmedBookings(); updateStats(); updateChart(); }
        function checkForNewBookings() {
            const allBookings = JSON.parse(localStorage.getItem('hotelBookings') || '[]'); const pending = loadPendingBookings();
            allBookings.forEach(booking => { const exists = pending.find(p => p.checkin === booking.checkin && p.checkout === booking.checkout && p.guest?.email === booking.guest?.email ); if (!exists) { booking.status = 'pending'; pending.push(booking); } }); savePendingBookings(pending); localStorage.setItem('hotelBookings', JSON.stringify([])); refreshDashboard();
        }
        function initDashboard() { initStorage(); checkForNewBookings(); refreshDashboard(); setInterval(checkForNewBookings, 3000); setInterval(refreshDashboard, 5000); window.addEventListener('resize', updateChart); }
        document.querySelectorAll('.nav-item').forEach(item => { item.addEventListener('click', function() { document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active')); this.classList.add('active'); }); });
        initDashboard();
    </script>
</body>
</html>

