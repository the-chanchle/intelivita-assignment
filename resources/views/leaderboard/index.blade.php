<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-4">🏆 Leaderboard</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filters -->
        <div class="mb-3 d-flex gap-2">
            <form method="GET" action="{{ route('leaderboard.index') }}" class="d-flex gap-2">
                <input type="hidden" name="filter" value="day">
                <button class="btn btn-primary">Today</button>
            </form>
            <form method="GET" action="{{ route('leaderboard.index') }}" class="d-flex gap-2">
                <input type="hidden" name="filter" value="month">
                <button class="btn btn-primary">This Month</button>
            </form>
            <form method="GET" action="{{ route('leaderboard.index') }}" class="d-flex gap-2">
                <input type="hidden" name="filter" value="year">
                <button class="btn btn-primary">This Year</button>
            </form>
            <a href="{{ route('leaderboard.index') }}" class="btn btn-secondary">Reset</a>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('leaderboard.index') }}" class="mb-3 d-flex gap-2">
            <input type="text" name="search_id" class="form-control" placeholder="Search by User ID">
            <button class="btn btn-info">Search</button>
        </form>

        <!-- Recalculate -->
        <form method="POST" action="{{ route('leaderboard.recalculate') }}">
            @csrf
            <button class="btn btn-danger mb-3">Recalculate Leaderboard</button>
        </form>

        <!-- Leaderboard Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Total Points</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leaderboardData as $entry)
                    <tr>
                        <td>{{ $entry['rank'] }}</td>
                        <td>{{ $entry['user_id'] }}</td>
                        <td>{{ $entry['user_name'] }}</td>
                        <td>{{ $entry['total_points'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
