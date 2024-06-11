# Рекомендуемое время выполнения 2 часа


# Задание

Имеется система управления логистикой.
Система является очень старой и практически неподдерживаемой.

### Задача
Сформировать новую систему с действующим функционалом на основе старой.
Реализовать текущий функционал системы
- добавление курьера
- отправка в рейс
- просмотр рейсов
- фильтрация по дате отправления

Добавить новый функционал
- Сортировка по всем полям таблицы
- Просмотр списка курьеров
- Фильтрация курьеров
- Удаление курьера
- Обновление данных курьера
- Добавление регионов
- Обновление названия региона (опечатка)
- Удаление регионов

В случае невозможности реализации какого-либо функционала описать необходимые данные для его реализации (спроектировать API)
Под проектировкой подразумевается описание url и набор передаваемых параметров. Реализация не требуется

Освежить кодовую базу используя vue3 + ecosystem
В качестве component framework взять primevue
Объяснить проблематику и свои решения при личной беседе

# Запуск
- cp -R .env.example .env
- docker-compose build
- docker-compose up

## адреса:
- localhost:8080 - api
- localhost:8080/old - старый ресурс
# API
## все приведенные ниже роуты являются ресурсными
- localhost:8080/couriers - курьеры
- localhost:8080/regions - регионы
- localhost:8080/leftlist - маршрутные листы

