<?php
	
if(isset($_POST['photos_choisies'])){
	try{
		//Connexion database
		$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$collection = $bdd ->galeries;

		$cursor = $collection ->find();
		$num_doc=$cursor->count();

		for($i=0; $i<count($_POST['photos_choisies']);$i++){
			$photos[$i]=$_POST['photos_choisies'][$i];	
			
		}
		date_default_timezone_set('UTC');
		
		$nom_galerie = $_POST['nom_galerie']!="" ?  $_POST['nom_galerie'] : "Galerie sans titre" ;
		
		$galerie=array(
			'nom'=>$nom_galerie,
			'photos'=>$photos,
			'date_creation'=>date('j/m/Y')
		);
		$collection -> insert($galerie);
		$id_galerie=$galerie['_id'];
		
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
	echo 'Vous n\'avez pas selectionné de photo.<a href="../creation_galerie.php">Créez votre galerie ici</a>';
}

?>