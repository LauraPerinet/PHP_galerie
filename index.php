<?php
function options_photos_preselectionnee($photos_enregistrees){
if(isset($_GET['id']) && count($photos_enregistrees)>0){
		for($i=0; $i<count($photos_enregistrees) ; $i++){
			echo '<option selected="selected">'.$photos_enregistrees[$i].'</option>';
		}
	}
}
function verifie_selection($nom, $photos_enregistrees){
	$checked=false;
	for($i=0; $i<count($photos_enregistrees) ; $i++){
		if($nom==$photos_enregistrees[$i]){
			$checked=true;
			break;
		}
	}
	return $checked;
}
function affichage_photos($photos_enregistrees){
	if(isset($_GET['id']) && count($photos_enregistrees)>0){
		for($i=0; $i<count($photos_enregistrees) ; $i++){
				echo "<li>".$photos_enregistrees[$i]."</li>";
		}
		
	}else{
		echo '<li id="no_photo" >
				<span class="ssTitre">Aucune photo selectionnée</span>
			</li>';
	}

}
try{
	//Connexion database
	$conn=new Mongo('localhost');

	// connexion à la bdd
	$bdd=$conn -> Galeries_Photos;
	$collection = $bdd ->photos;

	$cursor = $collection ->find();
	$num_doc=$cursor->count();
	
	if(isset($_GET['id'])){
		$action="Modifiez";
		$collection_gal = $bdd -> galeries;
		$galerie = $collection_gal->findOne(array('_id' => new MongoId($_GET['id'])));
		
		$photos_enregistrees = $galerie['photos'];
		$nom=$galerie['nom'];
		$theme=$galerie['theme'];
	}else{
		$action="Créez";
	}
	
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><? echo $action; ?> votre galerie photo</title>
	<link href="css/styles.css" type="text/css" rel="stylesheet"/>
	<script>
	
		function creer_balise(balise, texte){
			var b=document.createElement(balise);
			b.appendChild(document.createTextNode(texte));
			
			return b;
		}
		
		function transferRight(element){
			var select=document.getElementById('photos_choisies_hidden');
			var liste=document.getElementById("photos_choisies");
			var no_photo=document.getElementById("no_photo");
			var nom_photo=element.getAttribute("value");
			
			if(element.checked){
			
				var li = creer_balise("li", nom_photo);
				var option= creer_balise("option", nom_photo);
				option.setAttribute("selected","selected");
				liste.appendChild(li);
				select.appendChild(option);
				
				no_photo.setAttribute("class", "hidden");
				
			}else{
				
				list_items=liste.getElementsByTagName('li');
				for(let i=1; i<list_items.length; i++){
					text = list_items[i].textContent;
					if(text == nom_photo){
						console.log(list_items[i]);
						liste.removeChild(list_items[i]);
						
						select.removeChild(select.getElementsByTagName('option')[i-1]);
					}
				}
				
				if(list_items.length==1){
					no_photo.setAttribute("class", "");
				}
			}
		}
	</script>
</head>

<body>
	<div id="global">
	
	<form method="post" action="lib/creation_galerie.lib.php<?if(isset($_GET['id'])) echo "?id=".$_GET['id']; ?>">
		<div id="col_gauche">
			<h1><? echo $action;?> votre Galerie</h1>
			<p>
				<label for="nom_galerie">Nom de votre galerie : </label>
				<input type="text" name="nom_galerie" id="nom_galerie" <?if(isset($_GET['id'])) echo 'value="'.$nom.'"';?>/>
			</p>
			<p>
				<label for="theme_galerie">Thématique de votre galerie</label>
				<input type="text" name="theme_galerie" <?if(isset($_GET['id'])) echo 'value="'.$theme.'"';?>/>
			</p>
			<h2>Photos selectionnées</h2>
			<ul id="photos_choisies">
				<li id="no_photo" class="hidden">
								<span class="ssTitre">Aucune photo selectionnée</span>
				</li>
				<?php
					affichage_photos($photos_enregistrees);
					
				?>
				
			</ul>
			<input type="submit" value="<? echo $action;?> votre galerie" />
			<? include('inc/autresGalerie.php');?>
			
		</div>
		<div id="col_droite">
			<ul id="photos_possibles">
				
				<?php
					if($num_doc > 0){
						foreach($cursor as $photo){
							if(isset($_GET['id'])){
								$checked=verifie_selection($photo['nom'], $photos_enregistrees);
								
							}
				?>
							<li >
								<div  class="vignettes" style="background-image:url(img/<?echo $photo['nom']; ?>)">
									<input onclick="transferRight(this)" type="checkbox" value="<?echo $photo['nom']; ?>" <?if($checked) echo 'checked="checked"'; ?>
									/>
								</div>
							</li>
				<?
						}
					}else{
				?>
					<p>Pas de photos enregistrées... </p>
				<?
					}
				?>

			</ul>
		</div>
		<select multiple="multiple" size="10" name="photos_choisies[]" id="photos_choisies_hidden" class="hidden">
			<?
				options_photos_preselectionnee($photos_enregistrees);
			?>
		</select>
		
	</form>
	</div>
	</body>
</html>
<?php
					
					$conn->close();

				}
				catch(MongoConnectionException $e){
					echo $e->getMessage();
				}
				catch (MongoException $e){
					echo $e->getMessage();
				}
?>