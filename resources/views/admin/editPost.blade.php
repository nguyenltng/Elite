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
            .post input, textarea{
                display: flex;
                width: 60%;
                margin-left: 50px;
                height: 45px;
                margin-bottom: 20px;
                border: 1px solid gray;
                border-radius: 5px;
                padding-left: 25px;
            }
            #img{
                margin-left: 50px;
                padding-left: 25px;
            }
        </style>
        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image-view').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image").change(function(){
                readURL(this);
            });
        </script>
    </head>
    <body>
    @include('header')
    @section('title','Post')
    <h1>Edit Post</h1>
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
        <div class="post">
            <form action="{{route('editPost',$data->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                Title <input type="text" name="title" placeholder="Title" value="{{$data->title}}" >
                Description <textarea style="height: 100px; font-family: 'Nunito', sans-serif;" rows = "5" cols = "60" name = "description" placeholder="Description">{{$data->description}}</textarea>
                Tag <input type="text" name="tag" placeholder="Tag" value="{{$data['tag']}}" >
                Link <input type="text" name="link" placeholder="Link" value="{{$data->link}}" >
                Image <input id="image" type="file" name="image">
                <img src="{{(new \App\Http\Controllers\ImageController())->loadImage($data->id)}}" id="image-view" width="200px" height="200px" />
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                @endif
                <button style="margin: 20px 500px 200px  ; width: 100px; height: 40px; ">Update</button>
            </form>
        </div>
    </body>
</html>
