<!-- app/views/login.blade.php -->
<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="image/favicon.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,200,300,400,500,600,700,800,900&display=swap&subset=vietnamese"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet" />
    <script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/isotope.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/imagesloaded.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/1.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/angular-material.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/animate.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/hover.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/1.css')}}" />
</head>

<body>
@include('header')
    <div class="login-food">
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="login text-xs-center">
                        <h3>Login</h3>
                        @if(Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                        @endif
                        <form action="{{route('login')}}" method="post">
                            @csrf
                            <input type="text" name="email" placeholder="Email">
                            <input type="password" name="password" placeholder="Password">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endif
                            <button class="btn btn-warning btn-login">login</button>
                        </form>
                        <p>Don't have account</p>
                        <a href="{{route('viewRegister')}}" class="btn btn-danger btn-register">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

