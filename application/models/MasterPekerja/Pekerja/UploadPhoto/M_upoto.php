<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_upoto extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->load->database();
	}

	public function getInfo()
	{
		$sql="	SELECT noind,nama, trim(photo) photo
				FROM hrd_khs.tpribadi 
				where keluar=false
				group by noind,2,3
				order by noind ASC";
		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

	public function insert_link($noInd)
	{
		$sql="	UPDATE hrd_khs.tpribadi set
				photo='http://erp.quick.com/assets/img/photo/$noInd.JPG', path_photo='http://erp.quick.com/assets/img/photo/$noInd.JPG'
				where noind='$noInd'";
		$query = $this->personalia->query($sql);
	}
}