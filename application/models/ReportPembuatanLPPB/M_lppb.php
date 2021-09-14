<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_lppb extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->load->database();    
      $this->oracle = $this->load->database('oracle', true);
    }

    public function getDataLppb($tanggal,$lokasi,$io){
        $tanggal2 = explode(' - ', $tanggal);      
        $tgl_dari = $tanggal2[0];
        $tgl_sampai = $tanggal2[1];

        if ($lokasi == 'TUKSONO') {
            // AC PPBG TR 02, AC PPBG TR 03
            $created_by = "5330,5232"; 
        }else if ($lokasi == 'PUSAT') {
            // AA PPBG TR 02
            $created_by = "5213";
        }

        if ($io == 'ALL') {
            // ODM, OPM, EXP
            $org_id = "102,101,124"; 
        }else {
            $org_id = $io;
        }

        $sql = "SELECT   mp.organization_code, rsh.receipt_num no_lppb, rsl.shipment_line_id,
        msib.segment1 kode_item, rsl.item_description item, --msib.description item,
        --TO_CHAR (rsh.creation_date, 'DD/MM/YYYY HH24:MI:SS') tgl_shipment,
        TO_CHAR (rsh.shipped_date, 'DD/MM/YYYY HH24:MI:SS') tgl_shipment,
        (SELECT MIN (TO_CHAR (transaction_date, 'DD/MM/YYYY HH24:MI:SS'))
           FROM rcv_transactions
          WHERE transaction_type = 'RECEIVE'
            AND shipment_line_id = rsl.shipment_line_id) tgl_receive,
        (SELECT MIN (TO_CHAR (transaction_date, 'DD/MM/YYYY HH24:MI:SS'))
           FROM rcv_transactions
          WHERE transaction_type = 'TRANSFER'
            AND shipment_line_id = rsl.shipment_line_id) tgl_transfer,
        (SELECT MIN (TO_CHAR (transaction_date, 'DD/MM/YYYY HH24:MI:SS'))
           FROM rcv_transactions
          WHERE transaction_type IN ('ACCEPT', 'REJECT')
            AND shipment_line_id = rsl.shipment_line_id) tgl_inspect,
        (SELECT MIN (TO_CHAR (transaction_date, 'DD/MM/YYYY HH24:MI:SS'))
           FROM rcv_transactions
          WHERE transaction_type = 'DELIVER'
            AND shipment_line_id = rsl.shipment_line_id) tgl_deliver,
        -- rsl.to_subinventory, mil.segment1 to_locator, 
        hrl.location_code, fu.user_name akun_receipt
   FROM mtl_parameters mp,
        rcv_shipment_headers rsh,
        rcv_shipment_lines rsl,
        mtl_system_items_b msib,
        mtl_item_locations mil,
        fnd_user fu,
        rcv_transactions rt,
        hr_locations hrl
  WHERE rsh.ship_to_org_id = mp.organization_id
    AND rsh.shipment_header_id = rsl.shipment_header_id
    AND rsl.item_id = msib.inventory_item_id
    AND mp.organization_id = msib.organization_id
    AND rsl.locator_id = mil.inventory_location_id(+)
    AND rsh.shipment_header_id = rt.shipment_header_id
    AND rsl.shipment_line_id = rt.shipment_line_id
    AND rt.transaction_type = 'RECEIVE'
    AND rt.location_id = hrl.location_id(+)
    AND rsh.created_by = fu.user_id
    AND mp.organization_id IN ($org_id)
    AND rsh.created_by IN ($created_by)
    AND TRUNC (rsh.creation_date) BETWEEN TO_DATE('$tgl_dari') AND TO_DATE('$tgl_sampai')";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getOrgCode($io){
        $sql = "SELECT mp.organization_code
        FROM mtl_parameters mp
       WHERE mp.organization_id = $io";
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }


}