## Аттачменты

[Главная](main.md) 

### Загрузка файла аттачмента

Для того, чтобы загрузить файл аттачмента, необходимо отправить 
**`POST`** запрос на **`/v1/attachment/upload`**

Параметры:<br>
**attachment*** - файл.<br>

Пример ответа:<br>

```
{
    "file": "/attachments/6/64/64aeea4eb0bea61c85a42522e1e892ae.png"
}
```

### Добавление аттачмента

Для того, чтобы добавить аттачмент к сообщению, необходимо отправить 
**`POST`** запрос на **`/v1/attachment`**

Параметры:<br>
**type*** - тип аттачмента(image или file).<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**message_id*** - идентификатор сообщения к которому прикрепляется attachment.<br>
**options*** - параметры аттачмента в формате json.<br>

Пример ответа:<br>

```
{
    "data": {
        "id": 23,
        "status": "active",
        "message_id": "7",
        "type": "file",
        "options": "{"option1":32,"option2":"value_2"}"
    }
}
```

### Редактирование аттачмента

Для того, чтобы редактировать аттачмент, необходимо отправить 
**`PUT`** запрос на **`/v1/attachment/{attachment_id}`**

Параметры:<br>
**type*** - тип аттачмента(image или file).<br>
**status*** - принимает 2-а значения 'active' и 'disable'.<br>
**message_id*** - идентификатор сообщения к которому прикрепляется attachment.<br>
**options*** - параметры аттачмента в формате json.<br>

Пример ответа:<br>

```
{
    "data": {
        "id": 23,
        "status": "active",
        "message_id": "7",
        "type": "image",
        "options": "{"option1":32,"option2":"value_2","option3":"value_3"}"
    }
}
```

### Получение аттачмента по attachment_id

Для того, чтобы получить аттачмент, необходимо отправить 
**`GET`** запрос на **`/v1/attachment/{attachment_id}`**

Пример ответа:<br>

```
{
    "data": {
        "id": 22,
        "status": "active",
        "message_id": 4,
        "type": "file",
        "options": "{"option1":32,"option2":"value_2"}"
    }
}
```

### Удаление аттачмента

Для того, чтобы удалить аттачмент, необходимо отправить 
**`DELETE`** запрос на **`/v1/attachment/{attachment_id}`**

