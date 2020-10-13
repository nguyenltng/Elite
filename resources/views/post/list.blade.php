<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    @include('welcome')
    @section('title','Post')
    <h1>Post</h1>
    <table style="width:90%">
        <tr>
            <th>NUMBER</th>
            <th>TITLE</th>
            <th>DESCRIPTION</th>
            <th>LINK</th>
        </tr>
        @for($item = 0; $item < sizeof($data); $item++)
            <tr>
                <th>{{$item+1}}</th>
                <th>{{$data[$item]->title}}</th>
                <th>{{$data[$item]->description}}</th>
                <th><a href="{{$data[$item]->link}}">Click here</a></th>
            </tr>
        @endfor
    </table>
        <a href="{{ route('view.createPost') }}">New Post</a>
    </body>
</html>
