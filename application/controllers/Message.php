<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        if(!$_SESSION['user']) {
            redirect('user/login');
            return;
        }
        $data['content'] = 'view_post';
        $this->load->view('template/view_template', $data);
    }

    public function doPost() {
        if(!$_SESSION['user']) {
            redirect('user/login');
            return;
        }
        $this->load->model('Messages_model');
        $username = $_SESSION['user'];
        $message = $this->input->post('post');
        $this->Messages_model->insertMessage($username, $message);
        redirect('user/view/'.$username);
    }
}