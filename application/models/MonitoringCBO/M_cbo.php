<?php
clASs M_cbo extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

      public function cekCBO($tanggal,$shift,$line,$komponen)
	{
		$sql = "SELECT no_cbo
				FROM mc.mc_cbo WHERE tanggal ='$tanggal' AND shift ='$shift' AND line ='$line' AND komponen ='$komponen'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

    public function shift()
	{
		$sql = "SELECT id,shift_code
				FROM mc.mc_shift";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	 public function cekNomor($nomor)
	{
		$sql = "SELECT * FROM mc.mc_cbo WHERE no_cbo = '$nomor'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function line()
	{
		$sql = "SELECT id,line_code
				FROM mc.mc_line";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getQTY($col,$tipe,$nomor_urut)
	{
		$sql = "SELECT $col  FROM mc.mc_detail WHERE tipe ='$tipe' AND no_cbo = '$nomor_urut'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getDetail($nomor_urut)
	{
		$sql = "SELECT * FROM mc.mc_detail WHERE no_cbo = '$nomor_urut'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getReport($tanggal,$shift,$line,$komponen)
	{
		$sql = "SELECT md.tipe,sum(md.hasil_cat) hasil_cat ,sum(md.ok) ok,sum(md.reject) reject,sum(md.belang_a) belang_a,sum(md.belang_b) belang_b,sum(md.belang_c) belang_c,sum(md.dlewer_a) dlewer_a,sum(md.dlewer_b) dlewer_b,sum(md.dlewer_c) dlewer_c,sum(md.kasar_cat_a) kasar_cat_a,sum(md.kasar_cat_b) kasar_cat_b,sum(md.kasar_cat_c) kasar_cat_c,sum(md.kropos_a) kropos_a,sum(md.kropos_b) kropos_b,sum(md.kropos_c) kropos_c,sum(md.kasar_spat_a) kasar_spat_a,sum(md.kasar_spat_b) kasar_spat_b,sum(md.kasar_spat_c) kasar_spat_c,
			sum(md.kasar_mat_a) kasar_mat_a,sum(md.kasar_mat_b) kasar_mat_b,sum(md.kasar_mat_c) kasar_mat_c,sum(md.lain_lain) lain_lain
 			FROM mc.mc_cbo mc , mc.mc_detail md WHERE mc.no_cbo = md.no_cbo AND mc.tanggal = '$tanggal' AND mc.shift = '$shift' AND mc.line = '$line' 
			AND mc.komponen = '$komponen' group by md.tipe";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function komponen()
	{
		$sql = "SELECT msib.SEGMENT1, msib.DESCRIPTION
		FROM mtl_system_items_b msib,
		bom_operational_routings bor,
		mtl_item_locations mil
		WHERE msib.INVENTORY_ITEM_ID = bor.ASSEMBLY_ITEM_ID
		AND msib.ORGANIZATION_ID = bor.ORGANIZATION_ID
		AND bor.COMPLETION_LOCATOR_ID = mil.INVENTORY_LOCATION_ID
		AND bor.COMPLETION_SUBINVENTORY = 'INT-P&P'
		AND mil.DESCRIPTION = 'KOMPONEN FINISHED PAINTING'
		AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function insertCBO($nomor,$tanggal,$shift,$line,$komponen)
	{
		$sql = "INSERT INTO mc.mc_cbo(no_cbo,tanggal,shift,line,komponen) values('$nomor','$tanggal','$shift','$line','$komponen')";

		$query = $this->db->query($sql);
		
	}

	public function insertDetail($nomor_urut,$tipe)
	{
		$sql = "INSERT INTO mc.mc_detail(no_cbo,tipe) values('$nomor_urut','$tipe')";

		$query = $this->db->query($sql);
		
	}

	public function insertKomponen($komponen)
	{
		$sql = "INSERT INTO mc.mc_komponen(komponen) values('$komponen')";

		$query = $this->db->query($sql);
		
	}

	public function getKomponen($id)
	{
		$sql = "SELECT id,KOMPONEN
				FROM mc.mc_komponen WHERE id=$id";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateDetail($input,$no_urut,$tipe,$col)
	{
		$sql = "UPDATE mc.mc_detail set $col =$col+$input where  no_cbo = '$no_urut' and tipe='$tipe'";

		$query = $this->db->query($sql);

		return true;
		
	}

	public function UpdateKomponen($komponen,$id)
	{
		$sql = "UPDATE mc.mc_komponen set komponen ='$komponen' where id = '$id'";

		$query = $this->db->query($sql);
		
	}

	public function deleteKomponen($id)
	{
		$sql = "DELETE FROM mc.mc_komponen WHERE id = $id";

		$query = $this->db->query($sql);
		
	}

	public function tipe()
	{
		$sql = "SELECT
				ffvt.DESCRIPTION
				FROM fnd_flex_values ffv
				,FND_FLEX_VALUES_TL ffvt
				WHERE ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
				AND ffv.FLEX_VALUE_SET_ID = 1013710
				AND ffv.SUMMARY_FLAG = 'N'
				AND ffv.END_DATE_ACTIVE is null
				AND ffv.ENABLED_FLAG = 'Y'
				AND ffv.FLEX_VALUE like 'A%'
				AND ROWNUM <= 20";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function insertTipe($tipe)
	{
		$sql = "INSERT INTO mc.mc_tipe(tipe) values('$tipe')";

		$query = $this->db->query($sql);
		
	}

	public function getTipe($id)
	{
		$sql = "SELECT id,tipe
				FROM mc.mc_tipe WHERE id=$id";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function UpdateTipe($tipe,$id)
	{
		$sql = "UPDATE mc.mc_tipe set tipe ='$tipe' where id = '$id'";

		$query = $this->db->query($sql);
		
	}

	public function deleteTipe($id) 
	{
		$sql = "DELETE FROM mc.mc_tipe WHERE id = $id";

		$query = $this->db->query($sql);
		
	}

	public function getGrafik($tanggal1,$tanggal2,$shift,$line,$komponen)
	{
		$sql = "SELECT mc.tanggal,sum(md.hasil_cat) hasil_cat ,sum(md.ok) ok,sum(md.reject) reject,(sum(md.belang_a)+sum(md.belang_b)+sum(md.belang_c)) belang,(sum(md.dlewer_a)+sum(md.dlewer_b)+sum(md.dlewer_c)) dlewer,(sum(md.kasar_cat_a)+sum(md.kasar_cat_b)+sum(md.kasar_cat_c)) kasar_cat,(sum(md.kropos_a)+sum(md.kropos_b)+sum(md.kropos_c)) kropos,(sum(md.kasar_spat_a)+sum(md.kasar_spat_b)+sum(md.kasar_spat_c)) kasar_spat,(sum(md.kasar_mat_a)+sum(md.kasar_mat_b)+sum(md.kasar_mat_c)) kasar_mat,sum(md.lain_lain) lain_lain
 				FROM mc.mc_cbo mc , mc.mc_detail md WHERE mc.no_cbo = md.no_cbo  AND mc.shift = '$shift' AND mc.line = '$line' 
				AND mc.komponen = '$komponen' AND mc.tanggal between '$tanggal1' AND '$tanggal2' group by mc.tanggal";

		$query = $this->db->query($sql);
		return $query->result_array();
		
	}
}
?>