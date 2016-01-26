<?php

if (!isset($_GET['rating_name'])) {
  header('Location: index.php');
  exit();
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pw = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pw);

$rating_name = $_GET['rating_name'];

$sql = "SELECT title, genre_name, format_name
		  FROM dvds
		  INNER JOIN genres
			ON dvds.genre_id = genres.id
		  INNER JOIN formats
   		    ON dvds.format_id = formats.id
  		  INNER JOIN ratings
    		ON dvds.rating_id = ratings.id
		  WHERE rating_name = ?";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating_name);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8" />
	<title><?php echo $rating_name . ' Rated Movies' ?></title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
  </head>
<body>
  <form class="back-button" action="index.php" method="get">
    <input type="submit" class="btn btn-default" value="Home">
  </form>
  <h2 class="results-title">All <em><?php echo $rating_name ?></em> Movies:</h2>
    <div class="table-responsive">
 		<table class="table">
		  <tr>
    	  	<th>Title</th>
      	  	<th>Genre</th>
    	  	<th>Format</th>
  		  </tr>
  		  <?php foreach ($dvds as $dvd) : ?>
	  	  <tr>
	      	<td>
	  	  	  <?php echo $dvd->title ?>
	      	</td>
	      	<td>
	  	  	  <?php echo $dvd->genre_name ?>
	      	</td>
	      	<td>
	  	  	  <?php echo $dvd->format_name ?>
	      	</td>
	  	  </tr>
    	  <?php endforeach; ?>
  		</table>
  	</div>
</body>
</html>