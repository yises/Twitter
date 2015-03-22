<?php

ini_set('display_errors', 2);
require_once('config/conf.php');
require_once('library/TwitterAPIExchange.php');
require_once('library/database.php');

$db = new Database($dbUser,$dbPass,$dbTable,$dbHost);

/*//Si existe el valor memcached se utiliza, en caso contrario se hayan los valores y se insertan
$memcache = new Memcached();
$memcache->addServer('localhost',11211);
$rows = $memcache->get("tweets");
if($rows === false){
	var_dump('NO ESTÁ');
	//No está en memcache*/
	$rows = $db->getData();
/*	$memcache->set("tweets",$rows);
}else{
	var_dump('Sí ESTÁ');
}*/
?>
<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Listado de Tweets almacenados</title>
		<link rel="stylesheet" href="css/foundation.css" />
		<link rel="stylesheet" href="css/styles.css" />
		<script src="js/vendor/modernizr.js"></script>
	</head>
	<body>
		
		<div class="row">
			<div class="large-12 columns">
				<h1>Listado de Tweets almacenados</h1>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<?php
					foreach($rows as $row){
						echo '
							<div class="panel large-6 columns">
								<p>Nombre: '.$row[0].'</p>
								<p>'.htmlentities($row[1]).'</p>
								<p>Hashtag: '.$row[2].'</p>
							</div>';
					}
				?>
			</div>
		</div>
		
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script>
			$(document).foundation();
		</script>
	</body>
</html>
