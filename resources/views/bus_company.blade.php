<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Company Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <!-- Success message if any -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-center mb-4">Bus Company Details</h2>

    <!-- Form to add a new bus company -->
    <form action="{{ route('buscompany.save') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="text" name="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="bc_name" class="form-label">Bus Company Name</label>
            <input type="text" name="bc_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="no_of_bus" class="form-label">No. of Buses</label>
            <input type="number" name="no_of_bus" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <hr>

    <!-- Display all bus companies -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Bus Company Name</th>
                    <th>Owner Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>No. of Buses</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                <tr>
                    <td>{{ $bus->id }}</td>
                    <td>{{ $bus->bc_name }}</td>
                    <td>{{ $bus->user->name ?? 'N/A' }}</td>
                    <td>{{ $bus->user->email ?? 'N/A' }}</td>
                    <td>{{ $bus->user->phone ?? 'N/A' }}</td>
                    <td>{{ $bus->user->address ?? 'N/A' }}</td>
                    <td>{{ $bus->no_of_bus }}</td>
                    <td>
                        <span class="badge bg-{{ $bus->status == 'Active' ? 'success' : 'danger' }}">
                            {{ $bus->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
