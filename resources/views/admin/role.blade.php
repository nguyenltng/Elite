<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Blog</title>

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

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .admin {
            font-size: 50px;
            margin-left: 50px;
        }

        .add-role input, textarea {
            display: flex;
            width: 60%;
            margin-left: 50px;
            height: 45px;
            margin-bottom: 20px;
            border: 1px solid gray;
            border-radius: 5px;
            padding-left: 25px;
        }

        .add-role button {
            display: flex;
            width: 60%;
            margin-left: 50px;
            height: 30px;
            margin-bottom: 20px;
            border: 1px solid gray;
            border-radius: 5px;
            padding-left: 25px;
        }


    </style>
</head>
<body>
@include('header')
<div class="admin">
    Admin - Role
</div>
<div class="add-role">
    <table style="margin-left: 100px; margin-right: 100px; padding: 30px;  ">
        <tr>
            <th></th>
            <th></th>
        </tr>
        @for($item = 0; $item < sizeof($data); $item++)
            <tr style="margin-top:100px">
                <th></th>
                <th><input class="role" type="text" name='name' value="{{$data[$item]->name}}"></input></th>
                <th>
                    <a href="{{route('view.editPost',['id'=>$data[$item]->id])}}">
                        <button>Edit</button>
                    </a>
                    <a href="{{route('main.deleteRole',['id'=>$data[$item]->id])}}">
                        <button>Delete</button>
                    </a>
                </th>
            </tr>
        @endfor
    </table>
</div>


</body>
</html>
