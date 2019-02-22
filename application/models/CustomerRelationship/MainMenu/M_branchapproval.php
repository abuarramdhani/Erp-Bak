<?php
clASs M_branchapproval extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database ( 'oracle', TRUE );
    }
	
	public function countData()
	{
		$sql = "SELECT  DISTINCT(SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.STATUS = 'NEW') as new,
				        (SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.STATUS = 'APPROVED') as approved,
				        (SELECT count(*) FROM KHS_EXTERNAL_CLAIM_HEADERS CH WHERE CH.STATUS = 'CLOSED') as closed
				FROM KHS_EXTERNAL_CLAIM_HEADERS";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getCustName()
	{
		$sql = "SELECT 	ch.HEADER_ID ,hca.cust_account_id, hp.party_name
				FROM 	hz_cust_accounts hca, hz_parties hp, KHS_EXTERNAL_CLAIM_HEADERS ch
				WHERE 	hca.party_id = hp.party_id and ch.CUST_ACCOUNT_ID = hca.CUST_ACCOUNT_ID";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
//--------------------------------------------------------SHOW DATA CLAIM---------------------------------------------------------------
	public function getHeaderNew()
	{
		$sql = "SELECT *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.STATUS = 'NEW'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
	public function getHeaderApproved()
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.STATUS = 'APPROVED'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
	public function getHeaderOver()
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.STATUS = 'NEW' AND CH.CREATION_DATE  <= (SYSDATE - 1)";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	
	public function getHeaderClosed()
	{
		$sql = "SELECT  *
				FROM KHS_EXTERNAL_CLAIM_HEADERS CH, hz_parties hp,hz_cust_accounts hca
				WHERE hca.party_id = hp.party_id AND hca.CUST_ACCOUNT_ID=CH.CUST_ACCOUNT_ID AND CH.STATUS = 'CLOSED'";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
	//------------------------------------------------------------------------------------------------------------------------------
	public function getLines()
	{
		$sql = "SELECT *
				FROM KHS_EXTERNAL_CLAIM_LINES";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//----------------------------------------- UPDATE DATA CLAIM --------------------------------
	public function actionClaim($actType,$userUpdate,$id,$Priority,$note)
	{
		if ($actType=='approved') {
			$sql = "	UPDATE KHS_EXTERNAL_CLAIM_HEADERS
						set PRIORITY = '$Priority', STATUS = 'APPROVED', NOTE ='$note', LAST_UPDATED_BY ='$userUpdate', LAST_UPDATE_DATE = SYSDATE
						WHERE HEADER_ID = '$id'";
			$query = $this->oracle->query($sql);
		}elseif ($actType=='rejected' OR $actType=='closed') {
			$sql =	"	UPDATE KHS_EXTERNAL_CLAIM_HEADERS
						set PRIORITY = '$Priority', STATUS = 'CLOSED', NOTE ='$note', LAST_UPDATED_BY ='$userUpdate', LAST_UPDATE_DATE = SYSDATE
						WHERE HEADER_ID = '$id'";
			$query = $this->oracle->query($sql);
		}
	}
}
?>