# 🛒 JM-Commerce

🚀 Sistema completo de e-commerce desenvolvido para gerenciamento de loja online, permitindo cadastro de produtos, controle de estoque, sistema de carrinho, processamento de pedidos e geração de relatórios gerenciais.

## 📌 Tecnologias Utilizadas

- **PHP** (CodeIgniter 3)
- **MySQL** (Banco de dados)
- **HTML5/CSS3** (Interface)
- **Tailwind CSS** (Framework CSS moderno)
- **JavaScript** (Interatividade)
- **Chart.js** (Gráficos e relatórios)
- **Bootstrap Icons** (Ícones)
- **Alpine.js** (Reatividade)
- **mPDF** (Geração de PDFs)
- **Docker** (Containerização)

## 🎨 Funcionalidades

### 👥 Sistema de Usuários
- **Visitantes**: Visualização de produtos
- **Clientes**: Carrinho de compras e pedidos
- **Estoquistas**: Controle de estoque
- **Administradores**: Gestão completa do sistema

### 🛍️ E-commerce
- Catálogo de produtos com categorias
- Sistema de carrinho personalizado por usuário
- Processamento de pedidos
- Controle de estoque automatizado

### 📊 Relatórios Gerenciais
- **Compras por Cliente**: Análise de comportamento de compra
- **Produtos em Falta**: Controle de estoque crítico
- **Valor por Dia**: Acompanhamento de faturamento
- Exportação em PDF e CSV

## 📌 Pré-requisitos

Antes de rodar o projeto, certifique-se de ter instalado:

- **PHP 7.4+**
- **MySQL 5.7+** ou **MariaDB**
- **Apache** ou **Nginx**
- **Composer** (gerenciador de dependências PHP)
- **XAMPP/WAMP** (ambiente de desenvolvimento local)

## 📌 Configuração do Banco de Dados

O sistema utiliza MySQL. Execute os scripts SQL na seguinte ordem:

1. **Estrutura das tabelas**:
   ```bash
   mysql -u root -p < scripts/ddl.sql
   ```

2. **Dados das categorias**:
   ```bash
   mysql -u root -p < scripts/ddl_categorias.sql
   ```

No arquivo `application/config/database.php`, configure sua conexão:

```php
$db['default'] = array(
    'dsn'      => '',
    'hostname' => 'localhost',
    'username' => 'root',          // 🔹 Seu usuário MySQL
    'password' => '',              // 🔹 Sua senha MySQL
    'database' => 'loja_online',   // 🔹 Nome do banco
    'dbdriver' => 'mysqli',
    // ... outras configurações
);
```

## 📌 Passo a Passo para Rodar o Projeto

### 1️⃣ Clonar o repositório
```bash
git clone https://github.com/JoseMatheus29/Projeto_Loja_online.git
cd Projeto_Loja_online
```

### 2️⃣ Instalar dependências
```bash
composer install
```

### 3️⃣ Configurar ambiente local
```bash
# Copiar para pasta do servidor web
cp -r . /var/www/html/loja-online/  # Linux
# ou
# Mover para C:\xampp\htdocs\loja-online\  # Windows
```

### 4️⃣ Configurar banco de dados
- Criar banco: `loja_online`
- Executar scripts SQL da pasta `scripts/`
- Configurar `application/config/database.php`

### 5️⃣ Rodar o projeto
```bash
# Iniciar XAMPP/WAMP ou servidor local
# Acessar: http://localhost/loja-online/
```

## 🐳 Executar com Docker

```bash
# Subir containers
docker-compose up -d

# Acessar aplicação
http://localhost:8080
```

## 📁 Estrutura do Projeto

```
📦 Projeto_Loja_online/
├── 📂 application/
│   ├── 📂 controllers/     # Controladores MVC
│   ├── 📂 models/          # Modelos de dados
│   ├── 📂 views/           # Views e templates
│   └── 📂 config/          # Configurações
├── 📂 assets/              # CSS, JS, imagens
├── 📂 scripts/             # Scripts SQL
├── 📂 system/              # Core do CodeIgniter
├── 🐳 docker-compose.yml   # Configuração Docker
└── 📄 composer.json        # Dependências PHP
```

## 🔑 Usuários Padrão

| Tipo | Login | Senha | Permissões |
|------|-------|-------|------------|
| Admin | admin | admin123 | Gestão completa |
| Estoquista | estoque | estoque123 | Controle de estoque |
| Cliente | cliente | cliente123 | Compras e pedidos |

## 📊 Capturas de Tela

### Dashboard de Relatórios
![Relatórios](docs/screenshots/relatorios.png)

### Catálogo de Produtos
![Produtos](docs/screenshots/produtos.png)

### Sistema de Carrinho
![Carrinho](docs/screenshots/carrinho.png)

## 🚀 Deploy

### Servidor Web
1. Upload dos arquivos para servidor
2. Configurar banco de dados
3. Ajustar permissões de pasta
4. Configurar domínio/DNS

### AWS/Heroku
- Utilizar `buildspec.yml` e `appspec.yml` inclusos
- Configurar variáveis de ambiente
- Deploy automatizado via CI/CD

## 📌 Contribuição

1. Fork o projeto
2. Crie uma branch: `git checkout -b feature/nova-funcionalidade`
3. Commit: `git commit -m 'Adiciona nova funcionalidade'`
4. Push: `git push origin feature/nova-funcionalidade`
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📌 Autor

Desenvolvido por **José Matheus** ✌️

🔗 [LinkedIn](https://www.linkedin.com/in/josé-matheus-de-lima-27706a1b6/) | 📧 [Email](mailto:seu-email@exemplo.com) | 🐱 [GitHub](https://github.com/JoseMatheus29)

---

⭐ **Se este projeto te ajudou, deixe uma estrela!** ⭐
