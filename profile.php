<html>
	<head>
		<meta charset="UTF-8">
		<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        	<script src="javascript.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<title>Home</title>
		<link rel="stylesheet" type="text/css" href="navigation.css">
	</head>
	<body>
		<div>
			<nav class="main-menu">
        		<ul>
            		<li><a href="logout.php">Logout</a></li>
					<li><a href="contacts.php">Contacts</a></li>
					<li><a href="actualMessageList.php">Message List</a></li>
                	<li id="currentpage"><a id="userProf">Profile</a></li>
				</ul>
			</nav>
		</div>
    </body>
	<div class="twitter-widget">
		<div class="header cf">
			<a href="http://twitter.com/kayrel" target="_blank" class="avatar"><img src="http://cameronbaney.com/codepen/twitter-widget/avatar.jpg" alt="Edwin Delgado"></a>
			<h2>Edwin Delgado @kayrel</h2>
			<p>I do not recall how I came into existence.<br>Something to do with my dad and mom.</p>
		</div>
		<div class="stats cf">
			<a href="#" class="stat"><strong>1,250</strong>tweets</a>
			<a href="#" class="stat"><strong>60</strong>following</a>
			<a href="#" class="stat"><strong>117</strong>followers</a>
		</div>
		<ul class="menu cf">
			<li><a href="#" class="ico-compose">Compose</a></li>
			<li><a href="#" class="ico-mentions">Mentions</a></li>
			<li><a href="#" class="ico-profile">Profile</a></li>
			<li><a href="#" class="ico-settings">Settings</a></li>
		</ul>
	</div>
</html>

<?php
    include "./database.php";

    session_start();
    if(!isset($_COOKIE['username'])) {
        header('Location: index.php');
    }
    setcookie("username", $_SESSION['username'], 0);
	
	if($_GET['userVar'] == $_COOKIE['username'])
	{
		echo "<html><form action='getnewinfo.php' method='post'><input type='submit' value='Edit Settings'></form></html>";
	}
    $user = $_GET['userVar'];
    $sql = "SELECT * FROM Users WHERE username = '".$user."'";
    $results = executeStatement($sql);
    $username = $results[0][0];
    $firstname = $results[0][2];
    $lastname = $results[0][3];
    $birthday = $results[0][4];
    $gender = $results[0][5];
    $email = $results[0][6];
    $status = $results[0][7];
    echo "<br>User name: $username<br>";
    echo "Email: $email <br>";
    echo "First name: $firstname <br>";
    echo "Last name: $lastname <br>";
    echo "Birthday: $birthday <br>";
    echo "Gender: $gender <br>";
    echo "Status: $status <br>";
?>
<script type="text/javascript">
document.getElementById("userProf").setAttribute("href", "profile.php?userVar="+parse());
//gets the userVar GET variable from the URL
var parts = window.location.href;
var userVar = parts.substring(parts.indexOf("=")+1, parts.length);

var btn = document.createElement("BUTTON");
btn.setAttribute("id", "contactBtn_");
btn.setAttribute("value", userVar);
btn.onclick=function(){
window.location.replace("./messages.php?contacts="+this.value);
};
var t = document.createTextNode(userVar);
btn.appendChild(t);
document.body.appendChild(btn);

if(parse() != userVar){
	var blockBtn = document.createElement("BUTTON");
	blockBtn.setAttribute("id", userVar);
	blockBtn.setAttribute("value", parse());
	blockBtn.onclick=function(){
		$.ajax({
			type:'GET',
			url: './blockUser.php',
			data: {username: this.value, contact: this.id}
		});
	};
	var newT = document.createTextNode("Block/Unblock User");
	blockBtn.appendChild(newT);
	document.body.appendChild(blockBtn);
}
</script>
<html>
	<form id="statUpdate" style="display: none"  action="./updateStatus.php" type="GET">
		Update Status:<br>
		<input type="text" name="status">
	</form>
</html>
<script>
if(parse() == userVar){
	document.getElementById("statUpdate").style.display="block";
}
</script>
