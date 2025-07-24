<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProdutoController extends CI_Controller{
    public function editar($id) {
        $this->load->model('produtos_model');
        $this->load->model('categoria_model');
        $data['produto'] = $this->produtos_model->selecionarProdutosId($id)[0];
        $data['categorias'] = $this->categoria_model->getAll();
        $this->load->view('templates/header');
        $this->load->view('pages/atualizarProdutos', $data);
        $this->load->view('templates/footer');
    }
    public function index()
    {  
        $data['title'] = "Cadastro Produtos";
        $this->load->model('categoria_model');
        $data['categorias'] = $this->categoria_model->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/cadastroProdutos', $data);
        $this->load->view('templates/footer.php', $data);
    }


    public function novo(){
        $produto = $_POST;
        if (!isset($produto['categoria_id']) || empty($produto['categoria_id'])) {
            $produto['categoria_id'] = null;
        }
        $config['upload_path'] = 'assets/img/';
        $config['max_size'] = 2048;
        $config['allowed_types'] = 'png|jpg|jpeg';
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('foto')){
            echo $this->upload->display_errors();
        }else{
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }
        $produto['foto'] = $file_name;
        $this->load->model("produtos_model");
        $this->produtos_model->novo($produto);
        redirect(base_url());
    }

    public function deletar($idProduto){
        $this->load->model("produtos_model");
        $this->produtos_model->deletar($idProduto);
        redirect(base_url());

    }

    public function atualizar($tipo){
        $this->load->model("produtos_model");
        $produtoCliente = $_POST;
        if (!isset($produtoCliente['categoria_id']) || empty($produtoCliente['categoria_id'])) {
            $produtoCliente['categoria_id'] = null;
        }
        if($tipo == 'adm'){
            $this->produtos_model->atualizar($produtoCliente);
        }else{
            $this->produtos_model->atualizarEstoque($produtoCliente);
        }
        redirect(base_url());

    }
} 

?>