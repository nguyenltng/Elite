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
                background-color: #ffffff;
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
            .post input,textarea,select {
                display: flex;
                width: 60%;
                margin-left: 50px;
                height: 45px;
                margin-bottom: 20px;
                border: 1px solid gray;
                border-radius: 5px;
                padding-left: 25px;
            }
        </style>
    </head>
    <body>
    @include('header')
    @section('title','Post')
    <h1>New Post</h1>
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
        <div class="post">
            <form action="{{route('createPost')}}" method="post" enctype="multipart/form-data">
                @csrf
                <select name="categories" id="categories">
                    @foreach($data as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <input id="image" type="file" name="image">
                <input type="text" name="title" placeholder="Title" >
                <textarea style="height: 100px; font-family: 'Nunito', sans-serif;" rows = "5" cols = "60" name = "description" placeholder="Description"></textarea>
                <input type="text" name="link" placeholder="Link" >
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
                <button style="margin: 20px 500px 200px  ; width: 100px; height: 40px; ">Add</button>
            </form>
        </div>
    </body>
</html>
