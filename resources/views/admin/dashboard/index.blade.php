@extends('admin.layout')
 
@section('title', 'Dashboard')
 
@section('content')
 
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
 
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
/* ── Tokens (mirrors app design system) ─────────────────── */
:root {
  --bg:        #0A0A0F;
  --surface:   #12111C;
  --card:      #1A1826;
  --border:    #2A2640;
  --violet:    #7C6FFF;
  --violet-l:  #C4B9FF;
  --text-1:    #F0EDFF;
  --text-2:    #8E8BA8;
  --text-3:    #5A576E;
  --success:   #3DDC84;
  --warn:      #F5A623;
  --danger:    #FF5C72;
  --blue:      #4D9FFF;
  --radius-lg: 20px;
  --radius-md: 12px;
}
 
/* ── Shell ──────────────────────────────────────────────── */
.db {
  background: var(--bg);
  min-height: 100vh;
  padding: 32px;
  font-family: 'Inter', system-ui, sans-serif;
  color: var(--text-1);
}
 
/* Dot grid */
.db::before {
  content: '';
  position: fixed;
  inset: 0;
  background-image: radial-gradient(circle, #2A2640 1px, transparent 1px);
  background-size: 28px 28px;
  opacity: 0.35;
  pointer-events: none;
  z-index: 0;
}
 
.db > * { position: relative; z-index: 1; }
.db-inner { max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }
 
/* ── Welcome bar ────────────────────────────────────────── */
.welcome-bar {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 22px 28px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  overflow: hidden;
}
.welcome-bar::after {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--violet), transparent);
  opacity: 0.6;
}
.welcome-text h2 {
  font-size: 18px;
  font-weight: 700;
  letter-spacing: -0.3px;
  color: var(--text-1);
}
.welcome-text p {
  font-size: 13px;
  color: var(--text-2);
  margin-top: 3px;
}
.badge-live {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 12px;
  font-weight: 600;
  color: var(--success);
  background: rgba(61,220,132,0.1);
  border: 1px solid rgba(61,220,132,0.22);
  padding: 6px 14px;
  border-radius: 99px;
  letter-spacing: 0.3px;
}
.live-dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: var(--success);
  box-shadow: 0 0 8px var(--success);
  animation: pulse 2s ease-in-out infinite;
}
@keyframes pulse {
  0%, 100% { opacity: 1; box-shadow: 0 0 6px var(--success); }
  50% { opacity: 0.6; box-shadow: 0 0 14px var(--success); }
}
 
/* ── Stat grid ──────────────────────────────────────────── */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
}
.stat-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 22px 22px 20px;
  position: relative;
  overflow: hidden;
  transition: border-color 0.2s, transform 0.2s;
}
.stat-card:hover {
  transform: translateY(-3px);
  border-color: var(--violet);
}
 
/* Glowing left accent bar */
.stat-card::before {
  content: '';
  position: absolute;
  top: 20%; left: 0;
  width: 3px; height: 60%;
  border-radius: 0 3px 3px 0;
}
.stat-card.c-blue::before   { background: var(--blue);    box-shadow: 0 0 12px var(--blue); }
.stat-card.c-green::before  { background: var(--success); box-shadow: 0 0 12px var(--success); }
.stat-card.c-violet::before { background: var(--violet);  box-shadow: 0 0 12px var(--violet); }
.stat-card.c-warn::before   { background: var(--warn);    box-shadow: 0 0 12px var(--warn); }
 
/* Ambient blob behind number */
.stat-card::after {
  content: '';
  position: absolute;
  bottom: -20px; right: -20px;
  width: 80px; height: 80px;
  border-radius: 50%;
  opacity: 0.07;
}
.stat-card.c-blue::after   { background: var(--blue); }
.stat-card.c-green::after  { background: var(--success); }
.stat-card.c-violet::after { background: var(--violet); }
.stat-card.c-warn::after   { background: var(--warn); }
 
.stat-icon {
  width: 36px; height: 36px;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 14px;
  font-size: 15px;
}
.c-blue   .stat-icon { background: rgba(77,159,255,0.12);  color: var(--blue); }
.c-green  .stat-icon { background: rgba(61,220,132,0.12);  color: var(--success); }
.c-violet .stat-icon { background: rgba(124,111,255,0.12); color: var(--violet-l); }
.c-warn   .stat-icon { background: rgba(245,166,35,0.12);  color: var(--warn); }
 
