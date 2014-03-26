<?php

//store out base to check URL in order to highlight selected link
$base = basename($_SERVER['SCRIPT_NAME']);

?>
<div id="nav">
<ul><li><a href="register.php" <?php if($base == "register.php") echo " class=selected"; ?>>Register</a> | <li><a href="index.php" <?php if($base == "index.php") echo " class=selected"; ?>>Home</a> | <li><a href="login.php" <?php if($base == "login.php") echo "class=selected"; ?> >Login</a> | <li><a href="profile.php" <?php if($base == "profile.php") echo "class=selected"; ?>>Profile</a> | <li><a href="faves.php" <?php if($base == "faves.php") echo "class=selected"; ?>>My Favorites</a>| <li><a href="search.php" <?php if($base == "search.php") echo "class=selected"; ?>>Search</a></ul>
</li>
</div>