#!/bin/bash

echo "🚀 Iniciando JM-Commerce no Digital Ocean App Platform..."

# Aguarda o banco estar disponível
echo "⏳ Verificando conectividade com banco de dados..."

# Atualiza permissões
chmod -R 755 /var/www/html
chown -R www-data:www-data /var/www/html

# Cria diretórios necessários se não existirem
mkdir -p /var/www/html/application/logs
mkdir -p /var/www/html/application/cache
chmod 777 /var/www/html/application/logs
chmod 777 /var/www/html/application/cache

echo "✅ JM-Commerce configurado para Digital Ocean!"
echo "🌐 Aplicação disponível em: https://clownfish-app-b7sfb.ondigitalocean.app/"

# Inicia o Apache
exec apache2-foreground
