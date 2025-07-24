<br><br><br>
<?php 
    $idsProdutosPedidos = array();
    
    foreach($pedidos as $pedido){
        array_push($idsProdutosPedidos, explode(",",$pedido['id_produtos']));
    }

    if (isset($_SESSION['usuario_logado'])){
        $usuario_logado = $_SESSION['usuario_logado'];
    }

?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pedidos</h1>
    </div>
    <a class="btn btn" id="botaoCard" href="<?= base_url()?>pedidosController/?idUsuario=<?=$usuario_logado['user_id']?>">Voltar </a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Tamanho</th>
                    <th>Valor Item</th>
                    <th>Descricao</th>
                    <th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                
                    <?php 
                        foreach($produtos as $produto):
                            foreach($idsProdutosPedidos as $idsProdutos ):
                                foreach($idsProdutos as $ids):
                                    if($produto['id'] ==  $ids):?>
                                    <tr>
                                        <td><img class="card-img-top" src="<?= base_url()?>assets/img/<?php echo $produto['foto']?>" alt="Imagem roupa"></td>
                                        <td><?php echo $produto['nome'];?></td>
                                        <td><?php echo $produto['tamanho'];?></td>
                                        <td><?php echo $produto['valor'];?></td>
                                        <td><?php echo $produto['descricao'];?></td>
                                        <td>
                                            <?php
                                            if (isset($produto['categoria_nome'])) {
                                                echo htmlspecialchars($produto['categoria_nome']);
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endif?>
                                <?php endforeach?>
                            <?php endforeach?>
                        <?php endforeach?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function goDelete(idPedido,idUsuario){
        var myUrl = 'deletar/'+idPedido+'/'+idUsuario
        if(confirm('Deseja realmente apagar esse registro?')){
            window.location.href =myUrl
        }else{
            alert("Registro não alterado")
            return false
        }
    }
</script>