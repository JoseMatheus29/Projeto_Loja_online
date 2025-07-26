<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller{
    
    public function index()
    {       
        try {
            $this->load->model("produtos_model");
            
            $data['produtos'] = $this->produtos_model->index();
            $data['title'] = "Home";
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('templates/footer', $data);
            
        } catch (Exception $e) {
            echo "<h1>Erro no HomeController</h1>";
            echo "<p>Erro: " . $e->getMessage() . "</p>";
            echo "<p><a href='" . base_url('teste') . "'>Voltar ao teste</a></p>";
        }
    }
    
    public function teste() {
        echo "<h1>🏠 Home Controller - Teste Simples</h1>";
        echo "<p>✅ Controller HomeController funcionando!</p>";
        
        if ($this->db->conn_id) {
            echo "<p style='color: green;'>✅ Banco conectado!</p>";
            
            try {
                $this->load->model("produtos_model");
                echo "<p style='color: green;'>✅ Modelo produtos_model carregado!</p>";
                
                $produtos = $this->produtos_model->index();
                echo "<p style='color: green;'>✅ Consulta executada! " . count($produtos) . " produtos encontrados.</p>";
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Erro no modelo: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Erro na conexão com banco!</p>";
        }
        
        echo "<p><a href='" . base_url('teste') . "'>🔙 Voltar ao teste principal</a></p>";
    }
} 

?>