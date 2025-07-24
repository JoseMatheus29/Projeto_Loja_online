<?php
class CategoriaController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categoria_model');
        if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado']['tipo'] != 'adm') {
            $this->session->set_flashdata('error', 'Você não tem permissão para acessar esta página.');
            redirect(base_url());
        }
    }

    public function index()
    {
        $data['usuario_logado'] = $_SESSION['usuario_logado'];
        $data['categorias'] = $this->categoria_model->getAll();
        $data['title'] = "Gerenciamento de Categorias";
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/categorias', $data);
        $this->load->view('templates/footer');
    }

    public function inserir()
    {
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'status' => $this->input->post('status') ? 1 : 0
        ];
        if ($this->categoria_model->insert($data)) {
            $this->session->set_flashdata('success', 'Categoria cadastrada com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao cadastrar a categoria.');
        }
        redirect('CategoriaController');
    }

    public function atualizar($id)
    {
        $data = [
            'nome' => $this->input->post('nome'),
            'descricao' => $this->input->post('descricao'),
            'status' => $this->input->post('status') ? 1 : 0
        ];
        if ($this->categoria_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Categoria atualizada com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro ao atualizar a categoria.');
        }
        redirect('CategoriaController');
    }

    public function excluir($id)
    {
        if ($this->categoria_model->delete($id)) {
            $this->session->set_flashdata('success', 'Categoria excluída com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Não é possível excluir a categoria, pois ela está sendo utilizada em um ou mais produtos.');
        }
        redirect('CategoriaController');
    }
}
