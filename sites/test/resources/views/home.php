<!DOCTYPE html>
<html>

<head>
    <title>My Webpage</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    <link type="text/css" rel="stylesheet" href="/resources/css/style.css" />
</head>
<body>
    <header auth="{{auth}}" class='header'>
        <h1>Задачи</h1>
        {%  if(auth) %}
            <a class="btn" href="/logout/">Выход</a>
        {% else %}
            <a class="btn" href="/auth/">Авторизация</a>
        {% endif %}
    </header>
    <div id="jsGrid"></div>
    {% if(message) %}
        <div>{{ message }}</div>
    {% endif %}
    <div class='pagination'>
        <ul class="ul">
            {% for i in 1..pageCount %}
            {%  if(i == page) %}
            {% set active = ' active' %}
            {% else %}
            {% set active = '' %}
            {% endif %}
            <li class="li">
                <a class="page {{active}}" href="/?page={{ i }}">{{ i }}</a>
            </li>
            {% endfor %}
        </ul>
    </div>
    <hr>
    <h2>Добавить задание</h2>
    <form class="form" action="/insert/" method="POST" >
        <div>
            <label for="user">Имя </label>
            <input required class="input" type="text" name="user" id="user">
        </div>
        <div>
            <label for="email">email</label>
            <input required class="input" type="email" name="email" id="email">
        </div>
        <div>
            <label for="task">task</label>
            <textarea required class="textarea" name="task" id="task" cols="30" rows="10"></textarea>
        </div>
        <button class="btn">Добавить</button>
    </form>
    
    {% for item in messages %}
    <div>{{item}}</div>
    {% endfor %}
    
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
<script type="text/javascript" src="/resources/js/script.js"></script>


</html>