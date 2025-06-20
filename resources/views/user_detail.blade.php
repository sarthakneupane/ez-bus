<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Details</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-center mb-4">User Details</h2>

    <div class="card shadow p-4">
        <form action="{{route('buscompany.save')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User Name:</label>
                <select name="user_id" class="form-select">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        
            <div class="mb-3">
                <label for="bc_name" class="form-label">Bus Company Name:</label>
                <input type="text" name="bc_name" class="form-control">
            </div>
        
            <div class="mb-3">
                <label for="no_of_bus" class="form-label">No. of Bus:</label>
                <input type="number" name="no_of_bus" class="form-control">
            </div>
        
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
