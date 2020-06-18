<?php
class M_invoice extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function alldata($tanggal_awal, $tanggal_akhir, $supplier, $invoice_number, $invoice_status, $voucher_number){

		if($supplier == ''){
			$supplier = '%';
		}
		if($invoice_number == ''){
			$invoice_number = '%';
		}
		if($voucher_number == ''){
			$voucher_number = '%';
		}
		if($invoice_status == 1){
			$attribute = ' ';
		}else if($invoice_status == 2){
			$attribute = 'and aia.attribute3 is NOT NULL ';
		}else if($invoice_status == 3){
			$attribute = 'and aia.attribute3 is NULL ';
		}

		$supplier 		= str_replace("'", "''", $supplier);

		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("select
								aia.invoice_id, ass.vendor_name,aia.invoice_num,aia.invoice_date,aia.invoice_amount-nvl(aia.total_tax_amount,0) DPP,
								nvl(aia.total_tax_amount,0) PPN,aia.attribute5 tax_number_depan, aia.attribute3 tax_number_belakang, aia.attribute15 voucher_number,
								COUNT(*) 
								OVER (PARTITION BY aia.invoice_id) JML
								from
								ap_suppliers ass,
								ap_invoices_all aia,
								ap_invoice_lines_all aila
								where 
								1=1
								and aia.vendor_id = ass.vendor_id
								and aia.invoice_id = aila.invoice_id
								and aia.cancelled_date is NULL
								and invoice_date BETWEEN TO_DATE('$tanggal_awal','DD-MM-YYYY') AND TO_DATE('$tanggal_akhir','DD-MM-YYYY')
								AND ass.vendor_name LIKE '$supplier'
								AND aia.invoice_num LIKE '$invoice_number'
								AND aia.attribute15 LIKE '$voucher_number'
								$attribute"
		);
		return $query->result();
	}
	public function getSupplier($supplier){
		$supplier 		= str_replace("'", "''", $supplier);
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT vendor_name FROM ap_suppliers WHERE vendor_name LIKE '%$supplier%'");
		return $query->result_array();
	}

	
	public function getInvoiceNumber($invoice_num,$start_date,$end_date,$supplier){
		$vendor="'$supplier'";
		if($supplier==""){$vendor="b.VENDOR_NAME";}
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT a.INVOICE_NUM
			FROM ap_invoices_all a
			LEFT JOIN ap_suppliers b on a.VENDOR_ID = b.VENDOR_ID
			WHERE
				(a.INVOICE_NUM LIKE '$invoice_num%') AND
				(b.VENDOR_NAME = $vendor) AND
				(a.INVOICE_DATE BETWEEN TO_DATE('$start_date', 'DD-MM-YYYY') AND TO_DATE('$end_date', 'DD-MM-YYYY'))");
		return $query->result_array();
	}
	
	public function getVoucherNumber($voucher_num,$start_date,$end_date){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT ATTRIBUTE15
			FROM ap_invoices_all
			WHERE
				(ATTRIBUTE15 LIKE '$voucher_num%') AND
				(INVOICE_DATE BETWEEN TO_DATE('$start_date', 'DD-MM-YYYY') AND TO_DATE('$end_date', 'DD-MM-YYYY'))");
		return $query->result_array();
	}
	
	public function getInvoiceNumber2($period,$year,$invoice_num){
		$qperiod="'$period'"; if($period==""){$qperiod="month";}
		$qyear="'$year'"; if($year==""){$qyear="year";}
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			 SELECT *
			 FROM khs_faktur_web
			 WHERE month=$qperiod
				AND year=$qyear
				AND faktur_pajak LIKE '$invoice_num%'");
		return $query->result_array();
	}
	
	public function getInvoiceNumber3($invoice_num){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT name FROM khs_faktur_web WHERE faktur_pajak='$invoice_num'");
		return $query->result_array();
	}
	
	public function getInvoiceName($name){
		
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT DISTINCT name FROM khs_faktur_web WHERE upper(name) LIKE upper('%$name%')");
		return $query->result_array();
	}

	public function getDetail($invoice_id){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
								SELECT
									aia.invoice_id,
									ass.vendor_name,
									aia.invoice_num,
									TO_CHAR (aia.invoice_date, 'DD/MM/YYYY') AS TODATE,
									TO_CHAR(TO_DATE(aia.ATTRIBUTE4 , 'YYYY/MM/DD hh24:mi:ss'),'DD/MM/YYYY') AS FAKTUR_DATE,
									aila.description,
									aia.invoice_amount - NVL( aia.total_tax_amount, 0 ) DPP,
									NVL( aia.total_tax_amount, 0 ) PPN,
									aia.attribute5 tax_number_depan,
									aia.attribute3 tax_number_belakang,
									ass.VAT_REGISTRATION_NUM NPWP
								FROM
									ap_suppliers ass,
									ap_invoices_all aia,
									ap_invoice_lines_all aila
								WHERE
									1 = 1 
									and aia.vendor_id = ass.vendor_id 
									and aia.invoice_id = aila.invoice_id 
									AND aia.invoice_id = '$invoice_id'
		");
		return $query->result();
	}
	
	public function FindFaktur($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir){
		
		//VARIABLES
		$qmonth 	= "AND kfw.month = '$month'"; if($month==""){$qmonth="";}
		$qyear 		= "AND kfw.year = '$year'"; if($year==""){$qyear="";}
		$qinvnum 	= "AND kfw.faktur_pajak = '$invoice_num'"; if($invoice_num==""){$qinvnum="";}
		$qname 		= "AND kfw.name = '$name'"; if($name==""){$qname="";}
		
		$qket		= "";
						if($ket1=="yes" && $ket2=="no"){$qket="and kfw.description = 'REPORTED'";}
						else if($ket1=="no" && $ket2=="yes"){$qket="and kfw.description = 'UNREPORTED'";}
						else{$qket="";}
		
		$qsta		= "";
						if($sta1=="yes"){
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'NORMAL' or 'PENGGANTI' or 'DIGANTI')"; //semua
								} else {
									$qsta="and (kfw.status = 'NORMAL' or 'PENGGANTI')"; // A dan B
								}
							} else {
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'NORMAL' or 'DIGANTI')"; // A dan C
								} else {
									$qsta="and (kfw.status = 'NORMAL')"; // A
								}
							}
						} else {
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'PENGGANTI' or 'DIGANTI')"; // B dan C
								} else {
									$qsta="and (kfw.status = 'PENGGANTI')"; // B
								}
							} else {
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'DIGANTI')"; // C
								} else {
									$qsta=""; //semua
								}
							}
						}

		$qtyp		= "";
						if($typ1=="yes" && $typ2=="no"){$qtyp="and kfw.faktur_type = 'Y'";}
						else if($typ1=="no" && $typ2=="yes"){$qtyp="and kfw.faktur_type = 'N'";}
						else if($typ1=="yes" && $typ2=="yes"){$qtyp="";}
		
		$oracle = $this->load->database("oracle",true);
		
		$query = $oracle->query("
			SELECT kfw.FAKTUR_WEB_ID
				,kfw.FAKTUR_PAJAK
				,kfw.MONTH
				,kfw.YEAR
				,case when kfw.faktur_date
					is NULL then null 	
					else to_char(kfw.faktur_date, 'DD/MM/YY')
					end as faktur_date
				,kfw.NPWP
				,kfw.NAME
				,kfw.ADDRESS
				,kfw.DPP
				,kfw.PPN
				,kfw.PPN_BM
				,kfw.IS_CREDITABLE_FLAG
				,kfw.DESCRIPTION
				,kfw.STATUS
				,kfw.FM
				,kfw.COMMENTS
				,decode(kfw.FAKTUR_TYPE,'N','WITHOUT INVOICE','WITH INVOICE')  FAKTUR_TYPE
				,aia.INVOICE_NUM
				,max(aca.CHECK_DATE) PAYMENT_DATE
			FROM khs_faktur_web kfw 
			,ap_invoices_all aia
			,ap_invoice_payments_all aip
			,ap_checks_all aca
			where 
				1=1
				$qmonth
				$qyear
				$qinvnum
				$qname
				$qket
				$qsta
				$qtyp
				and aia.INVOICE_ID(+) = kfw.INVOICE_ID
				and aia.INVOICE_ID = aip.INVOICE_ID(+)
				and aip.CHECK_ID = aca.CHECK_ID(+)
				and faktur_date BETWEEN TO_DATE('$tanggal_awal','DD-MM-YYYY') AND TO_DATE('$tanggal_akhir','DD-MM-YYYY')
				and NPWP IS NOT NULL
			group by 
				kfw.FAKTUR_WEB_ID
				,kfw.FAKTUR_PAJAK
				,kfw.MONTH
				,kfw.YEAR
				,kfw.faktur_date
				,kfw.NPWP
				,kfw.NAME
				,kfw.ADDRESS
				,kfw.DPP
				,kfw.PPN
				,kfw.PPN_BM
				,kfw.IS_CREDITABLE_FLAG
				,kfw.DESCRIPTION
				,kfw.STATUS
				,kfw.FM
				,kfw.COMMENTS
				,kfw.FAKTUR_TYPE
				,aia.INVOICE_NUM
		");
		
		return $query->result();
	}
	
	//download data as CSV (compatible)
	function FindFakturCSV($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2,$tanggal_awal,$tanggal_akhir)
	{	
		//VARIABLES
		$qmonth 	= "AND month = '$month'"; if($month==""){$qmonth="";}
		$qyear 		= "AND year = '$year'"; if($year==""){$qyear="";}
		$qinvnum 	= "AND faktur_pajak = '$invoice_num'"; if($invoice_num==""){$qinvnum="";}
		$qname 		= "AND name = '$name'"; if($name==""){$qname="";}
		
		$qket		= "";
						if($ket1=="yes" && $ket2=="no"){$qket="and kfw.description = 'REPORTED'";}
						else if($ket1=="no" && $ket2=="yes"){$qket="and kfw.description = 'UNREPORTED'";}
						else{$qket="";}
		
		$qsta		= "";
						if($sta1=="yes"){
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'NORMAL' or 'PENGGANTI' or 'DIGANTI')"; //semua
								} else {
									$qsta="and (kfw.status = 'NORMAL' or 'PENGGANTI')"; // A dan B
								}
							} else {
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'NORMAL' or 'DIGANTI')"; // A dan C
								} else {
									$qsta="and (kfw.status = 'NORMAL')"; // A
								}
							}
						} else {
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'PENGGANTI' or 'DIGANTI')"; // B dan C
								} else {
									$qsta="and (kfw.status = 'PENGGANTI')"; // B
								}
							} else {
								if($sta3=="yes"){
									$qsta="and (kfw.status = 'DIGANTI')"; // C
								} else {
									$qsta=""; //semua
								}
							}
						}

		$qtyp		= "";
						if($typ1=="yes" && $typ2=="no"){$qtyp="and kfw.faktur_type = 'Y'";}
						else if($typ1=="no" && $typ2=="yes"){$qtyp="and kfw.faktur_type = 'N'";}
						else if($typ1=="yes" && $typ2=="yes"){$qtyp="";}
						
		$this->load->dbutil();
		
		$oracle = $this->load->database("oracle",true);
		$q=$oracle->query("
			SELECT kfw.FM
				,SUBSTR(kfw.FAKTUR_PAJAK,0,2) AS KODE_JENIS_TRANS
				,SUBSTR(kfw.FAKTUR_PAJAK,3,1) AS FG_PENGGANTI
				,SUBSTR(kfw.FAKTUR_PAJAK,4) AS NOMOR_FAKTUR
				,kfw.MONTH AS MASA_PAJAK
				,kfw.YEAR AS TAHUN_PAJAK
				,case when kfw.faktur_date
					is NULL then null     
					else to_char(kfw.faktur_date, 'DD/MM/YYYY')
					end as TANGGAL_FAKTUR
				,kfw.NPWP
				,kfw.NAME AS NAMA
				,kfw.ADDRESS AS ALAMAT_LENGKAP
				,kfw.DPP
				,kfw.PPN
				,kfw.PPN_BM
				,kfw.IS_CREDITABLE_FLAG
				,aia.INVOICE_NUM
				,max(aca.CHECK_DATE) PAYMENT_DATE
			FROM khs_faktur_web kfw 
			,ap_invoices_all aia
			,ap_invoice_payments_all aip
			,ap_checks_all aca
			where 
				1=1
				$qmonth
				$qyear
				$qinvnum
				$qname
				$qket
				$qsta
				$qtyp
				and aia.INVOICE_ID(+) = kfw.INVOICE_ID
				and aia.INVOICE_ID = aip.INVOICE_ID(+)
				and aip.CHECK_ID = aca.CHECK_ID(+)
				and faktur_date BETWEEN TO_DATE('$tanggal_awal','DD-MM-YYYY') AND TO_DATE('$tanggal_akhir','DD-MM-YYYY')
				and NPWP IS NOT NULL
				group by 
				kfw.FM
				,kfw.FAKTUR_PAJAK
				,kfw.MONTH
				,kfw.YEAR
				,kfw.faktur_date
				,kfw.NPWP
				,kfw.NAME
				,kfw.ADDRESS
				,kfw.DPP
				,kfw.PPN
				,kfw.PPN_BM
				,kfw.IS_CREDITABLE_FLAG
				,aia.INVOICE_NUM
		"
		);
		$delimiter = ",";
		$newline = "\r\n";
		return $this->dbutil->csv_from_result($q,$delimiter,$newline);
	}
	
	public function saveTaxNumber($invoice_id, $tanggalFaktur, $tanggalFakturCon, $tax_number_awal, $tax_number_akhir, $tax_number, $npwpPenjual, $namaPenjual, $alamatPenjual, $dpp, $ppn, $ppnbm, $faktur_type, $comment ){

		$npwpPenjual 	= str_replace("'", "''", $npwpPenjual);
		$namaPenjual 	= str_replace("'", "''", $namaPenjual);
		$alamatPenjual 	= str_replace("'", "''", $alamatPenjual);
		$comment 		= str_replace("'", "''", $comment);

		$checkFak = $this->M_Invoice->checkFaktur($tax_number);
		$oracle = $this->load->database("oracle",true);
		// echo "UPDATE ap_invoices_all SET ATTRIBUTE5 = '$tax_number_awal', ATTRIBUTE3 = '$tax_number_akhir' WHERE INVOICE_ID = '$invoice_id'";
		$query = true;
		if ($invoice_id != NULL || $invoice_id != '') {
			$date=date_create($tanggalFakturCon);
			$tanggalFaktur_fix = date_format($date,"Y/m/d H:i:s");
			$query = $oracle->query("UPDATE ap_invoices_all
									SET ATTRIBUTE5 = '$tax_number_awal',
										ATTRIBUTE3 = '$tax_number_akhir',
										ATTRIBUTE4 = '$tanggalFaktur_fix'
									WHERE INVOICE_ID = '$invoice_id'
									");
		};
		
		if ($checkFak) {
			$query1 = $oracle->query("UPDATE khs_faktur_web
									SET
									FAKTUR_PAJAK 		= '$tax_number', 
									MONTH 				= '0', 
									YEAR 				= '0', 
									FAKTUR_DATE 		= TO_DATE('$tanggalFaktur','DD/MM/YYYY'), 
									NPWP 				= '$npwpPenjual', 
									NAME 				= '$namaPenjual', 
									ADDRESS 			= '$alamatPenjual', 
									DPP 				= '$dpp', 
									PPN 				= '$ppn', 
									PPN_BM 				= '$ppnbm',
									IS_CREDITABLE_FLAG 	= '1', 
									DESCRIPTION 		= 'UNREPORTED', 
									STATUS 				= '-', 
									FM 					= 'FM', 
									INVOICE_ID 			= '$invoice_id', 
									FAKTUR_TYPE 		= '$faktur_type', 
									COMMENTS 			= '$comment'
									WHERE FAKTUR_PAJAK 	= '$tax_number'
			");
		} else {
			$query1 = $oracle->query("INSERT INTO 
									khs_faktur_web
									(FAKTUR_PAJAK, MONTH, YEAR, FAKTUR_DATE, NPWP, NAME, ADDRESS, 
									DPP, PPN, PPN_BM,IS_CREDITABLE_FLAG, DESCRIPTION, STATUS, FM, INVOICE_ID, FAKTUR_TYPE, COMMENTS)
									VALUES
									('$tax_number','0','0', TO_DATE('$tanggalFaktur','DD/MM/YYYY'),'$npwpPenjual', 
									'$namaPenjual', '$alamatPenjual', '$dpp', '$ppn', '$ppnbm', '1', 'UNREPORTED', '-', 'FM','$invoice_id', '$faktur_type', '$comment' )
			");
		};
		return $query*$query1;
	}

	public function saveTaxNumberManual($invoice_id, $tanggalFakturCon, $tax_number_awal, $tax_number_akhir, $tax_number, $seller){

		$oracle = $this->load->database("oracle",true);
		$checkFak = $this->M_Invoice->checkFaktur($tax_number);
		// echo "UPDATE ap_invoices_all SET ATTRIBUTE5 = '$tax_number_awal', ATTRIBUTE3 = '$tax_number_akhir' WHERE INVOICE_ID = '$invoice_id'";
		$query = true;
		if ($invoice_id != NULL || $invoice_id != '') {
			$date=date_create($tanggalFakturCon);
			$tanggalFaktur_fix = date_format($date,"Y/m/d H:i:s");
			$query = $oracle->query("UPDATE ap_invoices_all
									SET ATTRIBUTE5 = '$tax_number_awal',
										ATTRIBUTE3 = '$tax_number_akhir',
										ATTRIBUTE4 = '$tanggalFaktur_fix'
									WHERE INVOICE_ID = '$invoice_id'
									");
		};

		if ($checkFak){
			$oracle->query("UPDATE KHS_FAKTUR_WEB SET SELLER = '$seller' WHERE FAKTUR_PAJAK = '$tax_number'");
		} else {
			$oracle->query("INSERT INTO KHS_FAKTUR_WEB(FAKTUR_PAJAK, SELLER) VALUES ('$tax_number', '$seller')");
		}

		return $query;
	}

	public function deleteTaxNumber($invoice_id, $invoice_num){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			UPDATE ap_invoices_all
			SET ATTRIBUTE3 = '',
				ATTRIBUTE4 = '',
				ATTRIBUTE5 = ''
			WHERE INVOICE_ID = '$invoice_id'
		");
		if ($invoice_num != NULL || $invoice_num != '') {
			$query = $oracle->query("
				DELETE
				FROM khs_faktur_web
				WHERE FAKTUR_PAJAK = '$invoice_num'
			");
		};
			

		return $query;

	}
	
	public function UpdateFmDesc($update_data){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("UPDATE khs_faktur_web
								SET DESCRIPTION = 'REPORTED',
									STATUS = '$update_data[STATUS]',
									MONTH = '$update_data[MONTH]',
									YEAR = '$update_data[YEAR]' 
								WHERE FAKTUR_PAJAK = '$update_data[FAKTUR_PAJAK]'
		");
		return $query;

	}

	public function findSingleFaktur($invoice_id){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT * FROM khs_faktur_web WHERE invoice_id = '$invoice_id'");
		return $query->result();

	}

	public function checkInvoice($invoice){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT ATTRIBUTE3
								FROM ap_invoices_all
								WHERE INVOICE_ID = '$invoice'
								");
		return $query->result_array();

	}

	public function checkFaktur($faktur){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT FAKTUR_PAJAK
								FROM khs_faktur_web
								WHERE FAKTUR_PAJAK = '$faktur'
								");
		return $query->result_array();

	}

	public function checkInvFak($atr5, $atr3){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT ATTRIBUTE3, ATTRIBUTE5
								FROM ap_invoices_all
								WHERE 
								ATTRIBUTE5 = '$atr5'
								AND ATTRIBUTE3 = '$atr3'
								AND CANCELLED_DATE is NULL
								");
		return $query->result_array();

	}
	
}