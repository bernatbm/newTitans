FROM php:8.2-apache

# Actualizar el sistema operativo
RUN apt-get update && apt-get upgrade -y

# Instalar dependencias necesarias para la extensión intl
RUN apt-get install -y libicu-dev

# Instalar la extensión mysqli y otras extensiones comunes
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Instalar y habilitar la extensión intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

# Opcional: Instalar otras dependencias del sistema si las necesitas
RUN apt-get install -y \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev

# Habilitar extensiones gráficas (si necesitas procesamiento de imágenes)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j $(nproc) gd

# Opcional: Instalar y activar Xdebug para debugging
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Opcional: Configurar Xdebug (ajusta según tus necesidades)
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