.stat-label {
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.7px;
  color: var(--text-2);
  margin-bottom: 6px;
}
.stat-val {
  font-size: 34px;
  font-weight: 800;
  letter-spacing: -1px;
  font-variant-numeric: tabular-nums;
  color: var(--text-1);
  line-height: 1;
}
.c-blue   .stat-val { color: var(--blue); }
.c-green  .stat-val { color: var(--success); }
.c-violet .stat-val { color: var(--violet-l); }
.c-warn   .stat-val { color: var(--warn); }
 
.stat-sub {
  font-size: 12px;
  color: var(--text-3);
  margin-top: 8px;
}
 
/* ── Chart row ──────────────────────────────────────────── */
.chart-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.bottom-row {
  display: grid;
  grid-template-columns: 2fr 3fr;
  gap: 16px;
}
 
/* ── Chart card ─────────────────────────────────────────── */
.chart-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 24px;
  transition: border-color 0.2s;
}
.chart-card:hover { border-color: var(--border); }
 
.card-hd {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 16px;
  border-bottom: 1px solid var(--border);
}
.card-hd-left {
  display: flex;
  align-items: center;
  gap: 10px;
}
.card-hd-icon {
  width: 32px; height: 32px;
  border-radius: 9px;
  background: rgba(124,111,255,0.1);
  color: var(--violet-l);
  display: flex; align-items: center; justify-content: center;
  font-size: 13px;
}
.card-hd h3 {
  font-size: 14px;
  font-weight: 600;
  color: var(--text-1);
  letter-spacing: -0.2px;
}
.period {
  font-size: 11px;
  color: var(--text-2);
  background: rgba(255,255,255,0.05);
  border: 1px solid var(--border);
  padding: 4px 10px;
  border-radius: 99px;
  letter-spacing: 0.2px;
}
.chart-wrap { height: 220px; }
 
/* ── Status legend ──────────────────────────────────────── */
.legend-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 16px;
}
.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: var(--text-2);
  background: rgba(255,255,255,0.03);
  border: 1px solid var(--border);
  padding: 3px 9px;
  border-radius: 99px;
}
.legend-sq {
  width: 8px; height: 8px;
  border-radius: 2px;
  flex-shrink: 0;
}
 
/* ── Table ──────────────────────────────────────────────── */
.orders-table {
  width: 100%;
  border-collapse: collapse;
}
.orders-table th {
  text-align: left;
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.7px;
  color: var(--text-3);
  padding-bottom: 12px;
}
.orders-table td {
  font-size: 13px;
  color: var(--text-2);
  padding: 11px 0;
  border-bottom: 1px solid rgba(42,38,64,0.6);
}
.orders-table tbody tr:last-child td { border-bottom: none; }
.orders-table tbody tr:hover td { background: rgba(255,255,255,0.02); }
.orders-table td:first-child { color: var(--violet-l); font-weight: 600; font-size: 12px; }
 
.user-cell {
  display: flex;
  align-items: center;
  gap: 9px;
}
.uavatar {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--violet), var(--violet-l));
  display: flex; align-items: center; justify-content: center;
  font-size: 10px;
  font-weight: 700;
  color: #fff;
  flex-shrink: 0;
}
 
/* ── Status badges ──────────────────────────────────────── */
.status {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 3px 10px;
  border-radius: 99px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0.2px;
}
.status::before {
  content: '';
  width: 5px; height: 5px;
  border-radius: 50%;
}
.s-pending    { background: rgba(245,166,35,0.12);  color: var(--warn);    border: 1px solid rgba(245,166,35,0.25); }
.s-pending::before { background: var(--warn); }
.s-processing { background: rgba(77,159,255,0.12);  color: var(--blue);    border: 1px solid rgba(77,159,255,0.25); }
.s-processing::before { background: var(--blue); }
.s-shipped    { background: rgba(124,111,255,0.12); color: var(--violet-l);border: 1px solid rgba(124,111,255,0.25); }
.s-shipped::before { background: var(--violet-l); }
.s-delivered  { background: rgba(61,220,132,0.12);  color: var(--success); border: 1px solid rgba(61,220,132,0.25); }
.s-delivered::before { background: var(--success); }
.s-cancelled  { background: rgba(255,92,114,0.12);  color: var(--danger);  border: 1px solid rgba(255,92,114,0.25); }
.s-cancelled::before { background: var(--danger); }
 
