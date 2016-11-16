<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
    /**
     * Redirects to login page if a session is not active, otherwise loads
     * the post view.
     * @return void
     */
    public function index() {
        if(!$_SESSION['user']) {
            redirect('user/login');
            return;
        }
        $data['content'] = 'view_post';
        $this->load->view('template/view_template', $data);
    }

    /**
     * Redirects to login page if a session is not active, otherwise loads
     * the messages model and calls the insertMessage method with the given
     * username and password. Redirects to the messages view when done.
     * @return void
     */
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