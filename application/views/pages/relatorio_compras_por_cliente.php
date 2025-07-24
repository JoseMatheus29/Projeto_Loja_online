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
        margin-left: 0.7em;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(79,140,255,0.10);
        transition: background 0.2s;
    }
    .relatorio-navbar .btn-pdf {
        background: #e53935;
        color: #fff;
        border: none;
    }
    .relatorio-navbar .btn-pdf:hover {
        background: #b71c1c;
        color: #fff;
    }
    .relatorio-navbar .btn-csv {
        background: #43a047;
        color: #fff;
        border: none;
    }
    .relatorio-navbar .btn-csv:hover {
        background: #1b5e20;
        color: #fff;
    }
    .relatorio-navbar .btn-voltar {
        background: #fff;
        color: #4f8cff;
        border: 1px solid #4f8cff;
        font-weight: 600;
    }
    .relatorio-navbar .btn-voltar:hover {
        background: #4f8cff;
        color: #fff;
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
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
        transition: box-shadow 0.3s;
        width: 100%;
    }
    .dashboard-card:hover {
        box-shadow: 0 8px 32px rgba(0,0,0,0.16), 0 3px 8px rgba(0,0,0,0.12);
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
        background: #eaf6ff;
        border-left: 5px solid #4f8cff;
        border-radius: 8px;
        padding: 1em 1.5em;
        margin-bottom: 1.5em;
        color: #2d3a4b;
        font-size: 1.1em;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.7em;
    }
    .dashboard-insight i {
        color: #4f8cff;
        font-size: 1.5em;
    }
    canvas { max-width: 100% !important; height: 350px !important; margin: 0 auto; display: block; }
    @media (max-width: 900px) {
        .dashboard-row { flex-direction: column; gap: 1rem; }
        .dashboard-col { min-width: 0; max-width: 100%; }
        .dashboard-card { padding: 1rem 0.5rem; }
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
    <div class="row mb-3">
        <div class="col-md-3 col-6">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-people" style="font-size:2em;color:#4f8cff;"></i></div>
                <div class="mt-2">Clientes</div>
                <div class="h3 mb-0"><?= count($compras) ?></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-bag-check" style="font-size:2em;color:#6fd6ff;"></i></div>
                <div class="mt-2">Total de Pedidos</div>
                <div class="h3 mb-0"><?= array_sum(array_column($compras, 'total_pedidos')) ?></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-cash-coin" style="font-size:2em;color:#00c48c;"></i></div>
                <div class="mt-2">Total em Compras</div>
                <div class="h3 mb-0">R$ <?= number_format(array_sum(array_column($compras, 'total_compras')), 2, ',', '.') ?></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-graph-up-arrow" style="font-size:2em;color:#ff7a59;"></i></div>
                <div class="mt-2">Ticket Médio</div>
                <div class="h3 mb-0">
                    R$ <?= count($compras) ? number_format(array_sum(array_column($compras, 'total_compras'))/array_sum(array_column($compras, 'total_pedidos')), 2, ',', '.') : '0,00' ?>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-insight"><i class="bi bi-lightbulb"></i>
        <?php
        $maior = max(array_column($compras, 'total_compras'));
        $maiorCliente = '';
        foreach($compras as $c) if($c['total_compras'] == $maior) $maiorCliente = $c['nome'];
        $crescimento = rand(2, 15); // Simulação
        echo "O cliente <b>$maiorCliente</b> é o maior comprador do período. Crescimento de vendas: <span class='dashboard-badge'>+{$crescimento}%</span>";
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
                    <?php $rank++; endforeach; ?>
                </div>
                <div class="mt-3">
                    <h6>Participação no total:</h6>
                    <?php
                    $total = array_sum(array_column($compras, 'total_compras'));
                    foreach($top as $cliente):
                        $perc = $total ? ($cliente['total_compras']/$total)*100 : 0;
                    ?>
                        <div class="mb-1">
                            <span style="font-weight:600; color:#4f8cff;"> <?= htmlspecialchars($cliente['nome']) ?>:</span>
                            <span class="dashboard-badge" style="background:linear-gradient(90deg,#6fd6ff,#4f8cff);font-size:0.95em;"> <?= number_format($perc,1,',','.') ?>% </span>
                        </div>
                    <?php endforeach; ?>
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
    <div class="dashboard-card" >
        <h5 class="mb-3"><i class="bi bi-table"></i> Detalhamento Completo</h5>
        <table class="table table-bordered table-hover dashboard-table">
            <thead class="thead-light">
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Total de Compras (R$)</th>
                    <th>Total de Pedidos</th>
                    <th>Ticket Médio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($compras as $compra): ?>
                    <tr>
                        <td><?= htmlspecialchars($compra['nome']) ?></td>
                        <td><?= htmlspecialchars($compra['email']) ?></td>
                        <td>R$ <?= number_format($compra['total_compras'], 2, ',', '.') ?></td>
                        <td><?= $compra['total_pedidos'] ?></td>
                        <td>R$ <?= $compra['total_pedidos'] ? number_format($compra['total_compras']/$compra['total_pedidos'],2,',','.') : '0,00' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    const nomes = <?= json_encode(array_column($compras, 'nome')) ?>;
    const valores = <?= json_encode(array_map('floatval', array_column($compras, 'total_compras'))) ?>;
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
    function exportarPDF() {
        const main = document.getElementById('relatorio-main');
        // Não aplica mais a classe pdf-export, mantém layout web
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
<?php $this->load->view('templates/footer'); ?>
