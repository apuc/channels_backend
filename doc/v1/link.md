## Ссылки

[Главная](main.md)

### Простая ссылка

Для получения ссылки с мета информацией в сообщение необходимо отправить **`GET`** запрос на **`/v1/single-link?link={link}`** 

Параметры:<br>
**link*** - текст ссылки.<br>

Пример ответ:<br>

```
{
    "data":{
        "url": "https://laravel.com/",
        "title": "Laravel - The PHP Framework For Web Artisans",
        "description": "Laravel - The PHP framework for web artisans.",
        "icon": "/assets/img/laravel-logo-white.png",
        "base": "laravel.com"
    }
}
```

### Текст с ссылками

Для получения всех ссылок с мета информацией в тексте сообщения (включая произвольный текст) необходимо отправить **`GET`** запрос на **`/v1/text-link?link={link}`**

Параметры:<br>
**link*** - текст сообщения.<br>

Пример ответ:<br>

```
{
    "data": [
        {
            "url": "https://laravel.com/",
            "title": "Laravel - The PHP Framework For Web Artisans",
            "description": "Laravel - The PHP framework for web artisans.",
            "icon": "/assets/img/laravel-logo-white.png",
            "base": "laravel.com"
        },
        {
            "url": "https://stackoverflow.com/",
            "title": "Stack Overflow - Where Developers Learn, Share, & Build Careers",
            "description": "Stack Overflow is the largest, most trusted online community for developers to learn, share​ ​their programming ​knowledge, and build their careers.",
            "icon": "https://cdn.sstatic.net/Sites/stackoverflow/img/apple-touch-icon@2.png?v=73d79a89bded",
            "base": "stackoverflow.com"
            }
        ]
}
```