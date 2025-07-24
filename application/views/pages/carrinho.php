<div x-data="{}" class="container mx-auto px-4 sm:px-8 py-8">
    <h2 class="text-2xl font-semibold leading-tight mb-6">Meu Carrinho</h2>

    <!-- Alertas -->
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= $this->session->flashdata('success') ?></p>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('danger')) : ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p><?= $this->session->flashdata('danger') ?></p>
        </div>
    <?php endif; ?>

    <?php if (empty($produtos_carrinho)) : ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
            <p class="font-bold">Seu carrinho está vazio</p>
            <p>Adicione produtos à sua cesta para vê-los aqui.</p>
        </div>
        <div class="mt-6">
            <a href="<?= base_url() ?>" class="bg-primary text-white px-6 py-3 rounded-md hover:bg-primary-hover transition">
                Continuar Comprando
            </a>
        </div>
    <?php else : ?>
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Lista de Produtos -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Produto
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Quantidade
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Subtotal
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ação
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos_carrinho as $produto) : ?>
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-20 h-20">
                                                <img class="w-full h-full object-cover rounded" src="<?= base_url() ?>assets/img/<?= $produto['foto'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-gray-900 font-semibold whitespace-no-wrap"><?= htmlspecialchars($produto['nome']) ?></p>
                                                <p class="text-gray-600 whitespace-no-wrap">R$ <?= number_format($produto['valor'], 2, ',', '.') ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        <p class="text-gray-900 whitespace-no-wrap"><?= $produto['quantidade_carrinho'] ?></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <p class="text-gray-900 font-semibold whitespace-no-wrap">R$ <?= number_format($produto['subtotal'], 2, ',', '.') ?></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right">
                                        <a href="<?= base_url('index.php/carrinhoController/deletarProdutoCarrinho/' . $produto['id']) ?>" class="text-red-500 hover:text-red-700 transition">
                                            <i class="bi bi-trash-fill text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Resumo do Pedido -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-lg font-semibold border-b pb-4">Resumo do Pedido</h3>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">R$ <?= number_format($valor_total, 2, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-gray-600">Frete</span>
                        <span class="font-semibold">Grátis</span>
                    </div>
                    <div class="border-t mt-4 pt-4">
                        <div class="flex justify-between items-center font-bold text-lg">
                            <span>Total</span>
                            <span>R$ <?= number_format($valor_total, 2, ',', '.') ?></span>
                        </div>
                    </div>

                    <form action="<?= base_url('index.php/carrinhoController/finalizar') ?>" method="POST" class="mt-6">
                        <input type="hidden" name="ids_produtos" value="<?= $ids_produtos_string ?>">
                        <input type="hidden" name="valor_total" value="<?= $valor_total ?>">
                        <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-600 transition">
                            Finalizar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>