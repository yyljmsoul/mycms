<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章预览</title>
</head>
<body>

<div class="layuimini-container">
    <h1 style="text-align: center">{{$data->title}}</h1>
    <div class="site-text">
        {!! $data->content !!}
    </div>
</div>
</body>
</html>
