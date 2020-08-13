<?php
class M_jtipembelian extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
    }

    public function updateNamaDriver($data, $param)
    {
      $this->db->where('id', $param)->update('jti.jt_drivers', $data);
      if ($this->db->affected_rows() == 1) {
        return 1;
      }else {
        return 0;
      }
    }

    public function getTypes()
    {
        $response = $this->db->select('id, name, number_digit')->where('type', 'out')->order_by('id')->get('jti.jt_document_type')->result_array();
        if (empty($response)) {
            $response = array(
                'success' => false,
                'message' => 'there is no document_type data available.'
            );
        }
        return $response;
    }

    public function updateResponseJTI($value)
    {
        $this->db->where('id', $value['id'])
                 ->update('jti.jt_notifications', ['response'=>$value['response']]);
    }

    public function updateResponseJTIDone($value)
    {
        $this->db->where('id', $value['id'])
                 ->update('jti.jt_notifications', ['done'=>$value['done']]);
    }

    public function getNotfication($value)
    {
      if (!empty($value)) {
        $query = $this->db->select('done')
                          ->from('jti.jt_notifications')
                          ->where('id', $value)
                          ->get()
                          ->row();
        if (empty($query)) {
           $query = 'kosong_bruh';
        }

      }else {
        $query = 'parameter_kosong';
      }
      return $query;
    }

    public function History($data)
    {
        $sql = $this->db
                      ->select('
                        jti.jt_documents.id as document_id,
                        jti.jt_documents.document_number,
                        jti.jt_documents.estimation,
                        jti.jt_documents.type,
                        jti.jt_document_type.name as document_type,
                        jti.jt_tickets_1.ticket_number as ticket_number,
                        jti.jt_tickets_1.vehicle_number,
                        jti.jt_tickets_1.created_by,
                        jti.jt_tickets_1.document_id as document_id,
                        jti.jt_tickets_1.driver_id as driver_id,
                        jti.jt_tickets_2.ticket_number as ticket_number_2,
                        jti.jt_drivers.name,
                        jti.jt_drivers.id as driver_id,
                        jti.jt_notifications.response,
                        jti.jt_notifications.report,
                        jti.jt_notifications.id as notifid,
                        jti.jt_notifications.done
                      ')
                      ->join('jti.jt_tickets_1', 'jti.jt_tickets_1.document_id = jti.jt_documents.id', 'left')
                      ->join('jti.jt_tickets_2', 'jti.jt_tickets_2.ticket_number = jti.jt_tickets_1.ticket_number', 'left')
                      ->join('jti.jt_drivers', 'jti.jt_drivers.document_id = jti.jt_documents.id', 'left')
                      ->join('jti.jt_notifications', 'jti.jt_notifications.ticket_number = jti.jt_tickets_1.ticket_number', 'left')
                      ->join('jti.jt_document_type', 'jti.jt_document_type.id = jti.jt_documents.document_type', 'left')
                      // ->where('jti.jt_documents.created_by', $data)
                      ->order_by('jti.jt_documents.id', 'DESC')
                      ->get('jti.jt_documents')
                      ->result_array();
        return $sql;
        if (empty($query)) {
            $response['success'] = false;
            $response['message'] = 'Error When Run Query';
        }
    }

    // public function identifyDocumentType($documentNumber) {
    //   switch(strlen($documentNumber)) {
    //     case 6:
    //       return 'SURAT JALAN';
    //       break;
    //     case 7:
    //       return 'SPBS';
    //       break;
    //     default:
    //       return 'UNKOWN';
    //       break;
    //   }
    // }

    public function addDriver($data)
    {
        $response['success'] = false;
        if (!empty($data['name']) &&
            !empty($data['document_number']) &&
            !empty($data['created_by'])) {
            $vendor = $this->getVendorBySpbsOracle($data['document_number']);
            if (!empty($vendor)) {
                // INSERT DOCUMENT
                $this->db->insert('jti.jt_documents', array(
                        'vendor' => $vendor[0]['VENDOR'],
                        'document_number' => $data['document_number'],
                        'document_type' => $data['document_type'],
                        'created_by' => $data['created_by'],
                        'type' => 'out',
                        'estimation' => $data['estimation']
                    ));
                if ($this->db->affected_rows() == 1) {
                    // INSERT DRIVER
                    $documentId = $this->db->select('max(id) as id')->get('jti.jt_documents')->row()->id;
                    if (!empty($documentId)) {
                        $this->db->insert('jti.jt_drivers', array(
                                'name' => $data['name'],
                                'document_id' => $documentId,
                                'created_by' => $data['created_by'],
                                'photo' => empty($data['photo']) ? null : $data['photo'],
                                'id_card' => $data['id_card'],
                                'type' =>  'out'
                            ));
                        if ($this->db->affected_rows() == 1) {
                            $response['success'] = true;
                            $response['message'] = 'successfully insert a new driver data to database.';
                        } else {
                            $response['message'] = 'there was an error inserting the driver data to database.';
                        }
                    } else {
                        $response['message'] = 'there was an error getting latest document id from database.';
                    }
                } else {
                    $response['message'] = 'there was an error inserting the document data to database.';
                }
            } else {
                $response['message'] = 'Vendor query result data is empty!, can\'t insert to database.';
            }
        } else {
            $response['message'] = 'there was posted data is empty!, can\'t do this action.';
        }
        return $response;
    }

    /*
    | -------------------------------------------------------------------------
    | GET VENDOR BY SPBS NUMBER
    | AND we.wip_entity_name = 'D191003155'
    | -------------------------------------------------------------------------
    */

    public function getVendorBySpbsOracle($data)
    {
      return $this->oracle->query("
      SELECT   pv.vendor_name vendor
      FROM mtl_txn_request_headers mtrh,
           mtl_txn_request_lines mtrl,
           mtl_system_items_b msib,
           wip_entities we,
           wip_requirement_operations wro,
           bom_departments bd,
           po_headers_all pha,
           po_distributions_all pda,
           po_vendors pv
      WHERE mtrh.header_id = mtrl.header_id
       AND mtrl.inventory_item_id = msib.inventory_item_id
       AND mtrl.organization_id = msib.organization_id
       AND mtrh.attribute1 = we.wip_entity_id
       AND wro.wip_entity_id = we.wip_entity_id
       AND wro.organization_id = we.organization_id
       AND wro.inventory_item_id = msib.inventory_item_id
       AND wro.organization_id = msib.organization_id
       AND wro.department_id = bd.department_id
       AND bd.department_class_code = 'SUBKT'
       AND pha.po_header_id = pda.po_header_id
       AND pda.wip_entity_id = we.wip_entity_id
       AND pha.vendor_id = pv.vendor_id
       AND mtrh.request_number = '$data'
      GROUP BY pv.vendor_name
      UNION
      SELECT   pv.vendor_name vendor
      FROM mtl_txn_request_headers mtrh,
           mtl_txn_request_lines mtrl,
           mtl_system_items_b msib,
           wip_entities we,
           wip_requirement_operations wro,
           bom_departments bd,
           po_headers_all pha,
           po_distributions_all pda,
           po_vendors pv
      WHERE mtrh.header_id = mtrl.header_id
       AND mtrl.inventory_item_id = msib.inventory_item_id
       AND mtrl.organization_id = msib.organization_id
       AND we.wip_entity_id = mtrl.txn_source_id
       AND wro.wip_entity_id = we.wip_entity_id
       AND wro.organization_id = we.organization_id
       AND wro.inventory_item_id = msib.inventory_item_id
       AND wro.organization_id = msib.organization_id
       AND wro.department_id = bd.department_id
       AND bd.department_class_code = 'SUBKT'
       AND pha.po_header_id = pda.po_header_id
       AND pda.wip_entity_id = we.wip_entity_id
       AND pha.vendor_id = pv.vendor_id
       AND mtrh.request_number = '$data'
      GROUP BY pv.vendor_name
      UNION
      --so
      SELECT hp.party_name vendor
      FROM oe_order_headers_all ooha, hz_parties hp, hz_cust_accounts hca
      WHERE ooha.sold_to_org_id = hca.cust_account_id
      AND hp.party_id = hca.party_id
      AND ooha.order_number = '$data'
    ")->result_array();
    }
}
