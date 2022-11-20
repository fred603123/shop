<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
</head>
<body>
     <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        <input type="text" name="userAccount" placeholder="您的帳號">
        <br>
        <input type="password" name="userPassword" placeholder="您的密碼">
        <input type="submit" name="submit" value="登入">
    </form>
    @if (!empty($errorMessage))
        <p>{{ $errorMessage }}</p>
    @endif
</body>
</html>