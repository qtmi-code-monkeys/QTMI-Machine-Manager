<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" href="styles/main.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 

        <script type="text/JavaScript" >
	function submitFormOnReturnAllFeilds(thisForm, e){
	 var keycode = e.keyCode;
	  if(window.event){
		keycode = window.event.keyCode;
	  }else if (e){
		keycode = e.which;
	  }else{
		return true;
	  };
	  if(keycode == 13){
		//alert(keycode);
		formhash(thisForm.form, thisForm.form.password);
		document.login_form.submit();
	  };
	}	
	</script> 


    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
        <form action="includes/process_login.php" method="post" id="login_form" name="login_form"> 			
            <input type="text" name="email" />Email</br>
            <input type="password" 
                             name="password" 
                             id="password"  onkeyDown="submitFormOnReturnAllFeilds(this, event)" />Password
			     </br>
            <input type="button" 
                   value="Login" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>

    </body>
</html>
