<?php

class Usuarios_model extends CI_Model {


    public function index(){ 
        return $this->db->get("usuarios")->result_array();
    }



    public function novo($usuarios){
        $this->db->insert('usuarios', $usuarios);
    }
        
    public function deletar($id){
        // Guarda o estado atual do db_debug
        $db_debug = $this->db->db_debug;
        // Desativa o db_debug para a proxima query
        $this->db->db_debug = FALSE;

        $this->db->where("user_id",$id);
        $result = $this->db->delete("usuarios");

        // Restaura o estado do db_debug
        $this->db->db_debug = $db_debug;

        return $result;
    }

    public function atualizar($usuario){

        $this->db->set($usuario);
        $this->db->where('user_id', $usuario['user_id']);
        $this->db->update('usuarios');

    }
    public function login($email, $senha){
        $this->db->where('email', $email);
        $this->db->where('senha',$senha);
        $user = $this->db->get('usuarios')->row_array();
        $this->db->set('logado', 1);
        return $user;
    }

    public function retornaProdutosCarrinho($idUser){
        $this->db->select('carrinho');
        $this->db->where('user_id', $idUser); 
        return $this->db->get('usuarios')->row_array();
        
    }

}
?>