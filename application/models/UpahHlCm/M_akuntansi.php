<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akuntansi extends CI_Model {
	function __construct() 
	{ 
		parent:: __construct();
		$this->personalia 	= 	$this->load->database('personalia', TRUE);
		$this->erp 			=	$this->load->database('erp_db', TRUE);

	}

	function insertRecord($data){
		$this->erp->insert('hlcm.record_absen_pekerja',$data);
	}

	function insertRecordHistory($data){
		$this->erp->insert('hlcm.record_absen_pekerja_history',$data);
	}

	function getDetail($periode){
		$this->erp->where('periode',$periode);
		return $this->erp->get('hlcm.record_absen_pekerja')->result();
	}

	function getData(){
		$sql = "SELECT periode,
				 CASE WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '01' THEN 'Januari'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '02' THEN 'Februari'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '03' THEN 'Maret'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '04' THEN 'April'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '05' THEN 'Mei'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '06' THEN 'Juni'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '07' THEN 'Juli'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '08' THEN 'Agustus'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '09' THEN 'September'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '10' THEN 'Oktober'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '11' THEN 'November'
				 WHEN SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),6,2) = '12' THEN 'Desember'

				ELSE 'Tidak Diketahui' END as str_periode,
				COUNT(*) as jumlah_data, SUBSTR(TO_CHAR(periode,'YYYY-MM-DD'),1,4) as tahun
				FROM hlcm.record_absen_pekerja GROUP BY periode ORDER BY periode";
		$query = $this->erp->query($sql);
		return $query->result();

	}

	function deleteRekap($periode){
		$this->erp->where('periode',$periode);
		$this->erp->delete('hlcm.record_absen_pekerja');
	}

	function checkDataImport($noind,$periode){
		$this->erp->where('noind',$noind);
		$this->erp->where('periode',$periode);
		return $this->erp->get('hlcm.record_absen_pekerja')->num_rows();
	}

	function checkDataImportHistory($noind,$periode){
		$this->erp->where('noind',$noind);
		$this->erp->where('periode',$periode);
		return $this->erp->get('hlcm.record_absen_pekerja_history')->num_rows();
	}
}
