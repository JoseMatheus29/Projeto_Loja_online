<?php
class CategoriaController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('categoria_model');
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']['tipo'] != 'adm') {
            redirect(base_url());
        }
    }
    public function index() {
        $data['categorias'] = $this->categoria_model->getAll();
        $data['title'] = "Categorias";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('pages/categorias.php', $data);
        $this->load->view('templates/footer');
    }
    public function nova() {
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('pages/cadastroCategorias.php');
        $this->load->view('templates/footer');
    }
    public function inserir() {
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'status' => $this->input->post('status') ? 1 : 0
        ];
        $this->categoria_model->insert($data);
        redirect('CategoriaController/index');
    }
    public function editar($id) {
        $data['categoria'] = $this->categoria_model->getById($id);
        $this->load->view('templates/header');
        $this->load->view('templates/navbar');
        $this->load->view('pages/cadastroCategorias.php', $data);
        $this->load->view('templates/footer');
    }
    public function atualizar($id) {
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'status' => $this->input->post('status') ? 1 : 0
        ];
        $this->categoria_model->update($id, $data);
        redirect('CategoriaController');
    }
    public function excluir($id) {
        $this->categoria_model->delete($id);
        redirect('CategoriaController');
    }
}
