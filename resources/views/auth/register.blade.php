<form action="{{ route('register') }}" method="POST">
    @csrf

    <h2>Register</h2>

    <label for="name">Name:</label>
    <input type="text" name="name" required
           value="{{old('name')}}">

    <label for="email">Email:</label>
    <input type="email" name="email" required
           value="{{old('email')}}">

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" required>

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
