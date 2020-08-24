# Backend

#### Requirements
php >=7.4, composer >= 1.6.3, AWS account  

## Setup

1. Download composer from [https://getcomposer.org/download/](https://getcomposer.org/download/)
2. Clone laravel project from github
3. Go to your project root directory
4. `mv .example.env .env` 
5. Complete vars in .env (required: AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, AWS_DEFAULT_REGION)
4. `composer install` or `php composer.phar install`
5. `php artisan key:generate && php artisan serve`

## Setup with Docker

1. Clone Laravel project from github
2. Go to your project root directory
3. `mv .example.env .env.prod`
4. Complete env vars (required: AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, AWS_DEFAULT_REGION)
5. `docker build -f Dockerfile_prod . -t tag_name` (you can set your 'tag_name')
6. `docker run -p 8000:8000 tag_name`

#### Troubleshooting
In case issues during installation of dependencies, you can try the following command:

`sudo apt-get install php7.4 php7.4-{simplexml,mbstring,dom}`
