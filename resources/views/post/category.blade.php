<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
    @include('header')
    @section('title','Post')
    <h1></h1>
    <table style="width:100%">
        <tr>
            <th>NUMBER</th>
            <th></th>
        </tr>
        @for($item = 0; $item < sizeof($data); $item++)
            <tr style="margin-top: 100px">
                <th>{{$item+1}}</th>
                <th>
                    <p style="font-size: 20px">{{$data[$item]->title}}</p>
                    <p>{{$data[$item]->description}}<a href="{{$data[$item]->link}}">Click here</a></p>
                </th>
                <th>
                    <a href="{{route('view.editPost',['id'=>$data[$item]->id])}}"><button>Edit</button></a>
                    <a href="{{route('deletePost',['id'=>$data[$item]->id])}}"><button>Delete</button></a>
                </th>
            </tr>
        @endfor
    </table>
    <div>
        {{ $data->links() }}
    @if(Session::has('user'))
            <a href="{{ route('view.createPost') }}">New Post</a>
    @endif
</html>
