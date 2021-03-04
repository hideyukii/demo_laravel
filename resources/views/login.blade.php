@extends("layouts.no-header")
@section("title", "Login")
@section("content")
    <h1>Login</h1>
    <form action="/auth/login" method="post">
        {{csrf_field()}}
        <label>
            <input type="email" name="email" value="">
            Email
        </label>
        <label>
            <input type="password" name="password">
            Password
        </label>
        <button type="submit">Submit</button>
    </form>
@endsection
