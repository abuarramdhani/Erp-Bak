<?php
clASs M_creditlimit extends CI_Model {

	var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database ( 'oracle', TRUE );
    }
	
	public function showData()
	{
		$sql = "SELECT CL.LINE_ID, ORG.NAME, CL.PARTY_NAME, CL.ACCOUNT_NUMBER, CL.OVERALL_CREDIT_LIMIT, CL.EXPIRED_DATE, CL.ORG_ID
 				FROM HR_ALL_ORGANIZATION_UNITS_TL ORG, khs_om_credit_limit_base_tab CL
 				WHERE ORG.ORGANIZATION_ID = CL.ORG_ID
 				ORDER BY CL.LINE_ID DESC";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//-----------------get data to input--------------------
	public function customer($orgID)
	{
		$sql = "SELECT DISTINCT hca.cust_account_id, hca.account_number, hp.party_name, hcasa.org_id
           		FROM hz_cust_accounts hca, hz_parties hp, hz_cust_acct_sites_all hcasa
          		WHERE hca.party_id = hp.party_id
            		AND hca.cust_account_id = hcasa.cust_account_id
            		AND NOT EXISTS (SELECT account_number FROM khs_om_credit_limit_base_tab WHERE account_number = hca.account_number)
            		AND hcasa.org_id = '$orgID'
       			ORDER BY hp.PARTY_NAME";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function branch()
	{
		$sql = "SELECT organization_id, NAME
				FROM hr_organization_units
				WHERE NAME LIKE '%(OU)%' AND organization_id NOT IN (84)";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//-------------------ajax--------------------
	public function CustAccountID($PartyName)
	{
		$sql = "SELECT hca.cust_account_id
				FROM hz_parties hp, hz_cust_accounts hca
				WHERE hp.party_id = hca.party_id AND hp.party_name = '$PartyName'";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function AccountNumber($PartyName)
	{
		$sql = "SELECT hca.ACCOUNT_NUMBER
				FROM hz_parties hp, hz_cust_accounts hca
				WHERE hp.party_id = hca.party_id AND hp.party_name = '$PartyName'";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function PartyID($PartyName)
	{
		$sql = "SELECT hp.PARTY_ID
				FROM hz_parties hp, hz_cust_accounts hca
				WHERE hp.party_id = hca.party_id AND hp.party_name = '$PartyName'";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function PartyNumber($PartyName)
	{
		$sql = "SELECT hp.PARTY_NUMBER
				FROM hz_parties hp, hz_cust_accounts hca
				WHERE hp.party_id = hca.party_id AND hp.party_name = '$PartyName'";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	//------------------INSERT NEW----------------------
	public function saveNew($creator,$CustName,$Branch,$CustID,$CustType,$AccountNumber,$OverallCL,$Expired,$PartyID,$PartyNumber)
	{
		$sql = "INSERT INTO khs_om_credit_limit_base_tab
				(CUST_ACCOUNT_ID, ACCOUNT_NUMBER, PARTY_NAME, ORG_ID, CUSTOMER_TYPE, CL_VAL_ENABLED, OVERALL_CREDIT_LIMIT, ACTIVE, CREATED_BY, CREATION_DATE, EXPIRED_DATE, PARTY_ID, PARTY_NUMBER)
				VALUES
				('".$CustID."', '".$AccountNumber."', '".$CustName."', '".$Branch."', '".$CustType."', 'YES', '".$OverallCL."', 'YES', '".$creator."', SYSDATE, TO_DATE('".$Expired."', 'DD-MM-YYYY HH24:MI:SS'), '".$PartyID."', '".$PartyNumber."')";
		
		$query = $this->oracle->query($sql);
	}

	//---------------EDIT DATA-------------------------
	public function search($id)
	{
		$sql = "SELECT *
				FROM khs_om_credit_limit_base_tab
				WHERE LINE_ID = '$id'";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function customerItem($ORGid)
	{
		$sql = "SELECT DISTINCT(hp.party_name)
           		FROM hz_cust_accounts hca, hz_parties hp, hz_cust_acct_sites_all hcasa
          		WHERE hca.party_id = hp.party_id
            		AND hca.cust_account_id = hcasa.cust_account_id
            		AND hcasa.org_id = '$ORGid'
       			ORDER BY hp.PARTY_NAME";
		
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function saveEdit($editor,$lineID,$CustName,$Branch,$CustID,$CustType,$AccountNumber,$OverallCL,$Expired,$PartyID,$PartyNumber)
	{
		$sql = "UPDATE khs_om_credit_limit_base_tab SET
						CUST_ACCOUNT_ID = '$CustID',
						ACCOUNT_NUMBER = '$AccountNumber',
						PARTY_NAME = '$CustName',
						ORG_ID = '$Branch',
						CUSTOMER_TYPE = '$CustType',
						OVERALL_CREDIT_LIMIT = '$OverallCL',
						LAST_UPDATED_BY = '$editor',
						LAST_UPDATE_DATE = SYSDATE,
						EXPIRED_DATE = TO_DATE('$Expired', 'DD-MM-YYYY HH24:MI:SS'),
						PARTY_ID = '$PartyID',
						PARTY_NUMBER = '$PartyNumber'
				WHERE LINE_ID = '$lineID'";
		
		$query = $this->oracle->query($sql);
	}

	public function DeleteCL($id)
	{
		$sql = "DELETE FROM khs_om_credit_limit_base_tab
				WHERE LINE_ID = '$id'";
		
		$query = $this->oracle->query($sql);
		return;
	}
}
?>