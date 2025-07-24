<?php   
    
    if (isset($_SESSION['usuario_logado'])){
        $usuario_logado = $_SESSION['usuario_logado'];
    }else{
        $usuario_logado['tipo'] = "cliente";
    }

?>


<?php foreach($produtos as $produto):?>
<!-- Modal de Edição de Produto -->
<div 
    x-data="{ open: false }" 
    x-show="open"
    @open-modal.window="if ($event.detail.id === 'edit-product-<?= $produto['id'] ?>') open = true"
    x-on:keydown.escape.window="open = false"
    style="display: none;"
    class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center"
>
    <div @click.away="open = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl max-h-screen overflow-y-auto">
        <!-- Cabeçalho do Modal -->
        <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-2xl font-semibold">Editar Produto</h3>
            <button @click="open = false" class="text-gray-500 hover:text-gray-800">&times;</button>
        </div>

        <!-- Corpo do Modal (Formulário) -->
        <form action="<?= base_url('ProdutoController/atualizar/' . $produto['id']) ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Coluna da Imagem -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto do Produto</label>
                    <img class="w-full h-64 object-cover rounded-md mb-4" src="<?= base_url('assets/img/' . htmlspecialchars($produto['foto'])) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    <input type="file" name="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                </div>

                <!-- Coluna dos Campos -->
                <div class="space-y-4">
                    <div>
                        <label for="nome-<?= $produto['id'] ?>" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" id="nome-<?= $produto['id'] ?>" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="categoria-<?= $produto['id'] ?>" class="block text-sm font-medium text-gray-700">Categoria</label>
                        <select id="categoria-<?= $produto['id'] ?>" name="categoria_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <?php 
                            // Supondo que $categorias está disponível. Se não, precisará ser carregado.
                            // $categorias = $this->db->get('categorias')->result_array();
                            foreach($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($produto['categoria_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="valor-<?= $produto['id'] ?>" class="block text-sm font-medium text-gray-700">Valor (R$)</label>
                            <input type="text" id="valor-<?= $produto['id'] ?>" name="valor" value="<?= number_format($produto['valor'], 2, ',', '.') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="quantidade-<?= $produto['id'] ?>" class="block text-sm font-medium text-gray-700">Estoque</label>
                            <input type="number" id="quantidade-<?= $produto['id'] ?>" name="quantidade" value="<?= $produto['quantidade'] ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="descricao-<?= $produto['id'] ?>" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea id="descricao-<?= $produto['id'] ?>" name="descricao" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Rodapé do Modal -->
            <div class="flex justify-end space-x-4 mt-6 border-t pt-4">
                <button type="button" @click="open = false" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-hover">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach?>