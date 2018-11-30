## Группы

[Главная](main.md) 

### Получение групп пользователя

Для получения групп пользователя необходимо отправить **`GET`** запрос на **`/v1/group`**

Пример ответ:<br>
```
{
    "data":[
    {
        "group_id": 3,
        "title": "Mrs.",
        "slug": "mrs",
        "status": "disable",
        "owner_id": "8",
        "avatar":{
            "origin": null,
            "average": null,
            "small": null
        },
        "channels":[
        ]
    },
    {
        "group_id": 6,
        "title": "Ms.",
        "slug": "ms",
        "status": "active",
        "owner_id": "8",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/group/8/84/8440e9a9f4923d8e73413204198c7cbc.png",
            "average": "http://files.newchannels.loc/img/group/8/84/8440e9a9f4923d8e73413204198c7cbc_400.png",
            "small": "http://files.newchannels.loc/img/group/8/84/8440e9a9f4923d8e73413204198c7cbc_150.png"
        },
        "channels":[
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
    ]
}
```

### Добавление группы

Для того, чтобы добавить группу, необходимо отправить 
**`POST`** запрос на **`/v1/group`**

Параметры:<br>
**title*** - название группы.<br>
**slug*** - url группы.<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**owner_id*** - идентификатор создателя группы.<br>
**user_ids** - массив пользователей группы.<br>
**avatar** - автарка группы, 
принимает идентификатор заранее загруженной аватарки.

Пример ответа:<br>

```
{
    "data":{
        "group_id": 47,
        "title": "test add",
        "slug": "test_add",
        "status": "active",
        "owner_id": "8",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436.png",
            "average": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_400.png",
            "small": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_150.png"
        },
        "channels":[
        ]
    }
}
```

### Редактирование группы

Для того, чтобы редактировать группу, необходимо отправить 
**`PUT`** запрос на **`/v1/group/{group_id}`**

Параметры:<br>
**title*** - название группы.<br>
**slug*** - url группы.<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**owner_id*** - идентификатор создателя группы.<br>
**user_ids*** - массив пользователей группы.<br>
**avatar** - автарка группы, 
принимает идентификатор заранее загруженной аватарки.

### Получение группы по group_id

Для того, чтобы получить группу, необходимо отправить 
**`GET`** запрос на **`/v1/group/{group_id}`**

Пример ответа:<br>

```
{
    "data":{
        "group_id": 47,
        "title": "test add",
        "slug": "test_add",
        "status": "active",
        "owner_id": "8",
        "avatar":{
            "origin": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436.png",
            "average": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_400.png",
            "small": "http://files.newchannels.loc/img/group/9/99/994d2dc4c7c589937fbdcdda0db25436_150.png"
        },
        "channels":[
        ]
    }
}
```

### Удаление группы

Для того, чтобы удалить группу, необходимо отправить 
**`DELETE`** запрос на **`/v1/group/{group_id}`**

### Добавление каналов
Для того что бы добавить каналы необходимо отправить
**`POST`** запрос на **`/v1/group/{group_id}/channels`**

### Удаление канала
Для того что бы удалить канал необходимо отправить
**`DELETE`** запрос на **`/v1/group/{group_id}/delete-channel?channel_id={channel_id}`**

Параметры:<br>
**channel_id*** - id канала для удаления из группы.<br>