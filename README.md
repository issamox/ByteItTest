# Installation

```
git clone https://github.com/issamox/ByteItTest.git
```
### Order Management System with PDF and Image Upload

```
cd OrderManagement
composer install
cp .env.example .env
php artisan migrate --seed
php artisan storage:link
php artisan serve
php artisan test
```

### Project Management API with JWT Authentication

```
cd ProjectManagement
composer install
cp .env.example .env
php artisan migrate --seed
php artisan jwt:secret
php artisan serve
php artisan test
```

### Stock Management System with Real-Time Notification

```
cd notificationSystem
composer install
npm install
cp .env.example .env
```

```angular2html
in .env setup pusher and mail variable


BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-app-cluster

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

```
php artisan migrate --seed
php artisan serve
php artisan test
```