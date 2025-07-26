<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class usuarioController extends CI_Controller{

    public function index(){
        
        if (isset($_SESSION['usuario_logado'])){
            $data['usuario_logado'] = $_SESSION['usuario_logado'];
        }else{
            redirect(base_url());
        }

        $this->load->model("usuarios_model");
        $this->load->model("pedidos_model");
        $data['pedidos'] = $this->pedidos_model->todosPedidos();
        $data["usuarios"] = $this->usuarios_model->index();
        $data["title"] = 'Usuarios';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/usuarios', $data);
        $this->load->view('templates/footer');
    }
    public function login()
    {  
        $data['title'] = "Login";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/login', $data);
        $this->load->view('templates/footer');
    }

    public function cadastrarUsuario(){
        $data['title'] = "Cadastro";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('pages/cadastroUsuario', $data);
    }

    public function novoUsuario(){
        $usuario = $_POST;
        $usuario['senha'] = md5($usuario['senha']);
        $this->load->model("usuarios_model");
        if ($this->Usuarios_model->email_existe($usuario['email'])) {
            $this->session->set_flashdata('erro', 'E-mail já cadastrado!');
             redirect(base_url('usuarioController'));
        } else {
            $this->Usuarios_model->novo($usuario);
             $this->usuarios_model->novo($usuario);
        
        }
        redirect(base_url());
    }

    public function deletarUsuario($id){
        $this->load->model("usuarios_model");
        if ($this->usuarios_model->deletar($id)) {
            $this->session->set_flashdata('delete_success', 'Usuário excluído com sucesso.');
            redirect(base_url('usuarioController'));
        } else {
            $this->session->set_flashdata('error', 'Erro ao deletar o usuario. Verifique se ele não está associado a um pedido.');
        }
    }

    public function atualizar(){
        $this->load->model("usuarios_model");
        $usuarioAtt = $_POST;
        $this->usuarios_model->atualizar($usuarioAtt);
        redirect(base_url('usuarioController'));

    }

    public function logar(){
        $email = $_POST['email'];
        $senha = md5($_POST['senha']);
        $this->load->model("usuarios_model");
        $user = $this->usuarios_model->login($email, $senha);
        if($user){
            $this->session->set_userdata("usuario_logado", $user);
            redirect(base_url());
        }else{
            $this->session->set_flashdata('category_error', 'Error message.');
            redirect(base_url().'/usuarioController/login');
        }
    }

    public function sair(){
        $this->session->unset_userdata("usuario_logado");
        redirect(base_url().'/usuarioController/login');

    }

}

