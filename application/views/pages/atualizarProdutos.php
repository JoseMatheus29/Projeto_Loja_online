<?php   
    
    if (isset($_SESSION['usuario_logado'])){
        $usuario_logado = $_SESSION['usuario_logado'];
    }

?>


<?php foreach($produtos as $produto):?>
<div class="modal fade" id="modalAtt<?= $produto['id']?>" tabindex="-1" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEdicao">Edição de Produtos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url()?>ProdutoController/atualizar/<?= $usuario_logado['tipo']?>" method="post">
        <div class="form-group">
                <label for="nome" class="col-form-label" >Id:</label>
                <input type="text" class="form-control" name="id" value="<?php echo $produto['id']?>" readonly>
            </div>
        <?php if($usuario_logado['tipo'] == 'adm'):?>
            <div class="form-group">
                <label for="nome" class="col-form-label" >Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $produto['nome']?>">
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" class="form-control" name="valor" id="valor" value="<?php echo $produto['valor']?>"  >
            </div>
            <div class="form-group">
                <label for="descricao" class="col-form-label">Descrição:</label>
                <textarea class="form-control" name="descricao"><?php echo $produto['nome']?></textarea>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <img class="card-img-top" src="<?= base_url()?>assets/img/<?php echo $produto['foto']?>" alt="Imagem roupa">
                </div>
            </div>
            <?php endif?>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="qntd">Quantidade</label>
                    <input type="number" class="form-control" name="quantidade" id="quantidade" value="<?php echo $produto['quantidade']?>">
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