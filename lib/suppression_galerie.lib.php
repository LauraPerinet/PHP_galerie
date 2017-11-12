<?php
	
if(isset($_GET['id'])){
	try{
		//Connexion database
		$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$collection = $bdd ->galeries;

		$collection->remove(array('_id' => new MongoId($_GET['id'])));
		
		
		$conn->close();
		header("Location:../index.php");
	}
	catch(MongoConnectionException $e){
		echo $e->getMessage();
	}
	catch (MongoException $e){
		echo $e->getMessage();
	}
}
