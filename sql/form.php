<?php
//

//in class

// Create and include a configuration file with the database connection
include('config.php');

// Get an associative array of categories from the database
$sql = file_get_contents('sql/getAllCategories.sql');
$statement = $database->prepare($sql);
$statement->execute();

$allCategories = $statement->fetchAll(PDO::FETCH_ASSOC);
// Dynamically print the categories as options in the form
//Done

// Get type of form either add or edit from the URL (ex. form.php?action=add)
$action = $_GET['action'];

// If form submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// if the type of form specified in the URL is add must actually have typed in /form.php?action=add at end of URL
	if($action == 'add') {
		// Get variables from the form submitted using $_POST
		$isbn = $_POST['isbn'];
		$title = $_POST['book_title'];
		$bookCategories = $_POST['book-category'];
		// need author and price still

		// Insert the book into the database
		$sql = file_get_contents('sql/insertSampleBook.sql');
		$params = array(
			'isbn' => $isbn,
			'title' => $title,
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		$sql = file_get_contents('sql/insertBookCategory.sql');
		// Set the categories of the book in the database
		foreach($bookCategories as $category) {
			$params = array(
				'isbn' => $isbn,
				'categoryid' => $categoryID
			);
			$statement = $database->prepare($sql);
			$statement->execute($params);
		}
	}

		// Redirect to book listing page
	header('location: index.php');
	die();
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

  	<title>Add New Book</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Add New Book</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>ISBN:</label>
				<input type="text" name="isbn" class="textbox" />
			</div>
			<div class="form-element">
				<label>Title:</label>
				<input type="text" name="book-title" class="textbox" />
			</div>
			<div class="form-element">
				<label>Category:</label>
				<?php foreach($allCategories as $category) : ?>
					<input class="radio" type="checkbox" name="book-category[]" value="<?php echo $category['categoryid'] ?>" />
					<?php echo $category['name'] ?>
					<!-- </span> -->
					<br />
				<?php endforeach ?>
			</div>
			<div class="form-element">
				<label>Author</label>
				<input type="text" name="book-author" class="textbox" />
			</div>
			<div class="form-element">
				<label>Price:</label>
				<input type="number" step="any" name="book-price" class="textbox" />
			</div>
			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</form>
	</div>
</body>
</html>
