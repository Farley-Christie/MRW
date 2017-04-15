<?php
	
	ini_set('display_errors',1);
    error_reporting(E_ALL);
	
	require_once('phpscripts/init.php');

	if(isset($_GET['filter'])) {
		$tbl1 = "tbl_movies";
		$tbl2 = "tbl_cat";
		$tbl3 = "tbl_l_mc";
		$col1 = "movies_id";
		$col2 = "cat_id";
		$col3 = "cat_name";
		$filter = $_GET['filter'];
		$getMovies = filterType($tbl1, $tbl2, $tbl3, $col1, $col2, $col3, $filter);
	}else{
		$tbl = "tbl_movies";
		$getMovies = getAll($tbl);
	}

	if(isset($_POST['submit'])) {
		$movieid = $_POST['movieid'];
		$post = trim($_POST['post']);
		$username = trim($_POST['user']);

		$postComments = newcomment($movieid, $post, $username);
		$message = $postComments;
	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to the Finest Selection of Blu-rays on the internet!</title>
<link rel="stylesheet" type="text/css" href="css/foundation.min.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<header>
	<h1>Robert's Movie Site</h1>
	<nav id="mainNav">
		<ul class="filterNav">
			<li><a href="index.php?filter=action">Action</a></li>
			<li><a href="index.php?filter=comedy">Comedy</a></li>
			<li><a href="index.php?filter=family">Family</a></li>
			<li><a href="index.php?filter=horror">Horror</a></li>
			<li><a href="index.php">All Films</a></li>
		</ul>
	</nav>
</header>

<article class="row">
<?php
	if(!is_string($getMovies)){
		while($row = mysqli_fetch_array($getMovies)){
			echo "
			<div class='small-12 large-6 columns'>
			<div class='movebox row'>
				<img src=\"images/{$row['movies_thumb']}\" alt=\"{$row['movies_title']}\" class='small-6 columns'>
				<div class='movetext small-6 columns'>
					<h2>{$row['movies_title']}</h2>
					<p>{$row['movies_year']}</p>
					<button class='moreBtn' id='{$row['movies_id']}'>More</button<br><br>
				</div>
			</div>
			</div>";

			echo "
			<div class='more hide small-12 columns' id='movie{$row['movies_id']}'>
				<video width='500' height='300' controls>
				 	Sorry, Your browser does not support this video.
				</video>
				<p>Desription</p>
				<h3>Run Time</h3>
				<h4>Price</h4><br><br>
				<form method='post' id='commentform'>
					<input hidden name='movieid' value='{$row['movies_id']}'>
					<label>Add a comment</label>
					<textarea name='post' value='' size='32'></textarea><br>
					<label>Enter your name</label>
					<input name='user' value=''>
					<input name='submit' type='submit' value='post comment'>
				</form>
				<div id='commentbox'>";

					$idNum = "{$row['movies_id']}";
					$tbl="tbl_comments";
					$getComments = getAll($tbl);

					if(isset($getComments)){
				 		while ($row = mysqli_fetch_array($getComments)) {
				 			$movieNum = "{$row['comments_movie']}";
				 			if ($movieNum == $idNum){
							 	echo "
							 	<div class='commentbox'>
							 	 	<p>\"{$row['comments_post']}\"</p>
							 	 	<p>-{$row['comments_user']}</p>
								</div>";
							}
						}
					} else {
						echo "Comments are not available at this time.";
					}
				echo "
				</div>
			</div>";
		}
	}else{
		echo "<p>{$getMovies}</p>";
	}	
?>
</article>

<footer>
	<p>copyright info 2017</p>
</footer>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/foundation.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<!--<script type="text/javascript" src="js/utility.js"></script>-->
</body>
</html>