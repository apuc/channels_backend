## Аватарки

[Главная](main.md) 

Для того чтобы добавить аватарку необходимо отправить 
**`POST`** запрос на **`/group/avatar`** либо на 
**`/channel/avatar`** 
соответственно.

Параметры:<br>
**avatar*** - файл аватарки (тип file).

Пример ответ:<br>

```
{
    "data":{
        "avatar_id": 11,
        "origin": "http://files.newchannels.loc/img/group/a/a9/a99e2dd4cf56a3c41fe296bf3f0b3722.jpg",
        "average": "http://files.newchannels.loc/img/group/a/a9/a99e2dd4cf56a3c41fe296bf3f0b3722_400.jpg",
        "small": "http://files.newchannels.loc/img/group/a/a9/a99e2dd4cf56a3c41fe296bf3f0b3722_150.jpg",
        "status": "active"
    }
}
```