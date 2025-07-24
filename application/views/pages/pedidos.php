<?php if ($this->session->flashdata('success')) : ?>
    <div class="absolute top-20 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg animate-fade-out">
        <?= $this->session->flashdata('success') ?>
    </div>
<?php endif; ?>

<div x-data="{
    showDeleteModal: false,
    pedidoToDelete: null,
    pedidos: <?= htmlspecialchars(json_encode($pedidos), ENT_QUOTES, 'UTF-8') ?>
}">
    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <div>
                <h2 class="text-2xl font-semibold leading-tight"><?= $title ?></h2>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Cód. Pedido
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Data
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Valor
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="pedido in pedidos" :key="pedido.id">
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap" x-text="pedido.id"></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <span class="relative inline-block px-3 py-1 font-semibold leading-tight" :class="{ 'text-green-900': pedido.status.toLowerCase() === 'entregue', 'text-yellow-900': pedido.status.toLowerCase() === 'processando', 'text-red-900': pedido.status.toLowerCase() === 'cancelado' }">
                                            <span aria-hidden class="absolute inset-0 opacity-50 rounded-full" :class="{ 'bg-green-200': pedido.status.toLowerCase() === 'entregue', 'bg-yellow-200': pedido.status.toLowerCase() === 'processando', 'bg-red-200': pedido.status.toLowerCase() === 'cancelado' }"></span>
                                            <span class="relative" x-text="pedido.status"></span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap" x-text="new Date(pedido.data_entrega).toLocaleDateString('pt-BR')"></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap" x-text="new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(pedido.valor)"></p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a :href="'<?= base_url() ?>index.php/pedidosController/visualizarProdutos/' + pedido.id" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="bi bi-eye-fill"></i> Visualizar
                                        </a>
                                        <button @click="showDeleteModal = true; pedidoToDelete = pedido.id" class="text-red-600 hover:text-red-900 ml-4">
                                            <i class="bi bi-trash-fill"></i> Deletar
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Deletar Pedido</h3>
                            <p class="text-sm text-gray-500 mt-2">
                                Você tem certeza que quer deletar este pedido? Esta ação não pode ser desfeita.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a :href="'<?= base_url() ?>index.php/pedidosController/deletar/' + pedidoToDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm">Deletar</a>
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
