<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Creez votre galerie photo</title>
	<script>
		function transferRight(element){
			var select=document.getElementById('photos_choisies_hidden');
			var liste=document.getElementById("photos_choisies");
			var no_photo=document.getElementById("no_photo");
			if(element.checked){
				no_photo.setAttribute("class", "hidden");
				var li="<li>"+nom_photo+"</li>";
				var nom_photo=element.getAttribute("data-nom");
				select.insertAdjacentHTML('beforeend',option);
			}
			
			
			
		}
	</script>
	<link href="css/styles.css" type="text/css" rel="stylesheet"/>
</head>

<body>
	<div id="global">
	
	<form method="post" action="lib/creation_galerie.lib.php">
		<div id="col_gauche">
			<h1>Créez votre Galerie</h1>
			<p><label for="nom_galerie">Nom de votre galerie : </label><input type="text" name="nom_galerie" id="nom_galerie"/></p>
			<p><label for="theme_galerie">Thématique de votre galerie</label><input type="text" name="theme_galerie"/></p>
			<h2>Photos selectionnées</h2>
			<ul id="photos_choisies">
				<li id="no_photo" >Aucune photo selectionnée</li>
			</ul>
			<input type="submit" value="créer ma galerie" />
		</div>
		<div id="col_droite">
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
							echo '<li ><div  class="vignettes" style="background-image:url(img/'.$photo['nom'].')"><input onclick="transferRight(this)" type="checkbox" value="'.$photo['nom'].'"/></div></li>';
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
		</div>
		<select multiple="multiple" size="10" name="photos_choisies[]" id="photos_choisies_hidden" class="hidden">
		</select>
		
	</form>
	</div>
	</body>
</html>