ARG PHP_VERSION=8.4
ARG ALPINE_VERSION=3.22

FROM php:${PHP_VERSION}-cli-alpine${ALPINE_VERSION} AS base

RUN curl --location --output /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions bcmath intl

FROM base AS dev

COPY --from=composer/composer:2-bin /composer /usr/local/bin/composer

RUN mkdir /app
WORKDIR /app

RUN install-php-extensions xdebug

RUN curl -sL https://github.com/go-task/task/releases/latest/download/task_linux_amd64.tar.gz | tar -xz -C /usr/local/bin task \
    && chmod +x /usr/local/bin/task

ENTRYPOINT ["tail", "-f", "/dev/null"]
