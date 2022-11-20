<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車</title>
</head>
<body>
    <div>
        <h1>您的購物車內容如下：</h1>
        <button type="button" style="margin-top: 10px;">
            <a href="{{ route('commodity') }}" style="text-decoration:none;">回到所有商品頁面</a>
        </button>
        @foreach ($order as $item)
            <hr>
            <p>編號：{{ $item->id }} 商品名稱：{{ $item->commodityName }} 價格：{{ $item->commodityPrice }}</p>
            <hr>
        @endforeach
    </div>
    <button type="button" style="margin-top: 10px;">
        <a href="{{ route('commodity') }}" style="text-decoration:none;">回到所有商品頁面</a>
    </button>
</body>
</html>