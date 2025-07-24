
<br><br><br>

<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Categorias</h1>
	</div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categorias as $cat): ?>
                <tr>
                    <td><?= $cat['id'] ?></td>
                    <td><?= htmlspecialchars($cat['nome']) ?></td>
                    <td><?= htmlspecialchars($cat['descricao']) ?></td>
                    <td><?= $cat['status'] ? 'Ativa' : 'Inativa' ?></td>
                    <td>
                        <a href="<?= base_url('CategoriaController/editar/'.$cat['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= base_url('CategoriaController/excluir/'.$cat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir esta categoria?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
