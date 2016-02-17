<?php
class Picture extends CI_Controller {
	
	function index()
	{
		$facebook = new Facebook(array(
				'appId'  => FB_APP_ID,
				'secret' => FB_SECRET,
				'fileUpload' => true
		));
		$user = $facebook->getUser();
		
		if ($user != SPOT_ID) {
			echo "De gaga enao !!!";
			return;
		}
		
		$this->load->model('Photo');
		$photos = $this->Photo->getAll(null, array('id', 'desc'));
		$this->load->view('picture', array(
			'photos' => $photos
		));
	}
	
	function addPhoto() {
		$data = $this->input->post();
		$p->nom = $data['nom'];
		$p->sexe = $data['sexe'];
		$p->lien = date_format(date_create(), "U");
		
		$artistPicture = loadJpeg($data['lien']);
		$aw = imagesx($artistPicture);
		$ah = imagesy($artistPicture);
		
		if ($aw > $ah) {
			$arw = 300;
			$arh = $arw * $ah / $aw;
		} else {
			$arh = 300;
			$arw = $arh * $aw / $ah;
		}
		
		$artistResizedPicture = imagecreatetruecolor($arw, $arh);
		imagecopyresampled($artistResizedPicture, $artistPicture, 0, 0, 0, 0, $arw, $arh, $aw, $ah);
		
		$fileName = "a_" . $p->lien . ".jpg";
		imagejpeg($artistResizedPicture, realpath("resources/images/artistes") . "/" . $fileName);
		
		$this->load->model('Photo');
		$this->Photo->create($p);
		
		redirect('picture');
	}
	
}