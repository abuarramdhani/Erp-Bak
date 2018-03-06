<?php
class M_bppbgaccount extends CI_Model {
	public function __construct()
	{
		$this->oracle = $this->load->database('oracle',true);
		$this->load->library('encrypt');
	}

	public function getAccount($id=FALSE, $USING_CATEGORY_CODE=FALSE, $ACCOUNT_NUMBER=FALSE, $COST_CENTER=FALSE, $limit=FALSE)
	{
		if ($id===FALSE && $USING_CATEGORY_CODE===FALSE && $ACCOUNT_NUMBER===FALSE && $COST_CENTER===FALSE && $limit===FALSE) {
			$this->oracle->select('*');
			$this->oracle->from('KHS_BPPBG_ACCOUNT');
			$this->oracle->order_by('LAST_UPDATE_DATE DESC, CREATION_DATE DESC');
			$this->oracle->limit(100);
			$query = $this->oracle->get();
		}elseif ($id!==FALSE) {
			$query = $this->oracle->get_where('KHS_BPPBG_ACCOUNT', array('ACCOUNT_ID' => $id));
		}else{
			// ---- INISIALISASI DATA ----
				$where 					= '';
				$wUSING_CATEGORY_CODE	= '';
				$wACCOUNT_NUMBER		= '';
				$wCOST_CENTER			= '';
				$wlimit					= '';
			// ---- CHECKING DATA ONE BY ONE ----
				if ($USING_CATEGORY_CODE!==FALSE) {
					$where = 'WHERE';
					$wUSING_CATEGORY_CODE = "USING_CATEGORY_CODE LIKE '%$USING_CATEGORY_CODE%'";
				}

				if ($ACCOUNT_NUMBER!==FALSE) {
					$and = 'AND ';
					if ($where == '') {
						$where = 'WHERE';
						$and='';
					}
					$wACCOUNT_NUMBER = $and."ACCOUNT_NUMBER LIKE '%$ACCOUNT_NUMBER%'";
				}

				if ($COST_CENTER!==FALSE) {
					$and = 'AND ';
					if ($where == '') {
						$where = 'WHERE';
						$and='';
					}
					$wCOST_CENTER = $and."COST_CENTER LIKE '%$COST_CENTER%'";
				}

				if ($limit!==FALSE) {
					$and = 'AND ';
					if ($where == '') {
						$where = 'WHERE';
						$and='';
					}
					$wlimit = $and."ROWNUM <= $limit";
				}
			$sql = "SELECT *
					FROM KHS_BPPBG_ACCOUNT
					$where $wUSING_CATEGORY_CODE $wACCOUNT_NUMBER $wCOST_CENTER
					$wlimit
					ORDER BY CREATION_DATE, LAST_UPDATE_DATE ASC";
			$query = $this->oracle->query($sql);
		}
		return $query->result_array();
	}

	public function setAccount($ACCOUNT_ID, $USING_CATEGORY_CODE, $USING_CATEGORY, $COST_CENTER, $COST_CENTER_DESCRIPTION, $ACCOUNT_NUMBER, $ACCOUNT_ATTRIBUTE)
	{
		if(empty($ACCOUNT_ATTRIBUTE) || $ACCOUNT_ATTRIBUTE == '')
		{
			$ACCOUNT_ATTRIBUTE 	=	'NULL';
		}else{
			$ACCOUNT_ATTRIBUTE	=	"'".$ACCOUNT_ATTRIBUTE."'";
		}
		$sql = "INSERT INTO KHS_BPPBG_ACCOUNT(ACCOUNT_ID, USING_CATEGORY_CODE, USING_CATEGORY, COST_CENTER, COST_CENTER_DESCRIPTION, ACCOUNT_NUMBER, ACCOUNT_ATTRIBUTE, CREATION_DATE)
				VALUES ( '$ACCOUNT_ID',
				         '$USING_CATEGORY_CODE',
				         '$USING_CATEGORY',
				         '$COST_CENTER',
				         '$COST_CENTER_DESCRIPTION',
				         '$ACCOUNT_NUMBER',
				         ".$ACCOUNT_ATTRIBUTE.",
				         sysdate
				     )";
		$this->oracle->query($sql);
	}

	public function getNextVal()
	{
		$sql = "SELECT KHS_BPPBG_ACCOUNT_SEQ_REV.NEXTVAL FROM DUAL";
		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function updateAccount($ACCOUNT_ID, $USING_CATEGORY_CODE, $USING_CATEGORY, $COST_CENTER, $COST_CENTER_DESCRIPTION, $ACCOUNT_NUMBER, $ACCOUNT_ATTRIBUTE)
	{
		if(empty($ACCOUNT_ATTRIBUTE) || $ACCOUNT_ATTRIBUTE == '')
		{
			$ACCOUNT_ATTRIBUTE 	=	'NULL';
		}else{
			$ACCOUNT_ATTRIBUTE	=	"'".$ACCOUNT_ATTRIBUTE."'";
		}
		$sql = "UPDATE
					KHS_BPPBG_ACCOUNT
				SET
					USING_CATEGORY_CODE = '$USING_CATEGORY_CODE',
					USING_CATEGORY = '$USING_CATEGORY',
					COST_CENTER = '$COST_CENTER',
					COST_CENTER_DESCRIPTION = '$COST_CENTER_DESCRIPTION',
					ACCOUNT_NUMBER = '$ACCOUNT_NUMBER',
					ACCOUNT_ATTRIBUTE = $ACCOUNT_ATTRIBUTE
				WHERE
					ACCOUNT_ID = $ACCOUNT_ID
				";
		$this->oracle->query($sql);
	}
}