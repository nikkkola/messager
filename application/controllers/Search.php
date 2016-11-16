<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    /**
     * Loads the search view
     *
     * @return void
     */
    public function index() {
        $data['content'] = 'view_search';
        $this->load->view('template/view_template', $data);
    }

    /**
     * Loads the messages model and performs the searchMessages function
     * with the given input. Loads the messages view to display the results
     * after that.
     *
     * @return void
     */
    public function dosearch() {
        $this->load->model('Messages_model');
        $string = $this->input->get('search');
        $data['query'] = $this->Messages_model->searchMessages($string);
        $data['content'] = 'view_messages';
        $this->load->view('template/view_template', $data);
    }
}