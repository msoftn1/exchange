**Инструкция**

1. установить композер
2. запустить "composer update"
3. установить настройки бд в файле .env
4. обновить бд коммандой "doctrine:schema:update --force"
5. добавить в крон команду "php bin/console app:rate-parser" например каждую минуту

Есть особенность с курсом, он обновляется не каждый раз.  
Это Связано с поставщиком, переделывать на другой поставщик нужно ещё время.   
Думаю этого вполне достаточно.
