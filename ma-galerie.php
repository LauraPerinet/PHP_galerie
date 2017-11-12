<?php
	try{
		//Connexion database
		$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$collection = $bdd ->galeries;
		
		
		$galerie = $collection->findOne(array('_id' => new MongoId($_GET['id'])));
		
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galerie</title>
	<link href="css/styles.css" type="text/css" rel="stylesheet"/>
    <link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
   
</head>
<body>
<div id="global">


	<div id="col_gauche">
		<h1><? echo $galerie['nom']; ?></h1>
		<p><? echo $galerie['theme']; ?></p>
		<p>Créée le <? echo $galerie['date_creation']; ?></p>
		<p> <? if(isset($galerie['date_maj'])) echo 'Dernière mise à jour : '.$galerie['date_creation']; ?></p>
		
		<? include('inc/autresGalerie.php');?>
		<h2>Souhaitez vous une <a href="index.php">autre galerie ?</a></h2>
		<h2>Souhaitez vous <a href="index.php?id=<? echo $_GET['id']?>">modifier cette galerie ?</a></h2>
		<h2>Souhaitez vous <a href="lib/suppression_galerie.lib.php?id=<? echo $_GET['id']?>">supprimer cette galerie ?</a></h2>
	</div>
	<div id="col_droite">
		<div id="sliderFrame">
			<div id="slider">
				<?
					$photos = $galerie['photos'];
					for($i=0; $i<count($photos); $i++){
						echo '<img src="img/'.$photos[$i].'" alt="'.$photo[$i].'" />';
					}
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?
		$conn->close();

		}
		catch(MongoConnectionException $e){
			echo $e->getMessage();
		}
		catch (MongoException $e){
			echo $e->getMessage();
		}
?>