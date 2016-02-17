<?php
$dossier_traite = "temp";
$tempDir = opendir($dossier_traite);
while (false !== ($fichier = readdir($tempDir))) {
	$chemin = $dossier_traite."/".$fichier;
	if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier) AND pathinfo($f, PATHINFO_EXTENSION) == 'jpg') {
		unlink($chemin);
	}
}
closedir($tempDir);
