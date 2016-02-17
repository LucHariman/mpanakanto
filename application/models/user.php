<?php
class User extends Acicrud {

	//CONSTRUCTOR
	public function __construct() {
		parent::Acicrud('users');
	}
	
	public function listeAuHasard($limite = 8) {
		return $this->db->query("select userid from users order by rand() limit " . $limite)->result();
	}
	
	public function incrementerPartage($userid) {
		$this->db->query("update users set nb_partage = nb_partage + 1 where userid = '$userid'");
	}

}