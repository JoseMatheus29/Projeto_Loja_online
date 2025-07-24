<?php

class Carrinho_model extends CI_Model {

    public function finalizar($idsProdutosString, $idUsuario, $valor) {
        $data = array(
            'id_produtos' => $idsProdutosString,
            'id_usuario'  => $idUsuario,
            'status'      => 'Processo de entrega',
            'valor'       => $valor
        );

        $this->db->trans_start();

        $this->db->insert('pedidos', $data);

        // Limpa o carrinho do usuário
        $this->db->set('carrinho', NULL);
        $this->db->where('user_id', $idUsuario);
        $this->db->update('usuarios');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function adicionarCarrinho($idProduto, $idUsuario) {
        $this->db->select('quantidade');
        $this->db->where('id', $idProduto);
        $produto = $this->db->get('produtos')->row_array();

        if (!$produto || $produto['quantidade'] < 1) {
            return false; 
        }

        $item_carrinho = array(
            array(
                'id_produto' => $idProduto,
                'idUsuario' => $idUsuario
            )
        );

        $this->db->select('carrinho');
        $this->db->where('user_id', $idUsuario);
        $carrinho_atual_db = $this->db->get('usuarios')->row_array();
        
        $carrinho_array = array();
        if ($carrinho_atual_db && !empty($carrinho_atual_db['carrinho'])) {
            $carrinho_array = json_decode($carrinho_atual_db['carrinho'], true);
        }

        $carrinho_array[] = $item_carrinho;
        $novo_carrinho_json = json_encode($carrinho_array);

        $this->db->set('carrinho', $novo_carrinho_json);
        $this->db->where('user_id', $idUsuario);
        $this->db->update('usuarios');

        $this->db->set('quantidade', 'quantidade - 1', FALSE);
        $this->db->where('id', $idProduto);
        $this->db->update('produtos');

        return true;
    }

    public function deletarProdutoCarrinho($idUsuario, $idProduto) {
        $this->db->select('carrinho');
        $this->db->where('user_id', $idUsuario);
        $carrinho_db = $this->db->get('usuarios')->row_array();

        if (!$carrinho_db || empty($carrinho_db['carrinho'])) {
            return false; 
        }

        $carrinho_array = json_decode($carrinho_db['carrinho'], true);
        $carrinho_array = array_filter($carrinho_array); // Limpa possíveis entradas vazias

        $found_and_deleted = false;
        $novo_carrinho_array = [];

        // Itera para encontrar e remover a primeira ocorrência do produto
        foreach ($carrinho_array as $item) {
            if (!$found_and_deleted && isset($item[0]['id_produto']) && $item[0]['id_produto'] == $idProduto) {
                $found_and_deleted = true;
                continue; // Pula o item, efetivamente o removendo
            }
            $novo_carrinho_array[] = $item;
        }

        if (!$found_and_deleted) {
            return false; // Produto não foi encontrado no carrinho
        }

        // Devolve o item ao estoque
        $this->db->set('quantidade', 'quantidade + 1', FALSE);
        $this->db->where('id', $idProduto);
        $this->db->update('produtos');

        // Atualiza o carrinho com o array modificado
        $novoCarrinhoJSON = json_encode(array_values($novo_carrinho_array)); // Reindexa o array
        $this->db->set('carrinho', $novoCarrinhoJSON);
        $this->db->where('user_id', $idUsuario);
        
        return $this->db->update('usuarios');
    }
    
    
}
?>