# Use uma imagem base do PHP com Apache
FROM php:8.0-apache

# Instale as dependências do PHP (como mysqli e pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa o mod_rewrite no Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o conteúdo do projeto para o contêiner
COPY . .

# Dê permissões apropriadas para o Apache
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta 80 (padrão para Apache)
EXPOSE 80

# Defina o comando padrão para iniciar o Apache
CMD ["apache2-foreground"]
