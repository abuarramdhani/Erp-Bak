<?php
class M_Permintaandana extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getData($tanggal)
	{
		if($tanggal !== null) {
			$oracle = $this->load->database("oracle", true);
			$query = $oracle->query("select
										NO_BUKTI
										,TGL
										,KTRGN
										,DEBET
										,KREDIT
										,SUBTOTAL
										,ACCOUNT
										,STATUS
										,ACTIVITY
									from(	
										select
										    aia.invoice_num no_bukti
										    ,aipa.accounting_date tgl
										    ,aida.description ktrgn
										    ,case when aida.amount > 0 then
	    										to_number('')
	    									when aida.amount < 0 and aia.INVOICE_CURRENCY_CODE != 'IDR' then
	                                            -round(aida.amount*aca.exchange_rate)
	    									else
	                                            -aida.amount
	    									end debet
	    									,case when aida.amount > 0 and aia.INVOICE_CURRENCY_CODE != 'IDR' then
	    										round(aida.amount*aca.exchange_rate)
	    									when aida.amount > 0 then
	    										aida.amount
	    									else
	    										to_number('')
	    									end kredit
	    									,case when aia.INVOICE_CURRENCY_CODE != 'IDR' then
	                                            -round(aida.amount*aca.exchange_rate)
	    									else
	                                            -aida.amount 
	    									end subtotal
										    ,aca.check_number account
										    ,'K' status
										    ,'1' activity
    									from
										    ap_checks_all aca
										    ,ap_invoice_payments_all aipa
										    ,ap_invoices_all aia
										    ,ap_invoice_distributions_all aida
										    ,gl_code_combinations gcc
    									where 
    										aca.check_id = aipa.check_id
										    and aia.INVOICE_ID = aipa.invoice_id
										    and aida.invoice_id = aia.invoice_id
										    and aida.dist_code_combination_id = gcc.code_combination_id
										    and aipa.PAYMENT_NUM = (
										    select MAX(aipa2.PAYMENT_NUM)
    										from ap_invoice_payments_all aipa2
    										where aipa2.invoice_id = aipa.invoice_id)
											    and NVL(aida.reversal_flag,'N') != 'Y'
											    and aca.STATUS_LOOKUP_CODE != 'VOIDED'
											    and aca.BANK_ACCOUNT_NAME = 'Kas Kecil'
											    and aida.amount != 0
											    and aipa.accounting_date = to_date('$tanggal','DD-MON-RR')
    											union all
    											select
    												acra.receipt_number
    												,NVL(acra.receipt_date,apsa.due_date) TGL
												    ,acra.customer_receipt_reference||'/'||acra.comments descr
												    ,decode(substr(acra.receipt_number,0,1),'M',acra.amount,to_number('')) debet
												    ,decode(substr(acra.receipt_number,0,1),'M',to_number(''),acra.amount) KREDIT
												    ,decode(substr(acra.receipt_number,0,1),'M',acra.amount,acra.amount) subtotal
												    ,to_number(gcc.segment3) account
												    ,'M' status
												    ,NVL(arta.name,'2')
    											from
    												AR_CASH_RECEIPTS_ALL ACRA
												    ,ar_payment_schedules_all apsa
												    ,ra_cust_trx_line_gl_dist_all rctlgda
												    ,gl_code_combinations gcc
												    ,ar_cash_receipt_history_all acrha
												    ,ar_receivables_trx_all arta
    											where
												    acrha.cash_receipt_id (+)= acra.cash_receipt_id
												    and apsa.cash_receipt_id (+)= acra.cash_receipt_id
												    and rctlgda.CUSTOMER_TRX_ID (+)= apsa.customer_trx_id
												    and gcc.code_combination_id (+) = rctlgda.code_combination_id
												    and (acra.receipt_number like 'M%-__' OR acra.receipt_number like 'MBS%-__')    
												    and rctlgda.account_class (+)= 'REC'
												    and acra.receipt_method_id = 1026
												    and acrha.status (+)= 'CLEARED'
												    and acra.status (+)!= 'REV'
												    and acra.status (+)!= 'NSF'
												    and acra.receivables_trx_id = arta.receivables_trx_id(+)
												    and NVL(acra.receipt_date,apsa.due_date) = to_date('$tanggal','DD-MON-RR')
    									)
										order by ACCOUNT"
			);
			return $query->result_array();
		}
	}

	public function getSaldoSuntikanTotal($saldo, $saldoSetorTotal, $aug, $receiptInAll, $setorAll, $saldoNetAll, $tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
									NVL(sum(cc.cashflow_amount),0)+$saldo-$saldoSetorTotal+$aug+$receiptInAll-$setorAll+$saldoNetAll v_saldo_suntikan_total
								from ce_cashflows cc
									,ce_payment_transactions cpt
								where
									cpt.TRXN_REFERENCE_NUMBER = cc.trxn_reference_number
									and cc.cashflow_bank_account_id = 10024
									and cc.cashflow_direction = 'RECEIPT'
									and cc.cashflow_status_code != 'CANCELED'
									and cpt.TRXN_STATUS_CODE = 'SETTLED'
									and cc.cashflow_date < to_date('$tanggal','DD-MON-RR')"
		);
		return $query->result_array();
	}

	public function getSaldo($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select  
								    (NVL(SUM(subtotal),0)+99480050) v_saldo
								    FROM    
								(   SELECT
								    aia.invoice_num no_bukti
								    ,aipa.accounting_date tgl
								    ,aida.description ktrgn
								    ,CASE WHEN aida.amount > 0 THEN
								    to_number('')
								    WHEN aida.amount < 0 AND aia.INVOICE_CURRENCY_CODE != 'IDR' THEN
								    -round(aida.amount*aca.exchange_rate)
								    ELSE
								    -aida.amount
								    END debet
								    ,CASE WHEN aida.amount > 0 AND aia.INVOICE_CURRENCY_CODE != 'IDR' THEN
								    round(aida.amount*aca.exchange_rate)
								    WHEN aida.amount > 0  THEN
								    aida.amount
								    ELSE
								    to_number('')
								    END kredit
								    ,CASE WHEN aia.INVOICE_CURRENCY_CODE != 'IDR' THEN
								    -round(aida.amount*aca.exchange_rate)
								    ELSE
								    -aida.amount 
								    END subtotal
								    ,aca.check_number account
								    ,'K' status
								    ,'1' activity
								    FROM
								    ap_checks_all aca
								    ,ap_invoice_payments_all aipa
								    ,ap_invoices_all aia
								    ,ap_invoice_distributions_all aida
								    ,gl_code_combinations gcc
								    WHERE aca.check_id = aipa.check_id
								    AND aia.INVOICE_ID = aipa.invoice_id
								    AND aida.invoice_id = aia.invoice_id
								    AND aida.dist_code_combination_id = gcc.code_combination_id
								    AND aipa.PAYMENT_NUM = 
								    (select MAX(aipa2.PAYMENT_NUM)
								    from ap_invoice_payments_all aipa2
								    where aipa2.invoice_id = aipa.invoice_id)
								    AND NVL(aida.reversal_flag,'N') != 'Y'
								    AND aca.STATUS_LOOKUP_CODE != 'VOIDED'
								    and aca.BANK_ACCOUNT_NAME = 'Kas Kecil'
								    AND aida.amount != 0
								    AND aipa.accounting_date < to_date('$tanggal','DD-MON-RR')
								    UNION ALL
								    SELECT
								    acra.receipt_number
								    ,NVL(acra.receipt_date,apsa.due_date) TGL
								    ,acra.customer_receipt_reference||'/'||acra.comments descr
								    --,acra.amount
								    ,decode(substr(acra.receipt_number,0,1),'M',acra.amount,to_number('')) debet
								    ,decode(substr(acra.receipt_number,0,1),'M',to_number(''),acra.amount) KREDIT
								    ,decode(substr(acra.receipt_number,0,1),'M',acra.amount,acra.amount) subtotal
								    ,to_number(gcc.segment3) account
								    ,'M' status
								    ,NVL(arta.name,'2')
								    FROM 
								    AR_CASH_RECEIPTS_ALL ACRA
								    ,ar_payment_schedules_all apsa
								    ,ra_cust_trx_line_gl_dist_all rctlgda
								    ,gl_code_combinations gcc
								    ,ar_cash_receipt_history_all acrha
								    ,ar_receivables_trx_all arta
								    WHERE
								    acrha.cash_receipt_id (+)= acra.cash_receipt_id
								    AND apsa.cash_receipt_id (+)= acra.cash_receipt_id
								    AND rctlgda.CUSTOMER_TRX_ID (+)= apsa.customer_trx_id
								    AND gcc.code_combination_id (+) = rctlgda.code_combination_id
								    AND (acra.receipt_number like 'M%-__' OR acra.receipt_number like 'MBS%-__')    
								    AND rctlgda.account_class (+)= 'REC'
								    AND acra.receipt_method_id = 1026
								    AND acrha.status (+)= 'CLEARED'
								    AND acra.status (+)!= 'REV'
								    and acra.status (+)!= 'NSF'
								    AND acra.receivables_trx_id = arta.receivables_trx_id(+)
								    AND NVL(acra.receipt_date,apsa.due_date) < to_date('$tanggal','DD-MON-RR')
								    )"
		);
		return $query->result_array();
	}
	
	public function getSaldoSetorTotal($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
									NVL(sum(cc.cashflow_amount),0) v_saldo_setor_total
									from ce_cashflows cc
									where
									        cc.cashflow_bank_account_id = 10024
									        AND cc.cashflow_direction = 'PAYMENT'
									        AND cc.cashflow_status_code != 'CANCELED'
									        AND CC.CLEARED_AMOUNT IS NOT NULL
									AND (cc.cashflow_date+1) <= to_date('$tanggal','DD-MON-RR')"
		);
		return $query->result_array();
	}

	public function getAug($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
									sum(case when gjh.name like '%TARIKAN%' then
											gjh.running_total_dr
										else
											0
										end) amount
  								from 
  									gl_je_lines gjl
  									,gl_je_headers gjh
  								where 
  									gjl.effective_date < to_date('$tanggal','DD-MON-RR')
  									AND gjh.JE_HEADER_ID (+)= gjl.JE_HEADER_ID
									and gjh.name like '%KAS KECIL%'
									and gjh.status = 'P'
									and gjl.je_line_num = 1
  									AND gjl.description is not null"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getReceiptInAll($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select NVL(SUM(acra.amount),0) v_receipt_in_all
								from ar_cash_receipts_all acra
								where acra.receipt_number like '%BON%'
									AND acra.receipt_date+1 <= to_date('$tanggal','DD-MON-RR')"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getSetorAll($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select 
									sum(case when gjh.name like '%SETORAN%' then
											gjh.running_total_dr
										else
											0
										end) amount
									from 
									 	gl_je_lines gjl
									  	,gl_je_headers gjh
									where 
									  	gjl.effective_date < to_date('$tanggal','DD-MON-RR')
									  	AND gjh.JE_HEADER_ID (+)= gjl.JE_HEADER_ID
										and gjh.name like '%KAS KECIL%'
										and gjh.status = 'P'
										and gjl.je_line_num = 1
									  	AND gjl.description is not null"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getSaldoNetAll($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
	  								sum(aipa.amount) v_saldo_net_all
    							FROM
								    ap_checks_all aca
								    ,ap_invoice_payments_all aipa
								    ,ap_invoices_all aia
    							WHERE 
    								aca.check_id = aipa.check_id
								    AND aia.INVOICE_ID = aipa.invoice_id
								    AND aca.STATUS_LOOKUP_CODE != 'VOIDED'
								    and aca.BANK_ACCOUNT_NAME = 'Netting Account'
								    AND EXISTS (select aca1.BANK_ACCOUNT_NAME 
                  					from ap_checks_all aca1
                        				,ap_invoice_payments_all aipa1
                 					where aca1.check_id = aipa1.check_id
                   						AND aia.INVOICE_ID = aipa1.invoice_id
                   						and aca1.BANK_ACCOUNT_NAME = 'Kas Kecil'
                   						AND aipa1.accounting_date < to_date('$tanggal','DD-MON-RR')
    								)"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getSaldoSetor($tanggal, $setor)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
							        SUM(NVL(cc.cashflow_amount, 0)) v_saldo_setor1
							    from 
							    	ce_cashflows cc
							    where
							        cc.cashflow_bank_account_id = 10024
							        AND cc.cashflow_direction = 'PAYMENT'
							        AND cc.cashflow_status_code != 'CANCELED'
							        AND CC.CLEARED_AMOUNT IS NOT NULL
							        AND cc.cashflow_date = to_date('$tanggal','DD-MON-RR')"
		);
		if(empty($query->result())){
		    return 0+$setor;
		} else {
		    return $query->result_array();
		}
	}

	public function getSetor($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
									case when gjh.name like '%SETORAN%' then
										gjh.running_total_dr
									else
										0
									end amount
  								from 
  									gl_je_lines gjl
  									,gl_je_headers gjh
  								where 
  									gjl.effective_date = to_date('$tanggal','DD-MON-RR')
  									AND gjh.JE_HEADER_ID (+)= gjl.JE_HEADER_ID
									and gjh.name like '%KAS KECIL%'
									and gjh.status = 'P'
									AND GJH.JE_CATEGORY != 'Adjustment'
									AND gjh.JE_SOURCE != 'Manual'
									and gjl.je_line_num = 1
  									AND gjl.description is not null"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getSaldoSuntikan($tanggal, $aug, $receiptIn)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select 
									SUM(cc.cashflow_amount) v_saldo_suntikan
								from ce_cashflows cc
									,ce_payment_transactions cpt
								where
									cpt.TRXN_REFERENCE_NUMBER = cc.trxn_reference_number
									AND cc.cashflow_bank_account_id = 10024
									AND cc.cashflow_direction = 'RECEIPT'
									AND cc.cashflow_status_code != 'CANCELED'
									AND cpt.TRXN_STATUS_CODE = 'SETTLED'
									AND cc.cashflow_date = to_date('$tanggal','DD-MON-RR')"
		);
		if(empty($query->result())){
		    return 0+$aug+$receiptIn;
		} else {
		    return $query->result_array();
		}
	}

	public function getSAug($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
									case when gjh.name like '%TARIKAN%' then
										gjh.running_total_dr
									else
										0
									end amount
  								from 
  									gl_je_lines gjl
  									,gl_je_headers gjh
  								where 
  									gjl.effective_date = to_date('$tanggal','DD-MON-RR')
  									AND gjh.JE_HEADER_ID (+)= gjl.JE_HEADER_ID
									and gjh.name like '%KAS KECIL%'
									and gjh.status = 'P'
									AND GJH.JE_CATEGORY != 'Adjustment'
									AND gjh.JE_SOURCE != 'Manual'
									and gjl.je_line_num = 1
  									AND gjl.description is not null"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getReceiptIn($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select NVL(acra.amount,0) v_receipt_in
									from ar_cash_receipts_all acra
									where acra.receipt_number like '%BON%'
									AND acra.receipt_date = to_date('$tanggal','DD-MON-RR')"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function getSaldoNet($tanggal)
	{
		$oracle = $this->load->database("oracle", true);
		$query = $oracle->query("select
							      aipa.amount v_saldo_net
							    FROM
							    ap_checks_all aca
							    ,ap_invoice_payments_all aipa
							    ,ap_invoices_all aia
							    WHERE aca.check_id = aipa.check_id
							    AND aia.INVOICE_ID = aipa.invoice_id
							    AND aca.STATUS_LOOKUP_CODE != 'VOIDED'
							    and aca.BANK_ACCOUNT_NAME = 'Netting Account'
							    AND EXISTS (select aca1.BANK_ACCOUNT_NAME 
							                  from ap_checks_all aca1
							                        ,ap_invoice_payments_all aipa1
							                 where aca1.check_id = aipa1.check_id
							                   AND aia.INVOICE_ID = aipa1.invoice_id
							                   and aca1.BANK_ACCOUNT_NAME = 'Kas Kecil'
							                   AND aipa1.accounting_date = to_date('$tanggal','DD-MON-RR')
							    )"
		);
		if(empty($query->result())){
		    return 0;
		} else {
		    return $query->result_array();
		}
	}

	public function setDemand($data)
	{
		$oracle = $this->load->database("oracle", true);
		$creation_date = $data['CREATION_DATE'];
		$need_by_date = $data['NEED_BY_DATE'];
		unset($data['CREATION_DATE']);
		unset($data['NEED_BY_DATE']);
		$oracle->set('CREATION_DATE',"to_date('$creation_date','dd-Mon-yyyy HH24:MI:SS')",false);
		$oracle->set('NEED_BY_DATE',"to_date('$need_by_date','dd-Mon-yyyy HH24:MI:SS')",false);
		$oracle->insert('KHS_DEMAND_FOR_FUND_HEADERS', $data);
	}

	public function setDemandLines($data)
	{
		$oracle = $this->load->database("oracle", true);
		$creation_date = $data['CREATION_DATE'];
		unset($data['CREATION_DATE']);
		$oracle->set('CREATION_DATE',"to_date('$creation_date','dd-Mon-yyyy HH24:MI:SS')",false);
		$oracle->insert('KHS_DEMAND_FOR_FUND_LINES', $data);
	}

	public function getLastInserted($table, $id) {
		$oracle = $this->load->database("oracle", true);
		$oracle->select_max($id);
		$Q = $oracle->get($table);
		$row = $Q->row_array();
		return $row[$id];
 	}

}