/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 1000px) {
  .stat-grid   { grid-template-columns: repeat(2, 1fr); }
  .chart-row   { grid-template-columns: 1fr; }
  .bottom-row  { grid-template-columns: 1fr; }
}
@media (max-width: 560px) {
  .stat-grid { grid-template-columns: 1fr; }
  .db { padding: 20px 16px; }
}
@media (prefers-reduced-motion: reduce) {
  .live-dot { animation: none; }
}
</style>
 
<div class="db">
<div class="db-inner">
 
  {{-- Welcome --}}
  <div class="welcome-bar">
    <div class="welcome-text">
      <h2>Good morning, Admin 👋</h2>
      <p>Here's what's happening across your store today.</p>
    </div>
    <span class="badge-live"><span class="live-dot"></span>Live data</span>
  </div>
 
  {{-- Stat cards --}}
  <div class="stat-grid">
    <div class="stat-card c-blue">
      <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
      <div class="stat-label">Products</div>
      <div class="stat-val">{{ $stats['totalProducts'] ?? 0 }}</div>
      <div class="stat-sub">In your catalog</div>
    </div>
    <div class="stat-card c-green">
      <div class="stat-icon"><i class="fa-solid fa-cart-shopping"></i></div>
      <div class="stat-label">Total orders</div>
      <div class="stat-val">{{ $stats['totalOrders'] ?? 0 }}</div>
      <div class="stat-sub">All time</div>
    </div>
    <div class="stat-card c-violet">
      <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
      <div class="stat-label">Users</div>
      <div class="stat-val">{{ $stats['totalUsers'] ?? 0 }}</div>
      <div class="stat-sub">Registered accounts</div>
    </div>
    <div class="stat-card c-warn">
      <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
      <div class="stat-label">Pending</div>
      <div class="stat-val">{{ $stats['pendingOrders'] ?? 0 }}</div>
      <div class="stat-sub">Needs attention</div>
    </div>
  </div>
 
  {{-- Line + Bar charts --}}
  <div class="chart-row">
    <div class="chart-card">
      <div class="card-hd">
        <div class="card-hd-left">
          <div class="card-hd-icon"><i class="fa-solid fa-chart-line"></i></div>
          <h3>Orders</h3>
        </div>
        <span class="period">Last 7 days</span>
      </div>
      <div class="chart-wrap">
        <canvas id="ordersChart" role="img" aria-label="Orders over last 7 days"></canvas>
      </div>
    </div>
 
    <div class="chart-card">
      <div class="card-hd">
        <div class="card-hd-left">
          <div class="card-hd-icon"><i class="fa-solid fa-chart-bar"></i></div>
          <h3>Revenue</h3>
        </div>
        <span class="period">Last 7 days</span>
      </div>
      <div class="chart-wrap">
        <canvas id="revenueChart" role="img" aria-label="Revenue over last 7 days"></canvas>
      </div>
    </div>
  </div>
 
  {{-- Donut + Recent orders --}}
  <div class="bottom-row">
    <div class="chart-card">
      <div class="card-hd">
        <div class="card-hd-left">
          <div class="card-hd-icon"><i class="fa-solid fa-chart-pie"></i></div>
          <h3>Order status</h3>
        </div>
      </div>
 
      @php
        $legendColors = [
          'pending'    => 'rgba(245,166,35,0.85)',
          'processing' => 'rgba(77,159,255,0.85)',
          'shipped'    => 'rgba(124,111,255,0.85)',
          'delivered'  => 'rgba(61,220,132,0.85)',
          'cancelled'  => 'rgba(255,92,114,0.85)',
        ];
      @endphp
      <div class="legend-row">
        @foreach($statusData ?? [] as $status => $count)
          <span class="legend-item">
            <span class="legend-sq" style="background:{{ $legendColors[$status] ?? '#8E8BA8' }}"></span>
            {{ ucfirst($status) }} &nbsp;<strong style="color:var(--text-1)">{{ $count }}</strong>
          </span>
        @endforeach
      </div>
 
      <div style="position:relative;height:200px;">
        <canvas id="statusChart" role="img" aria-label="Order status distribution"></canvas>
      </div>
    </div>
 
    <div class="chart-card">
      <div class="card-hd">
        <div class="card-hd-left">
          <div class="card-hd-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
          <h3>Recent orders</h3>
        </div>
      </div>
 
      <table class="orders-table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentOrders ?? [] as $order)
          <tr>
            <td>#{{ $order->id }}</td>
            <td>
              <div class="user-cell">
                <div class="uavatar">{{ strtoupper(substr($order->user->name ?? 'NA', 0, 2)) }}</div>
                {{ $order->user->name ?? 'N/A' }}
              </div>
            </td>
            <td style="color:var(--text-1);font-weight:600">${{ number_format($order->total, 2) }}</td>
            <td><span class="status s-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
 
