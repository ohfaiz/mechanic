<html>
<head>
<title>Mechanic Management System</title>    
	<link rel="icon" href="img.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<div>
<body  style="background-image: url('u.jpg');">
    <div class="loginbox">
	<img src="img.png" class="avatar">
        <form method="post" action="login_action.php">
            <p>Email</p>
            <input type="text" name="email" placeholder="Enter email.." required>
            <p>Password</p>
            <input id="myInput" type="password" name="password" placeholder="Enter password.." required>
            <input type="submit" name="login_user" value="Login">
            <center><a href="register.php">Not yet a member? Sign up here.</a></center></br>
			<center><a href="forget.php">Forget password.</a></center>
        </form>
    </div>

</body>
</div>
</head>
</html>