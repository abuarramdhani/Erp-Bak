<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_rekapbon extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();	
	}

	public function getBill($noInduk)
	{
		$oracle = $this->load->database("oracle",true);
		// $query = $oracle->query("
		//	 select distinct
		//		 pvs.VENDOR_SITE_CODE 
		//		 ,aia.invoice_num
		//		 ,aia.invoice_type_lookup_code
		//		 ,aia.invoice_currency_code
		//		 ,aia.invoice_amount
		//		 ,aia.amount_paid
		//		 ,aia.invoice_date
		//		 ,aila.line_type_lookup_code
		//		 ,aila.description
		//		 ,aila.amount
		//	 from
		//		 ap_invoices_all aia
		//		 ,ap_invoice_lines_all aila
		//		 ,ap_suppliers asa
		//		 ,ap_supplier_sites_all assa
		//		 ,po_vendor_sites_all pvs
		//	 where
		//		 1 = 1
		//		 and aia.VENDOR_SITE_ID = pvs.vendor_site_id(+)
		//		 and aia.invoice_id = aila.invoice_id
		//		 and aia.vendor_id = asa.vendor_id
		//		 and asa.vendor_name = 'KHS Employee'
		//		 and aia.cancelled_date is null
		//		 and (aia.INVOICE_AMOUNT <> aia.AMOUNT_PAID or aia.AMOUNT_PAID is null)
		//		 and aia.invoice_type_lookup_code = 'PREPAYMENT'
		//		 and asa.vendor_id = assa.vendor_id
		//	 order by 2
		// ");
		$query = $oracle->query("
			SELECT distinct
				PVS.VENDOR_SITE_CODE VENDOR_SITE_CODE,
				AI.DESCRIPTION,
				(AI.INVOICE_AMOUNT * NVL(AI.EXCHANGE_RATE,1)) AMOUNT_IDR,
				-- ( (AIL.AMOUNT *-1) * NVL(AIA.EXCHANGE_RATE,1) ) AMOUNT_APPLY,
				(DECODE(
				(SELECT 
					SUM (AIL2.AMOUNT*-1)   
				 FROM
					AP_INVOICE_LINES_ALL AIL2,
					AP_INVOICES_ALL AI2,
					AP_INVOICES_ALL AIA2
				 WHERE
					AIA2.INVOICE_ID(+) = AIL2.INVOICE_ID
					AND AIL2.PREPAY_INVOICE_ID(+) = AI2.INVOICE_ID
					AND AI2.INVOICE_NUM =AI.INVOICE_NUM
					AND AI2.VENDOR_ID = AI.VENDOR_ID),NULL, AI.INVOICE_AMOUNT,  
					(AI.INVOICE_AMOUNT-
						(SELECT 
							SUM (AIL2.AMOUNT*-1)   
						 FROM
							AP_INVOICE_LINES_ALL AIL2,
							AP_INVOICES_ALL AI2,
							AP_INVOICES_ALL AIA2
						 WHERE
							AIA2.INVOICE_ID(+) = AIL2.INVOICE_ID
							AND AIL2.PREPAY_INVOICE_ID(+) = AI2.INVOICE_ID
							AND AI2.INVOICE_NUM =AI.INVOICE_NUM
							AND AI2.VENDOR_ID = AI.VENDOR_ID)
					)
				  ) * NVL(AI.EXCHANGE_RATE,1)) SALDO_PREPAYMENT,
				-- AI.INVOICE_NUM NO_INV_PREPAYMENT,
				-- AIA.INVOICE_NUM NO_INV,
				AI.ORG_ID
			FROM
				AP_INVOICES_ALL AI, 
				AP_INVOICE_LINES_ALL AIL,  
				AP_INVOICES_ALL AIA, 
				PO_VENDOR_SITES_ALL PVS,
				PO_VENDORS PV,	 
				HZ_PARTIES HP,
				AP_LOOKUP_CODES ALC, 
				AP_CHECKS_ALL AC,
				AP_INVOICE_PAYMENTS_ALL AIP
			WHERE
				AI.APPROVAL_READY_FLAG <> 'S'	
				AND PVS.VENDOR_SITE_CODE='$noInduk'
				AND ai.invoice_date BETWEEN TO_DATE('1/1/2015','MM/DD/YYYY') AND SYSDATE
				AND AC.CHECK_DATE BETWEEN TO_DATE('1/1/2015','MM/DD/YYYY') AND SYSDATE
				AND AI.INVOICE_TYPE_LOOKUP_CODE = 'PREPAYMENT'	
				AND (PV.VENDOR_NAME = 'KHS Employee' OR (PV.VENDOR_NAME like 'KHS_%' AND LENGTH(PVS.VENDOR_SITE_CODE) = 5)) 
				AND AI.VENDOR_SITE_ID = PVS.VENDOR_SITE_ID	 
				AND AIA.INVOICE_ID(+) = AIL.INVOICE_ID
				AND AIL.PREPAY_INVOICE_ID(+) = AI.INVOICE_ID	
				AND AI.PARTY_ID  = HP.PARTY_ID
				AND PV.VENDOR_ID = AI.VENDOR_ID  
				--AND AI.ORG_ID = 82
				AND ALC.LOOKUP_TYPE = 'PREPAY STATUS'
				AND ALC.LOOKUP_CODE = (													  
					AP_INVOICES_PKG.GET_APPROVAL_STATUS( AI.INVOICE_ID,
					AI.INVOICE_AMOUNT, AI.PAYMENT_STATUS_FLAG,
					AI.INVOICE_TYPE_LOOKUP_CODE))
				AND ALC.LOOKUP_CODE = 'AVAILABLE'
				AND AIP.INVOICE_ID(+) = AI.INVOICE_ID	
				AND AIP.CHECK_ID = AC.CHECK_ID 
				AND AC.STATUS_LOOKUP_CODE != 'VOIDED' 
			ORDER By 1
		");

		return $query->result_array();
	}

	public function getEmployee($noind)
	{
		$personalia = $this->load->database("personalia",true);
		$query = $personalia->query("
			select 
				emp.noind,
				emp.nama,
				emp.jabatan,
				seksi.dept,
				seksi.bidang,
				seksi.unit,
				seksi.seksi 
			from 
				hrd_khs.v_hrd_khs_tpribadi emp 
			join 
				hrd_khs.tseksi seksi on emp.kodesie = seksi.kodesie 
			where  
				emp.noind = '$noind'
		");
		
		return $query->result_array();
	}

	public function getEmployeeAll($employee)
	{
		$personalia = $this->load->database("personalia",true);
		$query = $personalia->query("
			select 
				emp.noind,
				emp.nama
			from 
				hrd_khs.v_hrd_khs_tpribadi emp
			where 
				upper(emp.noind) LIKE upper('%$employee%')
				or
				upper(emp.nama) LIKE upper('%$employee%')
		");
		
		return $query->result_array();
	}

	public function getPekerjaKeluar($tanggal1,$tanggal2, $keluar = 1){
		$personalia = $this->load->database("personalia",true);
		$sql = "select noind,nama,tglkeluar::date, ts.seksi
				from hrd_khs.tpribadi tp 
				left join hrd_khs.tseksi ts 
				on tp.kodesie = ts.kodesie
				where tglkeluar between '$tanggal1' and '$tanggal2' and keluar = '$keluar'";
				// echo $sql;exit();
		return $personalia->query($sql)->result_array();
	}

	public function getBill2($noInduk)
	{
		$oracle = $this->load->database("oracle",true);
		
		$query = $oracle->query("
			SELECT distinct
				PVS.VENDOR_SITE_CODE VENDOR_SITE_CODE,
				AI.DESCRIPTION,
				(AI.INVOICE_AMOUNT * NVL(AI.EXCHANGE_RATE,1)) AMOUNT_IDR,
				-- ( (AIL.AMOUNT *-1) * NVL(AIA.EXCHANGE_RATE,1) ) AMOUNT_APPLY,
				(DECODE(
				(SELECT 
					SUM (AIL2.AMOUNT*-1)   
				 FROM
					AP_INVOICE_LINES_ALL AIL2,
					AP_INVOICES_ALL AI2,
					AP_INVOICES_ALL AIA2
				 WHERE
					AIA2.INVOICE_ID(+) = AIL2.INVOICE_ID
					AND AIL2.PREPAY_INVOICE_ID(+) = AI2.INVOICE_ID
					AND AI2.INVOICE_NUM =AI.INVOICE_NUM
					AND AI2.VENDOR_ID = AI.VENDOR_ID),NULL, AI.INVOICE_AMOUNT,  
					(AI.INVOICE_AMOUNT-
						(SELECT 
							SUM (AIL2.AMOUNT*-1)   
						 FROM
							AP_INVOICE_LINES_ALL AIL2,
							AP_INVOICES_ALL AI2,
							AP_INVOICES_ALL AIA2
						 WHERE
							AIA2.INVOICE_ID(+) = AIL2.INVOICE_ID
							AND AIL2.PREPAY_INVOICE_ID(+) = AI2.INVOICE_ID
							AND AI2.INVOICE_NUM =AI.INVOICE_NUM
							AND AI2.VENDOR_ID = AI.VENDOR_ID)
					)
				  ) * NVL(AI.EXCHANGE_RATE,1)) SALDO_PREPAYMENT,
				-- AI.INVOICE_NUM NO_INV_PREPAYMENT,
				-- AIA.INVOICE_NUM NO_INV,
				AI.ORG_ID
			FROM
				AP_INVOICES_ALL AI, 
				AP_INVOICE_LINES_ALL AIL,  
				AP_INVOICES_ALL AIA, 
				PO_VENDOR_SITES_ALL PVS,
				PO_VENDORS PV,	 
				HZ_PARTIES HP,
				AP_LOOKUP_CODES ALC, 
				AP_CHECKS_ALL AC,
				AP_INVOICE_PAYMENTS_ALL AIP
			WHERE
				AI.APPROVAL_READY_FLAG <> 'S'	
				AND PVS.VENDOR_SITE_CODE in ($noInduk)
				AND ai.invoice_date BETWEEN TO_DATE('1/1/2015','MM/DD/YYYY') AND SYSDATE
				AND AC.CHECK_DATE BETWEEN TO_DATE('1/1/2015','MM/DD/YYYY') AND SYSDATE
				AND AI.INVOICE_TYPE_LOOKUP_CODE = 'PREPAYMENT'	
				AND (PV.VENDOR_NAME = 'KHS Employee' OR (PV.VENDOR_NAME like 'KHS_%' AND LENGTH(PVS.VENDOR_SITE_CODE) = 5)) 
				AND AI.VENDOR_SITE_ID = PVS.VENDOR_SITE_ID	 
				AND AIA.INVOICE_ID(+) = AIL.INVOICE_ID
				AND AIL.PREPAY_INVOICE_ID(+) = AI.INVOICE_ID	
				AND AI.PARTY_ID  = HP.PARTY_ID
				AND PV.VENDOR_ID = AI.VENDOR_ID  
				--AND AI.ORG_ID = 82
				AND ALC.LOOKUP_TYPE = 'PREPAY STATUS'
				AND ALC.LOOKUP_CODE = (													  
					AP_INVOICES_PKG.GET_APPROVAL_STATUS( AI.INVOICE_ID,
					AI.INVOICE_AMOUNT, AI.PAYMENT_STATUS_FLAG,
					AI.INVOICE_TYPE_LOOKUP_CODE))
				AND ALC.LOOKUP_CODE = 'AVAILABLE'
				AND AIP.INVOICE_ID(+) = AI.INVOICE_ID	
				AND AIP.CHECK_ID = AC.CHECK_ID 
				AND AC.STATUS_LOOKUP_CODE != 'VOIDED' 
			ORDER By 1
		");

		return $query->result_array();
	}

}