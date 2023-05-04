## Installation Guide

- git clone https://github.com/hagaitrg/Kendaraan-API.git
- composer update
- cp .env.example .env
- php artisan key:generate
- Create MongoDB Database
- .env
`` MONGO_DB_HOST=127.0.0.1``
`` MONGO_DB_PORT=27017``
`` MONGO_DB_DATABASE=kendaraan_api``
`` MONGO_DB_USERNAME=``
`` MONGO_DB_PASSWORD=``
``DB_CONNECTION=mongodb`` 
- php artisan jwt:secret
- php artisan migrate --database=mongodb
- php artisan serve
