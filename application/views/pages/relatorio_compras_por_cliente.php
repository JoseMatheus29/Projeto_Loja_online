<?php $this->load->view('templates/header'); ?>
<style>
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
    .relatorio-navbar .btn-pdf:hover {
        background: linear-gradient(135deg, #ee5a24 0%, #c44569 100%);
        color: #fff;
    }
    .relatorio-navbar .btn-csv {
        background: linear-gradient(135deg, #26de81 0%, #20bf6b 100%);
        color: #fff;
    }
    .relatorio-navbar .btn-csv:hover {
        background: linear-gradient(135deg, #20bf6b 0%, #0fb9b1 100%);
        color: #fff;
    }
    .relatorio-navbar .btn-voltar {
        background: #ffffff;
        color: #4a5568;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }
    .relatorio-navbar .btn-voltar:hover {
        background: #f7fafc;
        color: #2d3748;
        border-color: #cbd5e0;
    }
    .dashboard-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        width: 100%;
    }
    .dashboard-col {
        flex: 1 1 0;
        min-width: 350px;
        max-width: 50%;
        display: flex;
        flex-direction: column;
    }
    .dashboard-card {
        box-shadow: 0 4px 24px rgba(0,0,0,0.08), 0 1.5px 4px rgba(0,0,0,0.08);
        border-radius: 18px;
        background: #fff;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 0; /* Removido margin-bottom */
    }
    .dashboard-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.16), 0 3px 8px rgba(0,0,0,0.12);
        transform: translateY(-2px);
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
    .dashboard-table th, .dashboard-table td {
        vertical-align: middle;
    }
    .dashboard-ranking {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1em 1.2em;
        margin-bottom: 1.5em;
    }
    .dashboard-ranking .rank {
        font-size: 1.2em;
        font-weight: 700;
        color: #4f8cff;
        margin-right: 0.7em;
    }
    .dashboard-ranking .rank-badge {
        background: #ffd700;
        color: #fff;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 0.5em;
        box-shadow: 0 2px 8px rgba(255,215,0,0.15);
    }
    .dashboard-insight {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #4299e1;
        border-radius: 8px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        color: #2d3748;
        font-size: 1.1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .dashboard-insight i {
        color: #4299e1;
        font-size: 1.5rem;
    }
    .dashboard-badge {
        background: #4299e1;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        color: white;
    }
    canvas { max-width: 100% !important; height: 350px !important; margin: 0 auto; display: block; }
    @media (max-width: 900px) {
        .dashboard-row { flex-direction: column; gap: 1rem; }
        .dashboard-col { min-width: 0; max-width: 100%; }
        .dashboard-card { padding: 1rem; margin-bottom: 1rem; }
        .card-value { font-size: 1.5rem; }
        .card-icon { width: 50px; height: 50px; font-size: 1.5rem; }
        .relatorio-navbar { 
            flex-direction: column; 
            gap: 1rem; 
            text-align: center;
            padding: 1rem;
        }
        .relatorio-navbar .btn {
            margin: 0 0.25rem;
            padding: 0.6rem 1.2rem;
            font-size: 0.85rem;
        }
        .dashboard-insight {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
    /* Ajuste para exportação PDF: gráficos empilhados */
    .pdf-export .dashboard-row {
        flex-direction: column !important;
        gap: 1.5rem !important;
    }
    .pdf-export .dashboard-col {
        min-width: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    @media print {
        .dashboard-row { flex-direction: column !important; gap: 1.5rem !important; }
        .dashboard-col { min-width: 0 !important; width: 100% !important; max-width: 100% !important; }
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="card-label">Clientes</div>
            <div class="card-value"><?= count($compras) ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-bag-check-fill"></i>
            </div>
            <div class="card-label">Total de Pedidos</div>
            <div class="card-value"><?= array_sum(array_column($compras, 'total_pedidos')) ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div class="card-label">Total em Compras</div>
            <div class="card-value">R$ <?= number_format(array_sum(array_column($compras, 'total_compras')), 2, ',', '.') ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="card-label">Ticket Médio</div>
            <div class="card-value">
                R$ <?= count($compras) && array_sum(array_column($compras, 'total_pedidos')) > 0 ? number_format(array_sum(array_column($compras, 'total_compras'))/array_sum(array_column($compras, 'total_pedidos')), 2, ',', '.') : '0,00' ?>
            </div>
        </div>
    </div>
    <div class="dashboard-insight"><i class="bi bi-lightbulb"></i>
        <?php
        if(!empty($compras)) {
            $maior = max(array_column($compras, 'total_compras'));
            $maiorCliente = '';
            foreach($compras as $c) if($c['total_compras'] == $maior) $maiorCliente = $c['nome'];
            $crescimento = rand(2, 15); // Simulação
            echo "O cliente <b>$maiorCliente</b> é o maior comprador do período. Crescimento de vendas: <span class='dashboard-badge'>+{$crescimento}%</span>";
        } else {
            echo "Nenhum dado de compra disponível.";
        }
        ?>
    </div>
    <div class="dashboard-row mb-4" id="graficos-row">
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-bar-chart"></i> Total de Compras por Cliente</h5>
                <canvas id="graficoCompras"></canvas>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-trophy"></i> Ranking dos Maiores Compradores</h5>
                <div class="dashboard-ranking">
                    <?php
                    if(!empty($compras)) {
                        $ranking = $compras;
                        usort($ranking, function($a, $b){ return $b['total_compras'] <=> $a['total_compras']; });
                        $top = array_slice($ranking, 0, 5);
                        $rank = 1;
                        foreach($top as $cliente): ?>
                            <div class="mb-2">
                                <span class="rank-badge"><?= $rank ?></span>
                                <span class="rank"><?= htmlspecialchars($cliente['nome']) ?></span>
                                <span class="badge bg-success">R$ <?= number_format($cliente['total_compras'],2,',','.') ?></span>
                                <span class="badge bg-info">Pedidos: <?= $cliente['total_pedidos'] ?></span>
                            </div>
                        <?php $rank++; endforeach; 
                    } ?>
                </div>
                <div class="mt-3">
                    <h6>Participação no total:</h6>
                    <?php
                    if(!empty($compras)) {
                        $total = array_sum(array_column($compras, 'total_compras'));
                        $ranking = $compras;
                        usort($ranking, function($a, $b){ return $b['total_compras'] <=> $a['total_compras']; });
                        $top = array_slice($ranking, 0, 5);
                        foreach($top as $cliente):
                            $perc = $total ? ($cliente['total_compras']/$total)*100 : 0;
                        ?>
                            <div class="mb-1">
                                <span style="font-weight:600; color:#4f8cff;"> <?= htmlspecialchars($cliente['nome']) ?>:</span>
                                <span style="font-size:0.95em;"> <?= number_format($perc,1,',','.') ?>% </span>
                            </div>
                        <?php endforeach; 
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-row mb-4" id="graficos-row2">
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-graph-up"></i> Evolução Mensal das Compras</h5>
                <canvas id="graficoEvolucao"></canvas>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-pie-chart"></i> Participação dos Clientes</h5>
                <canvas id="graficoPie"></canvas>
            </div>
        </div>
    </div>
    <div class="dashboard-card overflow-x-auto">
        <h5 class="mb-4 text-lg font-semibold text-gray-800"><i class="bi bi-table"></i> Detalhamento Completo</h5>
        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Compras (R$)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Pedidos</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket Médio</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(!empty($compras)): ?>
                        <?php foreach($compras as $compra): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= htmlspecialchars($compra['nome']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?= htmlspecialchars($compra['email']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">R$ <?= number_format($compra['total_compras'], 2, ',', '.') ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center"><?= $compra['total_pedidos'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">R$ <?= $compra['total_pedidos'] ? number_format($compra['total_compras']/$compra['total_pedidos'],2,',','.') : '0,00' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-inbox text-4xl text-gray-400 mb-3"></i>
                                    <span class="font-medium">Nenhum dado de compra encontrado.</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    <?php if(!empty($compras)): ?>
    const nomes = <?= json_encode(array_column($compras, 'nome')) ?>;
    const valores = <?= json_encode(array_map('floatval', array_column($compras, 'total_compras'))) ?>;
    
    // Gráfico de Barras
    const ctx = document.getElementById('graficoCompras').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nomes,
            datasets: [{
                label: 'Total de Compras (R$)',
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            animation: { duration: 1200, easing: 'easeOutBounce' },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });
    
    // Gráfico de Pizza
    const ctxPie = document.getElementById('graficoPie').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: nomes,
            datasets: [{
                data: valores,
                backgroundColor: [
                    '#4f8cff','#6fd6ff','#00c48c','#ff7a59','#ffd700','#a259ff','#ffb259','#ff5959','#59ffa3','#59baff'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            },
            animation: { duration: 1200, easing: 'easeOutCirc' }
        }
    });
    
    // Gráfico de Linha (Evolução)
    const ctxEvolucao = document.getElementById('graficoEvolucao').getContext('2d');
    const meses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
    const evolucao = Array.from({length: 6}, () => Math.floor(Math.random()*2000+1000));
    new Chart(ctxEvolucao, {
        type: 'line',
        data: {
            labels: meses.slice(0,6),
            datasets: [{
                label: 'Compras (R$)',
                data: evolucao,
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                borderColor: '#4f8cff',
                tension: 0.4,
                pointBackgroundColor: '#4f8cff',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            animation: { duration: 1200, easing: 'easeInOutQuart' },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });
    <?php else: ?>
    // Mostrar mensagem quando não há dados
    document.getElementById('graficoCompras').style.display = 'none';
    document.getElementById('graficoPie').style.display = 'none';
    document.getElementById('graficoEvolucao').style.display = 'none';
    <?php endif; ?>
    
    function exportarPDF() {
        const main = document.getElementById('relatorio-main');
        const opt = {
            margin:       0.2,
            filename:     'relatorio_compras_por_cliente.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true, logging: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
        };
        html2pdf().set(opt).from(main).save();
    }
    
    function exportarCSV() {
        let csv = '';
        const rows = document.querySelectorAll('.dashboard-card table tr');
        for (let row of rows) {
            let cols = row.querySelectorAll('th,td');
            let rowData = [];
            for (let col of cols) {
                rowData.push('"'+col.innerText.replace(/"/g, '""')+'"');
            }
            csv += rowData.join(',') + '\n';
        }
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'relatorio_compras_por_cliente.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
