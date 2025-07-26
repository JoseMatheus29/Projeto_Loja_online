<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CarrinhoController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("carrinho_model");
        $this->load->model("usuarios_model");
        $this->load->model("produtos_model");
        $this->load->library('user_agent');
        if (!$this->session->userdata('usuario_logado')) {
            $this->session->set_flashdata('danger', 'Você precisa estar logado para acessar o carrinho.');
            redirect('usuarioController/login');
        }
    }

    public function index() {
        $usuario_logado = $this->session->userdata('usuario_logado');
        $idUsuario = $usuario_logado['user_id'];

        $carrinho_json = $this->usuarios_model->retornaProdutosCarrinho($idUsuario)['carrinho'];
        $carrinho_array = $carrinho_json ? json_decode($carrinho_json, true) : [];
        $carrinho_array = array_filter($carrinho_array);

        $data['produtos_carrinho'] = [];
        $data['valor_total'] = 0;
        $ids_produtos = [];

        if (!empty($carrinho_array)) {
            // Contar a ocorrência de cada produto
            $contador_produtos = [];
            foreach ($carrinho_array as $item) {
                if (isset($item[0]['id_produto'])) {
                    $id_produto = $item[0]['id_produto'];
                    $contador_produtos[$id_produto] = ($contador_produtos[$id_produto] ?? 0) + 1;
                }
            }
            
            $ids_unicos = array_keys($contador_produtos);

            if (!empty($ids_unicos)) {
                $produtos_db = $this->produtos_model->selecionarProdutosId($ids_unicos);

                foreach ($produtos_db as $produto) {
                    $quantidade_no_carrinho = $contador_produtos[$produto['id']];
                    $produto['quantidade_carrinho'] = $quantidade_no_carrinho;
                    $produto['subtotal'] = $produto['valor'] * $quantidade_no_carrinho;
                    $data['produtos_carrinho'][] = $produto;
                    $data['valor_total'] += $produto['subtotal'];
                    
                    // Adiciona o ID do produto para o array de finalização, respeitando a quantidade
                    for ($i=0; $i < $quantidade_no_carrinho; $i++) { 
                        $ids_produtos[] = $produto['id'];
                    }
                }
            }
        }
        
        // Prepara os IDs para o formulário de finalização
        $data['ids_produtos_string'] = implode(',', $ids_produtos);

        $data['title'] = "Carrinho";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/carrinho', $data);
        $this->load->view('templates/footer', $data);
    }

    public function adicionarCarrinho($idProduto) {
        $idUsuario = $this->session->userdata('usuario_logado')['user_id'];
        
        if ($this->carrinho_model->adicionarCarrinho($idProduto, $idUsuario)) {
            $this->session->set_flashdata('success', 'Produto adicionado ao carrinho!');
        } else {
            $this->session->set_flashdata('danger', 'Produto fora de estoque ou não encontrado.');
        }
        redirect($this->agent->referrer() ?: base_url());
    }

    public function deletarProdutoCarrinho($idProduto) {
        $idUsuario = $this->session->userdata('usuario_logado')['user_id'];
        
        if ($this->carrinho_model->deletarProdutoCarrinho($idUsuario, $idProduto)) {
            $this->session->set_flashdata('success', 'Produto removido do carrinho.');
        } else {
            $this->session->set_flashdata('danger', 'Não foi possível remover o produto do carrinho.');
        }
        redirect('carrinhoController');
    }
    
    public function finalizar() {
        $idUsuario = $this->session->userdata('usuario_logado')['user_id'];
        $idsProdutos = $this->input->post('ids_produtos');
        $valorTotal = $this->input->post('valor_total');

        if (empty($idsProdutos)) {
            $this->session->set_flashdata('danger', 'Seu carrinho está vazio.');
            redirect('carrinhoController');
            return;
        }

        if ($this->carrinho_model->finalizar($idsProdutos, $idUsuario, $valorTotal)) {
            $this->session->set_flashdata('success', 'Pedido finalizado com sucesso!');
            redirect('pedidosController');
        } else {
            $this->session->set_flashdata('danger', 'Ocorreu um erro ao finalizar seu pedido. Tente novamente.');
            redirect('carrinhoController');
        }
    }
}