<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_reffjamlembur extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);


	}

	
	public function lihat(){
		$sql = "select *
				from \"Presensi\".treffjamlembur";

		$result = $this->personalia->query($sql);
		return $result->result_array();
	}

	 public function input($input)
	 	{
	 		$this->personalia->insert('"Presensi".treffjamlembur',$input);
	 	}
	   public function GetReffJamLembur($id)
	    {

	    	$sql = "select *
				from \"Presensi\".treffjamlembur where id='$id'";

		$result = $this->personalia->query($sql);
		return $result->result_array();
	    }

	       public function delete($id)
	    {
	    	$sql = "delete from \"Presensi\".treffjamlembur where id='$id'";
		$result = $this->personalia->query($sql);
		return $result;
	    }


	    public function update($id,$data)
	    {
			$this->personalia->where('id', $id);
	    	$this->personalia->update('"Presensi".treffjamlembur',$data);

	    }
};    




