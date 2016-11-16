<div id="login">
    <h1>Login</h1>    
    <div class="login-form">
	    <?php
	    // display error message if flashdata exists
	    echo $this->session->flashdata('message');
	    ?><br>
	    <form action="<?php echo site_url('user/dologin')?>" method="POST">
	        <input type="text" name="username" placeholder="Username" required="required"><br>
	        <input type="password" name="password" placeholder="Password" required="required"><br>
	        <input class="button" type="submit" name="logout" value="Login">
	    </form>
    </div>
</div>