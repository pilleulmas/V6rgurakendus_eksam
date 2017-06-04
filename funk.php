<?php
function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}
function login(){
	if (isset($_POST['user'])) {
		include_once('vaated/hindamine.html');
	}
	if (isset($_SERVER['REQUEST_METHOD'])) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		  	
		  	$errors = array();
		  	if (empty($_POST['user']) || empty($_POST['pass'])) {
		  		if(empty($_POST['user'])) {
			    	$errors[] = "kasutajanimi on puudu";
				}
				if(empty($_POST['pass'])) {
					$errors[] = "parool on puudu";
				} 
		  	} else {
		  		global $connection;
		  		$username = mysqli_real_escape_string($connection, $_POST["user"]);
		  		$passw = mysqli_real_escape_string($connection, $_POST["pass"]);
		  		
				$query = "SELECT id FROM pulmas_eksam_kasutaja WHERE kasutaja='$username' && parool=SHA1('$passw')";
				$result = mysqli_query($connection, $query) or die("midagi läks valesti");
			
				$ridu = mysqli_num_rows($result);
					if ( $ridu > 0) {
						$_SESSION['user'] = $username;
						$_SESSION['id'] = $user_id;
						header("Location: ?page=hindamine");
					}
		  	}
		//igasuguste vigade korral ning lehele esmakordselt saabudes kuvatakse kasutajale sisselogimise vorm failist login.html
		} else {
			 include_once 'vaated/login.html';
		}
	}
	
	include_once('vaated/login.html');
}
function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function hindamine($kasutaja_id, $pakkumine){
	global $connection;
	$sql="INSERT INTO pulmas_eksam_pakkumine (kasutaja, pakkumine) VALUES ". $kasutaja_id.", ".$pakkumine."";
	if (mysqli_query($connection, $sql)) {
	echo "";
	//	echo "Record updated successfully";
	} else {
		echo "Error updating record: " . mysqli_error($connection);
	}
}
	
?>