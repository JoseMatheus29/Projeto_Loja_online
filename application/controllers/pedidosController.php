<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PedidosController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pedidos_model');
        $this->load->model('produtos_model'); 
        if (!isset($_SESSION['usuario_logado'])) {
            redirect(base_url('index.php/usuarioController/login'));
        }
    }

    public function index()
    {
        $data['usuario_logado'] = $_SESSION['usuario_logado'];
        $id_usuario = $data['usuario_logado']['user_id'];

        if ($data['usuario_logado']['tipo'] == 'adm') {
            $data['pedidos'] = $this->pedidos_model->todosPedidos();
        } else {
            $data['pedidos'] = $this->pedidos_model->index($id_usuario);
        }

        $data['title'] = "Meus Pedidos";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/pedidos', $data);
        $this->load->view('templates/footer');
    }

    public function deletar($idPedido)
    {
        $this->pedidos_model->deletar($idPedido);
        $this->session->set_flashdata('success', 'Pedido deletado com sucesso!');
        redirect('pedidosController');
    }

    public function visualizarProdutos($id_pedido)
    {
        $data['usuario_logado'] = $_SESSION['usuario_logado'];
        $pedido = $this->pedidos_model->selecionarPedido($id_pedido);

        if (!$pedido) {
            show_404();
            return;
        }
        
        $data['pedido'] = $pedido[0];
        $idsProdutos = explode(",", $data['pedido']['id_produtos']);
        
        $data['produtos'] = [];
        if(!empty($idsProdutos) && !empty($idsProdutos[0])){
            $data['produtos'] = $this->produtos_model->selecionarProdutosId($idsProdutos);
        }

        $data['title'] = "Produtos do Pedido #" . $id_pedido;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/visualizarProdutos', $data);
        $this->load->view('templates/footer');
    }
}