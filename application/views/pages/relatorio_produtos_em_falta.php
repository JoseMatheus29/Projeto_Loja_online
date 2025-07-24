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
        background: #fffbe6;
        border-left: 5px solid #ffd700;
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
        color: #ffd700;
        font-size: 1.5em;
    }
    .dashboard-table th, .dashboard-table td {
        vertical-align: middle;
    }
    .dashboard-product-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1em 1.2em;
        margin-bottom: 1.5em;
        display: flex;
        align-items: center;
        gap: 1.2em;
        box-shadow: 0 2px 8px rgba(255,215,0,0.08);
    }
    .dashboard-product-card img {
        max-width: 60px;
        border-radius: 8px;
        border: 1px solid #eee;
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
<main class="container-fluid px-4" id="relatorio-main-produtos">
    <div class="dashboard-subtitle">Visualize rapidamente os produtos zerados, porcentagem, destaques e tendências de estoque.</div>
    <div class="dashboard-row mb-4">
        <div class="dashboard-col">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-box-seam" style="font-size:2em;color:#ffd700;"></i></div>
                <div class="mt-2">Produtos Zerados</div>
                <div class="h3 mb-0"><?= count($produtos) ?></div>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card text-center">
                <div><i class="bi bi-archive" style="font-size:2em;color:#4f8cff;"></i></div>
                <div class="mt-2">Total de Produtos</div>
                <div class="h3 mb-0"><?= isset($total_produtos) ? $total_produtos : '-' ?></div>
            </div>
        </div>
    </div>
    <div class="dashboard-row mb-4">
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-pie-chart"></i> Distribuição dos Produtos Zerados</h5>
                <canvas id="graficoPie"></canvas>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="dashboard-card">
                <h5 class="mb-3"><i class="bi bi-list-ul"></i> Lista de Produtos Zerados</h5>
                <?php foreach($produtos as $produto): ?>
                    <div class="dashboard-product-card">
                        <img src="<?= base_url() ?>assets/img/<?= htmlspecialchars($produto['foto']) ?>" alt="Imagem produto">
                        <div>
                            <div style="font-weight:600; color:#4f8cff; font-size:1.1em;"> <?= htmlspecialchars($produto['nome']) ?> </div>
                            <div style="color:#6c757d; font-size:0.95em;"> <?= htmlspecialchars($produto['descricao']) ?> </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="dashboard-card" style="margin-top: 3rem;">
        <h5 class="mb-3"><i class="bi bi-table"></i> Detalhamento Completo</h5>
        <table class="table table-bordered table-hover dashboard-table">
            <thead class="thead-light">
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><?= htmlspecialchars($produto['descricao']) ?></td>
                        <td><img src="<?= base_url() ?>assets/img/<?= htmlspecialchars($produto['foto']) ?>" alt="Imagem produto" style="max-width: 80px;"></td>
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
    // Gráfico de pizza - Distribuição dos produtos zerados
    const nomes = <?= json_encode(array_column($produtos, 'nome')) ?>;
    const valores = <?= json_encode(array_fill(0, count($produtos), 1)) ?>;
    const ctxPie = document.getElementById('graficoPie').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: nomes,
            datasets: [{
                data: valores,
                backgroundColor: [
                    '#ffd700','#4f8cff','#6fd6ff','#00c48c','#ff7a59','#a259ff','#ffb259','#ff5959','#59ffa3','#59baff'
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
    function exportarPDF() {
        const main = document.getElementById('relatorio-main-produtos');
        const opt = {
            margin:       0.2,
            filename:     'relatorio_produtos_em_falta.pdf',
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
        a.download = 'relatorio_produtos_em_falta.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }
</script>
<?php $this->load->view('templates/footer'); ?>
