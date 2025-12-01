FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL y otras utilidades
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite de Apache para que funcionen las rutas amigables (MVC)
RUN a2enmod rewrite

# Copiar el código de la aplicación al contenedor
COPY . /var/www/html/

# Configurar el DocumentRoot para que apunte a la carpeta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf . /etc/apache2/conf-available/*.conf

# Crear carpeta de caché si no existe y dar permisos de escritura
RUN mkdir -p /var/www/html/cache && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/cache && \
    chmod -R 755 /var/www/html/public/uploads && \
    chmod -R 755 /var/www/html/cache

# Exponer el puerto que usa Railway (se pasa dinámicamente, pero Apache escucha en 80 por defecto)
EXPOSE 80
