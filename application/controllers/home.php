<?php
class Home extends CI_Controller {

	function index($special = null)
	{
		/* ##################################################
		 * Script de connexion fb
		 * ################################################## */
		
		$facebook = new Facebook(array(
				'appId'  => FB_APP_ID,
				'secret' => FB_SECRET,
				'fileUpload' => true
		));
		
		$user = $facebook->getUser();
		
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
			} catch (FacebookApiException $e) {
				error_log($e);
//				$facebook->destroySession();
				$user = null;
			}
		}

		if (!$user) {
			$loginUrl = $facebook->getLoginUrl(array(
				'scope' => 'publish_stream'
			));
//			$loginUrl = $facebook->getLoginUrl();
			$this->load->view("redirection", array('loginUrl' => $loginUrl));
//			echo "<script>window.location.href='$loginUrl';</script>";
			return;
		}
		
		/* ################################################## */
		
		/* ##################################################
		 * Selection de l'image
		* ################################################## */

		$sexe = ($user_profile['gender'] == "male") ? "homme" : "femme";
		
		$this->load->model('Photo');
		
		$count = $this->Photo->countAll(array('sexe' => $sexe));
		
		$cr = crc32($user . date_format(date_create(), "Y-m-d"));
		$rand = $cr % $count;
		
		$data = $this->Photo->getAll(array($rand, 1), null, array('sexe' => $sexe));
		$artisteData = $data[0];
		
		if ($special != null) {
			$essai = $this->Photo->getBy('lien', $special);
			if (!empty($essai))
				$artisteData = $essai[0];
		}
		
		/* ################################################## */
		
		
		/* ##################################################
		 * Generation de l'image
		 * ################################################## */
		
		$profilePictureData = $facebook->api('/me', array(
			'fields' => 'picture'
		));
		$profilePictureUrl = $profilePictureData['picture']['data']['url'];
		$profilePictureUrl = str_replace("_q.jpg", "_s.jpg", $profilePictureUrl);

		$artistePictureUrl = getResources("images/artistes/a_" . $artisteData->lien . ".jpg");
		
		$background = loadJpeg(getResources("images/background.jpg"));
		$profilePicture = loadJpeg($profilePictureUrl);
		$artistPicture = loadJpeg($artistePictureUrl);
		
		$aw = imagesx($artistPicture);
		$ah = imagesy($artistPicture);
		
		$ax = 180;
		$ay = 100;
		
		if ($aw > $ah) {
			$ay += (300 - $ah) / 2;
		} else {
			$ax += (300 - $aw) / 2;
		}
		
		$pw = imagesx($profilePicture);
		$ph = imagesy($profilePicture);
		
		$profileBorder = imagecreate($pw + 10, $ph + 10);
		imagecolorallocate($profileBorder, 204, 204, 204);
		
		$artistBorder = imagecreate($aw + 10, $ah + 10);
		imagecolorallocate($artistBorder, 204, 204, 204);
		
		imagecopymerge($background, $profileBorder, 35, 35, 0, 0, $pw + 10, $ph + 10, 100);
		imagecopymerge($background, $profilePicture, 40, 40, 0, 0, $pw, $ph, 100);
		imagecopymerge($background, $artistBorder, $ax - 5, $ay - 5, 0, 0, $aw + 10, $ah + 10, 100);
		imagecopymerge($background, $artistPicture, $ax, $ay, 0, 0, $aw, $ah, 100);
		
		$etoilePicture = imagecreatefrompng(getResources("images/star.png"));
		$ew = imagesx($etoilePicture);
		$eh = imagesy($etoilePicture);
		imagecopymerge_alpha($background, $etoilePicture, $ax + $aw - 60, $ay - 85, 0, 0, $ew, $eh, 100);
		
		$textBackground = imagecolorallocate($background, 255, 255, 255);
		imagettftext($background, 32, 0, 40, 460, $textBackground,
				realpath("resources/fonts/Callie_Hand.otf"),
				$artisteData->nom);
		
		$tempFileName = $user . "_" . date_format(date_create(), "Ymd") . ".jpg";
		$path = realpath("resources/temp") . "/" . $tempFileName;
		imagejpeg($background, $path);
		imagedestroy($background);
		
		/* ################################################## *
		 * mise a jour de la table users
		 * ################################################## */
		$this->load->model('User');
		$derniere_visite = date('Y-m-d H:i:s', filemtime($path));
		$us = $this->User->getBy('userid', $user);
		if (!empty($us)) {
			$u = $us[0];
			$u->derniere_visite = $derniere_visite;
			$this->User->update($u);
		} else {
			$u->id = null;
			$u->userid = $user;
			$u->derniere_visite = $derniere_visite;
			$this->User->create($u);
		}
		
		$totalVisiteur = $this->User->countAll();
		$hasard = $this->User->listeAuHasard();
				
		$this->load->view('main', array(
				'tempFileName' => $tempFileName,
				'userId' => $user,
				'totalVisiteur' => $totalVisiteur,
				'hasard' => $hasard
		));
		
		/* ################################################## */
		
	}
	
	function partagerImage() {
		$data = $this->input->post();
		
		$imagePath = realpath("resources/temp/" . $data['tempFileName']);
		
		$args = array(
				'message' => $data['message'] . "\n\nTsidiho : https://apps.facebook.com/mpanakanto/ na " . base_url(),
				'source' => '@' . $imagePath);
		
		$facebook = new Facebook(array(
				'appId'  => FB_APP_ID,
				'secret' => FB_SECRET,
				'fileUpload' => true
		));
		$res = $facebook->api('/me/photos', 'post', $args);
		
		$this->load->model('User');
		$user = $facebook->getUser();
		$this->User->incrementerPartage($user);
		
		echo $res['id'];
		
	}
		
}