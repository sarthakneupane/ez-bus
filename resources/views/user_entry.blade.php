<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-center">HELLO!!</h1>

    <div class="text-center mb-4">
        <a href="{{route('users.list')}}" class="btn btn-primary">Click me to go to user</a>
    </div>

    <div class="card p-4 shadow-lg">
        <form action="/save" method="post">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">User ID:</label>
                <input type="text" name="id" class="form-control">
                @error('id')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">User Name:</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">User Email:</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">User Phone:</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" class="form-select" required>
                    <option value=0>Admin</option>
                    <option value=1>User</option>
                    {{-- <option value=2>Bus Company</option> --}}
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">User Address:</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">User Password:</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
