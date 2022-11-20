<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品頁面</title>
</head>

<body>
    <a href="{{ route('order') }}">購物車</a>
    <p>搜尋您需要的商品</p>
    <form action="{{ route('search') }}" method="get">
        {{ csrf_field() }}
        <input type="text" name="commodityName">
        <input type="submit" name="submit" value="查詢">
    </form>
    @if (!empty($errorMessage))
        <p>{{ $errorMessage }}</p>
    @endif
    <hr>
    <!-- <button type="button" name="inDescendingOrder">以價格高到低排序</button> -->
    <!-- <form action="{{ route('addOrder') }}" method="post">
        {{ csrf_field() }}
        <input type="button" name="inDescendingOrder" value="由價格高至低排序" />
        <input type="buutton" name="inAscendingOrder"  value="由價格低至高排序" />
        <input type="submit" name="submit" value="加入購物車">
    </form> -->
    <a href="{{ route('commodity', ['inDescendingOrder' => 1]) }}">以價格高到低排序</a>
    <a href="{{ route('commodity', ['inAscendingOrder' => 1]) }}">由價格低至高排序</a>

    @if (!empty($allCommodity))
        <div>
            @foreach ($allCommodity as $item)
                <p>
                    商品名稱：{{ $item->c_name }}，價格：{{ $item->c_price }}
                    <form action="{{ route('addOrder') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="CommodityId" value="{{ $item->c_id }}" />
                        <input type="submit" name="submit" value="加入購物車">
                    </form>
                </p>
            @endforeach
        </div>
        <div>
            {{$allCommodity->links()}}
        </div>
    @endif
</body>

</html>