# **DMIEsys**

#### Follow this instructions to setup this project on your local computer.

### Pre-Requirements

-   PHP > 8.1
-   NodeJS > 18

#### Installation

**Type these commands on your terminal**

Clone this project to your local computer.

```ps
git clone https://github.com/madushanj/DMIEsys.git
```

Go to project folder.

```ps
cd DMIEsys/
```

Install required packages.

```ps
composer install
```

```ps
npm install && npm run dev
```

create new .env file.

```ps
cp .env.example .env
```

Generate new app key.

```ps
php artisan key:generate
```

Now open your .env file and config MySQL database.

Run migrations.

```ps
php artisan migrate --seed
```

Run the application.

```ps
php artisan serve
```

Now you can go to http://localhost:8000/ on your computer and see the application running.

## Authors

-   [@Madushan Jayawardane](https://www.github.com/madushanj)

## Feedback

If you have any feedback, please reach out to us at mtj.ssl@gmail.com
