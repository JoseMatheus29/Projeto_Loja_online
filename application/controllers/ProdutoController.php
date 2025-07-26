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
        try {
            if (!isset($_SESSION['usuario_logado'])) {
                redirect(base_url('usuarioController/login'));
                return;
            }
            $data['usuario_logado'] = $_SESSION['usuario_logado'];

            $this->load->model('produtos_model');
            $data['produtos'] = $this->produtos_model->index();
            $data['title'] = "Gerenciamento de Produtos";
            $this->load->model('categoria_model');
            $data['categorias'] = $this->categoria_model->getAll();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('pages/produtos_list', $data);
            $this->load->view('templates/footer.php', $data);
            
        } catch (Exception $e) {
            echo "<h1>Erro no ProdutoController</h1>";
            echo "<p>Erro: " . $e->getMessage() . "</p>";
            echo "<p><a href='" . base_url('teste') . "'>Voltar ao teste</a></p>";
        }
    }


    public function cadastrar()
    {
        if (!isset($_SESSION['usuario_logado'])) {
            redirect(base_url('index.php/usuarioController/login'));
            return;
        }
        $data['usuario_logado'] = $_SESSION['usuario_logado'];
        $data['title'] = "Cadastro de Produtos";
        $this->load->model('categoria_model');
        $data['categorias'] = $this->categoria_model->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/cadastroProdutos', $data);
        $this->load->view('templates/footer.php', $data);
    }


    public function novo()
    {
        if (!isset($_SESSION['usuario_logado'])) {
            redirect(base_url('index.php/usuarioController/login'));
            return;
        }

        $produto = $_POST;
        if (!isset($produto['categoria_id']) || empty($produto['categoria_id'])) {
            $produto['categoria_id'] = null;
        }

        $config['upload_path'] = './assets/img/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; 

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error['error']);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $produto['foto'] = $data['upload_data']['file_name'];

            $this->load->model("produtos_model");
            $this->produtos_model->novo($produto);
            $this->session->set_flashdata('success', 'Produto cadastrado com sucesso!');
        }
        redirect('ProdutoController');
    }

    public function deletar($idProduto)
    {
        if (!isset($_SESSION['usuario_logado'])) {
            redirect(base_url('index.php/usuarioController/login'));
            return;
        }
        $this->load->model("produtos_model");
        if ($this->produtos_model->deletar($idProduto)) {
            $this->session->set_flashdata('success', 'Produto deletado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao deletar o produto. Verifique se ele não está associado a um pedido.');
        }
        redirect('ProdutoController');
    }

    public function atualizar($tipo)
    {
        if (!isset($_SESSION['usuario_logado'])) {
            redirect(base_url('index.php/usuarioController/login'));
            return;
        }
        $this->load->model("produtos_model");
        $produtoCliente = $_POST;
        if (!isset($produtoCliente['categoria_id']) || empty($produtoCliente['categoria_id'])) {
            $produtoCliente['categoria_id'] = null;
        }
        if ($tipo == 'adm') {
            $this->produtos_model->atualizar($produtoCliente);
            $this->session->set_flashdata('success', 'Produto atualizado com sucesso!');
        } else {
            $this->produtos_model->atualizarEstoque($produtoCliente);
            $this->session->set_flashdata('success', 'Estoque do produto atualizado com sucesso!');
        }
        redirect('ProdutoController');
    }
} 

?>