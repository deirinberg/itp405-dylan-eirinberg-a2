<?php

if (!isset($_GET['dvd_title'])) {
  header('Location: index.php');
  exit();
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pw = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pw);

$dvd_title = $_GET['dvd_title'];

$sql = "SELECT title, genre_name, format_name, rating_name
		  FROM dvds
		  INNER JOIN genres
			ON dvds.genre_id = genres.id
		  INNER JOIN formats
   		    ON dvds.format_id = formats.id
  		  INNER JOIN ratings
    		ON dvds.rating_id = ratings.id
		  WHERE title LIKE ?";

$statement = $pdo->prepare($sql);
$like = '%' . $dvd_title . '%';
$statement->bindParam(1, $like);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8" />
	<title><?php echo $dvd_title . ' Results' ?></title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
  </head>
<body>
  <?php if ($statement->rowCount() == 0): ?>
  	<h2>No results for <em><?php echo $dvd_title ?></em></h2>
  	<form action="index.php" method="get">
    	<input type="submit" class="btn btn-default" value="Try Again">
    </form>
  <?php else: ?>
  	<form class="back-button" action="index.php" method="get">
    	<input type="submit" class="btn btn-default" value="Back">
    </form>
    <h2 class="results-title">You searched for <em><?php echo $dvd_title ?></em>:</h2>
    <div class="table-responsive">
 	<table class="table">
	  <tr>
    	<th>Title</th>
    	<th>Genre</th>
    	<th>Format</th>
    	<th>Rating</th>
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
	      <td>
	  	    <a href=<?php echo "./ratings.php?rating_name=" . $dvd->rating_name ?>>
	  		  <?php echo $dvd->rating_name ?>
	  	    </a>
	      </td>
	    </tr>
      <?php endforeach; ?>
    </table>
    </div>
  <?php endif ?>
</body>
</html>
