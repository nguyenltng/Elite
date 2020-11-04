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
            body {
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
    <body >
    @include('header')
    @section('title','Post')
    <h1>Post</h1>
    @if(!is_null(session()->get('roles')))
        @if(in_array('admin', session()->get('roles')))
            <button><a href="{{ route('view.createPost') }}">New Post</a></button>
        @endif
    @endif
    <table style="margin-left: 100px; margin-right: 100px; padding: 30px;  ">
        <tr>
            <th></th>
            <th></th>
        </tr>
        @for($item = 0; $item < sizeof($data); $item++)
            <tr style="margin-top:100px">
                <th></th>
                <th><img src="{{ (new \App\Http\Controllers\ImageController())->loadImage($data[$item]->id)}}"  height="200" width="250"></th>
                <th>
                    <p style="font-size: 20px">{{$data[$item]->title}}</p>
                    <p>{{$data[$item]->description}}<a href="{{$data[$item]->link}}" target="_blank">Click here</a></p>
                </th>
                <th>
                    @if(!is_null(session()->get('roles')))
                        @if(in_array('admin', session()->get('roles')))
                        <a href="{{route('view.editPost',['id'=>$data[$item]->id])}}"><button>Edit</button></a>
                        <a href="{{route('deletePost',['id'=>$data[$item]->id])}}"><button>Delete</button></a>
                        @endif
                    @endif
                </th>
            </tr>
        @endfor
    </table>
    <div>
        {{ $data->links() }}
    </div>
    </body>
</html>
