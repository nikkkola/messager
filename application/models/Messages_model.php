<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getMessagesByPoster($name) {
        return $this->db->select('*')
                    ->from('Messages')
                    ->where('user_username', $name)
                    ->order_by('posted_at', 'DESC')
                    ->get()
                    ->result_array();
    }

    public function searchMessages($string) {
        return $this->db->select('*')
                    ->from('Messages')
                    ->like('text', $string)
                    ->order_by('posted_at', 'DESC')
                    ->get()
                    ->result_array();
    }

    public function insertMessage($poster, $string) {
        $data = array(
                'user_username' => $poster,
                'text' => $string
        );
        $this->db->set('posted_at', 'now()', FALSE)
                ->insert('Messages', $data);
    }

    public function getFollowedMessages($name) {
        $followed = $this->db->select('followed_username')
                                ->from('User_Follows')
                                ->where('follower_username', $name)
                                ->get()
                                ->result_array();

        $followedArray = array();
        foreach($followed as $row) {
            $followedArray[] = $row['followed_username'];
        }

        return $this->db->select('*')
                    ->from('Messages')
                    ->where_in('user_username', $followedArray)
                    ->order_by('posted_at', 'DESC')
                    ->get()
                    ->result_array();
    }
}