</div>
</div>
 
<script>
(function() {
  const gridColor = 'rgba(42,38,64,0.8)';
  const tickColor = '#5A576E';
  const tip = {
    backgroundColor: '#1A1826',
    titleColor: '#8E8BA8',
    bodyColor: '#F0EDFF',
    padding: 12,
    displayColors: false,
    cornerRadius: 8,
    borderColor: '#2A2640',
    borderWidth: 1
  };
  const scaleBase = {
    grid:   { color: gridColor },
    ticks:  { color: tickColor, font: { size: 11, family: 'Inter' } },
    border: { display: false }
  };
 
  // Orders — line chart with violet
  new Chart(document.getElementById('ordersChart'), {
    type: 'line',
    data: {
      labels: @json($chartLabels ?? []),
      datasets: [{
        label: 'Orders',
        data: @json($chartData ?? []),
        borderColor: '#7C6FFF',
        backgroundColor: (ctx) => {
          const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
          g.addColorStop(0, 'rgba(124,111,255,0.22)');
          g.addColorStop(1, 'rgba(124,111,255,0)');
          return g;
        },
        fill: true,
        tension: 0.4,
        pointBackgroundColor: '#7C6FFF',
        pointBorderColor: '#1A1826',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false }, tooltip: tip },
      scales: {
        y: { ...scaleBase, beginAtZero: true },
        x: { ...scaleBase, grid: { display: false } }
      }
    }
  });
 
  // Revenue — bar chart with blue
  new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
      labels: @json($revenueLabels ?? []),
      datasets: [{
        label: 'Revenue ($)',
        data: @json($revenueData ?? []),
        backgroundColor: (ctx) => {
          const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
          g.addColorStop(0, 'rgba(77,159,255,0.7)');
          g.addColorStop(1, 'rgba(77,159,255,0.2)');
          return g;
        },
        borderColor: 'rgba(77,159,255,0.8)',
        borderWidth: 1,
        borderRadius: 6,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          ...tip,
          callbacks: { label: ctx => '$' + ctx.parsed.y.toLocaleString() }
        }
      },
      scales: {
        y: {
          ...scaleBase,
          beginAtZero: true,
          ticks: { ...scaleBase.ticks, callback: v => '$' + v.toLocaleString() }
        },
        x: { ...scaleBase, grid: { display: false } }
      }
    }
  });
 
  // Status — doughnut
  const statusData   = @json($statusData ?? []);
  const statusLabels = Object.keys(statusData);
  const statusValues = Object.values(statusData);
  const statusColors = {
    pending:    'rgba(245,166,35,0.85)',
    processing: 'rgba(77,159,255,0.85)',
    shipped:    'rgba(124,111,255,0.85)',
    delivered:  'rgba(61,220,132,0.85)',
    cancelled:  'rgba(255,92,114,0.85)',
  };
  const statusBorder = {
    pending:    '#F5A623',
    processing: '#4D9FFF',
    shipped:    '#7C6FFF',
    delivered:  '#3DDC84',
    cancelled:  '#FF5C72',
  };
 
  new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
      labels: statusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
      datasets: [{
        data: statusValues,
        backgroundColor: statusLabels.map(l => statusColors[l] ?? '#5A576E'),
        borderColor:     statusLabels.map(l => statusBorder[l] ?? '#2A2640'),
        borderWidth: 2,
        hoverOffset: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false }, tooltip: tip },
      cutout: '72%'
    }
  });
})();
</script>
 
@endsection