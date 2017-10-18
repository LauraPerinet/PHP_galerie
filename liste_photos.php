<?php
echo "Lecture bdd";

try{
//Connexion database
$conn=new Mongo('localhost');

// connexion à la bdd
$bdd=$conn -> Galeries_Photos;

$collection = $bdd ->photos;

$cursor = $collection ->find();
$num_doc=$cursor->count();
if($num_doc > 0){
	foreach($cursor as $photo){
		echo "<option value=".$photo[_id]."'>".$photo['nom']."</option>";
	}
}else{
	echo 'pas de photos enregistrées';
}

$conn->close();

}
catch(MongoConnectionException $e){
	echo $e->getMessage();
}
catch (MongoException $e){
	echo $e->getMessage();
}

?>