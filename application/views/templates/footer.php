</div> <!-- Fechamento do #app -->

<footer class="bg-gray-800 text-white mt-auto">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Sobre -->
            <div>
                <h3 class="text-lg font-semibold mb-4">LojaOnline</h3>
                <p class="text-gray-400">Sua loja de moda com as últimas tendências e os melhores preços.</p>
            </div>
            <!-- Links Rápidos -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Links Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="<?= base_url() ?>" class="text-gray-400 hover:text-white">Home</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Produtos</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Sobre Nós</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white">Contato</a></li>
                </ul>
            </div>
            <!-- Atendimento -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Atendimento</h3>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="bi bi-telephone-fill mr-2"></i> (99) 99999-9999</li>
                    <li><i class="bi bi-envelope-fill mr-2"></i> contato@lojaonline.com</li>
                    <li><i class="bi bi-geo-alt-fill mr-2"></i> Rua Fictícia, 123, Cidade, BR</li>
                </ul>
            </div>
            <!-- Redes Sociais -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Siga-nos</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-500">
            <p>Desenvolvido por <a href="https://www.linkedin.com/in/jos%C3%A9-matheus-de-lima-27706a1b6/" target="_blank" class="hover:text-white">José Matheus</a> &copy; <?= date('Y') ?></p>
        </div>
    </div>
</footer>

</body>
</html>

