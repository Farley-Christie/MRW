<?php
	function newComment($movieid, $post, $username){
		include('connect.php');
			$qstring = "INSERT INTO tbl_comments VALUES(NULL,'{$movieid}','{$post}','{$username}')";
			$result = mysqli_query($link, $qstring);
		mysqli_close($link);
		//redirect_to("../index.php");
	}
?>