<!-- app/views/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
    <body>

    <div style="text-align: center;">
        <h2>Login</h2>
        <form action={{route('login')}} method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}"> <br>
            <div >
                <input type="text" name="email" placeholder="Email " required><br> <br>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button>Login</button>
        </form>
        <p>Or no account</p>
        <a href="{{route('viewRegister')}}" >Register</a>
    </div>
    </body>
</html>
