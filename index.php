<?php  

	
	require('class.paginate.php');

	$paginate = new Paginate([
		'total'					=>	'100',
		'number_per_page'		=>	'20',
		'lrmpn'					=>	'3', 
		'selector'				=>	'page',
		'previous'				=>	'<li><a href="%page">&laquo;</a></li>',
		'normal'				=>	'<li><a href="%page">%number</a></li>',
		'active'				=>	'<li class="active"><a href="%page">%number</a></li>',
		'next'					=>	'<li><a href="%page">&raquo;</a></li>'
	]);


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Paginate</title>
	<style type="text/css">
		ul { display: flex; text-decoration: none; list-style: none; background: gray;}
		ul li { padding: 10px; background: yellowgreen; margin: 0px 2px; }
		ul li a { text-decoration: none; }
		.active { color: navy; border: 1px solid red; }
		.center { text-align: center; }
	</style>
</head>
<body>

	<h1 class="center"> Paginate </h1>

	<p>
		LIMIT for SQL QUERY ( you use limit in you sql query , to display right data per page ) : 
		<b><?= $paginate->limit() ?></b>
	</p>

	<h3>PAGINATION RENDERING</h3>
	
	<ul>
		<?= $paginate ?>
	</ul>

	<br>

</body>
</html>