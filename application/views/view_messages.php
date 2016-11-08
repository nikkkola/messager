<?php
    if(isset($isFollowing)) {
        if (($this->router->method != 'feed') && (!$isFollowing) && (($this->uri->segment(3)) != ($_SESSION['user']))) {
            echo anchor(site_url(array('user/follow', $this->uri->segment(3))), 'Follow', array('class' => 'button')).
                "<span class='follow'><span class='welcome'>Follow <strong>".$this->uri->segment(3).
                "</strong> if you would like to see their messages on your feed.</span></span>";
        }
    }

    if(empty($query)) {
        echo "<div class='message'>No messages found!</div>";
    }
    else {
        foreach ($query as $row) {
            echo "<div class='message'><ul><li><span class='username'>".anchor(site_url(array('user/view', $row['user_username'])), $row['user_username']).
                    "</span> - <span class='posted-at'>".$row['posted_at']."</span></li><li>".$row['text']."</li></ul></div>";
        }
    }
?>