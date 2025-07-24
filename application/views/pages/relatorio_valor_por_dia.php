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

<main class="container-fluid px-4" id="relatorio-main">
    <?php
        $totalArrecadado = array_sum(array_column($valores, 'total_valor'));
        $totalPedidos = array_sum(array_column($valores, 'total_pedidos'));
        $ticketMedio = $totalPedidos > 0 ? $totalArrecadado / $totalPedidos : 0;
        $diaMaiorFaturamento = 'N/A';
        $maiorValor = 0;
        if (!empty($valores)) {
            $maiorValorRow = max(array_map(function($item) {
                return $item['total_valor'];
            }, $valores));
            $key = array_search($maiorValorRow, array_column($valores, 'total_valor'));
            $diaMaiorFaturamento = date('d/m/Y', strtotime($valores[$key]['data']));
            $maiorValor = $valores[$key]['total_valor'];
        }
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #26de81 0%, #20bf6b 100%); color: white;">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="card-label">Total Arrecadado</div>
            <div class="card-value">R$ <?= number_format($totalArrecadado, 2, ',', '.') ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <i class="bi bi-bag-check-fill"></i>
            </div>
            <div class="card-label">Total de Pedidos</div>
            <div class="card-value"><?= $totalPedidos ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div class="card-label">Ticket Médio</div>
            <div class="card-value">R$ <?= number_format($ticketMedio, 2, ',', '.') ?></div>
        </div>
        <div class="dashboard-card text-center">
            <div class="card-icon mx-auto" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <i class="bi bi-calendar-star-fill"></i>
            </div>
            <div class="card-label">Dia de Pico</div>
            <div class="card-value" style="font-size: 1.5rem;"><?= $diaMaiorFaturamento ?></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-graph-up"></i> Evolução do Faturamento Diário</h5>
            <canvas id="graficoEvolucao"></canvas>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-pie-chart"></i> Distribuição de Faturamento</h5>
            <canvas id="graficoDistribuicao"></canvas>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-bar-chart-line-fill"></i> Evolução de Pedidos</h5>
            <canvas id="graficoPedidos"></canvas>
        </div>
        <div class="dashboard-card">
            <h5 class="mb-3 font-semibold text-gray-800"><i class="bi bi-receipt-cutoff"></i> Ticket Médio por Dia</h5>
            <canvas id="graficoTicketMedio"></canvas>
        </div>
    </div>

    <div class="dashboard-card overflow-x-auto">
        <h5 class="mb-4 text-lg font-semibold text-gray-800"><i class="bi bi-table"></i> Detalhamento de Faturamento por Dia</h5>
        <div class="overflow-hidden border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full divide-y divide-gray-200" id="tabela-detalhes">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Pedidos</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total (R$)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(!empty($valores)): ?>
                        <?php foreach($valores as $valor): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><?= date('d/m/Y', strtotime($valor['data'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center"><?= $valor['total_pedidos'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">R$ <?= number_format($valor['total_valor'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-inbox text-4xl text-gray-400 mb-3"></i>
                                    <span class="font-medium">Nenhum faturamento encontrado no período.</span>
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
    <?php if(!empty($valores)): ?>
    // Preparar dados para o gráfico
    const labels = <?= json_encode(array_map(function($v){ return date('d/m', strtotime($v['data'])); }, array_reverse($valores))) ?>;
    const dataValores = <?= json_encode(array_map('floatval', array_column(array_reverse($valores), 'total_valor'))) ?>;
    const dataPedidos = <?= json_encode(array_map('intval', array_column(array_reverse($valores), 'total_pedidos'))) ?>;
    const dataTicketMedio = <?= json_encode(array_map(function($v) {
        return $v['total_pedidos'] > 0 ? round($v['total_valor'] / $v['total_pedidos'], 2) : 0;
    }, array_reverse($valores))) ?>;

    // Gráfico de Linha (Evolução)
    const ctxEvolucao = document.getElementById('graficoEvolucao').getContext('2d');
    new Chart(ctxEvolucao, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Faturamento (R$)',
                data: dataValores,
                fill: true,
                backgroundColor: 'rgba(38, 222, 129, 0.1)',
                borderColor: 'rgba(38, 222, 129, 1)',
                tension: 0.4,
                pointBackgroundColor: 'rgba(38, 222, 129, 1)',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR'); } }
                }
            }
        }
    });

    // Gráfico de Pizza (Distribuição)
    const ctxDistribuicao = document.getElementById('graficoDistribuicao').getContext('2d');
    new Chart(ctxDistribuicao, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Faturamento (R$)',
                data: dataValores,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Gráfico de Barras (Pedidos)
    const ctxPedidos = document.getElementById('graficoPedidos').getContext('2d');
    new Chart(ctxPedidos, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nº de Pedidos',
                data: dataPedidos,
                backgroundColor: 'rgba(96, 165, 250, 0.7)',
                borderColor: 'rgba(96, 165, 250, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Gráfico de Linha (Ticket Médio)
    const ctxTicketMedio = document.getElementById('graficoTicketMedio').getContext('2d');
    new Chart(ctxTicketMedio, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ticket Médio (R$)',
                data: dataTicketMedio,
                backgroundColor: 'rgba(248, 113, 113, 0.1)',
                borderColor: 'rgba(248, 113, 113, 1)',
                tension: 0.4,
                pointBackgroundColor: 'rgba(248, 113, 113, 1)',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR'); } }
                }
            }
        }
    });
    <?php endif; ?>

    function exportarPDF() {
        const main = document.getElementById('relatorio-main');
        html2pdf().set({
            margin: 0.2,
            filename: 'relatorio_valor_por_dia.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).from(main).save();
    }

    function exportarCSV() {
        let csv = 'Data,Total Pedidos,Valor Total (R$)\n';
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
        link.setAttribute("download", "relatorio_valor_por_dia.csv");
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
