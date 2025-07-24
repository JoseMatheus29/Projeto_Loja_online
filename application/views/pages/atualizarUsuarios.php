<?php   
    if (isset($_SESSION['usuario_logado'])){
        $usuario_logado = $_SESSION['usuario_logado'];
    }else{
        redirect(base_url());
  }
?>
<?php foreach($usuarios as $usuario):?>
<div class="modal fade" id="modalAttUsuario<?= $usuario['user_id']?>" tabindex="-1" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEdicao">Edição de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url()?>usuarioController/atualizar/<?=$usuario_logado['user_id']?>" method="post" onsubmit="return validarFormularioCliente(this)">
            <div class="form-group">
                <label for="nome" class="col-form-label" >id:</label>
                <input type="text" class="form-control" name="user_id" value="<?php echo $usuario['user_id']?>" readonly>
            </div>
            <div class="form-group">
                <label for="nome" class="col-form-label" >Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $usuario['nome']?>">
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $usuario['email']?>"  >
            </div>
            <div class="form-group">
                <label for="descricao" class="col-form-label">Telefone:</label>
                <input type="tel" class="form-control" name="telefone" value="<?php echo $usuario['telefone']?>  ">
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="qntd">Tipo</label>
                    <select name="tipo" class="form-select form-select-sm" aria-label="Selecione o tipo de usuario">
                      <option selected>---</option>
                      <option value="adm">adm</option>
                      <option value="estoquista">estoquista</option>
                      <option value="cliente">cliente</option>
                    </select>                
                </div>
            </div>
          
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<?php endforeach?>