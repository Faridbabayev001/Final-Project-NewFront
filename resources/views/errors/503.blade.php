<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

        {{-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> --}}
        <link rel="stylesheet" href="{{url('/css/style.css')}}" media="screen" title="no title">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                color: black;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Bu səhifə tapılmadı &#9785</div>
                <h3><a href="{{url('/')}}">Ana Səhifə</a></h3>
            </div>
        </div>
    </body>
</html>
