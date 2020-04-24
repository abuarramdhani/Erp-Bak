<?php
class M_index extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getData()
    {
        $db = $this->load->database('oracle', true);
        $hasil = $db->query("select
                                hca.ACCOUNT_NUMBER CUSTOMER_NUMBER
                                ,hp.PARTY_NAME NAMA_CUSTOMER
                                ,acra.RECEIPT_NUMBER
                                ,acra.RECEIPT_DATE
                                ,acra.AMOUNT
                                ,acrha.STATUS
                                ,NVL (- (apsa.amount_applied), 0) applied_amount
                                ,acra.AMOUNT - NVL (- (apsa.amount_applied), 0) unapplied_amount
                                ,arm.NAME RECEIPT_METHOD
                                ,acra.COMMENTS
                            from
                                ar_cash_receipts_all acra
                                ,HZ_CUST_ACCOUNTS hca
                                ,HZ_PARTIES hp
                                ,AR_CASH_RECEIPT_HISTORY_ALL acrha
                                ,ar_payment_schedules_all apsa
                                ,ar_receipt_methods arm
                            where
                                acra.PAY_FROM_CUSTOMER = hca.CUST_ACCOUNT_ID
                                and hca.PARTY_ID = hp.PARTY_ID
                                and acra.CASH_RECEIPT_ID = acrha.CASH_RECEIPT_ID
                                and acra.CASH_RECEIPT_ID = apsa.CASH_RECEIPT_ID
                                and acra.RECEIPT_METHOD_ID = arm.RECEIPT_METHOD_ID
                                and hca.ACCOUNT_NUMBER in (9638, 14307, 13867, 14748)
                                order by acra.RECEIPT_DATE desc");
        return $hasil->result_array();
    }
}
?>