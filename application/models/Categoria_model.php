<?php
class Categoria_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getAll() {
        return $this->db->get('categorias')->result_array();
    }
    public function getById($id) {
        return $this->db->get_where('categorias', ['id' => $id])->row_array();
    }
    public function insert($data) {
        return $this->db->insert('categorias', $data);
    }
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categorias', $data);
    }
    public function delete($id) {
        $this->db->db_debug = false; 
        $this->db->where('id', $id);
        $result = $this->db->delete('categorias');
        $this->db->db_debug = true; 
        return $result;
    }
}
