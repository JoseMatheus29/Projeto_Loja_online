<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
	  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2"></h1>
	  </div>
			<br>
			<h3>Dados Usuario</h3>
			<div class="col-md-15">
				<form action="<?= base_url()?>UsuarioController/novoUsuario" method="post" enctype="multipart/form-data" onsubmit="return validarFormularioCliente(this)">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Nome</label>
							<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tamanho">Email</label>
							<input type="text" class="form-control" name="email" id="tamanho" placeholder="Email" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="tamanho">Telefone</label>
							<input type="tel" size="12" class="form-control" name="telefone" id="tamanho" placeholder="(xx) xxxxx-xxxx" required >
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="valor">Senha</label>
							<input type="password" class="form-control" name="senha" id="valor" placeholder="Senha" required >
						</div>
					</div>
					<?php 
					if (isset($usuario_logado['tipo'])):  
						if ($usuario_logado['tipo'] == 'adm'): ?>
							<div class="col-md-6">
								<div class="form-group">
									<label for="valor">Tipo</label>
									<select name="tipo" class="form-select form-select-sm" aria-label="Selecione o tipo de usuario">
										<option selected>---</option>
										<option value="adm">adm</option>
										<option value="estoquista">estoquista</option>
										<option value="cliente">cliente</option>
									</select>
								</div>
							</div>
						<?php endif?>
					<?php endif?>
					<div class="col-md-12">
					<button type="submit" class="btn btn btn-lg btn-block" id="botao">Salvar</button>
						</div>
					</div>
				</form>
			</div>

	</main>
  </div>
</div>
