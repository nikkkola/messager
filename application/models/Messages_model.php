<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_model extends CI_Model {
    /**
     * Performs a query to select all messages by a single user.
     *
     * @param  string $name The name of the poster
     * @return array An array of messages
     */
    public function getMessagesByPoster($name) {
        return $this->db->select('*')
                    ->from('Messages')
                    ->where('user_username', $name)
                    ->order_by('posted_at', 'DESC')
                    ->get()
                    ->result_array();
    }

    /**
     * Performs a query to select all messages containg the specified string.
     *
     * @param  string $string The string we're looking for
     * @return array An array of all messages containing the string
     */
    public function searchMessages($string) {
        return $this->db->select('*')
                    ->from('Messages')
                    ->like('text', $string)
                    ->order_by('posted_at', 'DESC')
                    ->get()
                    ->result_array();
    }

    /**
     * Performs a query to insert a message by a user into the database.
     *
     * @param  string $poster The user posting the meesage
     * @param  string $string The message to be posted
     * @return void
     */
    public function insertMessage($poster, $string) {
        $data = array(
                'user_username' => $poster,
                'text' => $string
        );
        $this->db->set('posted_at', 'now()', FALSE)
                ->insert('Messages', $data);
    }

    /**
     * Performs a query to select all messages from users which the current user follows.
     *
     * @param  string $name The name of the user
     * @return array An array of messages
     */
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