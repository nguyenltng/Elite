<!-- app/views/register.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
    <body>
    <div style="text-align: center">
    <h2>Register</h2>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
    <form action={{route('register')}} method="post">
        <input type="hidden" name="_token" value="{{csrf_token()}}"> <br>
        <div >
            <input type="text" name="email" placeholder="Email"><br> <br>
            <input type="text" name="name" placeholder="UserName "><br> <br>
            <input type="password" name="password" placeholder="Password"><br> <br>
            <input type="password" name="passwordConfirm" placeholder="Password Confirm">
        </div>

        <br><button>Register</button><br>
        <br><a href="{{route('viewLogin') }}">Login</a>
    </form>
    </div>
    </body>
</html>
