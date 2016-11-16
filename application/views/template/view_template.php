<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if($this->router->method == 'view') echo $this->uri->segment(3);
                    else if ($this->router->method == 'dosearch') echo "Search Results";
                    else if ($this->router->method == 'feed') echo "Feed";
                    else if ($this->router->method == 'login') echo "Login";
                    else if ($this->router->class == 'message') echo "Post";
                    else if ($this->router->class == 'search') echo "Search"; ?> | Messager
    </title>
    <link rel="stylesheet" href="<?php echo base_url('assets/stylesheets/main.css')?>"/>
    <link rel="icon" href="<?php echo base_url('favicon.ico')?>" type="image/gif">
</head>
<body>
<div id="navbar">
    <?php if ($this->session->userdata('user')) { ?>
            <div id="links">
                <a class="button" href="<?php echo site_url('user/feed/'.$_SESSION['user'])?>">Feed</a>
                <a class="button" href="<?php echo site_url('message/')?>">Post A Message</a>
                <a class="button" href="<?php echo site_url('user/view/'.$_SESSION['user'])?>">My Messages</a>
                <a class="button" href="<?php echo site_url('search/')?>">Search</a>
            </div>
    <?php }; ?>
    <div id="logo">Messager</div>
        <div id="user-links">
            <?php if ($this->session->userdata('user')) { ?>
                <span class="welcome">Welcome, <strong><?php echo $_SESSION['user']?></strong></span>
                <form  class="logout-form" action="<?php echo site_url('user/logout/')?>">
                    <input class="button" type="submit" value="Logout"/>
                </form>
            <?php } else { ?>
                <span class="welcome">You are not logged in.</strong></span>
                <a class="button" href="<?php echo site_url('user/login/')?>">Login</a>
            <?php }; ?>
        </div>
</div>
<div id="main-container">
    <div id="content">
        <?php
        // load the view content passed as a parameter
        $this->load->view($content);
        ?>
    </div>
</div>
</body>
</html>