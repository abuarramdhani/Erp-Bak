<?php
class M_klikbcachecking_check extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	public function ShowBCA($start,$end){
		$sql = "
			select *,
			case when oracle_checking is NULL then '-' else oracle_checking end as checking_status,
			case when upload_date
				is NULL then null 	
				else to_char(upload_date,'DD-MM-YYYY')
				end as tanggal,
			case when checking_date
				is NULL then null 	
				else to_char(checking_date,'DD-MM-YYYY')
				end as tanggal_cek
			from ap.ap_klikbca_checking 
			where upload_date between TO_DATE('$start', 'YYYY/MM/DD') and TO_DATE('$end', 'YYYY/MM/DD')
			order by no_referensi";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function ShowBCAGeneral(){
		$sql = "
			select *,
			case when oracle_checking is NULL then '-' else oracle_checking end as checking_status,
			case when upload_date
				is NULL then null 	
				else to_char(upload_date,'DD-MM-YYYY')
				end as tanggal,
			case when checking_date
				is NULL then null 	
				else to_char(checking_date,'DD-MM-YYYY')
				end as tanggal_cek
			from ap.ap_klikbca_checking";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function MatchWithOracle($berita,$no_rek_penerima,$jumlah){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT *
			FROM (
				SELECT DISTINCT
					PAY_NUMBER
					,PAY_DATE
					,VENDOR
					,DARI_BANK 
					,BANK_TUJUAN
					,REK_TUJUAN
					,ACCT_TUJUAN
					,CREATION_DATE
					,SITE
					,NOREK
					,AMOUNT
					,AMOUNT * NVL(RATE,1) AMOUNT_PAYMENT
					,VOUCHER VOCER
					,CHARGE
					,CURR
					,NVL(RATE,1) RATE
					,SUM(TOTAL) OVER (PARTITION BY VOUCHER,PAY_NUMBER) TOTAL
					,(SUM(TOTAL) OVER (PARTITION BY VOUCHER,PAY_NUMBER) * NVL(RATE,1)) TOTAL_IDR_AMOUNT
					,BRANCH_TUJUAN
					--,TOTAL
					,ORG_ID
				FROM (
				select distinct
				    nvl(aia.attribute15,aba.batch_name) voucher
				    ,aca.check_date pay_date
				    ,to_date(aca.creation_date,'DD/MM/RRRR') creation_date
				    ,case when aca.vendor_name in ('KHS Komisi','KHS INSIDENTIL','KHS Employee','KHS Jakarta Eceran')
				        then
				            (select distinct
				                    aca2.vendor_name ||'-'|| aca2.VENDOR_SITE_CODE
				                from ap_checks_all aca2
				                where
				                    aca.vendor_id = aca2.vendor_id
				                    and aca2.check_number = aca.check_number
				                )             
				        else
				            aca.VENDOR_NAME            
				     end vendor
				    ,aca.vendor_site_code site
				    ,cba.bank_account_name dari_bank
				    ,cba.bank_account_num norek
				    ,aca.amount
				    ,max(to_number(aca.attribute1)) over (partition by aca.vendor_name, aca.check_date) charge
				    ,case when
				        max(aca.currency_code) over (partition by aca.vendor_name) = min(aca.currency_code) over (partition by aca.vendor_name)
				        then sum(aca.amount) over (partition by aca.vendor_name,ieba.bank_account_num_electronic) 
				     end enuma
				    ,aca.currency_code curr
				    ,bp.party_name bank_tujuan
				    ,ieba.bank_account_num_electronic rek_tujuan
				    ,branch.party_name branch_tujuan
				    ,ieba.bank_account_name acct_tujuan
				    ,to_char(aca.check_number) pay_number
				    ,nvl(aca.exchange_rate,1) rate
				    ,aip.amount total
				    ,aca.org_id
				    ,aia.invoice_id
				    ,aca.check_id
				from
				    ap.ap_checks_all aca
				    ,ap_invoices_all aia
				    ,ap_batches_all aba
				    ,ap_invoice_payments_all aip
				    ,ce_bank_accounts cba
				    ,ce_bank_acct_uses_all cbau
				    ,iby_ext_bank_accounts ieba
				    ,hz_parties bp
				    ,hz_parties branch
				    ,fnd_lookup_values lv
				where
				    aia.invoice_id = aip.invoice_id
				    and aip.check_id = aca.check_id     
				    and aca.attribute13 is null
				    and aba.batch_id(+) = aia.batch_id 
				    and cbau.bank_account_id = cba.bank_account_id(+)
				    and aca.ce_bank_acct_use_id = cbau.bank_acct_use_id(+)
				    and aca.external_bank_account_id = ieba.ext_bank_account_id(+)
				    and ieba.bank_id = bp.party_id(+) 
				    and lv.lookup_code = aca.payment_type_flag
				    and aca.status_lookup_code = 'NEGOTIABLE'
				    and lv.meaning = 'Quick'
				    and lv.lookup_type = 'PAYMENT TYPE'    
				    and ieba.branch_id = branch.party_id(+) 
				   	
				) L
				ORDER BY PAY_NUMBER
			)
			WHERE
				PAY_NUMBER = '$berita'
				AND REK_TUJUAN = '$no_rek_penerima'
				AND AMOUNT = '$jumlah'
		");
		return $query->result_array();
	}

	public function GetOracle(){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT DISTINCT
				PAY_NUMBER
				,PAY_DATE
				,VENDOR
				,DARI_BANK 
				,BANK_TUJUAN
				,REK_TUJUAN
				,ACCT_TUJUAN
				,CREATION_DATE
				,SITE
				,NOREK
				,AMOUNT
				,AMOUNT * NVL(RATE,1) AMOUNT_PAYMENT
				,VOUCHER VOCER
				,CHARGE
				,CURR
				,NVL(RATE,1) RATE
				,SUM(TOTAL) OVER (PARTITION BY VOUCHER,PAY_NUMBER) TOTAL
				,(SUM(TOTAL) OVER (PARTITION BY VOUCHER,PAY_NUMBER) * NVL(RATE,1)) TOTAL_IDR_AMOUNT
				,BRANCH_TUJUAN
				--,TOTAL
				,ORG_ID
			FROM (
			select distinct
			    nvl(aia.attribute15,aba.batch_name) voucher
			    ,aca.check_date pay_date
			    ,to_date(aca.creation_date,'DD/MM/RRRR') creation_date
			    ,case when aca.vendor_name in ('KHS Komisi','KHS INSIDENTIL','KHS Employee','KHS Jakarta Eceran')
			        then
			            (select distinct
			                    aca2.vendor_name ||'-'|| aca2.VENDOR_SITE_CODE
			                from ap_checks_all aca2
			                where
			                    aca.vendor_id = aca2.vendor_id
			                    and aca2.check_number = aca.check_number
			                )             
			        else
			            aca.VENDOR_NAME            
			     end vendor
			    ,aca.vendor_site_code site
			    ,cba.bank_account_name dari_bank
			    ,cba.bank_account_num norek
			    ,aca.amount
			    ,max(to_number(aca.attribute1)) over (partition by aca.vendor_name, aca.check_date) charge
			    ,case when
			        max(aca.currency_code) over (partition by aca.vendor_name) = min(aca.currency_code) over (partition by aca.vendor_name)
			        then sum(aca.amount) over (partition by aca.vendor_name,ieba.bank_account_num_electronic) 
			     end enuma
			    ,aca.currency_code curr
			    ,bp.party_name bank_tujuan
			    ,ieba.bank_account_num_electronic rek_tujuan
			    ,branch.party_name branch_tujuan
			    ,ieba.bank_account_name acct_tujuan
			    ,to_char(aca.check_number) pay_number
			    ,nvl(aca.exchange_rate,1) rate
			    ,aip.amount total
			    ,aca.org_id
			    ,aia.invoice_id
			    ,aca.check_id
			from
			    ap.ap_checks_all aca
			    ,ap_invoices_all aia
			    ,ap_batches_all aba
			    ,ap_invoice_payments_all aip
			    ,ce_bank_accounts cba
			    ,ce_bank_acct_uses_all cbau
			    ,iby_ext_bank_accounts ieba
			    ,hz_parties bp
			    ,hz_parties branch
			    ,fnd_lookup_values lv
			where
			    aia.invoice_id = aip.invoice_id
			    and aip.check_id = aca.check_id     
			    and aca.attribute13 is null
			    and aba.batch_id(+) = aia.batch_id 
			    and cbau.bank_account_id = cba.bank_account_id(+)
			    and aca.ce_bank_acct_use_id = cbau.bank_acct_use_id(+)
			    and aca.external_bank_account_id = ieba.ext_bank_account_id(+)
			    and ieba.bank_id = bp.party_id(+) 
			    and lv.lookup_code = aca.payment_type_flag
			    and aca.status_lookup_code = 'NEGOTIABLE'
			    and lv.meaning = 'Quick'
			    and lv.lookup_type = 'PAYMENT TYPE'    
			    and ieba.branch_id = branch.party_id(+) 
			   	
			) L
			ORDER BY PAY_NUMBER
		");
		return $query->result_array();
	}

	public function VerifyOracleChecking($checking_id,$oracle_checking){
		$sql = "
		update ap.ap_klikbca_checking set 
			oracle_checking='$oracle_checking',
			checking_date=now()
		where checking_id='$checking_id'
		";
		$query = $this->db->query($sql);
		return;
	}

}
?>