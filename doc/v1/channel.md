## Каналы

### Получение каналов пользователя

Для получения каналов пользователя необходимо отправить **`GET`** запрос на **`/v1/channel`**

Пример ответ:<br>
```
{
    "data":[
        {
            "channel_id": 5,
            "title": "Mrs.",
            "slug": "mrs",
            "status": "active",
            "private": 1
        },
        {
            "channel_id": 6,
            "title": "Mr.",
            "slug": "mr",
            "status": "active",
            "private": 0
            },
        {
            "channel_id": 106,
            "title": "Не работает доменное имя",
            "slug": "eee",
            "status": "active",
            "private": 0
        }
    ]
}
```