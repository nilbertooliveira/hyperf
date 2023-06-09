# Default Dockerfile
#
# @link     https://www.hyperf.io
# @document https://hyperf.wiki
# @contact  group@hyperf.io
# @license  https://github.com/hyperf/hyperf/blob/master/LICENSE


##
# ---------- env settings ----------
##
# --build-arg timezone=Asia/Shanghai
ARG TIMEZONE
ARG PHP_VERSION
ARG ALPINE_VERSION
ARG SW_VERSION
ARG APP_ENV

FROM hyperf/hyperf:$PHP_VERSION-alpine-v$ALPINE_VERSION-swoole-v$SW_VERSION
LABEL maintainer="Hyperf Developers <group@hyperf.io>" version="1.0" license="MIT" app.name="Hyperf"



ENV TIMEZONE=$TIMEZONE \
    APP_ENV=$APP_ENV \
    SCAN_CACHEABLE=(true)

RUN apk add ssmtp

# update
RUN set -ex \
    # show php version and extensions
    && php -v \
    && php -m \
    && php --ri swoole \
    #  ---------- some config ----------
    && cd /etc/php* \
    # - config PHP
    && { \
        echo "upload_max_filesize=128M"; \
        echo "post_max_size=128M"; \
        echo "memory_limit=1G"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini \
    # - config timezone
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # ---------- clear works ----------
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /app
RUN chmod -R 775 .

# Composer Cache
COPY ./composer.* /app/
RUN composer install --no-dev --no-scripts

COPY . /app
RUN composer install --no-dev -o && php bin/hyperf.php

# Create a group and user
RUN addgroup -g 1000 www
RUN adduser -u 1000 -s /bin/bash --disabled-password -G www www
RUN chmod -R 775 "/usr/local/bin/composer"

# Copy existing application directory permissions
COPY --chown=www:www . /app

# Change current user to www
USER www

EXPOSE 9501

#ENTRYPOINT ["php", "/app/bin/hyperf.php", "start"]
ENTRYPOINT ["php", "/app/bin/hyperf.php", "server:watch"]