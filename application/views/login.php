<?php
$attributes = array('class' => 'pure-form pure-form-stacked');
$username   = array(
              'name'        => 'user_name',
              'placeholder' => 'User Name',
            );   
$pwd        = array(
              'name'        => 'password',
              'placeholder' => 'Password',
            ); 
?>
<div class="login_container">
	<?=form_open('/login/check_pw', $attributes);?>
	    <fieldset>
	        <legend>Site Update Page</legend>

	        <label for="email">Login</label>
	        <?=form_input($username);?>

	        <label for="password">Password</label>
	        <?=form_password($pwd);?>

	        <button type="submit" class="pure-button pure-button-primary">Sign in</button>
	    </fieldset>
	<?=form_close()?>
	<?php if(isset($the_error)){
		echo '<h3 class="error-color">';
		echo $the_error;
		echo '</h3>';
		}?>
</div>

