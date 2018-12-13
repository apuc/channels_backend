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

### Редактирование профиля

Для того, чтобы редактировать пользователя, 
необходимо отправить **`PUT`** запрос на **`/v1/user/profile/{user_id}`**

Параметры:<br>
**username** - имя, которое будет отображаться на сайте.<br>
**avatar_id** - идентификатор аватара.

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

### Поиск пользователей

Для того, чтобы искать пользователей, 
необходимо отправить **`GET`** запрос на **`/v1/user/search_request={request}&page={page}`**.<br>
Поиск происходит по email и username

Параметры:<br>
**search_request** - строка запроса на поиск пользователей.<br>
**page** - идентификатор аватара.

Примерный ответ сервера:

```
{
  "data": [
    {
      "user_id": 6,
      "email": "xharvey@example.org",
      "username": "Josephine Grimes Jr.",
      "avatar": null
    },
    {
      "user_id": 7,
      "email": "iwolff@example.net",
      "username": "Hellen Corwin DDS",
      "avatar": null
    },
    {
      "user_id": 8,
      "email": "rau.brielle@example.org",
      "username": "Fannie Goldner",
      "avatar": null
    },
    {
      "user_id": 9,
      "email": "liliana13@example.com",
      "username": "Dr. Jesse Jacobi I",
      "avatar": null
    },
    {
      "user_id": 10,
      "email": "jerome58@example.org",
      "username": "Leanna Stamm",
      "avatar": null
    }
  ],
  "links": {
    "first": "http:\/\/api.newchannels.loc\/v1\/user?page=1",
    "last": "http:\/\/api.newchannels.loc\/v1\/user?page=5",
    "prev": "http:\/\/api.newchannels.loc\/v1\/user?page=1",
    "next": "http:\/\/api.newchannels.loc\/v1\/user?page=3"
  },
  "meta": {
    "current_page": 2,
    "from": 6,
    "last_page": 5,
    "path": "http:\/\/api.newchannels.loc\/v1\/user",
    "per_page": 5,
    "to": 10,
    "total": 21
  }
}
```

### Запрос на добавления в контакты

Для того, чтобы отправить запрос на добавления пользователя в контакты, 
необходимо отправить **`POST`** запрос на **`/v1/user/add-contact`**

Параметры:<br>
**user_id*** - идентификатор пользователя, который отправляет запрос.<br>
**contact_id*** - идентификатор пользователя, которому отправляют запрос.

### Подтверждение запроса на добавления в контакты

Для того, чтобы отправить запрос на добавления пользователя в контакты, 
необходимо отправить **`PUT`** запрос на **`/v1/user/confirm-contact`**

Параметры:<br>
**user_id*** - идентификатор пользователя, который отправляет запрос.<br>
**contact_id*** - идентификатор пользователя, которому отправляют запрос.

### Отклонение запроса на добавления в контакты

Для того, чтобы отправить запрос на добавления пользователя в контакты, 
необходимо отправить **`DELETE`** запрос на **`/v1/user/reject-contact`**

Параметры:<br>
**user_id*** - идентификатор пользователя, который отправляет запрос.<br>
**contact_id*** - идентификатор пользователя, которому отправляют запрос.

