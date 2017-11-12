<?php
	
if(isset($_POST['photos_choisies'])){
	$message="La création de votre galerie est en cours. Merci de patienter.";
	try{
		//Connexion database
		$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$collection = $bdd ->galeries;

		for($i=0; $i<count($_POST['photos_choisies']);$i++){
			$photos[$i]=$_POST['photos_choisies'][$i];	
			
		}
		date_default_timezone_set('UTC');
		
		$nom_galerie = $_POST['nom_galerie']!="" ?  $_POST['nom_galerie'] : "Galerie sans titre" ;
		$theme_galerie = $_POST['theme_galerie']!="" ?  $_POST['theme_galerie'] : "" ;
		
		if(isset($_GET['id'])){
			
			$galerie = $collection->findOne(array('_id' => new MongoId($_GET['id'])));
			
			echo $galerie['nom'];
			if($galerie['nom']!=$nom_galerie) {
				$galerie['nom'] = $nom_galerie;
			}
			if($galerie['theme']!=$theme_galerie) {
				$galerie['theme'] = $theme_galerie;
			}
			$galerie['photos'] = $photos;
			$galerie['date_maj'] = date('j/m/Y');
			
			$collection->save($galerie);
			$id_galerie=$_GET['id'];
			
		}else{
			echo 'creation';
			$galerie=array(
				'nom'=>$nom_galerie,
				'theme'=>$theme_galerie,
				'photos'=>$photos,
				'date_creation'=>date('j/m/Y'),
				'date_maj'=>date('j/m/Y')
			);
			$collection -> insert($galerie);
			$id_galerie=$galerie['_id'];
		}
		
		
		
		$conn->close();
		header("Location:../ma-galerie.php?id=".$id_galerie);
	}
	catch(MongoConnectionException $e){
		echo $e->getMessage();
	}
	catch (MongoException $e){
		echo $e->getMessage();
	}
}else{
	$message="Vous n'avez pas sélectionné de photo  ! <a href='../index.php'>Retournez à la page de création de galerie</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Galerie</title>
	<link href="../css/styles.css" type="text/css" rel="stylesheet"/>
   
</head>
<body>
	<div id='global'>
		<id ='col_droite'>
		<h1>Création de votre galerie</h1>
		<p><? echo $message;?></p>
	</div>
</body>
</html>
