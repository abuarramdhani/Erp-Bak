<?php
class M_waktupenangananorder extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function getAllOrders($dateFrom,$dateTo){
		$oracle = $this->load->database('oracle',TRUE);
		$sql1="SELECT DISTINCT so_inv.org_id, so_inv.nomor_invoice, tgl_invoice, so_inv.no_receipt,
						        so_inv.tgl_receipt, so_inv.nomor_so, so_inv.tgl_so,
						        do_transact.nomor_mo nomor_do, do_transact.creation_date tgl_do,
						        hmm.transaction_date gudang_transact,
						         so_inv.shipping_instructions
						    FROM (SELECT ooha.org_id, ooha.order_number nomor_so, ooha.ordered_date tgl_so, oola.line_id oola_line_id,
						                 wnd.delivery_id,
						                 wdd.delivery_detail_id, rcta.trx_number nomor_invoice,
						                 rcta.creation_date tgl_invoice,wdd.move_order_line_id,
						                 app.cash_receipt_id, acra.receipt_number no_receipt,
						                 acra.creation_date tgl_receipt, ooha.shipping_instructions
						          FROM   oe_order_headers_all ooha,
						          		hr_organization_units hrou,
						                 oe_order_lines_all oola,
						                 hz_cust_accounts hca,
						                 hz_parties hp,
						                 oe_transaction_types_tl ottt,
						                 qp_list_headers_tl qlht,
						                 mtl_system_items_b msib,
						                 wsh_delivery_details wdd,
						                 wsh_new_deliveries wnd,
						                 wsh_delivery_assignments wda,
						                 ra_customer_trx_all rcta,
						                 ra_customer_trx_lines_all rctla,
						                 ar_payment_schedules_all ps,
						                 ar_receivable_applications_all app,
						                 ar_cash_receipts_all acra,
						                 (SELECT inventory_item_id, segment1, description
						                    FROM mtl_system_items_b
						                   WHERE organization_id = 81) msib2
						           WHERE ooha.header_id = oola.header_id
						             AND ooha.sold_to_org_id = hca.cust_account_id
						             AND hrou.organization_id = ooha.org_id
						             AND hca.party_id = hp.party_id
						             AND ottt.transaction_type_id = ooha.order_type_id
						             AND ooha.price_list_id = qlht.list_header_id
						             AND oola.inventory_item_id = msib.inventory_item_id
						             AND msib.organization_id = 81
						             AND wda.delivery_id = wnd.delivery_id(+)
						             AND wdd.delivery_detail_id = wda.delivery_detail_id(+)
						             AND wdd.source_line_id(+) = oola.line_id
						             AND rctla.interface_line_attribute6(+) = oola.line_id
						             AND rctla.customer_trx_id = rcta.customer_trx_id(+)
						             AND rctla.inventory_item_id = msib2.inventory_item_id(+)
						             AND hp.party_name = 'KHS CUSTOMER ECERAN E-COMMERCE'
						             AND ps.customer_trx_id = rcta.customer_trx_id
						             AND ps.org_id = rcta.org_id
						             AND ps.payment_schedule_id = app.applied_payment_schedule_id
						             AND app.cash_receipt_id = acra.cash_receipt_id
						             AND ooha.org_id = 82) so_inv,
						         (SELECT mtrh.request_number nomor_mo, wdd.move_order_line_id,
						                 wdd.creation_date, mtrl.line_number line_number_mo,
						                 msib.segment1 kode_barang_mo,
						                 msib.description nama_barang_mo,
						                 mtrl.primary_quantity qty_mo, mtrl.uom_code uom_mo,
						                 TO_CHAR (mmt.transaction_date, 'DD-MON-YYYY') transact_date,
						                 ABS (mmt.transaction_quantity) transact_qty,
						                 mmt.transaction_uom uom_transact, mmt.transaction_id
						            FROM wsh_delivery_details wdd,
						                 mtl_txn_request_headers mtrh,
						                 mtl_txn_request_lines mtrl,
						                 mtl_system_items_b msib,
						                 (SELECT transaction_id, transaction_date,
						                         transaction_quantity, transaction_uom,
						                         move_order_line_id
						                    FROM mtl_material_transactions
						                   WHERE transaction_type_id = 52 AND transaction_quantity < 0) mmt
						           WHERE wdd.move_order_line_id = mtrl.line_id
						             AND mtrl.header_id = mtrh.header_id
						             AND mtrl.inventory_item_id = msib.inventory_item_id
						             AND msib.organization_id = 81
						             AND mtrh.header_id = mtrl.header_id
						             AND mtrh.organization_id = mtrl.organization_id
						             AND mtrl.line_id = mmt.move_order_line_id(+)
						             AND wdd.org_id = 82) do_transact,
						         (select mmt.transaction_date, mmt.trx_source_line_id
						            from mtl_material_transactions mmt
						           where mmt.transaction_type_id = 52
						             and mmt.transaction_quantity > 0) hmm
						   WHERE so_inv.move_order_line_id = do_transact.move_order_line_id(+)
						     AND hmm.trx_source_line_id(+) = so_inv.oola_line_id
						     AND TRUNC(so_inv.tgl_receipt) BETWEEN TO_DATE('$dateFrom','dd/mm/yyyy') AND TO_DATE('$dateTo','dd/mm/yyyy')
						ORDER BY org_id,
						         nomor_so,
						         nomor_mo";
		$query = $oracle->query($sql1);
		return $query->result_array();
	}
}
?>