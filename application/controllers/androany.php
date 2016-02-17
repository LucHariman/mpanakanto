<?php
class Androany extends CI_Controller {
	
	function index($limite = null) {
		
		$facebook = new Facebook(array(
				'appId'  => FB_APP_ID,
				'secret' => FB_SECRET,
		));
		$user = $facebook->getUser();
		
		if ($user != SPOT_ID) {
			echo "De gaga enao !!!";
			return;
		}
		
		
		
		
		$this->load->model('User');
		
		$total = $this->User->countAll();
		$users = $this->User->getAll($limite, array('derniere_visite', 'desc'));
		
		$this->load->view('androany', array(
				'total' => $total,
				'users' => $users,
				'facebook' => $facebook));
		
	}
	
	function getPhotos($userId) {
		
		$rep = realpath("resources/temp");
		$dir = opendir($rep);
		$imgs = array();
		while ($f = readdir($dir)) {
			$path = $rep."/".$f;
			if(is_file($path)
					&& pathinfo($f, PATHINFO_EXTENSION) == 'jpg'
					&& strpos($f, $userId) !== false) {
				array_push($imgs, $f);
			}
		}
		echo json_encode(array('count' => count($imgs), 'imgs' => $imgs));
	}
	
}
