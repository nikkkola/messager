<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Users_model extends CI_model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function checkLogin($username, $pass) {
        return count($this->db->select('*')
                            ->from('Users')
                            ->where('username', $username)
                            ->where('password', sha1($pass))
                            ->get()
                            ->result()) > 0;
    }

    public function isFollowing($follower, $followed) {
        return count($this->db->select('*')
                            ->from('User_Follows')
                            ->where('follower_username', $follower)
                            ->where('followed_username', $followed)
                            ->get()
                            ->result()) > 0;
    }

    public function follow($followed) {
        $data = array(
                'follower_username' => $_SESSION['user'],
                'followed_username' => $followed
        );
        $this->db->insert('User_Follows', $data);
    }

    public function getAvatarUrl($name) {
        return $this->db->select('avatar_url')
                        ->from('Users')
                        ->where('username', $name)
                        ->get()
                        ->result_array();
    }
}