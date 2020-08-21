FROM bitnami/laravel

USER root:root

WORKDIR /usr/src/app

COPY . .
# RUN chown -R bitnami .

EXPOSE 8000

CMD php artisan serve --host 0.0.0.0 --port=8000