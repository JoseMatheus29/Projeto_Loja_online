<?php
$usuario_logado = $_SESSION['usuario_logado'] ?? null;
$is_adm = ($usuario_logado && $usuario_logado['tipo'] == 'adm');
?>

<main class="container mx-auto px-4 py-8">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-xl overflow-hidden mb-12">
        <div class="p-8 md:p-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Coleção de Verão</h1>
            <p class="text-lg md:text-xl mb-6">Descubra as últimas tendências e renove seu guarda-roupa.</p>
            <a href="#" class="bg-white text-indigo-600 font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition-transform transform hover:scale-105">Ver Produtos</a>
        </div>
        <div class="hidden md:block absolute bottom-0 right-0">
            <img src="<?= base_url('assets/img/image-01.png') ?>" alt="Modelo" class="h-64">
        </div>
    </section>

    <!-- Seção de Produtos -->
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Nossos Produtos</h2>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Filtrar por:</span>
                <select class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option>Categorias</option>
                    <option>Roupas</option>
                    <option>Calçados</option>
                    <option>Acessórios</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" x-data>
            <?php foreach($produtos as $produto): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden group transition-transform transform hover:-translate-y-2">
                    <div class="relative">
                        <img class="w-full h-64 object-cover" src="<?= base_url('assets/img/' . htmlspecialchars($produto['foto'])) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <?php if($produto['quantidade'] > 0): ?>
                                <a href="<?= $usuario_logado ? base_url('carrinhoController/adicionarCarrinho/'.$produto['id']) : base_url('usuarioController/login') ?>" class="text-white bg-primary px-4 py-2 rounded-md">Adicionar ao Carrinho</a>
                            <?php else: ?>
                                <span class="text-white bg-red-500 px-4 py-2 rounded-md">Indisponível</span>
                            <?php endif; ?>
                        </div>
                        <?php if($is_adm): ?>
                            <div class="absolute top-2 right-2 flex space-x-2">
                                <a href="javascript:goDelete(<?= $produto['id']?>)" class="bg-red-500 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center hover:bg-red-600"><i class="bi bi-trash3"></i></a>
                                <button @click="$dispatch('open-modal', { id: 'edit-product-<?= $produto['id'] ?>' })" class="bg-yellow-500 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center hover:bg-yellow-600"><i class="bi bi-pencil"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 truncate"><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p class="text-gray-500 text-sm mb-2"><?= htmlspecialchars($produto['descricao']) ?></p>
                        <div class="flex justify-between items-center">
                            <p class="text-xl font-bold text-primary">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
                            <p class="text-sm text-gray-600">Estoque: <?= $produto['quantidade'] ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<!-- Carrega os Modais de Edição -->
<?php
if ($is_adm) {
    // Supondo que $categorias está disponível. Se não, precisa ser carregado no controller.
    $CI =& get_instance();
    $CI->load->model('categoria_model');
    $categorias = $CI->categoria_model->getAll();

    foreach($produtos as $produto) {
        $this->load->view('pages/atualizarProdutos', ['produto' => $produto, 'categorias' => $categorias]);
    }
}
?>

<script>
    function goDelete(id){
        if(confirm('Deseja realmente apagar este produto?')){
            window.location.href = `<?= base_url('ProdutoController/deletar/') ?>${id}`;
        }
    }
</script>

