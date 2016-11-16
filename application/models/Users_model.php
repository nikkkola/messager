<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Users_model extends CI_model {
    /**
     * Performs a query to check whether a user with the given username and password
     * exists, and checks if the returned array is empty or not.
     *
     * @param  string $username The input username
     * @param  string $password The input password
     * @return boolean Wheter the input is in the database
     */
    public function checkLogin($username, $pass) {
        return count($this->db->select('*')
                            ->from('Users')
                            ->where('username', $username)
                            ->where('password', sha1($pass))
                            ->get()
                            ->result()) > 0;
    }

    /**
     * Performs a query to check whether there is an entry in the database
     * for such input and checks if the return array is empty or not.
     *
     * @param  string $follower The follower
     * @param  string $followed The followed user
     * @return boolean Whether the follower follows the followed user
     */
    public function isFollowing($follower, $followed) {
        return count($this->db->select('*')
                            ->from('User_Follows')
                            ->where('follower_username', $follower)
                            ->where('followed_username', $followed)
                            ->get()
                            ->result()) > 0;
    }

    /**
     * Performs a query to insert an entry in the database for the currently
     * logged user to follow the user passed as a parameter.
     *
     * @param  string $followed The user to be followed
     * @return void
     */
    public function follow($followed) {
        $data = array(
                'follower_username' => $_SESSION['user'],
                'followed_username' => $followed
        );
        $this->db->insert('User_Follows', $data);
    }
}