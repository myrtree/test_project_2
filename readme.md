# CRM

## Требования к п.о. из официальной документации
- PHP >= 5.6.4
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

Но в процессе использовал PHP7.

## Установка

### Установка ПО и первоначальная настройка

Просто опишу всё, что делал в процессе для настройки.
Использовал официальный ubuntu/xenial64 бокс Vagrant. Установил всё потребное:
```
apt update
apt upgrade
apt install software-properties-common
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xF1656F24C74CD1D8
 add-apt-repository 'deb [arch=amd64,i386,ppc64el] http://mirror.mephi.ru/mariadb/repo/10.2/ubuntu xenial main'
apt update
apt install mariadb-server apache2 php libapache2-mod-php php-mbstring php-xml php-mysql php-xdebug
mkdir ~/bin
cd ~/bin
wget https://getcomposer.org/composer.phar
mv composer.phar composer
chmod +x composer
```

Так же прокинул 80 порт из vm на 8080 хоста
```
config.vm.network "forwarded_port", guest: 80, host: 8080
```

И вот такой конфиг сайта для apache:
```
<VirtualHost *:80>
        DocumentRoot "/vagrant/crm/public"

        <Directory "/vagrant/crm/public">
                Require all granted
                Allowoverride All
        </Directory>
</VirtualHost>
```

Нужно создать `.env` файл. Пример находится в `.env.example`.

В итоге сайт доступен по ссылке [http://localhost:8080](http://localhost:8080)

### Установка проекта и зависимостей composer

```
cd /vagrant
git clone https://github.com/myrtree/test_project_2.git crm
cd /vagrant/crm
composer install
```

### Создание базы, таблиц и админской учётки

Создание базы
```
mysql -u root -p --execute="CREATE DATABASE IF NOT EXISTS crm CHARACTER SET utf8 COLLATE utf8_general_ci;"
```

Запуск миграций для создания таблиц
```
php artisan migrate
```

Создание ролей и учётки администратора
```
php artisan db:seed
```
При создании администратора пароль берётся из параметра `ADMIN_PASSWORD` файла `.env`.

## Описание API

Все маршруты API описаны в коллекции для Postman `CRM Api.postman_collection.json`
