<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_gentskk extends CI_Model
{
	var $oracle;
	function __construct()
	{
	  parent::__construct();
	  $this->load->database();
      $this->load->library('encrypt');
      $this->oracle = $this->load->database('oracle', true);
	  $this->db = $this->load->database('default', true);
	  $this->personalia = $this->load->database('personalia', true);
	  $this->lantuma = $this->load->database('lantuma', true);
	}

	public function saveProses($data)
	{
		$this->oracle->insert('KHS_TSKK_PROSES', $data);
		if ($this->oracle->affected_rows()) {
			return 200;
		}else {
			return 0;
		}
	}

	public function delProses($value='')
	{
		$ID = $this->input->post('id');
		$this->oracle->query("DELETE FROM KHS_TSKK_PROSES WHERE ID_PROSES = $ID");
		if ($this->oracle->affected_rows()) {
			return 200;
		}else {
			return 0;
		}
	}

	public function updateProses($value)
	{
		$this->oracle->where('ID_PROSES', $value['ID_PROSES'])->update('KHS_TSKK_PROSES', $value);
		if ($this->oracle->affected_rows()) {
			return 200;
		}else {
			return 0;
		}
	}

	public function getProses($value='')
	{
		return $this->oracle->order_by('PROSES', 'ASC')->get('KHS_TSKK_PROSES')->result_array();
	}

	public function getseksi($value='')
	{
		return $this->db->query("SELECT distinct seksi from gtskk.gtskk_header_tskk order by seksi")->result_array();
	}

	public function gettipe($value='')
	{
		return $this->db->query("SELECT distinct tipe from gtskk.gtskk_header_tskk where tipe != '' order by tipe")->result_array();
	}

	public function getfilterproses($value='')
	{
		return $this->db->query("SELECT distinct proses from gtskk.gtskk_header_tskk where proses != '' order by proses")->result_array();
	}

	public function filter($seksi, $tipe, $proses)
	{
		return $this->db->query("SELECT * from gtskk.gtskk_header_tskk where tipe like '%$tipe%' and seksi like '%$seksi%' and proses like '%$proses%' order by TO_DATE(tanggal, 'DD-Mon-YYYY') desc")->result_array();
	}

	function getTipeProduk($tp)
	{
	// $sql = "SELECT distinct
	// 		kjb.KODE_DIGIT
	// 		,kjb.JENIS_BARANG
	// 		,kjb.DESCRIPTION
	// 		from khs_jenis_barang kjb
	// 		,mtl_system_items_b msib
	// 		where msib.ORGANIZATION_ID = 81
	// 		and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
	// 		and kjb.JENIS_BARANG = 'KOMPONEN/IMPLEMEN'
	// 		and kjb.KODE_DIGIT(+) = case when substr(msib.SEGMENT1,0,2) in ('MF','RZ')
	// 		then substr(msib.SEGMENT1,0,4)
	// 		when substr(msib.SEGMENT1,0,2) = 'ME'
	// 		then substr(msib.SEGMENT1,0,9)
	// 		when substr(msib.SEGMENT1,0,3) in ('MDN','MDP')
	// 		then substr(msib.SEGMENT1,0,4)
	// 		when substr(msib.SEGMENT1,0,1) = ('L')
	// 		and substr(msib.SEGMENT1,0,2) not in ('LB','LK','LL','LP','L-')
	// 		then substr(msib.SEGMENT1,0,2)
	// 		when substr(msib.SEGMENT1,0,2) = 'RS'
	// 		then substr(msib.SEGMENT1,0,2)
	// 		else substr(msib.SEGMENT1,0,3)
	// 		end
	// 		order by 1,2";
			$Low = strtolower($tp);
			$lcfirst = lcfirst($tp);
			$ucfirst = ucfirst($tp);
			$ucwords = ucwords($tp);
			// $sql="SELECT distinct
			// kjb.KODE_DIGIT
			// ,kjb.JENIS_BARANG
			// ,kjb.DESCRIPTION
			// from khs_jenis_barang kjb
			// ,mtl_system_items_b msib
			// where msib.ORGANIZATION_ID = 81
			// and msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
			// and kjb.JENIS_BARANG = 'KOMPONEN/IMPLEMEN'
			// and kjb.KODE_DIGIT(+) = case when substr(msib.SEGMENT1,0,2) in ('MF','RZ')
			// then substr(msib.SEGMENT1,0,4)
			// when substr(msib.SEGMENT1,0,2) = 'ME'
			// then substr(msib.SEGMENT1,0,9)
			// when substr(msib.SEGMENT1,0,3) in ('MDN','MDP')
			// then substr(msib.SEGMENT1,0,4)
			// when substr(msib.SEGMENT1,0,1) = ('L')
			// and substr(msib.SEGMENT1,0,2) not in ('LB','LK','LL','LP','L-')
			// then substr(msib.SEGMENT1,0,2)
			// when substr(msib.SEGMENT1,0,2) = 'RS'
			// then substr(msib.SEGMENT1,0,2)
			// else substr(msib.SEGMENT1,0,3)
			// end
			// -- and kjb.DESCRIPTION like '%$tp%'
			// -- OR kjb.DESCRIPTION like '%$Low%'
			// -- OR kjb.DESCRIPTION like '%$lcfirst%'
			// and kjb.DESCRIPTION like '%$ucfirst%'
			// -- OR kjb.DESCRIPTION like '%$ucwords%'
			// order by 1,2";
		$sql = "SELECT ffv.flex_value, NVL (ffvt.description, '000') DESCRIPTION
						  FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt
						 WHERE ffv.flex_value_set_id = 1013710
						   AND ffv.flex_value_id = ffvt.flex_value_id
						   AND ffv.end_date_active IS NULL
						   AND ffv.summary_flag = 'N'
						   AND ffv.enabled_flag = 'Y'
						   AND ffvt.flex_value_meaning LIKE 'A%'
							 AND NVL (ffvt.description, '000') LIKE '%$ucfirst%'
							 ORDER BY NVL (ffvt.description, '000') ASC";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	function kodePart($variable, $product)
	{
  $where_product = '';
	if (!empty($product)) {
		$where_product .= "AND NVL (ffvt.description, '000') in";
		$where_product .= '(\''.implode('\',\'',$product).'\')';
	}

	// $sql="SELECT msib.segment1
  //      ,msib.description
  //      from mtl_system_items_b msib
  //      where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
  //      and msib.organization_id = 81
  //      AND (msib.DESCRIPTION LIKE '%$variable%'
	//    OR msib.SEGMENT1 LIKE '%$variable%')";

	$sql = "SELECT msib.segment1, msib.description
							FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt,
									 mtl_system_items_b msib
						 WHERE ffv.flex_value_set_id = 1013710
							 AND ffv.flex_value_id = ffvt.flex_value_id
							 AND ffv.end_date_active IS NULL
							 AND ffv.summary_flag = 'N'
							 AND ffv.enabled_flag = 'Y'
							 AND ffv.flex_value = SUBSTR (msib.segment1, 1, 3)
							 AND (msib.DESCRIPTION LIKE '%$variable%'
					   				OR msib.SEGMENT1 LIKE '%$variable%')
							 $where_product
							 AND msib.organization_id = 81
							 AND msib.inventory_item_status_code = 'Active'
					ORDER BY 1";

	   $query = $this->oracle->query($sql);
	   return $query->result_array();
	   // echo $sql;
		 // die;
	}

	function namaPart($kode_part)
	{
		$result = '';
		foreach ($kode_part as $key => $value) {
			$sql="SELECT DISTINCT msib.description
					 from mtl_system_items_b msib
					 where msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
					 and msib.organization_id = 81
				 AND msib.SEGMENT1 = '$value'";

			$query = $this->oracle->query($sql);
			if (!empty($query->row())) {
				$result .= $query->row()->DESCRIPTION.";";
			}
		}

	   // echo "<pre>"; print_r($result);
	   // exit();
	   return $result;
	}

	public function product_type_spec($item)
	{
		$result = '';
		foreach ($item as $key => $value) {
				$sql = "SELECT msib.segment1 item, NVL (ffvt.description, '000') DESCRIPTION
										FROM fnd_flex_values ffv, fnd_flex_values_tl ffvt,
												 mtl_system_items_b msib
									 WHERE ffv.flex_value_set_id = 1013710
										 AND ffv.flex_value_id = ffvt.flex_value_id
										 AND ffv.end_date_active IS NULL
										 AND ffv.summary_flag = 'N'
										 AND ffv.enabled_flag = 'Y'
										 AND ffv.flex_value = SUBSTR (msib.segment1, 1, 3)
										 AND msib.segment1 = '$value'
										 AND msib.organization_id = 81
										 AND msib.inventory_item_status_code = 'Active'
								ORDER BY 1";

				$query = $this->oracle->query($sql);
				if (!empty($query->row())) {
					$result .= $query->row()->DESCRIPTION.",";
				}
		}

	   return $result;
	}

	// function Seksi($term)
	// {
	// $sql="SELECT ffvv.DESCRIPTION
	// 		from FND_FLEX_VALUES_VL ffvv
	// 		where ffvv.FLEX_VALUE_SET_ID = 1013709
	// 		and ffvv.END_DATE_ACTIVE is null
	// 		and substr(ffvv.FLEX_VALUE_MEANING,3,4) <> '00'
	// 		and substr(ffvv.FLEX_VALUE,0,1) in ('4','5','7','8')
	// 		and ffvv.DESCRIPTION like '%$term%'
	// 		order by ffvv.DESCRIPTION";

	// $query = $this->oracle->query($sql);
	// return $query->result_array();
	// }

	function Seksi($term)
	{
		// $sql = "SELECT DISTINCT seksi_pengebon
		// 		FROM im.im_master_bon_bppct
		// 		WHERE seksi_pengebon <> ''
		// 		AND seksi_pengebon LIKE '%$term%'
		// 		ORDER BY seksi_pengebon";
		$sql = "SELECT DISTINCT seksi_pengebon FROM im_master_bon_bppct WHERE seksi_pengebon LIKE '%$term%' ORDER BY seksi_pengebon";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	function Mesin($mach)
	{
	$sql="SELECT fab.attribute1
		  FROM fa_additions_b fab
		  WHERE fab.attribute1 IS NOT NULL
		  AND fab.attribute1 like '%$mach%'";

	$query = $this->oracle->query($sql);
	return $query->result_array();
	}

	function SelectNoMesin($nm)
	{
		$sql = "SELECT 'ODM' ket, kdmr.no_mesin, kdmr.spec_mesin, br.resource_code,
				 br.description, br.disable_date, br.organization_id,
				 br.creation_date
			FROM khs_daftar_mesin_resource kdmr, bom_resources br
		   WHERE br.resource_id = kdmr.resource_id
			 AND (UPPER(kdmr.no_mesin) LIKE '%$nm%'
						OR UPPER(kdmr.spec_mesin) LIKE '%$nm%')
			 AND br.disable_date IS NULL         -- masih aktif
			 AND br.organization_id = 102        --odm
		UNION
		--opm
		SELECT   'OPM' ket, kdmro.no_mesin, kdmro.spec_mesin,
				 gor.resources resource_code, NULL, NULL, NULL, NULL
			FROM khs_daftar_mesin_resource_opm kdmro,
				 gmd_operations gos,
				 gmd_operation_activities goa,
				 gmd_operation_resources gor
		   WHERE gos.oprn_no LIKE '%RESOURCE%'
			 AND gos.oprn_id = goa.oprn_id
			 AND goa.oprn_line_id = gor.oprn_line_id
			 AND gor.resources = kdmro.resources
			 AND kdmro.oprn_line_id = gor.oprn_line_id
			 AND gos.oprn_vers = 1
			 AND (UPPER(kdmro.no_mesin) LIKE '%$nm%'
				    OR UPPER(kdmro.spec_mesin) LIKE '%$nm%')
		ORDER BY no_mesin ASC, creation_date DESC";

	$query = $this->oracle->query($sql);
	return $query->result_array();
	}

	function jenisMesin($no_mesin)
	{
		$result = '';
		foreach($no_mesin as $no) {
			//odm
			$sql="SELECT kdmr.spec_mesin
					FROM khs_daftar_mesin_resource kdmr, bom_resources br
				WHERE br.resource_id = kdmr.resource_id
					AND kdmr.no_mesin = '$no'
					AND br.disable_date IS NULL                            -- masih aktif
					AND br.organization_id = 102                           --odm
				UNION
				--opm
				SELECT kdmro.spec_mesin
					FROM khs_daftar_mesin_resource_opm kdmro,
						gmd_operations gos,
						gmd_operation_activities goa,
						gmd_operation_resources gor
				WHERE gos.oprn_no LIKE '%RESOURCE%'
					AND gos.oprn_id = goa.oprn_id
					AND goa.oprn_line_id = gor.oprn_line_id
					AND gor.resources = kdmro.resources
					AND kdmro.oprn_line_id = gor.oprn_line_id
					AND gos.oprn_vers = 1
					AND kdmro.no_mesin = '$no' ";

			$query = $this->oracle->query($sql);
			$result .= $query->row()->SPEC_MESIN."; \n";
		}
		return $result;
	}

	function Resource($no_mesin)
	{
		$result = '';
		foreach ($no_mesin as $mesin) {
			//odm
			$sql="SELECT br.resource_code,
			br.creation_date
			FROM khs_daftar_mesin_resource kdmr, bom_resources br
			WHERE br.resource_id = kdmr.resource_id
			AND kdmr.no_mesin = '$mesin'
			AND br.disable_date IS NULL                               -- masih aktif
			AND br.organization_id = 102                              --odm
			AND ROWNUM = 1
			UNION
			--opm
			SELECT gor.resources resource_code, NULL
			FROM khs_daftar_mesin_resource_opm kdmro,
				gmd_operations gos,
				gmd_operation_activities goa,
				gmd_operation_resources gor
			WHERE gos.oprn_no LIKE '%RESOURCE%'
			AND gos.oprn_id = goa.oprn_id
			AND goa.oprn_line_id = gor.oprn_line_id
			AND gor.resources = kdmro.resources
			AND kdmro.oprn_line_id = gor.oprn_line_id
			AND gos.oprn_vers = 1
			AND kdmro.no_mesin = '$mesin'
			ORDER BY creation_date DESC";

		$query = $this->oracle->query($sql);
		$result .= $query->row()->RESOURCE_CODE."; \n";
		}
	   	return $result;

	}

	function Operator($opr)
	{
	$sql = "SELECT noind, trim(nama) as nama from hrd_khs.tpribadi
			where nama LIKE '%$opr%'
			or noind like '%$opr%'";

	$query = $this->personalia->query($sql);
	return $query->result_array();
	}

	function insertData($inputan_elemen)
	{
	   $sql ="INSERT into gtskk.gtskk_standar_elemen_kerja (elemen_kerja)
		 	  VALUES ('$inputan_elemen')";

	   $query = $this->db->query($sql);
	   // echo $sql.'<br>';
	   // exit();
	   // return $sql;
	}

	function selectData()
	{
		$sql = "SELECT * FROM gtskk.gtskk_standar_elemen_kerja
				ORDER BY elemen_kerja asc";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function deleteElemen($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_elemen_tskk
				WHERE id_tskk='$id'";
		// echo $sql;exit();

		$query = $this->db->query($sql);
	}

	function deleteElemenObservasi($seq,$id)
	{
		$sql = "DELETE FROM gtskk.gtskk_observasi_elemen_kerja
				WHERE seq='$seq'
				AND id_tskk='$id'";

		$query = $this->db->query($sql);
	}

	function ElemenKerja($elk)
	{
		$Low = strtolower($elk);
		$lcfirst = lcfirst($elk);
		$ucfirst = ucfirst($elk);
		$ucwords = ucwords($elk);
		$sql = "SELECT elemen_kerja FROM gtskk.gtskk_standar_elemen_kerja
				WHERE elemen_kerja LIKE '%$elk%' OR elemen_kerja LIKE '%$Low%' OR elemen_kerja LIKE '%$lcfirst%'
				OR elemen_kerja LIKE '%$ucfirst%' OR elemen_kerja LIKE '%$ucwords%' ORDER BY elemen_kerja ASC";

		$query = $this->db->query($sql);
		return $query->result_array();
		// return $sql;
	}

	// $saveHeader = $this->M_gentskk->InsertHeaderTSKK($judul,$type,$kode,$nama_part,$seksi,
	// $proses,$kode_proses,$jenis_mesin,$proses_ke,$dari,$tanggal,$qty,$nm,
	// $nilai_distribusi,$takt_time,$no_mesin,$resource,$line,$alat_bantu,$tools,
	// $jml_operator,$dr_operator,$seksi_pembuat,$jenis_inputPart);

	public function InsertHeaderTSKK($judul,$type,$kode,$nama_part,$seksi,$proses,
									 $kode_proses,$mach,$proses_ke,$dari,$tanggal,$qty,$operator,
									 $nilai_distribusi,$takt_time,$no_mesin,$resource,$line,$alat_bantu,
									 $tools,$jml_operator,$dr_operator,$seksi_pembuat,$jenis_inputPart,$jenis_inputEquipment,
									 $nama_pekerja,$creationDate,$jenis_inputEquipmentMesin, $status_observasi)
	{
		$sql = "INSERT INTO gtskk.gtskk_header_tskk(judul_tskk, tipe, kode_part, nama_part,
				seksi, proses, kode_proses, mesin, proses_ke, proses_dari, tanggal,
				qty, operator, nilai_distribusi, takt_time, no_mesin, resource_mesin, line_process,
				alat_bantu, tools, jumlah_operator, jumlah_operator_dari, seksi_pembuat,jenis_input_part,jenis_input_element,
				nama_pembuat, tanggal_pembuatan, jenis_input_mesin, status_observasi)
				values('$judul','$type','$kode','$nama_part','$seksi','$proses',
				'$kode_proses','$mach','$proses_ke','$dari','$tanggal','$qty','$operator',
				'$nilai_distribusi','$takt_time','$no_mesin','$resource','$line','$alat_bantu','$tools',
                '$jml_operator','$dr_operator','$seksi_pembuat','$jenis_inputPart','$jenis_inputEquipment',
				'$nama_pekerja','$creationDate','$jenis_inputEquipmentMesin', '$status_observasi')";
		// echo $sql;
		// exit();
		$query = $this->db->query($sql);
	}

	function selectIdHeader()
	{
		$sql = "SELECT MAX (id_tskk) id
				FROM gtskk.gtskk_header_tskk";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function selectIdElemen($id)
	{
		$sql = "SELECT id_tskk
				FROM gtskk.gtskk_elemen_tskk
				WHERE id_tskk ='$id'";
		// echo $sql;exit();
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function selectHeader()
	{
		$sql = "SELECT * FROM  gtskk.gtskk_header_tskk
				ORDER BY id_tskk DESC limit 100";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function selectHeaderMonTSKK()
	{
		$sql = "SELECT distinct head.* from gtskk.gtskk_header_tskk head where id_tskk in (select distinct elem.id_tskk from gtskk.gtskk_elemen_tskk  elem where id_tskk = head.id_tskk)
				order by id_tskk DESC
				";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getseksi_montskk($value='')
	{
		return $this->db->query("SELECT distinct head.seksi from gtskk.gtskk_header_tskk head where id_tskk in (select distinct elem.id_tskk from gtskk.gtskk_elemen_tskk  elem where id_tskk = head.id_tskk) order by head.seksi")->result_array();
	}

	public function gettipe_montskk($value='')
	{
		return $this->db->query("SELECT distinct head.tipe from gtskk.gtskk_header_tskk head where head.tipe != '' and id_tskk in (select distinct elem.id_tskk from gtskk.gtskk_elemen_tskk elem where id_tskk = head.id_tskk) order by tipe")->result_array();
	}

	public function getfilterproses_montskk($value='')
	{
		return $this->db->query("SELECT distinct head.proses from gtskk.gtskk_header_tskk head where head.proses != '' and id_tskk in (select distinct elem.id_tskk from gtskk.gtskk_elemen_tskk elem where id_tskk = head.id_tskk) order by proses")->result_array();
	}

	public function filter_montskk($seksi, $tipe, $proses)
	{
		return $this->db->query("SELECT head.* from gtskk.gtskk_header_tskk head
																					 where head.tipe like '%$tipe%'
																					 and head.seksi like '%$seksi%'
																					 and head.proses like '%$proses%'
																					 and head.id_tskk in (select distinct elem.id_tskk
																						 										from gtskk.gtskk_elemen_tskk elem
																																where id_tskk = head.id_tskk)
																																order by TO_DATE(tanggal, 'DD-Mon-YYYY') desc")->result_array();
	}

	function cariId($id)
	{   $sql = "SELECT id_tskk FROM  gtskk.gtskk_header_tskk where id_tskk = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function InsertTableTSKK($jenis_proses,$elemen,$keterangan,$tipe_urutan,$waktu,$start,$finish,$id)
	{
		$sql = "INSERT INTO gtskk.gtskk_elemen_tskk(jenis_proses, elemen, keterangan_elemen, tipe_urutan, waktu, mulai, finish, id_tskk)
				values('$jenis_proses','$elemen','$keterangan', '$tipe_urutan', '$waktu','$start','$finish', '$id')";
		$query = $this->db->query($sql);
	}

	public function saveObservation($waktu_kerja)
    {
    	$this->db->insert('gtskk.gtskk_observasi_elemen_kerja',$waktu_kerja);
        return;
	}

	public function saveIrregularJobs($irregular_jobs)
	{
		$this->db->insert('gtskk.gtskk_irregular_job',$irregular_jobs);
        return;
	}
	// function insertObservation($inputan_elemen)
	// {
	// 	$sql = "INSERT INTO gtskk.gtskk_observasi_elemen_kerja(judul_tskk, tipe, kode_part, nama_part, no_alat_bantu, seksi, proses, kode_proses, mesin, proses_ke, proses_dari, tanggal, qty, operator, nilai_distribusi)
	// 	values('$judul','$type','$kode','$nama_part', '$no_alat', '$seksi','$proses','$kode_proses','$mach','$proses_ke','$dari','$tanggal','$qty','$operator', '$nilai_distribusi')";

	//    $query = $this->db->query($sql);
	//    // echo $sql.'<br>';
	//    // exit();
	//    // return $sql;
	// }

	public function selectObservation($id)
	{
		$sql = "SELECT jenis_proses, elemen, keterangan_elemen, tipe_urutan, waktu_kerja
				FROM gtskk.gtskk_observasi_elemen_kerja
				WHERE id_tskk = '$id'
				AND waktu_kerja IS NOT NULL
				ORDER BY seq";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function selectAllObservation($id)
	{
		$sql = "SELECT * FROM gtskk.gtskk_observasi_elemen_kerja
				WHERE id_tskk = '$id'
				AND waktu_kerja IS NOT NULL
				ORDER BY seq";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getAllObservation($id)
	{
		// $sql = "SELECT * FROM gtskk.gtskk_observasi_elemen_kerja
		// WHERE id_tskk = '$id'
		// ORDER BY seq";

		$sql = "SELECT * FROM gtskk.gtskk_header_tskk header, gtskk.gtskk_observasi_elemen_kerja observasi
		WHERE header.id_tskk = observasi.id_tskk
		AND header.id_tskk = '$id'
		ORDER BY seq";
		// echo $sql;
		// exit();
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getAllElementsWhenEdit($id)
	{
		$sql = "SELECT * FROM gtskk.gtskk_header_tskk header, gtskk.gtskk_elemen_tskk observasi
		WHERE header.id_tskk = observasi.id_tskk
		AND header.id_tskk = '$id'
		ORDER BY seq";
		// echo $sql;
		// exit();
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function tabelelemen($jenis)
    {

    	$this->db->insert('gtskk.gtskk_elemen_tskk',$jenis);
        return;
    }

	function selectAll($id) //select all of data
	{
		$sql = "SELECT * FROM gtskk.gtskk_header_tskk header, gtskk.gtskk_elemen_tskk elemen
				WHERE header.id_tskk = elemen.id_tskk
				AND header.id_tskk = '$id'
				ORDER BY seq";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function selectTaktTime($id) //select all of data
	{
		$sql = "SELECT takt_time FROM gtskk.gtskk_observasi_elemen_kerja
				WHERE id_tskk = '$id'";

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function deleteHeader($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_header_tskk
				WHERE id_tskk='$id'";

		$query = $this->db->query($sql);
	}

	function deleteTable($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_elemen_tskk
				WHERE id_tskk='$id'";

		$query = $this->db->query($sql);
	}

	// function deleteObservation($id)
	// {
	// 	$sql = "DELETE FROM gtskk.gtskk_elemen_tskk
	// 			WHERE id_tskk='$id'";

	// 	$query = $this->db->query($sql);
	// }

	function deleteEdit($seq,$id)
	{
		$sql = "DELETE FROM gtskk.gtskk_elemen_tskk
				WHERE seq='$seq'
				AND id_tskk='$id'";
		// echo $sql;exit();
		$query = $this->db->query($sql);
	}

	function UpdateHeaderTSKK($id,$judul,$type,$kode,$nama_part,$seksi,$proses,$kode_proses,
							  $jenis_mesin,$proses_ke,$dari,$tanggal,$qty,$nm,$nilai_distribusi,$takt_time,
							  $no_mesin,$resource,$line,$alat_bantu,$tools,$jml_operator,$dr_operator,$seksi_pembuat,
							  $jenis_inputPart,$jenis_inputEquipment,$nama_pekerja,$creationDate,$jenis_inputEquipmentMesin,$status_observasi){
		$sql = "UPDATE gtskk.gtskk_header_tskk
				SET judul_tskk ='$judul'
					,tipe='$type'
					,kode_part='$kode'
					,nama_part ='$nama_part'
					,seksi= '$seksi'
					,proses = '$proses'
					,kode_proses = '$kode_proses'
					,mesin = '$jenis_mesin'
					,proses_ke = '$proses_ke'
					,proses_dari = '$dari'
					,tanggal = '$tanggal'
					,qty = '$qty'
					,operator = '$nm'
					,nilai_distribusi = '$nilai_distribusi'
					,takt_time = '$takt_time'
					,no_mesin = '$no_mesin'
					,resource_mesin = '$resource'
					,line_process = '$line'
					,alat_bantu='$alat_bantu'
					,tools = '$tools'
					,jumlah_operator = '$jml_operator'
					,jumlah_operator_dari = '$dr_operator'
					,seksi_pembuat = '$seksi_pembuat'
					,jenis_input_part = '$jenis_inputPart'
					,jenis_input_element = '$jenis_inputEquipment'
					,nama_pembuat = '$nama_pekerja'
					,tanggal_pembuatan = '$creationDate'
					,jenis_input_mesin = '$jenis_inputEquipmentMesin'
					,status_observasi = '$status_observasi'
				WHERE id_tskk='$id'";
		// echo $sql;exit();
  		$query = $this->db->query($sql);
	}

	function deleteElement($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_elemen_tskk
				WHERE id_tskk='$id'";
		$query = $this->db->query($sql);
	}

	function deleteStandardElement($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_standar_elemen_kerja
				WHERE id='$id'";
		// echo $sql;exit();
		$query = $this->db->query($sql);
	}

	function deleteObservation($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_observasi_elemen_kerja
				WHERE id_tskk='$id'";
		$query = $this->db->query($sql);
	}

	function deleteIrregularJobs($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_irregular_job
		WHERE id_irregular_job='$id'";
		$query = $this->db->query($sql);
	}

	function deleteTaktTime($id)
	{
		$sql = "DELETE FROM gtskk.gtskk_takt_time
		WHERE id_takt_time='$id'";
		$query = $this->db->query($sql);
	}

	function UpdateTaktTimeHeader($id,$takt_time){
		$sql = "UPDATE gtskk.gtskk_header_tskk
				SET takt_time ='$takt_time'
				WHERE id_tskk='$id'";
		// echo $sql;exit();
  		$query = $this->db->query($sql);
	}

	public function detectSeksiUnit($noind){
        $sql = "SELECT seksi,unit,dept FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts
        where tp.kodesie=ts.kodesie
        and tp.keluar='0'
        and tp.noind='$noind'";

        return $this->personalia->query($sql)->result_array();
	}

	//SEARCH ALAT BANTU
	public function selectAlatBantu($ab){ //ganti db
        $sql = "SELECT distinct tto.fs_nm_tool
		from ttool tto WHERE tto.fs_nm_tool like '%$ab%'";

        return $this->lantuma->query($sql)->result_array();
	}

	//SEARCH TOOLS NAME
	public function selectTools($tl){
        $sql = "SELECT msib.SEGMENT1, msib.DESCRIPTION from mtl_system_items_b msib
		where msib.SEGMENT1 LIKE 'MJ%'
		AND upper(msib.DESCRIPTION) LIKE upper('%$tl%')
		OR upper(msib.SEGMENT1) LIKE upper('%$tl%')
		AND msib.ENABLED_FLAG = 'Y'";
		// echo $sql;exit();
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//SELECT IRREGULAR JOBS
	public function selectIrregularJobs($id){
		$sql = "SELECT * FROM gtskk.gtskk_irregular_job
				WHERE id_irregular_job = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function saveTaktTime($id,$waktu_satu_shift,$jumlah_shift,$forecast,$qty_unit,$rencana_produksi,$jumlah_hari_kerja)
	{
		$sql = "INSERT INTO gtskk.gtskk_takt_time(id_takt_time, waktu_satu_shift, jumlah_shift, forecast, qty_unit, rencana_produksi, jumlah_hari_kerja)
				values('$id', '$waktu_satu_shift', '$jumlah_shift', '$forecast', '$qty_unit', '$rencana_produksi', '$jumlah_hari_kerja')";
		$query = $this->db->query($sql);
	}

	public function selectTaktTimeCalculation($id)
	{
			$sql = "SELECT * FROM gtskk.gtskk_takt_time
					WHERE id_takt_time = '$id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function updateTaktTime($id,$waktu_satu_shift,$jumlah_shift,$forecast,$qty_unit,$rencana_produksi,$jumlah_hari_kerja)
	{
		$sql = "UPDATE gtskk.gtskk_takt_time
				SET waktu_satu_shift ='$waktu_satu_shift'
				,jumlah_shift='$jumlah_shift'
				,forecast='$forecast'
				,qty_unit='$qty_unit'
				,rencana_produksi='$rencana_produksi'
				,jumlah_hari_kerja ='$jumlah_hari_kerja'
				WHERE id_takt_time = '$id'";
		// echo $sql;exit();
		$query = $this->db->query($sql);
	}

	function selectNamaPekerja($noind)
	{
		$sql = "SELECT trim(nama) as nama from hrd_khs.tpribadi
				where noind = '$noind'";

		$query = $this->personalia->query($sql);
		return $query->result_array();
	}

}
