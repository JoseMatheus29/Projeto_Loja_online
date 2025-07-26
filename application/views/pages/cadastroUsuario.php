<div class="min-h-screen bg-gray-50 flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Cadastro de Usuário
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Ou <a href="<?= base_url() ?>usuarioController/login" class="font-medium text-indigo-600 hover:text-indigo-500">faça login</a> se já possui uma conta
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <button onclick="document.getElementById('modalUsuario').classList.remove('hidden')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
            Novo Usuário
        </button>

        <!-- Modal -->
        <div id="modalUsuario" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg w-full p-8 relative">
                    <button onclick="document.getElementById('modalUsuario').classList.add('hidden')" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
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
    </div>
</div>

