<center>

<form method="post" action="<?php echo base_url('picture/addPhoto'); ?>">
	<input type="text" name="nom" title="nom"/>
	<select name="sexe">
		<option value="homme" selected="selected">Homme</option>
		<option value="femme">Femme</option>
	</select>
	<input type="text" name="lien" title="lien"/>
	<input type="submit" value="ajouter" />
</form>

<br/>


<?php
foreach ($photos as $photo) {
?>
	
	<div style="float: left; width: 300px; height: 300px; margin: 5px; position: relative">
		<div style="position: absolute; width: 300px;
				text-align: center; color: white;
				background-color: <?php echo ($photo->sexe == "homme") ? "#3B5998" : "#DD5E9D"?>">
			<?php echo $photo->nom; ?>
		</div>
		<img src="<?php echo getResources("images/artistes/a_" . $photo->lien . ".jpg"); ?>" />
	</div>
	
<?php 
}
?>
</center>
