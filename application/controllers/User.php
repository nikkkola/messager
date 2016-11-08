<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        if($this->session->userdata('user')) {
            redirect('user/view/'.$_SESSION['user']);
        }
        else {
            redirect('user/login');
        }
    }

    public function view($name = NULL)
    {
        if ($name == NULL) {
            echo "Missing username";
            return;
        }

        $this->load->model('Messages_model');
        $this->load->model('Users_model');
        $data['query'] = $this->Messages_model->getMessagesByPoster($name);
        if ($this->session->userdata('user')) {
            $data['isFollowing'] = $this->Users_model->isFollowing($_SESSION['user'], $name);
        }
        $data['content'] = 'view_messages';
        $this->load->view('template/view_template', $data);
    }

    public function feed($name) {
        if($name == NULL) {
            echo "Missing username";
            return;
        }

        $this->load->model('Messages_model');
        $data['query'] = $this->Messages_model->getFollowedMessages($name);
        $data['content'] = 'view_messages';
        $this->load->view('template/view_template', $data);
    }

    public function follow($followed) {
        $this->load->model('Users_model');
        $this->Users_model->follow($followed);
        redirect('user/view/'.$followed);
    }

    public function login() {
        $data['content'] = 'view_login';
        $this->load->view('template/view_template', $data);
    }

    public function dologin() {
        $this->load->model('Users_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $checkLogin = $this->Users_model->checkLogin($username, $password);

        if($checkLogin) {
            $_SESSION['user'] = $username;
            redirect('user/view/'.$username);
        }
        else {
            $this->session->set_flashdata('message', '<div id="error-message">Wrong username and/or password!</div>');
            redirect('user/login');
        }
    }

    public function logout() {
        if($this->session->userdata('user')) {
            unset($_SESSION['user']);
            session_destroy();
            redirect('user/login', 'refresh');
        }
    }
}