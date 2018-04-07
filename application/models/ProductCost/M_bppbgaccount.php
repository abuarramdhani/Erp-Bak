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
			$sql = "SELECT *
					FROM
					  ( SELECT kba.ACCOUNT_ID,
					           kba.USING_CATEGORY_CODE,
					           kba.USING_CATEGORY,
					           kba.COST_CENTER,
					           ffvt.DESCRIPTION COST_CENTER_DESCRIPTION,
					           kba.ACCOUNT_NUMBER,
					           kba.ACCOUNT_ATTRIBUTE,
					           DECODE(kba.LAST_UPDATE_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.LAST_UPDATE_DATE) LAST_UPDATE_DATE,
					           DECODE(kba.CREATION_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.CREATION_DATE) CREATION_DATE
					   FROM KHS_BPPBG_ACCOUNT kba
					   		,fnd_flex_values ffv
							,fnd_flex_values_tl ffvt
					   WHERE kba.COST_CENTER = ffv.FLEX_VALUE
					    AND ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
						AND ffv.FLEX_VALUE_SET_ID = 1013709
					   ORDER BY kba.LAST_UPDATE_DATE DESC, kba.CREATION_DATE DESC )
					WHERE ROWNUM <= 500";
			$query = $this->oracle->query($sql);
		}elseif ($id!==FALSE) {
			$sql = "SELECT kba.ACCOUNT_ID,
					       kba.USING_CATEGORY_CODE,
					       kba.USING_CATEGORY,
					       kba.COST_CENTER,
					       ffvt.DESCRIPTION COST_CENTER_DESCRIPTION,
					       kba.ACCOUNT_NUMBER,
					       kba.ACCOUNT_ATTRIBUTE,
					       DECODE(kba.LAST_UPDATE_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.LAST_UPDATE_DATE) LAST_UPDATE_DATE,
					       DECODE(kba.CREATION_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.CREATION_DATE) CREATION_DATE
					FROM KHS_BPPBG_ACCOUNT kba ,
					     fnd_flex_values ffv ,
					     fnd_flex_values_tl ffvt
					WHERE kba.COST_CENTER = ffv.FLEX_VALUE
					  AND ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
					  AND ffv.FLEX_VALUE_SET_ID = 1013709
					  AND kba.ACCOUNT_ID = $id
					";
			$query = $this->oracle->query($sql);
		}else{
			// ---- INISIALISASI DATA ----
				$wUSING_CATEGORY_CODE	= '';
				$wACCOUNT_NUMBER		= '';
				$wCOST_CENTER			= '';
				$wlimit					= '';
			// ---- CHECKING DATA ONE BY ONE ----
				if ($USING_CATEGORY_CODE!==FALSE) {
					$wUSING_CATEGORY_CODE = "AND USING_CATEGORY_CODE LIKE '%$USING_CATEGORY_CODE%'";
				}

				if ($ACCOUNT_NUMBER!==FALSE) {
					$wACCOUNT_NUMBER = "AND ACCOUNT_NUMBER LIKE '%$ACCOUNT_NUMBER%'";
				}

				if ($COST_CENTER!==FALSE) {
					$wCOST_CENTER = "AND COST_CENTER LIKE '%$COST_CENTER%'";
				}

				if ($limit!==FALSE) {
					$wlimit = "WHERE ROWNUM <= $limit";
				}
			$sql = "SELECT *
					FROM
					  ( SELECT kba.ACCOUNT_ID,
					           kba.USING_CATEGORY_CODE,
					           kba.USING_CATEGORY,
					           kba.COST_CENTER,
					           ffvt.DESCRIPTION COST_CENTER_DESCRIPTION,
					           kba.ACCOUNT_NUMBER,
					           kba.ACCOUNT_ATTRIBUTE,
					           DECODE(kba.LAST_UPDATE_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.LAST_UPDATE_DATE) LAST_UPDATE_DATE,
					           DECODE(kba.CREATION_DATE, NULL, TO_DATE('1970-01-01 00:00:00', 'YYYY-MM-DD HH24:MI:SS'), kba.CREATION_DATE) CREATION_DATE
					   FROM KHS_BPPBG_ACCOUNT kba
					   		,fnd_flex_values ffv
							,fnd_flex_values_tl ffvt
					   WHERE kba.COST_CENTER = ffv.FLEX_VALUE
					    AND ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
						AND ffv.FLEX_VALUE_SET_ID = 1013709
						$wUSING_CATEGORY_CODE $wACCOUNT_NUMBER $wCOST_CENTER
					   ORDER BY kba.LAST_UPDATE_DATE DESC, kba.CREATION_DATE DESC )
					$wlimit";
			$query = $this->oracle->query($sql);
		}
		return $query->result_array();
	}

	public function setAccount($ACCOUNT_ID, $USING_CATEGORY_CODE, $USING_CATEGORY, $COST_CENTER, $ACCOUNT_NUMBER, $ACCOUNT_ATTRIBUTE)
	{
		if(empty($ACCOUNT_ATTRIBUTE) || $ACCOUNT_ATTRIBUTE == '')
		{
			$ACCOUNT_ATTRIBUTE 	=	'NULL';
		}else{
			$ACCOUNT_ATTRIBUTE	=	"'".$ACCOUNT_ATTRIBUTE."'";
		}
		$sql = "INSERT INTO KHS_BPPBG_ACCOUNT(ACCOUNT_ID, USING_CATEGORY_CODE, USING_CATEGORY, COST_CENTER, ACCOUNT_NUMBER, ACCOUNT_ATTRIBUTE, CREATION_DATE)
				VALUES ( '$ACCOUNT_ID',
				         '$USING_CATEGORY_CODE',
				         '$USING_CATEGORY',
				         '$COST_CENTER',
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

	public function updateAccount($ACCOUNT_ID, $USING_CATEGORY_CODE, $USING_CATEGORY, $COST_CENTER, $ACCOUNT_NUMBER, $ACCOUNT_ATTRIBUTE)
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
					ACCOUNT_NUMBER = '$ACCOUNT_NUMBER',
					ACCOUNT_ATTRIBUTE = $ACCOUNT_ATTRIBUTE,
					LAST_UPDATE_DATE = SYSDATE
				WHERE
					ACCOUNT_ID = $ACCOUNT_ID
				";
		$this->oracle->query($sql);
	}

	public function deleteAccount($id)
	{
		$this->oracle->where('ACCOUNT_ID', $id);
		$this->oracle->delete('KHS_BPPBG_ACCOUNT');
	}

	public function getCostCenter()
	{
		$sql = "SELECT ffv.FLEX_VALUE cost_center,
				       ffvt.DESCRIPTION cost_center_description
				FROM fnd_flex_values ffv ,
				     fnd_flex_values_tl ffvt
				WHERE ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
				  AND ffv.FLEX_VALUE_SET_ID = 1013709
				  AND ffv.ENABLED_FLAG = 'Y'
				  AND ffv.END_DATE_ACTIVE IS NULL
				  AND ffv.SUMMARY_FLAG = 'N'
				ORDER BY ffv.FLEX_VALUE";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}

	public function getAccountNumber()
	{
		$sql = "SELECT ffv.FLEX_VALUE account_number,
				       ffvt.DESCRIPTION account_number_description
				FROM fnd_flex_values ffv ,
				     fnd_flex_values_tl ffvt
				WHERE ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
				  AND ffv.FLEX_VALUE_SET_ID = 1013708
				  AND ffv.ENABLED_FLAG = 'Y'
				  AND ffv.END_DATE_ACTIVE IS NULL
				  AND ffv.SUMMARY_FLAG = 'N'
				ORDER BY ffv.FLEX_VALUE";

		$query = $this->oracle->query($sql);
		return $query->result_array();
	}
}