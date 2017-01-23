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

		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("select
								aia.invoice_id, ass.vendor_name,aia.invoice_num,aia.invoice_date,aila.description,aia.invoice_amount-nvl(aia.total_tax_amount,0) DPP,
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
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("SELECT vendor_name FROM ap_suppliers WHERE vendor_name LIKE '$supplier%'");
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
									TO_CHAR (aia.invoice_date, 'DD-MON-YYYY') AS TODATE,
									TO_CHAR(TO_DATE(aia.ATTRIBUTE4 , 'YYYY/MM/DD hh24:mi:ss'),'DD-MON-YYYY') AS FAKTUR_DATE,
									aila.description,
									aia.invoice_amount - NVL( aia.total_tax_amount, 0 ) DPP,
									NVL( aia.total_tax_amount, 0 ) PPN,
									aia.attribute5 tax_number_depan,
									aia.attribute3 tax_number_belakang
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
	
	public function FindFaktur($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2){
		
		//VARIABLES
		$qmonth 	= "'$month'"; if($month==""){$qmonth="month";}
		$qyear 		= "'$year'"; if($year==""){$qyear="year";}
		$qinvnum 	= "'$invoice_num'"; if($invoice_num==""){$qinvnum="faktur_pajak";}
		$qname 		= "'$name'"; if($name==""){$qname="name";}
		
		$qket		= "description";
						if($ket1=="yes" && $ket2=="no"){$qket="'REPORTED'";}
						else if($ket1=="no" && $ket2=="yes"){$qket="'UNREPORTED'";}
		
		$qsta		= "status";
						if($sta1=="yes"){
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="'NORMAL' or 'PENGGANTI' or 'DIGANTI'"; //semua
								} else {
									$qsta="'NORMAL' or 'PENGGANTI'"; // A dan B
								}
							} else {
								if($sta3=="yes"){
									$qsta="'NORMAL' or 'DIGANTI'"; // A dan C
								} else {
									$qsta="'NORMAL'"; // A
								}
							}
						} else {
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="'PENGGANTI' or 'DIGANTI'"; // B dan C
								} else {
									$qsta="'PENGGANTI'"; // B
								}
							} else {
								if($sta3=="yes"){
									$qsta="'DIGANTI'"; // C
								} else {
									$qsta="status"; //semua
								}
							}
						}

		$qtyp		= "faktur_type";
						if($typ1=="yes" && $typ2=="no"){$qtyp="'Y'";}
						else if($typ1=="no" && $typ2=="yes"){$qtyp="'N'";}
		
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT FAKTUR_WEB_ID
				,FAKTUR_PAJAK
				,MONTH
				,YEAR
				,case when faktur_date
					is NULL then null 	
					else to_char(faktur_date, 'DD/MM/YY')
					end as faktur_date
				,NPWP
				,NAME
				,ADDRESS
				,DPP
				,PPN
				,PPN_BM
				,IS_CREDITABLE_FLAG
				,DESCRIPTION
				,STATUS
				,FM
			FROM khs_faktur_web
			where month=$qmonth
				and year=$qyear
				and faktur_pajak = $qinvnum
				and name = $qname
				and description = $qket
				and (status = $qsta)
				and faktur_type = $qtyp
		");
		return $query->result();
	}
	
	//download data as CSV (compatible)
	function FindFakturCSV($month,$year,$invoice_num,$name,$ket1,$ket2,$sta1,$sta2,$sta3,$typ1,$typ2)
	{	
		//VARIABLES
		$qmonth 	= "'$month'"; if($month==""){$qmonth="month";}
		$qyear 		= "'$year'"; if($year==""){$qyear="year";}
		$qinvnum 	= "'$invoice_num'"; if($invoice_num==""){$qinvnum="faktur_pajak";}
		$qname 		= "'$name'"; if($name==""){$qname="name";}
		
		$qket		= "description";
						if($ket1=="yes" && $ket2=="no"){$qket="'REPORTED'";}
						else if($ket1=="no" && $ket2=="yes"){$qket="'UNREPORTED'";}
		
		$qsta		= "status";
						if($sta1=="yes"){
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="'NORMAL' or 'PENGGANTI' or 'DIGANTI'"; //semua
								} else {
									$qsta="'NORMAL' or 'PENGGANTI'"; // A dan B
								}
							} else {
								if($sta3=="yes"){
									$qsta="'NORMAL' or 'DIGANTI'"; // A dan C
								} else {
									$qsta="'NORMAL'"; // A
								}
							}
						} else {
							if($sta2=="yes"){
								if($sta3=="yes"){
									$qsta="'PENGGANTI' or 'DIGANTI'"; // B dan C
								} else {
									$qsta="'PENGGANTI'"; // B
								}
							} else {
								if($sta3=="yes"){
									$qsta="'DIGANTI'"; // C
								} else {
									$qsta="status"; //semua
								}
							}
						}

		$qtyp		= "faktur_type";
						if($typ1=="yes" && $typ2=="no"){$qtyp="'Y'";}
						else if($typ1=="no" && $typ2=="yes"){$qtyp="'N'";}
						
		$this->load->dbutil();
		
		$oracle = $this->load->database("oracle",true);
		$q=$oracle->query("
			SELECT FM
				,SUBSTR(FAKTUR_PAJAK,0,2) AS KODE_JENIS_TRANS
				,SUBSTR(FAKTUR_PAJAK,3,1) AS FG_PENGGANTI
				,SUBSTR(FAKTUR_PAJAK,4) AS NOMOR_FAKTUR
				,MONTH AS MASA_PAJAK
				,YEAR AS TAHUN_PAJAK
				,case when faktur_date
					is NULL then null 	
					else to_char(faktur_date, 'DD/MM/YYYY')
					end as TANGGAL_FAKTUR
				,NPWP
				,NAME AS NAMA
				,ADDRESS AS ALAMAT_LENGKAP
				,DPP
				,PPN
				,PPN_BM
				,IS_CREDITABLE_FLAG

			FROM khs_faktur_web
			where month=$qmonth
				and year=$qyear
				and faktur_pajak = $qinvnum
				and name = $qname
				and description = $qket
				and (status = $qsta)
				and faktur_type = $qtyp
		"
		);
		$delimiter = ",";
		$newline = "\r\n";
		return $this->dbutil->csv_from_result($q,$delimiter,$newline);
	}
	
	public function saveTaxNumber($invoice_id, $invoice_date, $tax_number_awal, $tax_number_akhir){
		$oracle = $this->load->database("oracle",true);
		// echo "UPDATE ap_invoices_all SET ATTRIBUTE5 = '$tax_number_awal', ATTRIBUTE3 = '$tax_number_akhir' WHERE INVOICE_ID = '$invoice_id'";
		$date=date_create($invoice_date);
		$invoice_date_fix = date_format($date,"Y/m/d H:i:s");
		$query = $oracle->query("UPDATE ap_invoices_all
								SET ATTRIBUTE5 = '$tax_number_awal',
									ATTRIBUTE3 = '$tax_number_akhir',
									ATTRIBUTE4 = '$invoice_date_fix'
								WHERE INVOICE_ID = '$invoice_id'
		");
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
		$query = $oracle->query("
			DELETE
			FROM khs_faktur_web
			WHERE FAKTUR_PAJAK = '$invoice_num'
		");

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
	
}