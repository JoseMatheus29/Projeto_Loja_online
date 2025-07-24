<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller{
    public function index()
	{       
        $this->load->model("produtos_model");
        $data['produtos'] = $this->produtos_model->index();
        $data['title'] = "Home";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
		$this->load->view('pages/home', $data);
        $this->load->view('templates/footer', $data);
	}
} 

?>