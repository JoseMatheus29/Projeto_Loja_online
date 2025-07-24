<?php

class Produtos_model extends CI_Model {


    public function index(){
        $this->db->select('produtos.*, categorias.nome as categoria_nome');
        $this->db->from('produtos');
        $this->db->join('categorias', 'produtos.categoria_id = categorias.id', 'left');
        return $this->db->get()->result_array();
    }



    public function novo($produto){
        $this->db->insert('produtos', $produto);
    }
        
    public function deletar($id){
        $this->db->where("id",$id);
        return $this->db->delete("produtos");  
    }

    public function atualizar($produto){

        $this->db->set($produto);
        $this->db->where('id', $produto['id']);
        $this->db->update('produtos');

    }

    public function atualizarEstoque($produto){
        $this->db->set('quantidade',$produto['quantidade']);
        $this->db->where('id', $produto['id']);
        $this->db->update('produtos');
    }
    public function selecionarProdutosId($idProduto){
        if (is_array($idProduto)) {
            $this->db->where_in('id', $idProduto);
        } else {
            $this->db->where('id', $idProduto);
        }
        return $this->db->get('produtos')->result_array();
    }
    
    // Relatório: Produtos em falta no estoque
    public function getProdutosEmFalta() {
        $this->db->select('*');
        $this->db->from('produtos');
        $this->db->where('quantidade', 0);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>