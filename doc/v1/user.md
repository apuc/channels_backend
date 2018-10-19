## Пользователи

[Главная](main.md) 

### Добавления пользователя

Для того, чтобы добавить нового пользователя, 
необходимо отправить **`POST`** запрос на **`/v1/user`**

Параметры:<br>
**email*** - Email который пользователь указал при регистрации.<br>
**password*** - пароль пользователя.<br>
**password_confirmation*** - подтверждение пароля пользователя.<br>
**username** - имя, которое будет отображаться на сайте.

Примерный ответ сервера:

```
{
    "data":{
        "user_id": 1,
        "email": "ruben39@example.com",
        "username": "Mrs. Camylle Collier DVM",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b.jpg",
            "average": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_400.jpg",
            "small": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_150.jpg"
        }
    }
}
```

### Редактирование пользователя

Для того, чтобы редактировать пользователя, 
необходимо отправить **`PUT`** запрос на **`/v1/user/{user_id}`**

Параметры:<br>
**email*** - Email который пользователь указал при регистрации.<br>
**password*** - пароль пользователя.<br>
**password_confirmation*** - подтверждение пароля пользователя.<br>
**username** - имя, которое будет отображаться на сайте.

Примерный ответ сервера:

```
{
    "data":{
        "user_id": 1,
        "email": "ruben39@example.com",
        "username": "Mrs. Camylle Collier DVM",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b.jpg",
            "average": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_400.jpg",
            "small": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_150.jpg"
        }
    }
}
```

### Просмотр пользователя

Для того, чтобы просмотреть пользователя, 
необходимо отправить **`GET`** запрос на **`/v1/user/{user_id}`**

Примерный ответ сервера:

```
{
    "data":{
        "user_id": 1,
        "email": "ruben39@example.com",
        "username": "Mrs. Camylle Collier DVM",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b.jpg",
            "average": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_400.jpg",
            "small": "http://files.newchannels.loc/img/channel/0/04/04882234d9761dc7072283ba61e2c29b_150.jpg"
        }
    }
}
```

### Удаление пользователя

Для того, чтобы просмотреть пользователя, 
необходимо отправить **`DELETE`** запрос на **`/v1/user/{user_id}`**
