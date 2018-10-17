## Каналы

[Главная](main.md) 

### Получение каналов пользователя

Для получения каналов пользователя необходимо отправить **`GET`** запрос на **`/v1/channel`**

Пример ответ:<br>
```
{
    "data":[
        {
            "channel_id": 6,
            "title": "Mr.",
            "slug": "mr",
            "status": "active",
            "private": 0,
            "avatar":{
                "origin": "http://files.newchannels.loc/var/www/newchannels.loc/storage/app/public/img/channel/b/b6/b6ba4c2140f71b3430a7aaf44a4bd2e1.jpg",
                "average": "http://files.newchannels.loc/var/www/newchannels.loc/storage/app/public/img/channel/b/b6/b6ba4c2140f71b3430a7aaf44a4bd2e1_400.jpg",
                "small": "http://files.newchannels.loc/var/www/newchannels.loc/storage/app/public/img/channel/b/b6/b6ba4c2140f71b3430a7aaf44a4bd2e1_150.jpg"
            }
        },
        {
            "channel_id": 106,
            "title": "Не работает доменное имя",
            "slug": "eee",
            "status": "active",
            "private": 0,
            "avatar":{
                "origin": null,
                "average": null,
                "small": null
            }
        }
    ]
}
```

### Добавление канала

Для того, чтобы добавить канал, необходимо отправить 
**`POST`** запрос на **`/v1/channel`**

Параметры:<br>
**title*** - название канала.<br>
**slug*** - url канала.<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**user_ids*** - массив пользователей канала.<br>
**type*** - тип канала, принимает такие значения: 
'chat', 'wall' и 'dialog'<br>
**private*** - приватность канала, принимает 0 или 1.<br>
**avatar** - автарка канала, 
принимает идентификатор заранее загруженной аватарки.

Пример ответ:<br>

```
{
    "data":{
        "channel_id": 108,
        "title": "test add",
        "slug": "test_add",
        "status": "active",
        "private": "0",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436.png",
            "average": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_400.png",
            "small": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_150.png"
        }
    }
}
```

### Редактирование канала

Для того, чтобы редактировать канал, необходимо отправить 
**`PUT`** запрос на **`/v1/channel/{channel_id}`**

Параметры:<br>
**title*** - название канала.<br>
**slug*** - url канала.<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**user_ids*** - массив пользователей канала.<br>
**type*** - тип канала, принимает такие значения: 
'chat', 'wall' и 'dialog'<br>
**private*** - приватность канала, принимает 0 или 1.<br>
**avatar** - автарка канала, 
принимает идентификатор заранее загруженной аватарки.

### Получение канала по channel_id

Для того, чтобы получить канал, необходимо отправить 
**`GET`** запрос на **`/v1/channel/{channel_id}`**

Пример ответ:<br>

```
{
    "data":{
        "channel_id": 108,
        "title": "test add",
        "slug": "test_add",
        "status": "active",
        "private": "0",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436.png",
            "average": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_400.png",
            "small": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_150.png"
        }
    }
}
```

### Добавление пользователя в канал

Для добавления пользователя необходимо отправить
**`POST`** запрос на **`/v1/channel/add-user`**

Параметры:<br>
**user_id*** - идентификатор пользователя.<br>
**channel_id*** - идентификатор канала.<br>

### Удалить пользователя из канала

Для добавления пользователя необходимо отправить
**`DELETE`** запрос на **`/v1/channel/delete-user`**

Параметры:<br>
**user_id*** - идентификатор пользователя.<br>
**channel_id*** - идентификатор канала.<br>

### Удаление канала

Для того, чтобы удалить канал, необходимо отправить 
**`DELETE`** запрос на **`/v1/channel/{channel_id}`**