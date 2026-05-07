<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; display: flex; }
        .sidebar { width: 220px; height: 100vh; background-color: #fff; }
        .sidebar .top { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
        .sidebar a, .sidebar form button { display: block; padding: 10px 20px; text-decoration: none; color: #333; width: 100%; border: none; background: none; text-align: left; cursor: pointer; }
        .sidebar a:hover, .sidebar form button:hover { background-color: #4CAF50; color: white; }
        .main { flex: 1; padding: 20px; }
        .chart-container { width: 600px; margin-bottom: 40px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="top">
        <h2>Emoti App</h2>
    </div>
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <a href="#">Settings ⚙️</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

<div class="main">
    <h1>✅ Admin Dashboard</h1>
    <p>Welcome {{ auth()->user()->name }}</p>

    <div class="chart-container">
        <h3>Users Last 7 Days</h3>
        <canvas id="usersChart"></canvas>
    </div>

    <div class="chart-container">
        <h3>Emotions Distribution</h3>
        <canvas id="emotionsChart"></canvas>
    </div>
</div>

<script>
    // Users chart
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($usersChart['labels']) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($usersChart['data']) !!},
                borderColor: 'green',
                backgroundColor: 'rgba(0,255,0,0.2)',
                fill: true,
            }]
        }
    });

    // Emotions chart
    const emotionsCtx = document.getElementById('emotionsChart').getContext('2d');
    new Chart(emotionsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($emotionsChart['labels']) !!},
            datasets: [{
                label: 'Emotions',
                data: {!! json_encode($emotionsChart['data']) !!},
backgroundColor: ['#4CAF50','#FFC107','#F44336']
            }]
        }
    });
</script>

</body>
</html>