<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @foreach ($val as $item)
        <div class="row">
            <div class="col-4">
                <p> 商品名稱：{{ $item->c_name }}，價格：{{ $item->c_price }}</p>
            </div>
        </div>
    @endforeach

    <div style="position: fixed">
        {{$val->links()}}
    </div>
</body>

</html>