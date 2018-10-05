## Регистрация

Для того, чтобы зарегистрировать нового пользователя, 
необходимо отправить **`POST`** запрос на **`/v1/registration`**

Параметры:<br>
**email*** - Email который пользователь указал при регистрации.<br>
**password*** - пароль пользователя.<br>
**password_confirmation*** - подтверждение пароля пользователя.<br>
**username** - имя, которое будет отображаться на сайте.

Ответы сервера:<br>
**status 201** - пользователь добавлен.<br>
**status 500** - ошибка добавления пользователя.