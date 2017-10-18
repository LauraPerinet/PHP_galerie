<?php

try {

//Connexion database
$conn=new Mongo('localhost');

// connexion à la bdd
$bdd=$conn -> Galeries_Photos;

$collection = $bdd ->photos;

for($i=0; $i<20;$i++){
	$photo=array(
		'nom'=>'photo'.$i.'.jpg'	
	);
	$collection ->insert($photo);
}




echo 'produit indéré avec l\'id : '.$photo['nom'].'\n';

$conn->close();
}
catch(MongoConnectionException $e){
	echo $e->getMessage();
}
catch (MongoException $e){
	echo $e->getMessage();
}

?>