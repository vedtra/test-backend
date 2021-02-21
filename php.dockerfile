FROM php:7.3-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions mbstring pdo pdo_pgsql pdo_sqlsrv mongodb grpc redis

# RUN pecl install mongodb \
#     && pecl install grpc \
#     && pecl install redis \
#     && pecl install pdo_sqlsrv \
#     && pecl install pdo_pgsql \
#     && docker-php-ext-enable mongodb grpc redis pdo_sqlsrv pdo_pgsql