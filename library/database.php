<?php 
class Database{
	private $dbUser;
	private $dbPass;
	private $dbTable;
	private $dbHost;
	private $db;
	public function __construct($dbUserT,$dbPassT,$dbTableT,$dbHostT){
		$this->dbUser = $dbUserT;
		$this->dbPass = $dbPassT;
		$this->dbTable = $dbTableT;
		$this->dbHost = $dbHostT;

		// Conectando, seleccionando la base de datos
		$this->db = new mysqli($this->dbHost, $this->dbUser, $this->dbPass,$this->dbTable);
		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
	}

	public function insertData($data,$hashtag){
		$returnHtml = '';
		$idTwitter = $data['id'];
		$texto = $data['text'];
		$user = $data['user']['screen_name'];
		$profile_image = $data['user']['profile_image_url'];

		//Comprobar si existe
		$result = mysqli_query($this->db,"SELECT COUNT(*) as counter FROM hashtag WHERE id_twitter='".$data['id']."'");
		$extract = mysqli_fetch_array($result);

		if($extract['counter'] == 0){
			$result = mysqli_query($this->db,"INSERT INTO hashtag (id_twitter,texto,user,hashtag) VALUES ('".$idTwitter."','".$texto."','".$user."','".$hashtag."')");
			$returnHtml .= '<p>Insertado: </p>';
		}else{
			$returnHtml .= '<p>Repetido: </p>';
		}

		$returnHtml .= "	<img src=\"".$profile_image."\" width=\"25px\" height=\"25px\" /> 
				<a href=\"http://twitter.com/$user\">@".$user."</a>
				".$texto;

		return $returnHtml;
	}

	public function getData(){
		$rows = array();
		$result = mysqli_query($this->db,"SELECT user,texto,hashtag FROM hashtag");

		while($row = $result->fetch_row()) {
		  $rows[]=$row;
		}
		return $rows;
	}

}