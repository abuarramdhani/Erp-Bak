<?php
class M_klikbcachecking_check extends CI_Model {

	public function __construct(){
		parent::__construct();
	}
	
	public function ShowBCA($start,$end){
		$sql = "
			select
				checking_id,
				no_referensi,
				no_rek_pengirim,
				nama_pengirim,
				no_rek_penerima,
				nama_penerima,
				substr(nama_penerima, 1, 5) inisial_penerima,
				berita,
				jenis_transfer,
				oracle_checking,
				to_char(jumlah, 'FM999,999,999,990D00') as jumlah,
				case when oracle_checking is NULL then '-' else oracle_checking end as checking_status,
				case when upload_date
					is NULL then null 	
					else to_char(upload_date,'DD MON YY')
					end as tanggal,
				case when checking_date
					is NULL then null 	
					else to_char(checking_date,'DD MON YY')
					end as tanggal_cek
				,pay_num_oracle
				,substr(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(no_rek_penerima_oracle, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 1, 3)||'-'||substr(REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(no_rek_penerima_oracle, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 4) rek_tujuan
				,substr(nama_penerima_oracle, 1, 5) inisial_tujuan
				,nama_penerima_oracle
				,to_char(jumlah_oracle, 'FM999,999,999,990D00') as jumlah_oracle
			from ap.ap_klikbca_checking 
			where upload_date between TO_DATE('$start', 'DD/MM/YYYY') and (TO_DATE('$end', 'DD/MM/YYYY')+1)
			order by no_referensi";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function GetOracleInPostgre($checking_id){
		$sql = "
			select
				checking_id
				,berita
				,pay_num_oracle
				,no_rek_penerima
				,substr(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(no_rek_penerima_oracle, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 1, 3)||'-'||substr(REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(no_rek_penerima_oracle, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 4) rek_tujuan
				,substr(nama_penerima, 1, 5) inisial_penerima
				,substr(nama_penerima_oracle, 1, 5) inisial_tujuan
				,to_char(jumlah, 'FM999,999,999,990D00') as jumlah
				,to_char(jumlah_oracle, 'FM999,999,999,990D00') as jumlah_oracle
			from ap.ap_klikbca_checking
			where checking_id='$checking_id'";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function MatchWithOracle($berita,$no_rek_penerima,$jumlah){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT *
			FROM (
				SELECT 
					PAY_NUMBER
					,PAY_DATE
					,VENDOR
					,DARI_BANK 
					,BANK_TUJUAN
					,SUBSTR(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(REK_TUJUAN, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 1, 3)||'-'||SUBSTR(REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(
										REPLACE(REK_TUJUAN, ' ', '')
										,'-',''
									)
									,'.',''
								)
								,',',''
							)
							,'(IDR)',''
						)
						, 4) REK_TUJUAN
					,ACCT_TUJUAN
					,SUBSTR(ACCT_TUJUAN, 1, 5) INISIAL_TUJUAN
					,CREATION_DATE
					,SITE
					,NOREK
					,TO_CHAR(AMOUNT,'999,999,999,999.99') AMOUNT
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
				select 
				    nvl(aia.attribute15,aba.batch_name) voucher
				    ,aca.check_date pay_date
				    ,to_date(aca.creation_date,'DD/MM/RRRR') creation_date
				    ,case when aca.vendor_name in ('KHS Komisi','KHS INSIDENTIL','KHS Employee','KHS Jakarta Eceran')
				        then
				            (select 
				                    aca2.vendor_name ||'-'|| aca2.VENDOR_SITE_CODE
				                from ap_checks_all aca2
				                where
				                    aca.vendor_id = aca2.vendor_id
				                    and aca2.check_number = aca.check_number
				                    and rownum = 1
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
				    and aca.status_lookup_code <> 'VOID'
				    and lv.meaning = 'Quick'
				    and lv.lookup_type = 'PAYMENT TYPE'    
				    and ieba.branch_id = branch.party_id(+) 
				union all --cm only    
				select distinct
				    cpt.bank_trxn_number voucher
				    ,ipa.payment_date pay_date
				    ,to_date(ipa.creation_date,'DD/MM/RRRR') creation_date
				    ,cba2.bank_account_name vendor
				    ,'' site
				    ,cba.bank_account_name dari_bank
				    ,cba.bank_account_num norek
				    ,ipa.payment_amount amount
				    ,max(ipa.bank_charge_amount) over (partition by cba.bank_account_name, ipa.payment_date) charge
				    ,case when
				        max(ipa.payment_currency_code) over (partition by cba2.bank_account_name) = min(ipa.payment_currency_code) over (partition by cba2.bank_account_name)
				        then sum(ipa.payment_amount) over (partition by cba2.bank_account_name,ieba.bank_account_num_electronic)
				     end enuma
				    ,ipa.payment_currency_code curr
				    ,bp.party_name bank_tujuan
				    ,ieba.bank_account_num_electronic rek_tujuan
				    ,branch.party_name branch_tujuan
				    ,ieba.bank_account_name acct_tujuan
				    ,to_char(ipa.paper_document_number) pay_number
				    ,1 rate
				    ,ipa.payment_amount * 1 total
				    ,to_number('') org_id
				    ,0 invoice_id
				    ,0 check_id
				from        
				    ce_cashflows cc_pay
				    ,ce_payment_transactions cpt
				    ,ce_bank_accounts cba
				    ,ce_bank_accounts cba2
				    ,iby_pay_service_requests ipsr
				    ,iby_payments_all ipa
				    ,iby_ext_bank_accounts ieba
				    ,hz_parties bp
				    ,hz_parties branch
				where
				    cc_pay.trxn_reference_number = cpt.trxn_reference_number(+)
				    and cc_pay.cashflow_bank_account_id = cba.bank_account_id
				    and cc_pay.cashflow_legal_entity_id = cba.account_owner_org_id
				    and cc_pay.counterparty_bank_account_id = cba2.bank_account_id(+)
				    and instr (cc_pay.cashflow_status_code, 'CANCELED', 1, 1) = 0
				    and cc_pay.cashflow_direction = 'PAYMENT'
				    and ipa.payment_status != 'VOID'
				    and ieba.bank_id = bp.party_id(+)
				    and ieba.branch_id = branch.party_id(+)
				    and ipa.external_bank_account_id = ieba.ext_bank_account_id(+)
				    and ipsr.call_app_pay_service_req_code = to_char(cpt.payment_request_number) 
				    and ipa.payment_service_request_id = ipsr.payment_service_request_id   				
				) L
				ORDER BY PAY_NUMBER
			)
			WHERE
				PAY_NUMBER = '$berita'
				AND REK_TUJUAN = '$no_rek_penerima'
				AND AMOUNT LIKE '%$jumlah'
				
		");
		return $query->result_array();
	}

	public function GetOcracleMatch($berita){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT *
			FROM (
				SELECT
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
				select 
				    nvl(aia.attribute15,aba.batch_name) voucher
				    ,aca.check_date pay_date
				    ,to_date(aca.creation_date,'DD/MM/RRRR') creation_date
				    ,case when aca.vendor_name in ('KHS Komisi','KHS INSIDENTIL','KHS Employee','KHS Jakarta Eceran')
				        then
				            (select 
				                    aca2.vendor_name ||'-'|| aca2.VENDOR_SITE_CODE
				                from ap_checks_all aca2
				                where
				                    aca.vendor_id = aca2.vendor_id
				                    and aca2.check_number = aca.check_number
				                    and rownum = 1
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
				    and aca.status_lookup_code <> 'VOID'
				    and lv.meaning = 'Quick'
				    and lv.lookup_type = 'PAYMENT TYPE'    
				    and ieba.branch_id = branch.party_id(+) 
				union all --cm only    
				select distinct
				    cpt.bank_trxn_number voucher
				    ,ipa.payment_date pay_date
				    ,to_date(ipa.creation_date,'DD/MM/RRRR') creation_date
				    ,cba2.bank_account_name vendor
				    ,'' site
				    ,cba.bank_account_name dari_bank
				    ,cba.bank_account_num norek
				    ,ipa.payment_amount amount
				    ,max(ipa.bank_charge_amount) over (partition by cba.bank_account_name, ipa.payment_date) charge
				    ,case when
				        max(ipa.payment_currency_code) over (partition by cba2.bank_account_name) = min(ipa.payment_currency_code) over (partition by cba2.bank_account_name)
				        then sum(ipa.payment_amount) over (partition by cba2.bank_account_name,ieba.bank_account_num_electronic)
				     end enuma
				    ,ipa.payment_currency_code curr
				    ,bp.party_name bank_tujuan
				    ,ieba.bank_account_num_electronic rek_tujuan
				    ,branch.party_name branch_tujuan
				    ,ieba.bank_account_name acct_tujuan
				    ,to_char(ipa.paper_document_number) pay_number
				    ,1 rate
				    ,ipa.payment_amount * 1 total
				    ,to_number('') org_id
				    ,0 invoice_id
				    ,0 check_id
				from        
				    ce_cashflows cc_pay
				    ,ce_payment_transactions cpt
				    ,ce_bank_accounts cba
				    ,ce_bank_accounts cba2
				    ,iby_pay_service_requests ipsr
				    ,iby_payments_all ipa
				    ,iby_ext_bank_accounts ieba
				    ,hz_parties bp
				    ,hz_parties branch
				where
				    cc_pay.trxn_reference_number = cpt.trxn_reference_number(+)
				    and cc_pay.cashflow_bank_account_id = cba.bank_account_id
				    and cc_pay.cashflow_legal_entity_id = cba.account_owner_org_id
				    and cc_pay.counterparty_bank_account_id = cba2.bank_account_id(+)
				    and instr (cc_pay.cashflow_status_code, 'CANCELED', 1, 1) = 0
				    and cc_pay.cashflow_direction = 'PAYMENT'
				    and ipa.payment_status != 'VOID'
				    and ieba.bank_id = bp.party_id(+)
				    and ieba.branch_id = branch.party_id(+)
				    and ipa.external_bank_account_id = ieba.ext_bank_account_id(+)
				    and ipsr.call_app_pay_service_req_code = to_char(cpt.payment_request_number) 
				    and ipa.payment_service_request_id = ipsr.payment_service_request_id   	
				) L
				ORDER BY PAY_NUMBER
			)
			WHERE
				PAY_NUMBER = '$berita'
				AND rownum = 1

		");
		return $query->result_array();
	}

	public function GetOracle(){
		$oracle = $this->load->database("oracle",true);
		$query = $oracle->query("
			SELECT 
				PAY_NUMBER
				,PAY_DATE
				,VENDOR
				,DARI_BANK 
				,BANK_TUJUAN
				,SUBSTR(
					REPLACE(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(REK_TUJUAN, ' ', '')
									,'-',''
								)
								,'.',''
							)
							,',',''
						)
						,'(IDR)',''
					)
					, 1, 3)||'-'||SUBSTR(REPLACE(
						REPLACE(
							REPLACE(
								REPLACE(
									REPLACE(REK_TUJUAN, ' ', '')
									,'-',''
								)
								,'.',''
							)
							,',',''
						)
						,'(IDR)',''
					)
					, 4) REK_TUJUAN
				,ACCT_TUJUAN
				,SUBSTR(ACCT_TUJUAN, 1, 5) INISIAL_TUJUAN
				,CREATION_DATE
				,SITE
				,NOREK
				,TO_CHAR(AMOUNT,'999,999,999,999.99') AMOUNT
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
			select 
			    nvl(aia.attribute15,aba.batch_name) voucher
			    ,aca.check_date pay_date
			    ,to_date(aca.creation_date,'DD/MM/RRRR') creation_date
			    ,case when aca.vendor_name in ('KHS Komisi','KHS INSIDENTIL','KHS Employee','KHS Jakarta Eceran')
			        then
			            (select 
			                    aca2.vendor_name ||'-'|| aca2.VENDOR_SITE_CODE
			                from ap_checks_all aca2
			                where
			                    aca.vendor_id = aca2.vendor_id
			                    and aca2.check_number = aca.check_number
			                    AND rownum = 1
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
			    and aca.status_lookup_code <> 'VOID'
			    and lv.meaning = 'Quick'
			    and lv.lookup_type = 'PAYMENT TYPE'    
			    and ieba.branch_id = branch.party_id(+) 
		   	union all --cm only    
			select distinct
			    cpt.bank_trxn_number voucher
			    ,ipa.payment_date pay_date
			    ,to_date(ipa.creation_date,'DD/MM/RRRR') creation_date
			    ,cba2.bank_account_name vendor
			    ,'' site
			    ,cba.bank_account_name dari_bank
			    ,cba.bank_account_num norek
			    ,ipa.payment_amount amount
			    ,max(ipa.bank_charge_amount) over (partition by cba.bank_account_name, ipa.payment_date) charge
			    ,case when
			        max(ipa.payment_currency_code) over (partition by cba2.bank_account_name) = min(ipa.payment_currency_code) over (partition by cba2.bank_account_name)
			        then sum(ipa.payment_amount) over (partition by cba2.bank_account_name,ieba.bank_account_num_electronic)
			     end enuma
			    ,ipa.payment_currency_code curr
			    ,bp.party_name bank_tujuan
			    ,ieba.bank_account_num_electronic rek_tujuan
			    ,branch.party_name branch_tujuan
			    ,ieba.bank_account_name acct_tujuan
			    ,to_char(ipa.paper_document_number) pay_number
			    ,1 rate
			    ,ipa.payment_amount * 1 total
			    ,to_number('') org_id
			    ,0 invoice_id
			    ,0 check_id
			from        
			    ce_cashflows cc_pay
			    ,ce_payment_transactions cpt
			    ,ce_bank_accounts cba
			    ,ce_bank_accounts cba2
			    ,iby_pay_service_requests ipsr
			    ,iby_payments_all ipa
			    ,iby_ext_bank_accounts ieba
			    ,hz_parties bp
			    ,hz_parties branch
			where
			    cc_pay.trxn_reference_number = cpt.trxn_reference_number(+)
			    and cc_pay.cashflow_bank_account_id = cba.bank_account_id
			    and cc_pay.cashflow_legal_entity_id = cba.account_owner_org_id
			    and cc_pay.counterparty_bank_account_id = cba2.bank_account_id(+)
			    and instr (cc_pay.cashflow_status_code, 'CANCELED', 1, 1) = 0
			    and cc_pay.cashflow_direction = 'PAYMENT'
			    and ipa.payment_status != 'VOID'
			    and ieba.bank_id = bp.party_id(+)
			    and ieba.branch_id = branch.party_id(+)
			    and ipa.external_bank_account_id = ieba.ext_bank_account_id(+)
			    and ipsr.call_app_pay_service_req_code = to_char(cpt.payment_request_number) 
			    and ipa.payment_service_request_id = ipsr.payment_service_request_id   	
			) L
			ORDER BY PAY_NUMBER
		");
		return $query->result_array();
	}

	public function InsertOracleToPostgre($checking_id,$oracle_berita,$oracle_no_rek_penerima,$oracle_nama_penerima,$oracle_jumlah){
		$sql = "
		update ap.ap_klikbca_checking set 
			pay_num_oracle='$oracle_berita',
			no_rek_penerima_oracle='$oracle_no_rek_penerima',
			nama_penerima_oracle='$oracle_nama_penerima',
			jumlah_oracle='$oracle_jumlah'
		where checking_id='$checking_id'
		";
		$query = $this->db->query($sql);
		return;
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