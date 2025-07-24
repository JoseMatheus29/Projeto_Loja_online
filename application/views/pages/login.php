<main class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
        <!-- Cabeçalho -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Bem-vindo de volta!</h1>
            <p class="mt-2 text-sm text-gray-600">Faça login para continuar suas compras.</p>
        </div>

        <!-- Formulário de Login -->
        <form action="<?= base_url('usuarioController/logar') ?>" method="post" class="space-y-6">
            <!-- Campo de Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="seu.email@exemplo.com">
                </div>
            </div>

            <!-- Campo de Senha -->
            <div>
                <label for="senha" class="block text-sm font-medium text-gray-700">Senha</label>
                <div class="mt-1">
                    <input id="senha" name="senha" type="password" autocomplete="current-password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                           placeholder="Sua senha">
                </div>
            </div>

            <!-- Opções (Lembrar-me e Esqueceu a senha) -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">Lembrar-me</label>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-primary hover:text-primary-hover">Esqueceu sua senha?</a>
                </div>
            </div>

            <!-- Botão de Envio -->
            <div>
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Entrar
                </button>
            </div>
        </form>

        <!-- Mensagem de Erro -->
        <?php if ($this->session->flashdata('category_error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline">Usuário ou senha inválido.</span>
            </div>
        <?php endif; ?>

        <!-- Link para Cadastro -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Não tem uma conta?
            <a href="<?= base_url('usuarioController/cadastrarUsuario') ?>" class="font-medium text-primary hover:text-primary-hover">
                Cadastre-se aqui
            </a>
        </p>
    </div>
</main>
  </div>
</div>
