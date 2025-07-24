<?php

class Pedidos_model extends CI_Model {

    public function index($idUsuario){ 
        return $this->db->get_where('pedidos', array('id_usuario'=> $idUsuario))->result_array();
    }
    public function deletar($id){
        $this->db->where("id",$id);
        return $this->db->delete("pedidos");  
    }
    public function selecionarPedido($id){
        return $this->db->get_where('pedidos', array('id'=> $id))->result_array();

    }
    public function todosPedidos(){
        return $this->db->get('pedidos')->result_array();

    }

    // Relatório: Total de compras por cliente
    public function getComprasPorCliente() {
        $this->db->select('usuarios.nome, usuarios.email, SUM(pedidos.valor) as total_compras, COUNT(pedidos.id) as total_pedidos');
        $this->db->from('pedidos');
        $this->db->join('usuarios', 'usuarios.user_id = pedidos.id_usuario');
        $this->db->group_by('usuarios.user_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Relatório: Total de valor recebido por dia
    public function getValorPorDia() {
        $this->db->select('DATE(pedidos.data_entrega) as data, SUM(pedidos.valor) as total_valor, COUNT(pedidos.id) as total_pedidos');
        $this->db->from('pedidos');
        $this->db->group_by('DATE(pedidos.data_entrega)');
        $this->db->order_by('data', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>