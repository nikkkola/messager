<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    /**
     * Redirects to the messages view if a session is active or the login
     * page, if not.
     * @return void
     */
    public function index() {
        if($this->session->userdata('user')) {
            redirect('user/view/'.$_SESSION['user']);
        }
        else {
            redirect('user/login');
        }
    }

    /**
     * Loads the messages view to display all messages by the
     * username given as a parameter.
     *
     * @param  string $name The username, null default value.
     * @return void
     */
    public function view($name = NULL)
    {
        if ($name == NULL) {
            $this->index();
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

    /**
     * Loads the messages view to display all messages by users
     * which the currently logged in user follows.
     *
     * @param  string $name The username, null default value
     * @return void
     */
    public function feed($name = NULL) {
        if($name == NULL) {
            $this->index();
        }

        $this->load->model('Messages_model');
        $data['query'] = $this->Messages_model->getFollowedMessages($name);
        $data['content'] = 'view_messages';
        $this->load->view('template/view_template', $data);
    }

    /**
     * Loads the users model and calls the follow function
     * with the given parameter. Redirects to the messages view
     * for the followed user.
     *
     * @param  string $followed The user to be followed
     * @return void
     */
    public function follow($followed) {
        $this->load->model('Users_model');
        $this->Users_model->follow($followed);
        redirect('user/view/'.$followed);
    }

    /**
     * Redirects to the messages view for the logged in user if
     * a session is active, else loads the login view.
     *
     * @return void
     */
    public function login() {
        if($this->session->userdata('user')) {
            redirect('user/view/'.$_SESSION['user']);
        }
        else {
            $data['content'] = 'view_login';
            $this->load->view('template/view_template', $data);
        }
    }

    /**
     * Loads the users model and checks the input login details.
     * If that returns true, creates a session variable and redirects
     * to the messages view for the user, else creates a flashdata error
     * message and redirects back to login page.
     * @return void
     */
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

    /**
     * Checks if a session variable is active and if that
     * returns true, unsets the variable, destroys the session and
     * redirects to the login page.
     * @return void
     */
    public function logout() {
        if($this->session->userdata('user')) {
            unset($_SESSION['user']);
            session_destroy();
            redirect('user/login');
        }
    }
}