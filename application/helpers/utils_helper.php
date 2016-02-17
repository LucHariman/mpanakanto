<?php
function getResources($argSite = "") {
	return base_url() . "resources/" . $argSite;
}

function loadJpeg($imgname)
{
	/* Tente d'ouvrir l'image */
	$im = @imagecreatefromjpeg(str_replace("https:", "http:", $imgname));

	/* Traitement en cas d'échec */
	
	if(!$im)
	{
		/* Création d'une image vide */
		$im  = imagecreatetruecolor(150, 30);
		$bgc = imagecolorallocate($im, 255, 255, 255);
		$tc  = imagecolorallocate($im, 0, 0, 0);

		imagefilledrectangle($im, 0, 0, 100, 100, $bgc);

		/* On y affiche un message d'erreur */
		imagestring($im, 1, 5, 5, 'Tsy kobo' . $imgname, $tc);
	}
		

	return $im;
}

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
	// creating a cut resource
	$cut = imagecreatetruecolor($src_w, $src_h);

	// copying relevant section from background to the cut resource
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

	// copying relevant section from watermark to the cut resource
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

	// insert cut resource to destination image
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}