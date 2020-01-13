<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Пример на bootstrap 4: Пользовательская форма и дизайн для простой формы входа.">

    <title>Страница входа</title>

    <!-- Bootstrap core CSS -->
    <link href="/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="/style.css" rel="stylesheet">

</head>

<body class="text-center">
{% if success === null or success === false %}
<form class="form-signin" method="post">
    <label for="inputEmail" class="sr-only">Login</label>
    {{ form.render('login', ['class': 'form-control', 'placeholder': 'Логин', 'required': 'required']) }}
    {% if form.hasMessagesFor('login') %}
        <div>
            {% for message in form.getMessagesFor('login') %}
                <p class="text-danger">{{ message.getMessage() }}</p>
            {% endfor %}
        </div>
    {% endif %}
    <label for="inputPassword" class="sr-only">Password</label>
    {{ form.render('password', ['class': 'form-control', 'placeholder': 'Пароль', 'required': 'required']) }}
    {% if form.hasMessagesFor('password') %}
        <div>
            {% for message in form.getMessagesFor('password') %}
                <p class="text-danger">{{ message.getMessage() }}</p>
            {% endfor %}
        </div>
    {% endif %}
    {{ form.render('csrf') }}
    {% if form.hasMessagesFor('csrf') %}
        <div>
            {% for message in form.getMessagesFor('csrf') %}
                <p class="text-danger">{{ message.getMessage() }}</p>
            {% endfor %}
        </div>
    {% endif %}
    {% if success === false %}
        <div>
            <p class="text-danger">Неверный логин или пароль</p>
        </div>
    {% endif %}
    <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
</form>
{% else %}
    <h3 class="w-100">Успешная авторизация</h3>
{% endif %}
</body>
</html>