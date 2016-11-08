<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $data['content'] = 'view_search';
        $this->load->view('template/view_template', $data);
    }

    public function dosearch() {
        $this->load->model('Messages_model');
        $string = $this->input->get('search');
        $data['query'] = $this->Messages_model->searchMessages($string);
        $data['content'] = 'view_messages';
        $this->load->view('template/view_template', $data);
    }
}