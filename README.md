## About this application

It is basically an application where users watch lesson videos and make comments to unlock achievements. After some achievements have been unlocked, a new badge is gotten by the user

## :heavy_check_mark: Getting Started
This sets of instructions will get the application running on your system. As, stated above a good understanding of PHP and Laravel is very important.


## :rocket: Installation

#### 1. Clone the project

Via SSH (recommended):
```
git@github.com:jmkolawole/unlock-badge.git
```

Or via HTTPS:
```
https://github.com/jmkolawole/unlock-badge.git
```

#### 2. Install Dependencies With Composer
Change directory to your project folder and run:
```
composer install
```

#### 3. Setup Environment Configuration
Create a _.env_ file from _.env.example_ file provided in the cloned project
```
cp .env.example .env
```
Create a _.env.testing_ file from _.env.testing.example_ file provided in the cloned project
```
cp .env.testing.example .env.testing
```

#### 4. Generate App Key
```
php artisan key:generate
```

#### 5. Run Migration and Seeders for the application

```
php artisan migrate --database=mysql --seed
```

Cheers! You have successfully setup the application  on your local machine.
:+1: :+1: :+1:

## :package: Built With

* [Laravel](http://laravel.com/docs/)
* [Composer](https://getcomposer.org/)

## :handshake: Developer
Unlock-badge
- JIMOH Mofoluwasho Kolawole (jmkolawole@gmail.com) - Developer

