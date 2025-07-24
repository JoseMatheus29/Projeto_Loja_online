<?php   
	if (isset($_SESSION['usuario_logado'])){
		$usuario_logado = $_SESSION['usuario_logado'];
	}else{
		redirect(base_url());
  }
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
	  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2"></h1>
	  </div>
			<br>
			<h3>Dados produtos</h3>
			<div class="col-md-12">
				<form action="<?= base_url()?>ProdutoController/novo" method="post" enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="form-group">
							<label for="categoria_id">Categoria</label>
							<select class="form-control" name="categoria_id" id="categoria_id" required>
								<option value="">Selecione</option>
								<?php foreach($categorias as $cat): ?>
									<option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Nome</label>
							<input type="text" class="form-control" name="nome" id="nome" placeholder="Name" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tamanho">Tamanho</label>
							<input type="text" class="form-control" name="tamanho" id="tamanho" placeholder="Tamanho" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="valor">Valor</label>
							<input type="number" class="form-control" name="valor" id="valor" placeholder="Valor" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea name="descricao" id="descricao" rows="5" class="form-control" required ></textarea>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="qntd">Quantidade</label>
							<input type="number" class="form-control" name="quantidade" id="quantidade" placeholder="Quantidade"  required >
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="foto">Foto</label>
							<input type="file" class="form-control" name="foto" id="foto" placeholder="Foto"  >
						</div>
					</div>
					<div class="col-md-12">
					<button type="submit" class="btn btn btn-lg btn-block" id="botao">Salvar</button>
						</div>
					</div>
				</form>
				<br><br>
			</div>

	</main>
  </div>
</div>
