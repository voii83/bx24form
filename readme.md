<h2>Форма создания заявок на портале Битрикс24.</h2>

* Скопировать проект на хостинг.
* Создать файл /config/params-local.php со следующим содержимым:
```php
<?php
return [
    'urlBitrix' => 'адрес вашего bitrix24',
    'secretBitrix' => 'ключ входящего вебхука битрикс24',
    'userBitrix' => 'id пользователя битрикс24 через которого подключен вебхук',
];
```
