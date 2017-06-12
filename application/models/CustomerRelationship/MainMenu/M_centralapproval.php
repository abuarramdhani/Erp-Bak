<?php
clASs M_centralapproval extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database ( 'oracle', TRUE );
    }

	public function countData()
	{
		$sql = "SELECT  DISTINCT(SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.CREATION_DATE  <= (SYSDATE - 1) AND CH.STATUS = 'NEW') as over,
				        (SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.STATUS = 'APPROVED') as approved,
				        (SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.STATUS = 'CLOSED') as closed
				FROM KHS_EXTERNAL_CLAIM_HEADERS";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
//--------------------------------------------------------SHOW DATA CLAIM---------------------------------------------------------------
	public function getHeaderOver()
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.STATUS = 'OVER'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//-------------------------EDIT DATA CLAIM--------------------------------------------
	public function searchClaim($id)
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.HEADER_ID = '$id'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//-------------------------GET DATA ADDRESS---------------------------
		
	public function cityRegency()
	{
		$sql =	"	SELECT DISTINCT(regency_name)
					FROM sys.sys_area_city_regency
					ORDER BY regency_name
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
	public function district()
	{
		$sql =	"	SELECT district_name
					FROM sys.sys_area_district
					ORDER BY district_name
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		
	public function village()
	{
		$sql =	"	SELECT village_name
					FROM sys.sys_area_village
					ORDER BY village_name
				";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	//-------------------------- PRINT DATA CLAIM -----------------------------
	public function searchDataClaim($id)
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, KHS_EXTERNAL_CLAIM_LINES CL, hz_parties hp,hz_cust_accounts hca
				WHERE CH.HEADER_ID = CL.HEADER_ID AND hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID
						AND CH.HEADER_ID = '$id'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
}
?>