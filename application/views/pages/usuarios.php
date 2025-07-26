<div class="container mx-auto px-4 sm:px-8 py-8" x-data="{ openCreateModal: false, openEditModal: false, userToEdit: {} }">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Usuários</h2>
        </div>

        <?php if ($this->session->flashdata('delete_error')) : ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline"><?= $this->session->flashdata('delete_error') ?></span>
                <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Fechar</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        <?php endif; ?>

        <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0">
                <button @click="openCreateModal = true" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Novo Usuário
                </button>
            </div>
        </div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Nome
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Telefone
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Pedidos
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?= $usuario["user_id"] ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?= $usuario["nome"] ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?= $usuario["email"] ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"><?= $usuario["telefone"] ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative"><?= $usuario["tipo"] ?></span>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <?php
                                    $resultadoPedidos = array();
                                    foreach ($pedidos as $pedido) {
                                        if ($pedido['id_usuario'] == $usuario["user_id"]) {
                                            array_push($resultadoPedidos, $pedido['id']);
                                        }
                                    }
                                    $idPedidos = implode(', ', $resultadoPedidos);
                                    echo !empty($idPedidos) ? $idPedidos : 'N/A';
                                    ?>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <button @click="userToEdit = <?= htmlspecialchars(json_encode($usuario), ENT_QUOTES, 'UTF-8') ?>; openEditModal = true" class="text-indigo-600 hover:text-indigo-900 mr-5">
                                        Editar
                                    </button>
                                    <a href="javascript:goDelete(<?= $usuario['user_id'] ?>)" class="text-red-600 hover:text-red-900">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Cadastro de Usuário -->
    <div x-show="openCreateModal" class="fixed z-10 inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-8 relative">
                <button @click="openCreateModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Cadastrar Novo Usuário</h3>
                <form action="<?= base_url() ?>UsuarioController/novoUsuario" method="post" class="space-y-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                        <div class="mt-1">
                            <input id="nome" name="nome" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Seu nome completo">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="seu@email.com">
                        </div>
                    </div>
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                        <div class="mt-1">
                            <input id="telefone" name="telefone" type="tel" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700">Senha</label>
                        <div class="mt-1">
                            <input id="senha" name="senha" type="password" autocomplete="new-password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Crie uma senha forte">
                        </div>
                    </div>
                    <?php if (isset($usuario_logado['tipo']) && $usuario_logado['tipo'] == 'adm'): ?>
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Usuário</label>
                            <select id="tipo" name="tipo" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="cliente" selected>Cliente</option>
                                <option value="adm">Administrador</option>
                                <option value="estoquista">Estoquista</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cadastrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal para Edição de Usuário -->
    <?php $this->load->view('pages/atualizarUsuarios'); ?>
</div>

<script>
    function showToast(message, type = 'success') {
        // Remove toast anterior se existir
        const oldToast = document.getElementById('custom-toast');
        if (oldToast) oldToast.remove();
        // Cria novo toast
        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.className = `fixed top-5 right-5 z-50 px-6 py-4 rounded shadow-lg text-white font-bold ${type === 'error' ? 'bg-red-600' : 'bg-green-600'}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => { toast.remove(); }, 4000);
    }
    function goDelete(id) {
        var myUrl = '<?= base_url("usuarioController/deletarUsuario") ?>/' + id;
        if (confirm('Deseja realmente apagar esse registro?')) {
            // Ajax para não redirecionar
            fetch(myUrl, { method: 'GET', credentials: 'same-origin' })
                .then(response => response.text())
                .then(html => {
                    if (html.includes('showToast')) {
                        eval(html);
                    } else {
                        showToast('Usuário excluído com sucesso.');
                        setTimeout(() => { location.reload(); }, 1200);
                    }
                });
        } else {
            showToast("Registro não alterado", 'error');
            return false;
        }
    }
</script>

