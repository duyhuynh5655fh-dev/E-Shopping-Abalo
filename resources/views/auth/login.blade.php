<form action="{{ route('login') }}" method="POST">
    @csrf

    <h2>Login</h2>

    <label for="email">Email:</label>
    <input type="email" name="email" required
           value="{{old('email')}}">

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>

    <!-- validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
    {{--<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abalo Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/js/app.js'])
</head>
<body>
<div id="login-app">
    <login-form></login-form>
</div>
</body>
</html>--}}
