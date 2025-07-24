<?php $this->load->view('templates/header'); ?>
<style>
    canvas {
        max-width: 100% !important;
        height: 350px !important;
        margin: 0 auto;
        display: block;
    }
    .relatorio-navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f8fafc;
        border-radius: 14px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(79,140,255,0.07);
    }
    .relatorio-navbar .btn {
        margin-left: 0.5rem;
        font-weight: 600;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: none;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .relatorio-navbar .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    .relatorio-navbar .btn-pdf {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: #fff;
    }
    .relatorio-navbar .btn-csv {
        background: linear-gradient(135deg, #26de81 0%, #20bf6b 100%);
        color: #fff;
    }
    .relatorio-navbar .btn-voltar {
        background: #ffffff;
        color: #4a5568;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }
    .dashboard-card {
        box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.08);
        border-radius: 18px;
        background: #fff;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 1.5rem;
    }
    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.8rem;
    }
    .card-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0.5rem 0;
    }
    .card-label {
        font-size: 0.9rem;
        color: #718096;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="relatorio-navbar">
    <div>
        <a href="javascript:history.back()" class="btn btn-voltar"><i class="bi bi-arrow-left"></i> Voltar</a>
    </div>
    <div>
        <button class="btn btn-pdf" onclick="exportarPDF()"><i class="bi bi-file-earmark-pdf"></i> Exportar PDF</button>
        <button class="btn btn-csv" onclick="exportarCSV()"><i class="bi bi-file-earmark-spreadsheet"></i> Exportar CSV</button>
    </div>
</div>

<main class="container-fluid px-4" id="relatorio-main">
    <?php
        $totalProdutos = count($produtos);
        $categoriasAfetadas = count(array_unique(array_column($produtos, 'categoria_nome')));
        
        // Garante que a chave 'preco' exista, caso contrário, usa 0.
        $valorTotalPerdido = array_sum(array_map(function($p) {
            return $p['preco'] ?? 0;
        }, $produtos));

        // Lógica para Categoria Mais Crítica
        $produtosPorCategoriaContagem = [];
        if (!empty($produtos)) {
            foreach ($produtos as $p) {
                $categoria = $p['categoria_nome'] ?? 'Sem Categoria';
                if (!isset($produtosPorCategoriaContagem[$categoria])) {
                    $produtosPorCategoriaContagem[$categoria] = 0;
                }
                $produtosPorCategoriaContagem[$categoria]++;
            }
            arsort($produtosPorCategoriaContagem);
            $categoriaMaisCritica = key($produtosPorCategoriaContagem);
        } else {
            $categoriaMaisCritica = 'N/A';
        }

        // Lógica para Top 5 Produtos Mais Caros em Falta
        $produtosCaros = [];
        if (!empty($produtos)) {
            $produtosCaros = $produtos;
            usort($produtosCaros, function($a, $b) {
                return ($b['preco'] ?? 0) <=> ($a['preco'] ?? 0);
            });
            $produtosCaros = array_slice($produtosCaros, 0, 5);
        }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%); color: white;">
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <div class="card-label">Produtos em Falta</div>
            <div class="card-value"><?= $totalProdutos ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="bi bi-tags-fill"></i>
            </div>
            <div class="card-label">Categorias Afetadas</div>
            <div class="card-value"><?= $categoriasAfetadas ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="card-label">Valor de Custo Parado</div>
            <div class="card-value">R$ <?= number_format($valorTotalPerdido, 2, ',', '.') ?></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-bar-chart-line-fill"></i> Produtos por Categoria</h5>
            <canvas id="graficoCategorias"></canvas>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-pie-chart-fill"></i> Distribuição de Valor por Categoria</h5>
            <canvas id="graficoValorCategoria"></canvas>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-exclamation-triangle-fill text-amber-500"></i> Categoria Mais Crítica</h5>
            <div class="text-center py-4">
                <div class="card-icon mx-auto bg-amber-100 text-amber-600">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <div class="card-label mt-3">Categoria com mais itens em falta</div>
                <div class="card-value text-amber-700"><?= htmlspecialchars($categoriaMaisCritica) ?></div>
            </div>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-graph-up-arrow text-red-500"></i> Top 5 Produtos Mais Caros em Falta</h5>
            <ul class="divide-y divide-gray-200">
                <?php foreach($produtosCaros as $p): ?>
                <li class="py-2 flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700"><?= htmlspecialchars($p['nome']) ?></span>
                    <span class="text-sm font-bold text-red-600">R$ <?= number_format($p['preco'] ?? 0, 2, ',', '.') ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="dashboard-card overflow-x-auto">
        <h5 class="mb-4 text-lg font-semibold text-gray-800"><i class="bi bi-table"></i> Detalhamento de Produtos em Falta</h5>
        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200" id="tabela-detalhes">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço (R$)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(!empty($produtos)): ?>
                        <?php foreach($produtos as $produto): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="<?= base_url('assets/img/' . htmlspecialchars($produto['foto'])) ?>" class="w-12 h-12 object-cover rounded-lg shadow-sm">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars($produto['nome']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($produto['categoria_nome'] ?? 'Sem Categoria') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">R$ <?= number_format($produto['preco'] ?? 0, 2, ',', '.') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600 text-center"><?= $produto['quantidade'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-check-circle-fill text-4xl text-green-500 mb-3"></i>
                                    <span class="font-medium">Ótima notícia! Nenhum produto em falta no estoque.</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    <?php if(!empty($produtos)): ?>
    // Preparar dados para os gráficos
    <?php
        $produtosPorCategoria = [];
        $valorPorCategoria = [];
        foreach ($produtos as $p) {
            $categoria = $p['categoria_nome'] ?? 'Sem Categoria';
            if (!isset($produtosPorCategoria[$categoria])) {
                $produtosPorCategoria[$categoria] = 0;
                $valorPorCategoria[$categoria] = 0;
            }
            $produtosPorCategoria[$categoria]++;
            $valorPorCategoria[$categoria] += $p['preco'] ?? 0;
        }
    ?>
    const produtosPorCategoriaData = <?= json_encode($produtosPorCategoria) ?>;
    const valorPorCategoriaData = <?= json_encode($valorPorCategoria) ?>;

    const labels = Object.keys(produtosPorCategoriaData);
    const dataProdutos = Object.values(produtosPorCategoriaData);
    const dataValor = Object.values(valorPorCategoriaData);
    const backgroundColors = ['#ff6b6b', '#f093fb', '#4facfe', '#fa709a', '#26de81', '#fee140', '#764ba2', '#ff9a8b'];

    // Gráfico de Barras - Produtos por Categoria
    const ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');
    new Chart(ctxCategorias, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nº de Produtos em Falta',
                data: dataProdutos,
                backgroundColor: 'rgba(255, 107, 107, 0.7)',
                borderColor: 'rgba(255, 107, 107, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    // Gráfico de Pizza - Valor por Categoria
    const ctxValor = document.getElementById('graficoValorCategoria').getContext('2d');
    new Chart(ctxValor, {
        type: 'pie',
        data: {
            labels: Object.keys(valorPorCategoriaData),
            datasets: [{
                data: dataValor,
                backgroundColor: backgroundColors,
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
    <?php endif; ?>

    function exportarPDF() {
        const main = document.getElementById('relatorio-main');
        html2pdf().set({
            margin: 0.2,
            filename: 'relatorio_produtos_em_falta.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).from(main).save();
    }

    function exportarCSV() {
        let csv = 'Produto,Categoria,Preco,Estoque\n';
        const rows = document.querySelectorAll('#tabela-detalhes tbody tr');
        rows.forEach(row => {
            if (row.querySelectorAll('td').length > 1) {
                let rowData = [];
                row.querySelectorAll('td').forEach(col => {
                    rowData.push(`"${col.innerText.replace(/"/g, '""')}"`);
                });
                csv += rowData.join(',') + '\n';
            }
        });
        
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);
        link.setAttribute("href", url);
        link.setAttribute("download", "relatorio_produtos_em_falta.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
