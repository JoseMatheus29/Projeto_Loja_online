#!/bin/bash

echo "🚀 Configurando projeto JM-Commerce para Digital Ocean..."

# Aguarda o MySQL estar pronto
echo "⏳ Aguardando MySQL..."
until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e 'SELECT 1' &>/dev/null; do
    echo "MySQL ainda não está pronto... aguardando 5 segundos"
    sleep 5
done

echo "✅ MySQL está pronto!"

# Verifica se as tabelas existem
TABLES_COUNT=$(mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" -e "SHOW TABLES;" | wc -l)

if [ $TABLES_COUNT -le 1 ]; then
    echo "📦 Criando estrutura do banco de dados..."
    
    # Executa os scripts SQL se existirem
    if [ -f /var/www/html/scripts/ddl.sql ]; then
        mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < /var/www/html/scripts/ddl.sql
        echo "✅ Estrutura das tabelas criada!"
    fi
    
    if [ -f /var/www/html/scripts/ddl_categorias.sql ]; then
        mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < /var/www/html/scripts/ddl_categorias.sql
        echo "✅ Dados das categorias inseridos!"
    fi
else
    echo "✅ Banco de dados já configurado!"
fi

echo "🎉 Projeto configurado com sucesso!"
echo "🌐 Acesse seu projeto no navegador!"
