
<?php
//in class


// Create and include a configuration file with the database connection
include('config.php');
// Get a list of books from the database
$sql = file_get_contents('sql/getAllBooks.sql');
$statement = $database->prepare($sql);
$statement->execute();

$allBooks = $statement->fetchAll(PDO::FETCH_ASSOC);

// Get a list of categories for each book from the database
$sql = file_get_contents('sql/getBooksCategories.sql');
$statement = $database->prepare($sql);
$statement->execute();

$booksCategories = $statement->fetchAll(PDO::FETCH_ASSOC);

// Create an associative array storing the categories of each book indexed by isbn
$books = array();

foreach($allBooks as $book) {
	$books[$book['isbn']] = array(
		'title' => $book['title'],
		//also need Price
		'categories' => array()
	);
}


foreach($booksCategories as $bookCategory) {
	$books[$bookCategory['isbn']]['categories'][] = $bookCategory['name'];
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

  	<title>Books</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Books</h1>
		<pre>
			<?php print_r($books); ?>
		</pre>
		<?php // Loop over books printing the title, price and list the categories ?>
		<?php foreach($books as $book) : ?>
			<div class="book">
				<h2>
					<?php echo $book['title'] ?>
				</h2>
				<ul>
					<?php foreach($book['categories'] as $category) : ?>
						<li>
							<?php echo category ?>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php endforeach ?>
	</div>
</body>
</html>
