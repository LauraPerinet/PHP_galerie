<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Creez votre galerie photo</title>
	<script>
		function transferRight(element){
			var nom_photo=element.getAttribute("data-nom");
			var option="<option value='"+nom_photo+"' selected='selected'>"+nom_photo+"</option>";
			var select=document.getElementById('photos_choisies');

			select.insertAdjacentHTML('beforeend',option);
			
			
		}
	</script>
	<link href="css/styles.css" type="text/css" rel="stylesheet"/>
</head>

<body>
	<div id="global">
	<h1>Créez votre Galerie</h1>
	<p>Choississez les photos que vous voulez faire apparaitre dans votre galerie</p>
	<form method="post" action="lib/creation_galerie.lib.php">
		<p><label>Nom de votre galerie : </label><input type="text" name="nom_galerie"/></p>
		<ul id="photos_possibles">
			<?php
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
							echo '<li ><div  class="vignettes"><img  ondblclick="transferRight(this)" data-nom="'.$photo['nom'].'" src="img/'.$photo['nom'].'" /></div></li>';
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
		</ul>
		<select multiple="multiple" size="10" name="photos_choisies[]" id="photos_choisies">
		</select>
		<input type="submit" value="créer ma galerie" />
		
	</form>
	</div>
	</body>
</html>