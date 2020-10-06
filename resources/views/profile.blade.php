<!-- app/views/login.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Look at me Login</title>
</head>
    <body>
    {{ print $message ?? '' }}

    {{ Form::open(array('url' => 'logout')) }}

        <p>{{ Form::submit('Logout!') }}</p>
    {{ Form::close() }}
    </body>
</html>
