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
    @media (max-width: 900px) {
        .dashboard-row { flex-direction: column; gap: 1rem; }
        .dashboard-col { min-width: 0; max-width: 100%; }
    }
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
    .dashboard-title {
        font-weight: 700;
        font-size: 2.1rem;
        color: #2d3a4b;
        margin-bottom: 0.5rem;
    }
    .dashboard-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
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
    .dashboard-table th, .dashboard-table td {
        vertical-align: middle;
    }
    @media (max-width: 900px) {
        .dashboard-title { font-size: 1.3rem; }
        .dashboard-card { padding: 1rem 0.5rem; }
    }
    canvas { max-width: 100% !important; height: 350px !important; margin: 0 auto; display: block; }
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
<main class="container-fluid px-4" id="relatorio-main-valor">
    <div class="dashboard-title mt-4 mb-1">Relatórios &gt; Valor Recebido por Dia</div>
    <div class="dashboard-subtitle">Veja a evolução diária das vendas, melhores dias, médias e tendências.</div>
    <div class="dashboard-row mb-4">
        <div class="dashboard-col">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-calendar-event" style="font-size:2em;color:#4f8cff;"></i></div>
                <div class="mt-2">Dias de Venda</div>
                <div class="h3 mb-0"><?= count($valores) ?></div>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-cash-coin" style="font-size:2em;color:#00c48c;"></i></div>
                <div class="mt-2">Total Recebido</div>
                <div class="h3 mb-0">R$ <?= number_format(array_sum(array_column($valores, 'total_valor')), 2, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="dashboard-row mb-4">
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-graph-up"></i> Evolução Diária das Vendas</h5>
                <canvas id="graficoLinha"></canvas>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-bar-chart"></i> Vendas por Dia</h5>
                <canvas id="graficoBarra"></canvas>
            </div>
        </div>
    </div>
    <div class="dashboard-card" style="margin-top: 3rem;">
        <h5 class="mb-3"><i class="bi bi-table"></i> Detalhamento Completo</h5>
        <table class="table table-bordered table-hover dashboard-table">
            <thead class="thead-light">
                <tr>
                    <th>Data</th>
                    <th>Total de Pedidos</th>
                    <th>Valor Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($valores as $valor): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($valor['data'])) ?></td>
                        <td><?= $valor['total_pedidos'] ?></td>
                        <td>R$ <?= number_format($valor['total_valor'], 2, ',', '.') ?></td>
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
    // Gráfico de linha - Evolução diária das vendas
    const datas = <?= json_encode(array_map(function($v){ return date('d/m', strtotime($v['data'])); }, $valores)) ?>;
    const valoresDia = <?= json_encode(array_map('floatval', array_column($valores, 'total_valor'))) ?>;
    const ctxLinha = document.getElementById('graficoLinha').getContext('2d');
    new Chart(ctxLinha, {
        type: 'line',
        data: {
            labels: datas,
            datasets: [{
                label: 'Valor Recebido (R$)',
                data: valoresDia,
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
    // Gráfico de barras - Vendas por dia
    const ctxBarra = document.getElementById('graficoBarra').getContext('2d');
    new Chart(ctxBarra, {
        type: 'bar',
        data: {
            labels: datas,
            datasets: [{
                label: 'Valor Recebido (R$)',
                data: valoresDia,
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
    function exportarPDF() {
        const main = document.getElementById('relatorio-main-valor');
        const opt = {
            margin:       0.2,
            filename:     'relatorio_valor_por_dia.pdf',
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
        a.download = 'relatorio_valor_por_dia.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
<?php $this->load->view('templates/footer'); ?>
