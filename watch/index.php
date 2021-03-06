<?php header("Cache-Control: max-age=86400"); ?>
<?php if(!isset($_POST['psuedonym'])) header("Location: ../");?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="none" onload="if(media!='screen,projection')media='screen,projection'">
		<link rel="shortcut icon" type="image/webp" href="../images/logo.webp">
		<link rel="icon" sizes="192x192" type="image/webp" href="../images/logo192.webp">
		<link rel="manifest" href="../manifest.json">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#EE6E73">
		<meta name="Description" content="Collaborate with your friends, teachers, colleagues, etc. to broadcast public boards viewable worldwide using a simple psuedonym.">
	</head>
	<title>Liveboard - Real time, collaborative boards</title>
	<body bgcolor="#F6F6F6">
		<nav>
			<div class="nav-wrapper">
				<a style="font-family: 'Ubuntu', sans-serif; font-size:3em; color:#FFFFFF;" href="../">&larr;Live<span style="color:rgba(0,0,0,0.87);">board</span></a>
				<img class="brand-logo" id="logo" src="../images/logo.webp" width="5%" alt="Unable to load image" />
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li style="font-family: 'Ubuntu', sans-serif; font-size:1em;">You're watching "<?php echo $_POST['psuedonym']; ?>"<span>&emsp;&emsp;</span></li>
				</ul>
			</div>
		</nav>
		<main>
			<p id="screen" style="font-family: 'Ubuntu', sans-serif; font-size:3em;">...</p>
		</main>
		<p style="font-family: 'Ubuntu', sans-serif; font-size:1em; text-align:center;" id="myfoot"></p>
		<script>
			if(screen.availWidth<1075) {
				document.getElementById('logo').style.display = "none";
			}
			
			window.onresize = function(event) {
				if(window.outerWidth<1075) {
					document.getElementById('logo').style.display = "none";

				}
					else {
					document.getElementById('logo').style.display = "block";
				}
			};
			
		</script>
		<script>
			document.getElementById('myfoot').innerHTML = '&copy; ' + new Date().getFullYear() + ' <a href="https://volatile.ga/" target="_blank" rel="noopener">Volatile, Inc.</a> Made with love for everyone.';
		</script>
		<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js" async></script>
		<script>
			window.onload = function(){
			// Initialize Firebase
			var config = {
			  apiKey: "AIzaSyAuG-t9DKxuaETJk3-CcGiZjYjTgMcqB5w",
			  authDomain: "liveboard-1.firebaseapp.com",
			  databaseURL: "https://liveboard-1.firebaseio.com",
			  projectId: "liveboard-1",
			  storageBucket: "",
			  messagingSenderId: "423517565710"
			};
			firebase.initializeApp(config);
			
			// Get a reference to the database service
			var database = firebase.database();
			
			database.ref('/<?php echo $_POST['psuedonym']; ?>/message').on('value', function(snapshot) {
			document.getElementById('screen').innerHTML = snapshot.val();
			});
			}
		</script>
		<!--JavaScript at end of body for optimized loading-->
		<script type="text/javascript" src="../js/materialize.min.js" async></script>
	</body>
</html>
