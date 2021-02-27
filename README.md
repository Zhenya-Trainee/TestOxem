# Запуск проекта

  - Запустить Docker
  - Выполнить команду
```sh
    $ docker-compose up -d
```
  - Выполнить команду
```sh
    $ docker ps
```
- Зайти в контейнер php-cli
```sh
    $ docker exec -u 1000:1000 -it id_container bash 
```
- Выполнить команду 
```sh
    $ composer install 
```
- Создать файл .env 

- Тестирование проекта производил через Postman

- Таблицы можно создать с помощью миграций 
