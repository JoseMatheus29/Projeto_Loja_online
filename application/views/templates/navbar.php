<?php
$usuario_logado = $_SESSION['usuario_logado'] ?? null;
$is_adm = ($usuario_logado && $usuario_logado['tipo'] == 'adm');
?>

<header x-data="{ openMobileMenu: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <nav class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="<?= base_url() ?>HomeController" class="text-2xl font-bold text-primary">
                LojaOnline
            </a>

            <!-- Links de Navegação (Desktop) -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="<?= base_url() ?>HomeController" class="text-gray-600 hover:text-primary transition">Home</a>
                
                <?php if ($is_adm): ?>
                    <!-- Menu Admin -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-gray-600 hover:text-primary transition">
                            Admin
                            <i class="bi bi-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="<?= base_url() ?>ProdutoController" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Produtos</a>
                            <a href="<?= base_url() ?>CategoriaController" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Categorias</a>
                            <a href="<?= base_url() ?>usuarioController" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Usuários</a>
                        </div>
                    </div>
                     <!-- Menu Relatórios -->
                     <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-gray-600 hover:text-primary transition">
                            Relatórios
                            <i class="bi bi-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="<?= base_url() ?>RelatorioController/comprasPorCliente" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Compras por Cliente</a>
                            <a href="<?= base_url() ?>RelatorioController/produtosEmFalta" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Produtos em Falta</a>
                            <a href="<?= base_url() ?>RelatorioController/valorPorDia" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Valor Recebido por Dia</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ícones e Ações do Usuário -->
            <div class="flex items-center space-x-4">
                <a href="<?= base_url() ?>carrinhoController" class="text-gray-600 hover:text-primary transition relative">
                    <i class="bi bi-cart text-xl"></i>
                    <!-- Badge do Carrinho (exemplo) -->
                    <!-- <span class="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span> -->
                </a>

                <?php if ($usuario_logado): ?>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center text-gray-600 hover:text-primary transition">
                            <i class="bi bi-person-circle text-xl mr-2"></i>
                            <span class="hidden sm:inline"><?= htmlspecialchars(explode(' ', $usuario_logado['nome'])[0]) ?></span>
                            <i class="bi bi-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
                            <a href="<?= base_url() ?>pedidosController/?idUsuario=<?=$usuario_logado['user_id']?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meus Pedidos</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Minha Conta</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="<?= base_url() ?>usuarioController/sair" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url() ?>usuarioController/login" class="hidden sm:inline text-gray-600 hover:text-primary transition">Entrar</a>
                    <a href="<?= base_url() ?>usuarioController/cadastrarUsuario" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-hover transition">Cadastrar-se</a>
                <?php endif; ?>

                <!-- Botão do Menu Mobile -->
                <button @click="openMobileMenu = !openMobileMenu" class="md:hidden text-gray-600 hover:text-primary transition">
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>
        </nav>
    </div>

    <!-- Menu Mobile -->
    <div x-show="openMobileMenu" class="md:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="<?= base_url() ?>HomeController" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-primary">Home</a>
            
            <?php if ($is_adm): ?>
                <h3 class="px-3 pt-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</h3>
                <a href="<?= base_url() ?>ProdutoController" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-primary">Produtos</a>
                <a href="<?= base_url() ?>CategoriaController" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-primary">Categorias</a>
                <a href="<?= base_url() ?>usuarioController" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-primary">Usuários</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-white hover:bg-primary">Relatórios</a>
            <?php endif; ?>
        </div>
    </div>
</header>


