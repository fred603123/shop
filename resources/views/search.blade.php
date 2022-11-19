<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>搜尋商品頁面</title>
</head>

<body>
    <a href="">購物車</a>
    <p>搜尋您需要的商品</p>
    <form action="{{ route('search') }}" method="get">
        @csrf
        <input type="text" name="commodityName">
        <input type="submit" name="submit" value="查詢">
    </form>
    @if (!empty($errorMessage))
        <p>{{ $errorMessage }}</p>
    @endif
<hr>
    @if (!empty($searchCommodity))
        <div>
            @foreach ($searchCommodity as $item)
                <p> 商品名稱：{{ $item->c_name }}，價格：{{ $item->c_price }}</p>
            @endforeach
        </div>
        <div>
            {{$searchCommodity->links()}}
        </div>
        <button type="button" style="margin-top: 10px;">
            <a href="{{ route('commodity') }}" style="text-decoration:none;">回到所有商品頁面</a>
        </button>
    @endif
</body>

</html>