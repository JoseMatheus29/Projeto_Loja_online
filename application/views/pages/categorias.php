
<?php if ($this->session->flashdata('success')) : ?>
    <div class="absolute top-20 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg animate-fade-out">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')) : ?>
    <div class="absolute top-20 right-5 bg-red-500 text-white p-4 rounded-lg shadow-lg animate-fade-out">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<div x-data="{
    showAddModal: false,
    showEditModal: false,
    showDeleteModal: false,
    categoriaToDelete: null,
    categoriaToEdit: { id: '', nome: '', descricao: '', status: 1 },
    categorias: <?= htmlspecialchars(json_encode($categorias), ENT_QUOTES, 'UTF-8') ?>
}">
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight">Gerenciamento de Categorias</h2>
            </div>
            <div class="my-2 flex sm:flex-row flex-col">
                <div class="block relative">
                    <button @click="showAddModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Nova Categoria
                    </button>
                </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Descrição
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="categoria in categorias" :key="categoria.id">
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap" x-text="categoria.nome"></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap" x-text="categoria.descricao"></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span :class="categoria.status == 1 ? 'text-green-600' : 'text-red-600'" x-text="categoria.status == 1 ? 'Ativa' : 'Inativa'"></span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <button @click="showEditModal = true; categoriaToEdit = { ...categoria }" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                                        <button @click="showDeleteModal = true; categoriaToDelete = categoria.id" class="text-red-600 hover:text-red-900 ml-4">Deletar</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Categoria -->
    <div x-show="showAddModal" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <form action="<?= base_url('index.php/CategoriaController/inserir') ?>" method="post">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Nova Categoria</h3>
                        <div class="mt-2">
                            <div class="mb-4">
                                <label for="nome" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                <input type="text" name="nome" id="nome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="mb-4">
                                <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                                <textarea name="descricao" id="descricao" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                    <option value="1">Ativa</option>
                                    <option value="0">Inativa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Salvar</button>
                        <button @click="showAddModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Categoria -->
    <div x-show="showEditModal" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <form :action="'<?= base_url('index.php/CategoriaController/atualizar/') ?>' + categoriaToEdit.id" method="post">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Categoria</h3>
                        <div class="mt-2">
                            <input type="hidden" name="id" x-model="categoriaToEdit.id">
                            <div class="mb-4">
                                <label for="edit_nome" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                <input type="text" name="nome" id="edit_nome" x-model="categoriaToEdit.nome" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_descricao" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
                                <textarea name="descricao" id="edit_descricao" x-model="categoriaToEdit.descricao" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="edit_status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <select name="status" id="edit_status" x-model="categoriaToEdit.status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                    <option value="1">Ativa</option>
                                    <option value="0">Inativa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Atualizar</button>
                        <button @click="showEditModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Deleção -->
    <div x-show="showDeleteModal" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Deletar Categoria</h3>
                            <p class="text-sm text-gray-500 mt-2">
                                Você tem certeza que quer deletar esta categoria? Produtos associados a ela não serão deletados, mas ficarão sem categoria.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a :href="'<?= base_url() ?>index.php/CategoriaController/excluir/' + categoriaToDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Deletar</a>
                    <button @click="showDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-out {
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
            display: none;
        }
    }
</style>

