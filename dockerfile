# Use uma imagem base do PHP com Apache (otimizada para Digital Ocean)
FROM php:8.0-apache

# Instale as dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql pdo_pgsql pgsql

# Ativa módulos do Apache necessários
RUN a2enmod rewrite headers ssl

# Configure o Apache para CodeIgniter e Digital Ocean App Platform
RUN echo '<Directory /var/www/html>' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf

# Configure o Virtual Host padrão
RUN echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    ServerName clownfish-app-b7sfb.ondigitalocean.app' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    ErrorLog ${APACHE_LOG_DIR}/error.log' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    CustomLog ${APACHE_LOG_DIR}/access.log combined' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf

# Define variáveis de ambiente
ENV APACHE_DOCUMENT_ROOT /var/www/html
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o conteúdo do projeto
COPY . .

# Crie diretórios necessários e configure permissões
RUN mkdir -p application/logs application/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    chmod 777 application/logs application/cache

# Exponha a porta 80
EXPOSE 80

# Script de inicialização
COPY scripts/start-digital-ocean.sh /start.sh
RUN chmod +x /start.sh

# Comando padrão
CMD ["/start.sh"]
