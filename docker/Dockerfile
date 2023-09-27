FROM php:7.4-fpm
ARG TIMEZONE="Asia/Dhaka"


ARG DOMAIN="localhost"
ARG TIMEOUT="600"

ENV DOMAIN="${DOMAIN}" \
    TIMEOUT="${TIMEOUT}"

RUN echo "${TIMEZONE}" > /etc/timezone \
    && rm /etc/localtime \
    && dpkg-reconfigure -f noninteractive tzdata \
    && apt-get update -y \
    && apt-get install -y --no-install-recommends gnupg gnupg1 gnupg2 \
    && echo "deb http://nginx.org/packages/debian/ $(awk -F'=' '/VERSION_CODENAME/ {print $2}' /etc/*release) nginx" >> /etc/apt/sources.list \
    && curl -s -N -L https://nginx.org/keys/nginx_signing.key | apt-key add - \
    && apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y --no-install-recommends \
        zip \
        ca-certificates \
        unzip \
        vim \
        gettext \
        libz-dev \
        libpq-dev \
        libssl-dev \
        libzip-dev \
        zlib1g-dev \
        libicu-dev \
        nginx \
        supervisor \
        g++ \
        openssl \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libldap2-dev \
        libxml2-dev \
        libonig-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl opcache intl soap \
    && docker-php-ext-configure gd --prefix=/usr --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install sockets \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && apt-get purge -y --auto-remove g++ \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && curl --silent --fail --location --retry 3 https://getcomposer.org/installer | php -- --version=2.3.7 \
    && echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc \
    && mv composer.phar /usr/local/bin/composer \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && . ~/.bashrc

WORKDIR /var/www
RUN composerInstallArgs="--ignore-platform-reqs --no-interaction --no-scripts --no-autoloader --prefer-dist" \
    && export composerInstallArgs \
    && if [ "${BUILD_MODE}" = "prod" ]; then \
        composerInstallArgs="${composerInstallArgs} --no-dev" \
        && export composerInstallArgs \
    ;fi \
    && composer install $composerInstallArgs

COPY --chown=www:www ./src .
COPY ./docker/app/nginx/ /etc/nginx/

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN usermod -u 1000 www-data
WORKDIR /var/www
