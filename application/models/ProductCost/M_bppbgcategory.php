<?php
class M_bppbgcategory extends CI_Model {
	public function __construct()
	{
		$this->oracle = $this->load->database('oracle',true);
		$this->load->library('encrypt');
	}

	public function getBppbgCategory()
	{
		$this->oracle->select('*');
		$this->oracle->from('KHS_USING_CATEGORY_TAB');
		$this->oracle->order_by('LAST_UPDATE_DATE DESC, CREATION_DATE DESC');
		$query = $this->oracle->get();
		return $query->result_array();
	}

	public function setBppbgCategory($a,$b,$c)
	{
		if (empty($c) || $c=='') {
			$c= 'NULL';
		}else{
			$c= "'".$c."'";
		}
		
		$sql = "INSERT INTO KHS_USING_CATEGORY_TAB (USING_CATEGORY_CODE, USING_CATEGORY_DESCRIPTION, GENERAL_DESCRIPTION, CREATION_DATE)
				VALUES('$a', '$b', $c, sysdate)
		";

		$this->oracle->query($sql);
	}

	public function updateCategory($id,$a,$b,$c)
	{
		if (empty($c) || $c=='') {
			$c= 'NULL';
		}else{
			$c= "'".$c."'";
		}
		
		$sql = "UPDATE KHS_USING_CATEGORY_TAB
				SET USING_CATEGORY_CODE = '$a' ,
					USING_CATEGORY_DESCRIPTION = '$b' ,
					GENERAL_DESCRIPTION = $c,
					LAST_UPDATE_DATE = SYSDATE
				WHERE ID = $id
		";

		$this->oracle->query($sql);
	}

	public function deleteCategory($id)
	{
		$this->oracle->where('ID', $id);
		$this->oracle->delete('KHS_USING_CATEGORY_TAB');
	}
}