
<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Categoria</h1>
    </div>
    <form method="post" action="<?= base_url('CategoriaController/inserir') ?>">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" name="descricao" id="descricao"></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option value="1">Ativa</option>
                <option value="0">Inativa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="<?= base_url('CategoriaController/index') ?>" class="btn btn-secondary">Voltar</a>
    </form>
</main>
