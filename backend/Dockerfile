FROM php:8.2-apache

# Instala extensões do PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Habilita mod_rewrite para Yii funcionar corretamente
RUN a2enmod rewrite

# Copia arquivos do Yii para dentro do container
COPY . /var/www/html

# Copia a configuração do Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Permissões corretas para o Yii
RUN chown -R www-data:www-data /var/www/html/runtime /var/www/html/web/assets

EXPOSE 80
CMD ["apache2-foreground"]
