<?php header("Cache-Control: max-age=86400"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="none" onload="if(media!='screen,projection')media='screen,projection'">
		<link rel="shortcut icon" type="image/webp" href="images/logo.webp">
		<link rel="icon" sizes="192x192" type="image/webp" href="images/logo192.webp">
		<link rel="manifest" href="manifest.json">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#EE6E73">
		<meta name="Description" content="Collaborate with your friends, teachers, colleagues, etc. to broadcast public boards viewable worldwide using a simple psuedonym.">
	</head>
	<title>Liveboard - Real time, collaborative boards</title>
	<body bgcolor="#F6F6F6">
		<p id="heading" style="font-family: 'Ubuntu', sans-serif; font-size:8em; text-align:center; color:#FF0000;">Live<span style="color:rgba(0,0,0,0.87);">board</span></p>
		<nav id="nav" style="display:none;">
			<div class="nav-wrapper">
				<a style="font-family: 'Ubuntu', sans-serif; font-size:3em; color:#FFFFFF;" href="#">Live<span style="color:rgba(0,0,0,0.87);">board</span></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<li style="font-family: 'Ubuntu', sans-serif; font-size:1em;">Broadcast your board to the world!<span>&emsp;&emsp;</span></li>
				</ul>
			</div>
		</nav>
		<main>
			<form action="watch/index.php" method="post" id="form">
				<div class="row" style="font-family: 'Ubuntu', sans-serif;">
					<div class="col s12 m4 offset-m4" id="cardsize">
						<div class="card" style="margin-top:-5em;">
							<div class="card-content">
								<span class="card-title">Let's begin!</span>
								<div class="input-field" style="font-color:#FFFFFF;">
									<input id="username" onkeydown="if(event.keyCode == 13){event.preventDefault(); document.getElementById('watch').click();}" class="validate" type="text" name="psuedonym" oninput="checkFirebase();" autofocus></input>
									<label for="username">Pick a pseudonym</label>
								</div>
							</div>
							<div class="card-action" style="text-align:center;">
								<a class="waves-effect waves-light btn" id="watch" onclick="handleWatch();"><i class="material-icons left">remove_red_eye</i>Watch</a>
								<span>&emsp;</span>
								<a class="waves-effect waves-light btn" onclick="handleBroadcast();"><i class="material-icons left"><i class="material-icons">settings_input_antenna</i></i>Broadcast</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</main>
		<p style="font-family: 'Ubuntu', sans-serif; font-size:1em; text-align:center;" id="myfoot"></p>
		<script>
			if(screen.availWidth<1075) {
				document.getElementById('heading').style.display = "none";
				document.getElementById('nav').style.display = "block";
				document.getElementById('form').style = "margin-top:20em";
				document.getElementById('cardsize').className = "col s12 m6 offset-m3";
			}
			
			window.onresize = function(event) {
				if(window.outerWidth<1075) {
					document.getElementById('heading').style.display = "none";
					document.getElementById('nav').style.display = "block";
					document.getElementById('form').style = "margin-top:20em";
					document.getElementById('cardsize').className = "col s12 m6 offset-m3";
				}
					else {
					document.getElementById('heading').style.display = "block";
					document.getElementById('nav').style.display = "none";
					document.getElementById('form').style = "";
					document.getElementById('cardsize').className = "col s12 m4 offset-m4";
				}
			};
			
		</script>
		<script>
			document.getElementById('myfoot').innerHTML = '&copy; ' + new Date().getFullYear() + ' <a href="https://volatile.ga/" target="_blank" rel="noopener">Volatile, Inc.</a> Made with love for everyone.';
		</script>
		<script>
			if('serviceWorker' in navigator) {
			  navigator.serviceWorker
			           .register('sw.js')
			           .then(function() { console.log("Service Worker Registered"); });
			}
		</script>
		<script src="https://www.gstatic.com/firebasejs/4.12.0/firebase.js"></script>
		<script>
			window.onload = function(){
			document.getElementById('heading').innerHTML = 'Live<span style="color:rgba(0,0,0,0.87);">board</span><img src="images/logo.webp" width="10%" height="10%" alt="Unable to load image" /></p>';
			}
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
			var collaborate, inuse, flag, boards = [];
			function checkFirebase(){
				var pseudonym = document.getElementById('username').value;
				database.ref('/' + pseudonym + '/collaborate').on('value', function(snapshot) {
					collaborate = snapshot.val();
				});
				database.ref('/' + pseudonym + '/inuse').on('value', function(snapshot) {
					inuse = snapshot.val();
				});
			}
			
			database.ref('/').once('value', function(snapshot) {
			snapshot.forEach(function(childSnapshot) {
			 boards.push(childSnapshot.key);
			});
			});
		</script>
		<script>
			function handleWatch(){
				document.getElementById('username').value = document.getElementById('username').value.toLowerCase();
				for(var i=0; i<boards.length; i++){if(boards[i].toString() === document.getElementById('username').value) {flag = true; break;} else flag = false;}
				if(flag){
					if(document.getElementById('username').value) document.getElementById('form').submit();
					else alert('Looks like you forgot to pick a pseudonym!');
				}
				else alert('You seem to have gotten the pseudonym wrong');
			}
			function handleBroadcast(){
				document.getElementById('username').value = document.getElementById('username').value.toLowerCase();
				document.getElementById('form').action = 'broadcast/index.php';
				if(document.getElementById('username').value){
					if(collaborate) document.getElementById('form').submit();
					else if(inuse) alert('Sorry, looks like someone is using that board. Try using a different pseudonym.');
					else document.getElementById('form').submit();
				}
				else alert('Looks like you forgot to pick a pseudonym!');
			}
		</script>
		<!--JavaScript at end of body for optimized loading-->
		<script type="text/javascript" src="js/materialize.min.js" async></script>
	</body>
</html>
