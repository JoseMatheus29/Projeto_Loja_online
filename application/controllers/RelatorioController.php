<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RelatorioController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('pedidos_model');
        $this->load->model('produtos_model');
        $this->load->model('usuarios_model');
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']['tipo'] != 'adm') {
            redirect(base_url());
        }
    }

    // Relatório: Total de compras por cliente
    public function comprasPorCliente() {
        $data["title"] = 'Compra por Cliente';

        $dados['compras'] = $this->pedidos_model->getComprasPorCliente();
        $this->load->view('templates/header');
        $this->load->view('pages/relatorio_compras_por_cliente', $dados);
        $this->load->view('templates/footer');
    }

    // Relatório: Produtos em falta no estoque
    public function produtosEmFalta() {
        $data["title"] = 'Produtos em Falta';

        $dados['produtos'] = $this->produtos_model->getProdutosEmFalta();
        $this->load->view('templates/header');
        $this->load->view('pages/relatorio_produtos_em_falta', $dados);
        $this->load->view('templates/footer');
    }

    // Relatório: Total de valor recebido por dia
    public function valorPorDia() {
        $data["title"] = 'Valor por dia';

        $dados['valores'] = $this->pedidos_model->getValorPorDia();
        $this->load->view('templates/header');
        $this->load->view('pages/relatorio_valor_por_dia', $dados);
        $this->load->view('templates/footer');
    }
} 