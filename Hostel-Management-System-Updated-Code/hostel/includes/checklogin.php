<?php
function check_login()
{
if(strlen($_SESSION['id'])==0)
	{	
		
		$_SESSION["id"]="";
		header("Location: logout.php");
	}
}
?>