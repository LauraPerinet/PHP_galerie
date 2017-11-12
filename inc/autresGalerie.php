<?php
$conn=new Mongo('localhost');

		// connexion à la bdd
		$bdd=$conn -> Galeries_Photos;
		$col = $bdd ->galeries;

		$cur = $col ->find();
		$num=$cur->count();
?>
<h2>Autres galeries</h2>
<ul class="liste_galeries">
	<?
	if($num > 0){
		foreach($cur as $gal){
			?>
		<li>
			
			<? 
			echo '<a href="ma-galerie.php?id='.$gal['_id'].'" >';
			echo $gal['nom']; ?>
			<br/>
			<span class="ssTitre">
			<?
			if(isset($gal['theme'])) echo $gal['theme'].' - ';
			echo $gal['date_creation'];
			?>
			</span>
			</a>
		</li>
			<?
		}
	}
	?>
</ul>