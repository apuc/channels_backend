## Авторизация

### Получение token
 
Запрос на авторизацию отправляется на **`/v1/oauth/token`** 
методом **`POST`**

Параметры:<br>
**grant_type*** - тип авторизации, сейчас доступно только одно
значени "password".<br>
**client_id*** - идинтификатор клиента, генерируется по запросу.<br>
**client_secret*** - ключ клиента, генерируется по запросу.<br>
**username*** - email пользователя.<br>
**password*** - пароль пользователя.<br>
**scope** - ?

Ответы сервера:<br>
status 401 - Unauthorized
status 200 - OK

Если запрос прошел успешно, то сервер вернет информацию для 
работы с API

```
{
"token_type": "Bearer",
"expires_in": 86400,
"access_token": "eyJ0eXAiOiJKV1Q...",
"refresh_token": "def5020009c17a37..."
}
```

### Получение данных пользователя

Для получения данных пользователя нужно отправить **`GET`** 
запрос на **`/v1/user`**, в заголовках передать параметры 
авторизации:<br>
**`Authorization: Bearer eyJ0eXAiOiJKV1QiLC...`**

Примерный ответ сервера:

```
{
"user_id": 1,
"username": "Mrs. Camylle Collier DVM",
"email": "ruben39@example.com",
"email_verified_at": "2018-09-29 12:40:34",
"created_at": "2018-09-29 12:40:34",
"updated_at": "2018-09-29 12:40:34",
"login": null
}
```