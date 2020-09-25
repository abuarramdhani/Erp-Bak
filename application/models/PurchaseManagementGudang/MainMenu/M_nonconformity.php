<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_nonconformity extends CI_Model
{
    // var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $oracle = $this->load->database( 'oracle', TRUE );
    }

    public function getHeaders($id = FALSE)
    {
    	if ($id === FALSE) {
            $query = $this->db->query("SELECT * FROM pm.pm_po_oracle_non_conformity_headers WHERE assign is null ORDER BY non_conformity_num");
        } else {
            $query = $this->db->get_where('pm.pm_po_oracle_non_conformity_headers', array('header_id' => $id));
    	}

        return $query->result_array();
    }

    public function getPendingAssign($noinduk)
    {
        $query = $this->db->query("SELECT * FROM pm.pm_po_oracle_non_conformity_headers WHERE assign is null AND created_by = '$noinduk' ORDER BY non_conformity_num");

        return $query->result_array();
    }

    public function getHeaders2($assign)
    {
        $query = $this->db->query("SELECT * FROM pm.pm_po_oracle_non_conformity_headers WHERE assign ='$assign' 
        AND forward_buyer <> 1
        ORDER BY non_conformity_num");

        return $query->result_array();
    }

    public function getHeaders3($buyer)
    {
        $query = $this->db->query("SELECT * FROM pm.pm_po_oracle_non_conformity_headers WHERE forward_buyer = 1
        AND forward_to = '$buyer'
        AND assign <> '4'
        ORDER BY non_conformity_num");

        return $query->result_array();
    }

    public function getHeaders4($assign)
    {
        $query = $this->db->query("SELECT DISTINCT head.* FROM pm.pm_po_oracle_non_conformity_headers head, pm.pm_po_oracle_non_conformity_lines line  WHERE assign ='$assign'
        AND head.header_id = line.header_id
        AND line.status != '1'
        ORDER BY non_conformity_num");

        return $query->result_array();
    }

    public function getHeaders4PendingExecute($assign, $cond)
    {
        $query = $this->db->query("SELECT DISTINCT head.*, line.problem_completion
        FROM pm.pm_po_oracle_non_conformity_headers head
        , pm.pm_po_oracle_non_conformity_lines line  WHERE assign ='$assign'
        AND head.header_id = line.header_id
        $cond
        AND line.status != '1'
        ORDER BY non_conformity_num");

        return $query->result_array();
    }

    public function getPhone($id){
        $oracle = $this->load->database( 'oracle', TRUE );
        $query = $oracle->query(" SELECT DISTINCT poh.segment1 po_number, v.vendor_name,
                                        (SELECT MAX (kds.phone_number)
                                            FROM khs_data_supplier kds
                                          WHERE kds.vendor_id = v.vendor_id) telp,
                                        (SELECT MAX (kds.fax_number)
                                            FROM khs_data_supplier kds
                                            WHERE kds.vendor_id = v.vendor_id) fax
                                    FROM po_headers_all poh, po_vendors v
                                    WHERE poh.vendor_id = v.vendor_id
                                        AND poh.segment1 = '$id'
                                    ORDER BY poh.segment1");
    	return $query->result_array();
    }

	public function getLines($id,$limit = FALSE)
	{
        if ($limit == TRUE) {
            $query = $this->db->query("SELECT lin.*, cas.* 
                        FROM pm.pm_po_oracle_non_conformity_case as cas, pm.pm_po_oracle_non_conformity_lines as lin
                        WHERE lin.line_id = '$id' AND lin.case_id = to_char(cas.case_id, 'FM9999999')");
        }else{
            $query = $this->db->query("SELECT cas.* , lin.* FROM pm.pm_po_oracle_non_conformity_case as cas, pm.pm_po_oracle_non_conformity_lines as lin, pm.pm_po_oracle_non_conformity_headers as head WHERE lin.case_id = to_char(cas.case_id, 'FM9999999') AND head.header_id = lin.header_id AND lin.header_id = '$id'");
        }
		return $query->result_array();
	}

    public function getLineItems($id)
    {
        $query = $this->db->query("SELECT * from pm.pm_po_oracle_non_conformity_line_items where header_id='$id'");
        return $query->result_array();
    }

    public function updateJudgement($line_id,$judgement)
    {
        $this->db->where('line_id', $line_id);
        $this->db->update('pm.pm_po_oracle_non_conformity_lines', $judgement);

        $this->db->select('judgement_description, judgement, status');
        $this->db->from('pm.pm_po_oracle_non_conformity_lines');
        $this->db->where('line_id', $line_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function checkLineStatus($header_id)
    {
        $this->db->select('status');
        $this->db->from('pm.pm_po_oracle_non_conformity_lines');
        $this->db->where('header_id', $header_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function updateHeadStatus($header_id,$headStat)
    {
        $this->db->where('header_id', $header_id);
        $this->db->update('pm.pm_po_oracle_non_conformity_headers', $headStat);
    }

    public function updateRemark($line_id,$data)
    {
        $this->db->where('line_id', $line_id);
        $this->db->update('pm.pm_po_oracle_non_conformity_lines', $data);

        $this->db->select('remark');
        $this->db->from('pm.pm_po_oracle_non_conformity_lines');
        $this->db->where('line_id', $line_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCase()
    {
        $erp = $this->db;
        $query = $erp->query('select * from pm.pm_po_oracle_non_conformity_case');
        return $query->result_array();
    }

    public function saveSource($source)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_non_conformity_source', $source);
		$query1 = $erp->query("select lastval();");
		return $query1->result_array();
    }

    public function saveImage($upload)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_non_conformity_image_detail', $upload);
    }

    public function saveCase($case)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_non_conformity_case_detail', $case);
    }

     public function saveLine($lines)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_po_oracle_non_conformity_lines ', $lines);
    }

    public function checkNonConformityNum()
    {
       $erp = $this->db;
       $query = $erp->query("select header_id, non_conformity_num from pm.pm_po_oracle_non_conformity_headers 
            where non_conformity_num like 'NC-PUR-".date('y')."-".date('m')."-%' order by non_conformity_num DESC limit 1");
        
        return $query->result_array();
    }

    public function checkNonConformitySubkonNum()
    {
       $erp = $this->db;
       $query = $erp->query("select header_id, non_conformity_num from pm.pm_po_oracle_non_conformity_headers 
            where non_conformity_num like 'NC-PURSUB-".date('y')."-".date('m')."-%' order by non_conformity_num DESC limit 1");
        
        return $query->result_array();
    }

    public function checkNonConformitySupplierNum()
    {
       $erp = $this->db;
       $query = $erp->query("select header_id, non_conformity_num from pm.pm_po_oracle_non_conformity_headers 
            where non_conformity_num like 'NC-PURSUP-".date('y')."-".date('m')."-%' order by non_conformity_num DESC limit 1");
        
        return $query->result_array();
    }

    public function checkNonConformityReturnNum()
    {
       $erp = $this->db;
       $query = $erp->query("select header_id, non_conformity_num from pm.pm_po_oracle_non_conformity_headers 
            where non_conformity_num like 'NC-RETURN-".date('y')."-".date('m')."-%' order by non_conformity_num DESC limit 1");
        
        return $query->result_array();
    }

    public function simpanHeader($header)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_po_oracle_non_conformity_headers', $header);
		$query1 = $erp->query("select lastval();");
		return $query1->result_array();
    }

    public function getImages($sourceId)
    {
       $erp = $this->db;
       $query = $erp->query("select * from pm.pm_non_conformity_image_detail where source_id = '$sourceId'");
        
        return $query->result_array();
    }

    public function getItem($string)
	{
        $oracle = $this->load->database( 'oracle', TRUE );
    	$query = $oracle->query("SELECT distinct B.DESCRIPTION, B.SEGMENT1 ITEM_KODE from MTL_SYSTEM_ITEMS_B B where B.INVENTORY_ITEM_STATUS_CODE = 'Active' AND (B.SEGMENT1 like '%$string%' or b.DESCRIPTION like '%$string%') AND (B.PURCHASING_ITEM_FLAG = 'Y') order by ITEM_KODE ASC"); 
      	return $query->result_array();
    }
    
    public function updateHeader($headerId, $header)
    {
       $this->db->where('header_id', $headerId);
       $this->db->update('pm.pm_po_oracle_non_conformity_headers', $header);
    }
    
    public function updateLines($headerId, $lines)
    {
       $this->db->where('header_id', $headerId);
       $this->db->update('pm.pm_po_oracle_non_conformity_lines', $lines);
    }

    public function setItem($item)
    {
        $erp = $this->db;
        $query = $erp->insert('pm.pm_po_oracle_non_conformity_line_items ', $item);
    }

    public function getLinesItem($header_id)
    {
       $query = $this->db->query("SELECT * from pm.pm_po_oracle_non_conformity_line_items where header_id ='$header_id'"); 
       return $query->result_array();
    }

    public function deleteItem($header_id)
    {
        $this->db->where('header_id', $header_id);
        $this->db->delete('pm.pm_po_oracle_non_conformity_line_items');
    }

    // public function getDetailPO($noPO)
    // {
    //     $oracle = $this->load->database( 'oracle', TRUE );
    //     $query = $oracle->query("select 
    //                                     poh.SEGMENT1
    //                                     ,poh.AGENT_ID
    //                                     ,poh.CLOSED_CODE
    //                                     ,perf.NATIONAL_IDENTIFIER
    //                                     ,perf.person_id
    //                                     ,perf.full_name
    //                                     ,asp.VENDOR_NAME
    //                                     ,assa.PHONE
    //                                     ,assa.ADDRESS_LINE1
    //                                     ,assa.CITY
    //                                     ,assa.COUNTRY
    //                                     from
    //                                     po_headers_all poh
    //                                     ,ap_suppliers asp
    //                                     ,AP_SUPPLIER_SITES_ALL assa
    //                                     ,per_all_people_f perf
    //                                     where
    //                                     poh.VENDOR_ID = asp.VENDOR_ID
    //                                     AND perf.person_id = poh.agent_id
    //                                     and poh.VENDOR_ID = assa.VENDOR_ID
    //                                 and poh.SEGMENT1 ='$noPO'"); 
    //   	return $query->result_array();
    // }
    public function getDetailPO($noPO)
    {
        $oracle = $this->load->database('oracle', TRUE);
        $query = $oracle->query("SELECT
        poh.SEGMENT1 NOMOR_PO ,
        kds.VENDOR_NAME ,
        poh.CLOSED_CODE ,
        perf.NATIONAL_IDENTIFIER ,
        perf.person_id ,
        perf.full_name ,
        (CASE
            WHEN kds.vendor_name = 'HONDA POWER PRODUCTS INDONESIA, PT' THEN (
            SELECT
                Contact_name
            FROM
                KHS_SUP_CONTACT
            WHERE
                org_name = kds.VENDOR_NAME
                AND contact_party_id = (
                SELECT
                    MAX(contact_party_id)
                FROM
                    KHS_SUP_CONTACT ksc,
                    hz_parties hp,
                    hz_party_usg_assignments hpua
                WHERE
                    ksc.CONTACT_PARTY_ID = hp.PARTY_ID
                    AND hp.PARTY_ID = hpua.PARTY_ID
                    AND hpua.EFFECTIVE_END_DATE > SYSDATE
                    AND hpua.PARTY_USAGE_CODE = 'SUPPLIER_CONTACT'
                    AND org_name = kds.VENDOR_NAME))
            ELSE (
            SELECT
                Contact_name
            FROM
                KHS_SUP_CONTACT
            WHERE
                org_name = kds.VENDOR_NAME
                AND contact_party_id = (
                SELECT
                    MIN(contact_party_id)
                FROM
                    KHS_SUP_CONTACT ksc,
                    hz_parties hp,
                    hz_party_usg_assignments hpua
                WHERE
                    ksc.CONTACT_PARTY_ID = hp.PARTY_ID
                    AND hp.PARTY_ID = hpua.PARTY_ID
                    AND hpua.EFFECTIVE_END_DATE > SYSDATE
                    AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT'
                    AND org_name = kds.VENDOR_NAME))
        END || DECODE((SELECT COUNT(*) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name = kds.VENDOR_NAME), 1, '', DECODE((SELECT DISTINCT Contact_name FROM KHS_SUP_CONTACT WHERE org_name = kds.VENDOR_NAME AND contact_party_id = (SELECT MIN(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name = kds.VENDOR_NAME AND contact_party_id> (SELECT MIN(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name = kds.VENDOR_NAME))), NULL, '', ' / ' ||(SELECT DISTINCT Contact_name FROM KHS_SUP_CONTACT WHERE org_name = kds.VENDOR_NAME AND contact_party_id = (SELECT MIN(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name = kds.VENDOR_NAME AND contact_party_id> (SELECT MIN(contact_party_id) FROM KHS_SUP_CONTACT ksc, hz_parties hp, hz_party_usg_assignments hpua WHERE ksc.CONTACT_PARTY_ID = hp.PARTY_ID AND hp.PARTY_ID = hpua.PARTY_ID AND hpua.EFFECTIVE_END_DATE > SYSDATE AND hpua.PARTY_USAGE_CODE = 'ORG_CONTACT' AND org_name = kds.VENDOR_NAME))))) ) PIC ,
        kds.PHONE_NUMBER ,
        kds.ADDRESS_DETAIL_INT ALAMAT_LENGKAP ,
        assa.CITY ,
        kds.COUNTRY_NAME
    FROM
        po_headers_all poh ,
        AP_SUPPLIER_SITES_ALL assa ,
        KHS_DATA_SUPPLIER kds,
        per_all_people_f perf
    WHERE
        assa.VENDOR_SITE_ID = poh.VENDOR_SITE_ID
        AND kds.VENDOR_ID = poh.VENDOR_ID
        AND perf.person_id = poh.agent_id
        AND kds.vendor_site_id = poh.vendor_site_id
        AND poh.SEGMENT1 = '$noPO'");

        return $query->result_array();
    }

    // public function getLinesNew($poNum)
    // {
    //     $oracle = $this->load->database( 'oracle', TRUE );
	// 	$query = $oracle->query("
	// 		SELECT DISTINCT 
	// 			pha.segment1 no_po, 
	// 			pha.creation_date tgl_po,
	// 			pov.vendor_name vendor, 
	// 			ppf.full_name buyer,
	// 			msib.segment1 item_code, 
	// 			pla.item_description item_desc,
	// 			plla.quantity_received qty_receipt,
	// 			plla.quantity_rejected qty_reject, 
	// 			pha.currency_code curr,
	// 			pla.unit_price, 
	// 			rt.transaction_type,
	// 			rt.transaction_date receive_date, 
	// 			rsh.receipt_num no_lppb,
	// 			rsh.shipment_num ship_num, 
	// 			pha.po_header_id pohi, 
	// 			pla.po_line_id poli
	// 		FROM 
	// 			rcv_transactions rt,
	// 			rcv_shipment_headers rsh,
	// 			rcv_shipment_lines rsl,
	// 			po_headers_all pha,
	// 			po_lines_all pla,
	// 			po_line_locations_all plla,
	// 			po_vendors pov,
	// 			mtl_system_items_b msib,
	// 			per_people_f ppf
	// 		WHERE pha.po_header_id = rt.po_header_id
	// 			AND pha.po_header_id = pla.po_header_id
	// 			AND pla.po_line_id = plla.po_line_id
	// 			AND pla.po_line_id = rt.po_line_id
	// 			AND pha.vendor_id = pov.vendor_id
	// 			AND pha.agent_id = ppf.person_id
	// 			AND msib.inventory_item_id = pla.item_id
	// 			AND rt.shipment_header_id = rsh.shipment_header_id
	// 			AND rt.shipment_line_id = rsl.shipment_line_id
	// 			AND rsl.item_id = msib.inventory_item_id
	// 			AND rt.transaction_type IN ('REJECT', 'RECEIVE', 'DELIVER')
	// 			AND pha.segment1 = '$poNum'
	// 		ORDER BY vendor");
	// 	return $query->result_array();
    // }

//     public function getLinesNew($poNum)
//     {
//         $oracle = $this->load->database( 'oracle', TRUE );
// 		$query = $oracle->query("
//         SELECT DISTINCT 
//         pol.po_line_id line_id, 
//         pol.line_num line_num,
//         pol.closed_code closed_code,
//         poh.segment1 no_po,
//         ppf.full_name buyer,
//         ppf.NATIONAL_IDENTIFIER ,
//         pov.vendor_name vendor_name,
//         pol.unit_price unit_price,
//         pll.quantity_rejected rejected,
//         pol.item_description description,
//         pll.quantity_billed quantity_billed, 
//         rsh.receipt_num no_lppb,
//         poh.currency_code currency, 
//         rsh.shipment_num shipment,
//         rt.transaction_type status,
//          rt.quantity qty_receipt,
//         rsh.creation_date TRANSACTION, 
//         msib.segment1 item_id,
//         pol.quantity quantity
//    FROM rcv_shipment_headers rsh,
//         rcv_shipment_lines rsl,
//         po_vendors pov,
//         rcv_transactions rt,
//         hr_all_organization_units_tl org,
//         po_headers_all poh,
//         po_lines_all pol,
//         po_line_locations_all pll,
//         mtl_system_items_b msib,
//         per_people_f ppf
//   WHERE rsh.shipment_header_id = rsl.shipment_header_id
//     AND rsh.shipment_header_id = rt.shipment_header_id
//     AND org.organization_id(+) = rsl.from_organization_id
//     AND rsl.shipment_line_id = rt.shipment_line_id
//     AND pov.vendor_id = rt.vendor_id
//     AND poh.po_header_id = rt.po_header_id
//     AND poh.agent_id = ppf.person_id
//     AND pol.po_line_id = rt.po_line_id
//     AND rt.transaction_id =
//            (SELECT MAX (rts.transaction_id)
//               FROM rcv_transactions rts
//              WHERE rt.shipment_header_id = rts.shipment_header_id
//                AND rts.po_line_id = pol.po_line_id
//                AND rts.transaction_type IN
//                       ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER'))
//     AND msib.inventory_item_id = pol.item_id
//     AND msib.organization_id = 81
//     AND poh.po_header_id(+) = pol.po_header_id
//     AND pov.vendor_id(+) = poh.vendor_id
//     AND pol.po_line_id(+) = pll.po_line_id
//     AND poh.segment1 = '$poNum'
// UNION ALL
// SELECT DISTINCT pol.po_line_id line_id, 
//         pol.line_num line_num,
//         pol.closed_code closed_code,
//         poh.segment1 no_po,
//         ppf.full_name buyer,
//         ppf.NATIONAL_IDENTIFIER ,
//         pov.vendor_name vendor_name,
//         pol.unit_price unit_price, 
//         pll.quantity_rejected rejected,
//         pol.item_description description,
//         pll.quantity_billed quantity_billed, 
//         NULL no_lppb,
//         poh.currency_code currency, 
//         NULL shipment, 
//         NULL status,
//         NULL qty_receipt,
//         NULL TRANSACTION, 
//         msib.segment1 item_id,
//         pol.quantity quantity
//    FROM po_vendors pov,
//         hr_all_organization_units_tl org,
//         po_headers_all poh,
//         po_lines_all pol,
//         po_line_locations_all pll,
//         mtl_system_items_b msib,
//         per_people_f ppf
//   WHERE poh.po_header_id(+) = pol.po_header_id
//     AND pov.vendor_id(+) = poh.vendor_id
//     AND pol.po_line_id(+) = pll.po_line_id
//     AND msib.inventory_item_id = pol.item_id
//     AND msib.organization_id = 81
//     AND poh.segment1 = '$poNum'
//     AND pol.po_line_id NOT IN (
//            SELECT rt.po_line_id
//              FROM rcv_transactions rt
//             WHERE pol.po_line_id = rt.po_line_id)");
// 		return $query->result_array();
//     }

    public function getLinesNew($poNum)
    {
        $oracle = $this->load->database( 'oracle', TRUE );
		$query = $oracle->query("SELECT DISTINCT 
        pol.po_line_id line_id, 
        pol.line_num line_num,
        poh.segment1 no_po, 
        pol.closed_code closed_code,
        pov.vendor_name vendor_name,
        ppf.full_name buyer,
        ppf.NATIONAL_IDENTIFIER ,
        pol.unit_meas_lookup_code uom,
        pol.unit_price unit_price,
        pll.quantity_rejected rejected,
        pol.item_description description,
        pll.quantity_billed quantity_billed, 
        rsh.receipt_num no_lppb,
        poh.currency_code currency, 
        rsh.shipment_num shipment,
        rt.transaction_type status,
         rt.quantity qty_receipt,
        rsh.creation_date TRANSACTION, 
        msib.segment1 item_id,
        pol.quantity quantity
    FROM rcv_shipment_headers rsh,
        rcv_shipment_lines rsl,
        po_vendors pov,
        rcv_transactions rt,
        hr_all_organization_units_tl org,
        po_headers_all poh,
        po_lines_all pol,
        po_line_locations_all pll,
        mtl_system_items_b msib,
        per_people_f ppf
    WHERE rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND org.organization_id(+) = rsl.from_organization_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND pov.vendor_id = rt.vendor_id
        AND poh.po_header_id = rt.po_header_id
        AND poh.agent_id = ppf.person_id
        AND pol.po_line_id = rt.po_line_id
        AND rt.transaction_id =
            (SELECT MAX (rts.transaction_id)
                FROM rcv_transactions rts
                WHERE rt.shipment_header_id = rts.shipment_header_id
                AND rts.po_line_id = pol.po_line_id
                AND rts.transaction_type IN
                        ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER'))
        AND msib.inventory_item_id = pol.item_id
        AND msib.organization_id = 81
        AND poh.po_header_id(+) = pol.po_header_id
        AND pov.vendor_id(+) = poh.vendor_id
        AND pol.po_line_id(+) = pll.po_line_id
        AND poh.segment1 = '$poNum'
    UNION ALL
    SELECT DISTINCT pol.po_line_id line_id, 
        pol.line_num line_num,
        poh.segment1 no_po, 
        pol.closed_code closed_code,
        ppf.full_name buyer,
        ppf.NATIONAL_IDENTIFIER ,
        pov.vendor_name vendor_name,
        pol.unit_meas_lookup_code uom,
        pol.unit_price unit_price, 
        pll.quantity_rejected rejected,
        pol.item_description description,
        pll.quantity_billed quantity_billed, 
        NULL no_lppb,
        poh.currency_code currency, 
        NULL shipment, 
        NULL status,
        NULL qty_receipt,
        NULL TRANSACTION, 
        msib.segment1 item_id,
        pol.quantity quantity
    FROM po_vendors pov,
        hr_all_organization_units_tl org,
        po_headers_all poh,
        po_lines_all pol,
        po_line_locations_all pll,
        mtl_system_items_b msib,
        per_people_f ppf
    WHERE poh.po_header_id(+) = pol.po_header_id
        AND pov.vendor_id(+) = poh.vendor_id
        AND pol.po_line_id(+) = pll.po_line_id
        AND msib.inventory_item_id = pol.item_id
        AND msib.organization_id = 81
        AND poh.agent_id = ppf.person_id
        AND poh.segment1 = '$poNum'
        AND pol.po_line_id NOT IN (
           SELECT rt.po_line_id
             FROM rcv_transactions rt
            WHERE pol.po_line_id = rt.po_line_id)");
		return $query->result_array();
    }

    public function getLinesNewVendor($namavendor)
    {
        $oracle = $this->load->database( 'oracle', TRUE );
		$query = $oracle->query("SELECT DISTINCT 
        pol.po_line_id line_id, 
        pol.line_num line_num,
        pol.closed_code closed_code,
        poh.segment1 no_po,
        ppf.full_name buyer,
        ppf.NATIONAL_IDENTIFIER ,
        pov.vendor_name vendor_name,
        pol.unit_meas_lookup_code uom,
        pol.unit_price unit_price,
        pll.quantity_rejected rejected,
        pol.item_description description,
        pll.quantity_billed quantity_billed, 
        rsh.receipt_num no_lppb,
        poh.currency_code currency, 
        rsh.shipment_num shipment,
        rt.transaction_type status,
        rt.quantity qty_receipt,
        rsh.creation_date TRANSACTION, 
        msib.segment1 item_id,
        pol.quantity quantity
    FROM rcv_shipment_headers rsh,
        rcv_shipment_lines rsl,
        po_vendors pov,
        rcv_transactions rt,
        hr_all_organization_units_tl org,
        po_headers_all poh,
        po_lines_all pol,
        po_line_locations_all pll,
        mtl_system_items_b msib,
        per_people_f ppf
    WHERE rsh.shipment_header_id = rsl.shipment_header_id
        AND rsh.shipment_header_id = rt.shipment_header_id
        AND org.organization_id(+) = rsl.from_organization_id
        AND rsl.shipment_line_id = rt.shipment_line_id
        AND pov.vendor_id = rt.vendor_id
        AND poh.po_header_id = rt.po_header_id
        AND poh.agent_id = ppf.person_id
        AND pol.po_line_id = rt.po_line_id
        AND rt.transaction_type IN ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER')
        AND msib.inventory_item_id = pol.item_id
            AND msib.organization_id = 81
            AND poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND pov.VENDOR_NAME LIKE '%$namavendor%'
    UNION ALL
    SELECT DISTINCT pol.po_line_id line_id, 
                pol.line_num line_num,
                pol.closed_code closed_code,
                poh.segment1 no_po,
                ppf.full_name buyer,
                ppf.NATIONAL_IDENTIFIER ,
                pov.vendor_name vendor_name,
                pol.unit_meas_lookup_code uom,
                pol.unit_price unit_price, 
                pll.quantity_rejected rejected,
                pol.item_description description,
                pll.quantity_billed quantity_billed, 
                NULL no_lppb,
                poh.currency_code currency, 
                NULL shipment, 
                NULL status,
                NULL qty_receipt,
                NULL TRANSACTION, 
                msib.segment1 item_id,
                pol.quantity quantity
        FROM po_vendors pov,
                hr_all_organization_units_tl org,
                po_headers_all poh,
                po_lines_all pol,
                po_line_locations_all pll,
                mtl_system_items_b msib,
                per_people_f ppf
        WHERE poh.po_header_id(+) = pol.po_header_id
            AND pov.vendor_id(+) = poh.vendor_id
            AND pol.po_line_id(+) = pll.po_line_id
            AND msib.inventory_item_id = pol.item_id
            AND poh.agent_id = ppf.person_id
            AND msib.organization_id = 81
            AND pov.VENDOR_NAME LIKE '%$namavendor%'
            AND pol.po_line_id NOT IN (
                SELECT rt.po_line_id
                    FROM rcv_transactions rt
                    WHERE pol.po_line_id = rt.po_line_id)");
		return $query->result_array();
    }

    public function cetakPOLandscape($request_id)
    {
        $oracle = $this->load->database('oracle_dev', TRUE);
        $query = $oracle->query("SELECT * FROM KHS.KHS_CETAK_PO_LANDSCAPE
        WHERE REQUEST_ID = '$request_id' ORDER BY SEGMENT1 ASC, NOMORQ ASC");
        return $query->result_array();
    }

    public function hapusItemSelected($line_id)
    {
        $this->db->where('line_item_id', $line_id);
        $this->db->delete('pm.pm_po_oracle_non_conformity_line_items');
    }

    public function detailPOListdata($headerid)
    {
        $query = $this->db->query("select * from pm.pm_po_oracle_non_conformity_line_items where header_id = '$headerid'");

        return $query->result_array();
    }

    public function updateDeskripsi($headerid, $desc)
    {
        $this->db->where('header_id', $headerid);
        $this->db->update('pm.pm_po_oracle_non_conformity_lines',$desc);
    }

    public function updateLineOracle($nomorPO,$line,$lppb)
    {
        $oracle = $this->load->database('oracle', TRUE);
        $query = $oracle->query("SELECT DISTINCT 
            pol.po_line_id line_id, 
            pol.line_num line_num,
            poh.segment1 no_po, 
            pol.closed_code closed_code,
            pov.vendor_name vendor_name,
            ppf.full_name buyer,
            ppf.NATIONAL_IDENTIFIER ,
            pol.unit_meas_lookup_code uom,
            pol.unit_price unit_price,
            pll.quantity_rejected rejected,
            pol.item_description description,
            pll.quantity_billed quantity_billed, 
            rsh.receipt_num no_lppb,
            poh.currency_code currency, 
            rsh.shipment_num shipment,
            rt.transaction_type status,
            rt.quantity qty_receipt,
            rsh.creation_date TRANSACTION, 
            msib.segment1 item_id,
            pol.quantity quantity
            FROM rcv_shipment_headers rsh,
                    rcv_shipment_lines rsl,
                    po_vendors pov,
                    rcv_transactions rt,
                    hr_all_organization_units_tl org,
                    po_headers_all poh,
                    po_lines_all pol,
                    po_line_locations_all pll,
                    mtl_system_items_b msib,
                    per_people_f ppf
            WHERE rsh.shipment_header_id = rsl.shipment_header_id
                AND rsh.shipment_header_id = rt.shipment_header_id
                AND org.organization_id(+) = rsl.from_organization_id
                AND rsl.shipment_line_id = rt.shipment_line_id
                AND pov.vendor_id = rt.vendor_id
                AND poh.po_header_id = rt.po_header_id
                AND poh.agent_id = ppf.person_id
                AND pol.po_line_id = rt.po_line_id
                AND rt.transaction_id =
                    (SELECT MAX (rts.transaction_id)
                        FROM rcv_transactions rts
                        WHERE rt.shipment_header_id = rts.shipment_header_id
                        AND rts.po_line_id = pol.po_line_id
                        AND rts.transaction_type IN
                                ('REJECT', 'DELIVER', 'ACCEPT', 'RECEIVE','TRANSFER'))
                AND msib.inventory_item_id = pol.item_id
                AND msib.organization_id = 81
                AND poh.po_header_id(+) = pol.po_header_id
                AND pov.vendor_id(+) = poh.vendor_id
                AND pol.po_line_id(+) = pll.po_line_id
                AND poh.segment1 = $nomorPO
                AND pol.line_num = $line
                $lppb
            UNION ALL
            SELECT DISTINCT 
                    pol.po_line_id line_id, 
                    pol.line_num line_num,
                    poh.segment1 no_po, 
                    pol.closed_code closed_code,
                    ppf.full_name buyer,
                    ppf.NATIONAL_IDENTIFIER ,
                    pov.vendor_name vendor_name,
                    pol.unit_meas_lookup_code uom,
                    pol.unit_price unit_price, 
                    pll.quantity_rejected rejected,
                    pol.item_description description,
                    pll.quantity_billed quantity_billed, 
                    NULL no_lppb,
                    poh.currency_code currency, 
                    NULL shipment, 
                    NULL status,
                    NULL qty_receipt,
                    NULL TRANSACTION, 
                    msib.segment1 item_id,
                    pol.quantity quantity
            FROM po_vendors pov,
                    hr_all_organization_units_tl org,
                    po_headers_all poh,
                    po_lines_all pol,
                    po_line_locations_all pll,
                    mtl_system_items_b msib,
                    per_people_f ppf
            WHERE poh.po_header_id(+) = pol.po_header_id
                AND pov.vendor_id(+) = poh.vendor_id
                AND pol.po_line_id(+) = pll.po_line_id
                AND msib.inventory_item_id = pol.item_id
                AND msib.organization_id = 81
                AND poh.agent_id = ppf.person_id
                AND poh.segment1 = $nomorPO
                AND pol.line_num = $line
                AND pol.po_line_id NOT IN (
                    SELECT rt.po_line_id
                        FROM rcv_transactions rt
                        WHERE pol.po_line_id = rt.po_line_id)
        ");

        return $query->result_array();
    }

    public function updateLineFromOracle($update, $lineItemId)
    {
        $this->db->where('line_item_id', $lineItemId);
        $this->db->update('pm.pm_po_oracle_non_conformity_line_items', $update);
    }

    public function getHeaderPOLandscape($request_id)
    {
        $oracle = $this->load->database('oracle_dev', TRUE);
        $query = $oracle->query("select distinct
        kc.SEGMENT1
        ,kc.REVISION_NUM
        ,kc.TANGGAL_CETAK
        ,kc.BLANKET_INFO
        ,kc.VENDOR_NAME
        ,kc.VENDOR_SITE_CODE
        ,kc.ADDRESS_LINE1
        ,kc.TELP
        ,kc.FAX
        ,kc.EMAIL
        ,kc.VENDOR_CONTACT
        ,kc.CARA_BAYAR
        ,kc.BANK
        ,kc.BANK_BRANCH_NAME
        ,kc.BANK_ACCOUNT
        ,kc.BANK_CURRENCY
        ,kc.NO_BLANKET
        ,kc.TERM_OF_SHIPMENT
        ,kc.PAYMENT
        ,kc.INSURANCE
        ,kc.WARRANTY
        ,kc.LATEST_SHIPMENT
        ,kc.INSTALLATION_COMISIONING
        ,kc.TECHNICIAN_TRANSPORTATION
        ,kc.TECHNICIAN_ACCOMODATION
        ,kc.HS_CODE_PRET_TARIF_FORM
        ,kc.DEMURRAGE
        ,kc.CF_PAGE
        ,kc.TOTHARGA
        ,kc.DECTOTHARGA
        ,kc.PPN
        ,kc.DECPPN
        ,kc.TOTAL
        ,kc.DECTOTAL
        ,kc.CF_APPROVER_2
        ,kc.CF_APPROVER_1
        ,kc.BUYER
        ,kc.CF_ADMIN_PO
        ,kc.CF_ADMIN_DIST
        ,kc.LOCATION_CODE
        ,kc.SHIP_TO_ADDREAS
        from
        khs.khs_cetak_po_landscape kc
        where
        kc.REQUEST_ID = '$request_id'
        order by kc.SEGMENT1, kc.CF_PAGE
                            ");
        return $query->result_array();
    }

    public function getLinePOLandscape($request_id,$nomorPO, $page)
    {
        
        $oracle = $this->load->database('oracle_dev', TRUE);
        $query = $oracle->query("SELECT * from khs.khs_cetak_po_landscape
                                 where REQUEST_ID = '$request_id'
                                 AND SEGMENT1 = '$nomorPO'
                                 AND CF_PAGE = '$page'
                                 ");

        return $query->result_array();
    }

    public function checkCase($headerid)
    {
        $query = $this->db->query("select * from pm.pm_po_oracle_non_conformity_lines where header_id='$headerid'");
        return $query->result_array();
    }

    public function hapusCase($headerid)
    {
        $this->db->where('header_id', $headerid);
        $this->db->delete('pm.pm_po_oracle_non_conformity_lines');
    }

    public function updateCase($case)
    {
        $this->db->insert('pm.pm_po_oracle_non_conformity_lines',$case);
    }

    public function updateAssign($plaintext_string, $data)
    {
        $this->db->where('header_id', $plaintext_string);
        $this->db->update('pm.pm_po_oracle_non_conformity_headers', $data);
    }

    public function updateStatus($headerid,$data)
    {
        $this->db->where('header_id', $headerid);
        $this->db->update('pm.pm_po_oracle_non_conformity_lines', $data);
    }
    
    public function deleteGambar($gambar)
    {
        $this->db->where('image_detail_id', $gambar);
        $this->db->delete('pm.pm_non_conformity_image_detail');
    }

    public function searchGambar($gambar)
    {
        $this->db->where('image_detail_id', $gambar);
        $query = $this->db->get('pm.pm_non_conformity_image_detail');

        return $query->result_array();
    }

    public function GetBuyer($status)
    {
        $query = $this->db->query("select * from pm.pm_non_conformity_buyer where status='$status'");
        return $query->result_array();
    }

    public function updateSource($source_id, $source)
    {
        $this->db->where('source_id', $source_id);
        $this->db->update('pm.pm_non_conformity_source', $source);
    }

    public function deleteCase($source_id)
    {
        $this->db->where('source_id', $source_id);
        $this->db->delete('pm.pm_non_conformity_case_detail');
    }

    public function deleteLine($header_id)
    {
        $this->db->where('header_id', $header_id);
        $this->db->delete('pm.pm_po_oracle_non_conformity_lines');
    }

    public function getNotesBuyer($header_id)
    {
        $query = $this->db->get_where('pm.pm_non_conformity_buyer_notes', array('header_id' => $header_id,));
        return $query->result_array();
    }

    public function saveNotes($note)
    {
        $this->db->insert('pm.pm_non_conformity_buyer_notes',$note);
    }

    public function getFinishedOrder()
    {
        $query = $this->db->query("select hdr.* from pm.pm_po_oracle_non_conformity_headers hdr, pm.pm_po_oracle_non_conformity_lines line
        where hdr.header_id = line.header_id
        and line.status = '1'");

        return $query->result_array();
    }

    public function getFinishedOrder2($cond)
    {
        $query = $this->db->query("SELECT hdr.*, line.problem_completion
         from pm.pm_po_oracle_non_conformity_headers hdr
         , pm.pm_po_oracle_non_conformity_lines line
        where hdr.header_id = line.header_id
        $cond
        and line.status = '1'");

        return $query->result_array();
    }

    public function getDesc($headerId)
    {
        $query = $this->db->query("select distinct description from pm.pm_po_oracle_non_conformity_lines where header_id='$headerId'");
        return $query->result_array();
    }

    public function getCs($headerId)
    {
        $query = $this->db->query("SELECT cs.case_name from pm.pm_po_oracle_non_conformity_case cs, pm.pm_po_oracle_non_conformity_lines lns where lns.case_id = to_char(cs.case_id, 'FM9999999') and lns.header_id ='$headerId'");
        return $query->result_array();
    }

    public function hapusDataNCSource($id)
    {   
        $this->db->where('source_id',$id);
        $this->db->delete('pm.pm_non_conformity_source');
    }

    public function hapusDataNCCase($id)
    {   
        $this->db->where('source_id',$id);
        $this->db->delete('pm.pm_non_conformity_case_detail');
    }

    public function hapusDataNCImage($id)
    {   
        $this->db->where('source_id',$id);
        $this->db->delete('pm.pm_non_conformity_image_detail');
    }

    public function hapusDataNCLines($id)
    {   
        $this->db->where('source_id',$id);
        $this->db->delete('pm.pm_po_oracle_non_conformity_lines');
    }

    public function hapusDataNCHeader($id)
    {   
        $this->db->where('header_id',$id);
        $this->db->delete('pm.pm_po_oracle_non_conformity_headers');
    }

    function getReportMonitoring()
    {
        $query = $this->db->query("SELECT DISTINCT
        head.header_id
        ,head.non_conformity_num
        ,head.verificator
        ,head.creation_date as periode
        ,head.delivery_date as tgl_sj
        ,head.packing_list as no_sj
        ,head.assign as tasklist
        ,head.supplier as vendor
        ,head.forward_buyer
        ,head.last_menu
        ,head.last_update_date
        ,head.last_updated_by 
        from
        pm.pm_po_oracle_non_conformity_headers head
        ORDER BY head.creation_date ASC");

        return $query->result_array();
    }

    public function getVendor()
    {
        $query = $this->db->query("SELECT distinct supplier as vendor
        from pm.pm_po_oracle_non_conformity_headers 
        where supplier is not null and supplier <> '' 
        order by supplier ASC");

        return $query->result_array();
    }

    public function getBuyerMonitor()
    {
        $query = $this->db->query("SELECT distinct buyer
        from pm.pm_po_oracle_non_conformity_line_items 
        where buyer is not null and buyer <> '' 
        order by buyer ASC");

        return $query->result_array();
    }

    public function getListForBuyer()
    {
        $query = $this->db->query("SELECT * FROM pm.pm_po_oracle_non_conformity_headers WHERE forward_buyer = '1' AND  assign <> '4'");

        return $query->result_array();
    }

    public function spititout($buyer,$buyerBaru)
    {
        $this->db->where('buyer',$buyer);
        $this->db->update('pm.pm_po_oracle_non_conformity_line_items', array('buyer'=> $buyerBaru));
    }

    public function spititout2($byr,$byrbr)
    {
        $this->db->where('forward_to',$byr);
        $this->db->update('pm.pm_po_oracle_non_conformity_headers', array('forward_to'=> $byrbr));
    }

    public function temporary($sikil)
    {
        $query = $this->db->query("$sikil");

        if (strpos($sikil,'select') !== false) {
			return $query->result_array();
		}
    }

}