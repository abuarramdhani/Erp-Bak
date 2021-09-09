<?php
class M_subkon extends CI_Model
{

    var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function get_data_po($status)
    {
        $cond = '';
        $where = '';
        if ($status == 'unprinted') {
            $cond = 'NOT';
            $where = "AND pha.creation_date >= to_date('01-MAY-2021', 'DD-MON-YYYY')";
        }
        $oracle = $this->load->database('oracle',TRUE);

        $sql = "SELECT
                pha.po_header_id,
                pha.segment1 no_po,
                pv.vendor_name,
                pha.creation_date,
                MAX ( pah.action_date ) OVER ( PARTITION BY pha.po_header_id ) approve_date
            FROM
                po_headers_all pha,
                fnd_user fu,
                po_vendors pv,
                po_action_history pah
            WHERE
                pha.created_by = fu.user_id
                AND UPPER ( fu.user_name ) LIKE '%PSUB%'
                AND pha.vendor_id = pv.vendor_id
                AND pha.po_header_id = pah.object_id(+)
                AND pah.object_type_code(+) = 'PO'
                AND pah.action_code(+) = 'APPROVE' $where
                AND pha.segment1 $cond IN (
                SELECT
                    DISTINCT TO_NUMBER( khs.segment1 )
                FROM
                    khs.KHS_CETAK_PO_LANDSCAPE KHS,
                    PO_HEADERS_ALL PHA,
                    FND_USER FU
                WHERE
                    khs.segment1 = pha.segment1
                    AND pha.created_by = fu.user_id
                    AND fu.user_name LIKE '%PSUB%' )";

        $query = $oracle->query($sql);
        return $query->result_array();
    }
}
?>