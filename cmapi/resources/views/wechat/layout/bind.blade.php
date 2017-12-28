
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no" />
    <title>blog1</title>
    <link rel="stylesheet" href="{{ URL::asset('/blog/static/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/blog/static/share/css/share.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/blog/css/simplify.min.css')}}">
    <link rel="stylesheet" href="//at.alicdn.com/t/font_470811_x0xuuy2egnzh0k9.css">
</head>

<body class="overflow-hidden light-background">
<div class="wrapper no-navigation preload">


    @yield("contents")

</div>
<!-- /wrapper -->

</body>

</html>