<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
</head>
<body>
     <form action="{{ url('login') }}" method="post">
        @csrf
        <input type="text" name="userAccount" value="你的帳號">
        <br>
        <input type="password" name="userPassword" value="你的密碼">
        <input type="submit" name="submit" value="登入">
    </form>
</body>
</html>