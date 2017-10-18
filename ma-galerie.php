<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Votre galerie</title>
	<link href="css/styles.css" type="text/css" rel="stylesheet"/>
	<script>
		function transferRight(element){
			document.getElementById('photos_choisies').appendChild(element);
		}
	</script>
</head>

<body>
	<div id="global">
	<?php
	try{
		//Connexion database
		$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$collection = $bdd ->galeries;
		
		$galerie = $collection->findOne(array('_id' => new MongoId($_GET['id'])));
		echo '<h1>'.$galerie['nom'].'</h1>';
		echo '<div id="caroussel">';
		$photos = $galerie['photos'];
		for($i=0; $i<count($photos); $i++){
			echo '<div id="img'.$i.'"><img src="img/'.$photos[$i].'" alt="'.$photo[$i].'" /></div>';
		}
		echo '</div>';
		$conn->close();

		}
		catch(MongoConnectionException $e){
			echo $e->getMessage();
		}
		catch (MongoException $e){
			echo $e->getMessage();
		}
		?>
	</div>
</body>
</html>