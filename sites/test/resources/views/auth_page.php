<!DOCTYPE html>
<html>
<head>
    <title>Авторизация</title>
    <link type="text/css" rel="stylesheet" href="/resources/css/style.css" />
</head>
<body>
    <h1>Авторизация</h1>
    <div>{{  message }}</div>
    <form class="form" action="/login/" method="POST">
        <div>
            <label for="user">Логин </label>
            <input required class="input" type="text" name="user" id="user">
        </div>
        <div>
            <label for="password">Пароль</label>
            <input required class="input" type="password" name="password" id="password">
        </div>
        <button class="btn">Ок</button>
    </form>
</body>
</html>