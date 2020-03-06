<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_api extends CI_Model {

	function __construct() {
		parent::__construct();
        $this->load->database();
	}

	function login($username, $password) {
        $db = $this->load->database('tpb_sql', true);
        $array = array('username' => $username, 'password' => $password);
		$query = $db->where($array)->get('tp_login');
		return $query->result_array();
        }
        
        function detailConfirmationTPB($noSPB) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT LINE_ID
                                ,NO_SPB 'NO SPB'
                                ,SO 
                                ,CUST
                                ,ALAMAT
                                ,KODE_ITEM 'KODE ITEM'
                                ,NAMA_ITEM 'NAMA ITEM'
                                ,CONVERT(QTY, CHAR) 'QTY'
                                ,UOM
                                ,CONFIRMATION_STATUS 
                        FROM tpb_spb 
                        where no_spb = '$noSPB'";
                return $db->query($sql)->result_array();
                }

        function editPass($username) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT * 
                          FROM tp_login
                         where username = '$username'";
                return $db->query($sql)->result_array();
                }     
        
        function editPassUpdate($username, $md5NewPass) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "UPDATE tp_login set password = '$md5NewPass' where username = '$username'";
                $db->query($sql);
                } 

        function endTPB($noSPB,$status,$penerima) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "UPDATE tpb SET  last_update_date = now(), 
                                        status = '$status', 
                                        penerima = '$penerima', 
                                        end_date = now() 
                                  where no_spb = '$noSPB'";
                $db->query($sql);
                } 
        
        function endTPBGetSPB($noSPB) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT * FROM tpb where no_spb = '$noSPB'";
                return $db->query($sql)->result_array();
                } 

        function finishConfirmTPB($noSPB,$line_id) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT LINE_ID
                              ,NO_SPB 'NO SPB'
                              ,SO 
                              ,CUST
                              ,ALAMAT
                              ,KODE_ITEM 'KODE ITEM'
                              ,NAMA_ITEM 'NAMA ITEM'
                              ,CONVERT(QTY, CHAR) 'QTY'
                              ,UOM
                              ,CONFIRMATION_STATUS 
                          FROM tpb_spb 
                        WHERE no_spb = '$noSPB'
                          AND line_id = '$line_id'";
                return $db->query($sql)->result_array();
                } 

        function finishConfirmTPBUpdate($noSPB,$line_id,$confirmation_status,$note,$confirmed_by) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "UPDATE tpb_spb
                           SET confirmation_status = '$confirmation_status'
                         WHERE LINE_ID = '$line_id'";
                $db->query($sql);

                $sqlCountConfirm = "SELECT count(confirmation_status) jumlah
                                      FROM tpb_spb
                                     WHERE no_spb = '$noSPB'";
                $countConfirm = $db->query($sqlCountConfirm)->result();

                $sqlCountData = "SELECT count(kode_item) jumlah
                                   FROM tpb_spb
                                   WHERE no_spb = '$noSPB'";
                $countData = $db->query($sqlCountData)->result();

                if($countConfirm == $countData){
                        $sqlUpdateHeader = "UPDATE tpb 
                                              SET confirmation = (SELECT *
                                                                    FROM (SELECT DISTINCT confirmation_status 
                                                                            FROM tpb_spb 
                                                                           WHERE no_spb = '$noSPB'
                                                                             AND confirmation_status = 'Y'
                                                                           UNION 
                                                                          SELECT DISTINCT confirmation_status 
                                                                            FROM tpb_spb 
                                                                           WHERE no_spb = '$noSPB'
                                                                             AND confirmation_status = 'N'
                                                                           ORDER BY confirmation_status) confirm
                                                                           LIMIT 1),
                                                                note = '$note',
                                                                confirmed_by = '$confirmed_by',
                                                                last_update_date = now(),
                                                                end_date = now(),
                                                                status = 'onFinish'
                                                          WHERE no_spb = '$noSPB'";
                         $db->query($sqlUpdateHeader);                                
                }


                } 

        function getConfirmationTPB($noSPB) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT confirmation FROM tpb where no_spb = '$noSPB'";
                return $db->query($sql)->result_array();
                } 
        
        function getKendaraan() {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT id_kendaraan, kendaraan, nomor_kendaraan FROM tp_kendaraan";
                return $db->query($sql)->result_array();
                } 

        function getListTPB($nama_pekerja) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT * FROM tpb where nama_pekerja = '$nama_pekerja'";
                return $db->query($sql)->result_array();
                } 
                
        function insertTPB($noSPB,$nama_pekerja,$kendaraan,$status) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "INSERT INTO tpb(no_spb, nama_pekerja, kendaraan, last_update_date, status) 
                             VALUES('$noSPB', '$nama_pekerja', '$kendaraan', now(), '$status')";
                $db->query($sql);                     
                }        

        function insertTPBGet($noSPB) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT * FROM tpb where no_spb = '$noSPB'";
                return $db->query($sql)->result_array();
                } 

        function startTPB($noSPB,$kendaraan,$status) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "UPDATE tpb SET kendaraan = '$kendaraan', last_update_date = now(), 
                                          status = '$status', start_date = now() 
                                 where no_spb = '$noSPB'";
                $db->query($sql); 
                
                //insert ke tablle tpb_spb
                $oracle = $this->load->database('oracle',true);
                $sql = "SELECT distinct
                                       mtrh.REQUEST_NUMBER \"NO_SPB\"
                                      ,mtrh.ATTRIBUTE7 \"SO\"
                                      ,party.PARTY_NAME \"CUST\"
                                      ,case when ship_loc.address1 is null
                                       then mtrh.TO_SUBINVENTORY_CODE ||' ('|| mtrh.ATTRIBUTE4
                                       else ship_loc.address1
                                       end \"ALAMAT\"
                                      ,msib.SEGMENT1 \"KODE_ITEM\"
                                      ,msib.DESCRIPTION \"NAMA_ITEM\"
                                      ,mtrl.quantity \"QTY\"
                                      ,msib.PRIMARY_UOM_CODE \"UOM\"
                                              FROM mtl_txn_request_headers mtrh
                                                   ,mtl_txn_request_lines mtrl
                                                   ,MTL_SYSTEM_ITEMS_B msib
                                                   ,oe_order_headers_all ooha
                                                   ,hz_parties party
                                                   ,hz_cust_accounts cust_acct
                                                   ,hz_locations ship_loc
                                                   ,hz_cust_site_uses_all ship_su
                                                   ,hz_cust_acct_sites_all ship_cas
                                                   ,hz_party_sites ship_ps
                                                          where mtrh.HEADER_ID(+) = mtrl.header_id
                                                          and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                                          and mtrh.ATTRIBUTE7 = ooha.ORDER_NUMBER(+)
                                                          AND ooha.sold_to_org_id = cust_acct.cust_account_id(+)
                                                          AND cust_acct.party_id = party.party_id(+)
                                                          and ooha.ship_to_org_id = ship_su.site_use_id(+)
                                                          AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                                                          AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                                                          AND ship_loc.location_id(+) = ship_ps.location_id
                                                          and mtrh.REQUEST_NUMBER = '$noSPB'";
                $run = $oracle->query($sql);
                $data = $run->result_array();

                foreach($data as $key => $value){
                        $no_spb     = $value['NO_SPB'];
                        $so         = $value['SO'];
                        $cust       = $value['CUST'];
                        $alamat     = $value['ALAMAT'];
                        $kode_item  = $value['KODE_ITEM'];
                        $nama_item  = $value['NAMA_ITEM'];
                        $qty        = $value['QTY'];
                        $uom        = $value['UOM'];
                        $insertToTPBSPB = "INSERT INTO tpb_spb(no_spb, 
                                                               so, 
                                                               cust, 
                                                               alamat, 
                                                               kode_item, 
                                                               nama_item, 
                                                               qty, 
                                                               uom, 
                                                               confirmation_status) 
                                                        values('$no_spb',
                                                               '$so',
                                                               '$cust',
                                                               '$alamat',
                                                               '$kode_item',
                                                               '$nama_item',
                                                               '$qty',
                                                               '$uom',
                                                               NULL)";
                        $db->query($insertToTPBSPB); 
                        }
                }  

        function startTPBGet($noSPB) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT * FROM tpb where no_spb = '$noSPB'";
                return $db->query($sql)->result_array();
                } 

        function showPosition($id_login) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT tpp.*, tpl.nama_pekerja 
                          FROM tp_login tpl 
                               RIGHT JOIN tp_position tpp on tpl.id_login = tpp.id_login 
                         Where tpp.id_login = '$id_login'";
                return $db->query($sql)->result_array();
                } 

        function setPositionGet($id_login) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "SELECT count(tpp.id_login) jumlah
                          FROM tp_login tpl 
                               RIGHT JOIN tp_position tpp on tpl.id_login = tpp.id_login 
                         WHERE tpp.id_login = '$id_login'";
                return $db->query($sql)->result_array();
                } 

        function setPositionInsert($id_login,$lat,$long) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "INSERT INTO tp_position VALUES('$id_login', '$long', '$lat') ";
                $db->query($sql); 
                } 

        function setPositionUpdate($id_login,$lat,$long) {
                $db = $this->load->database('tpb_sql', true);
                $sql = "UPDATE tp_position tpp set tpp.lat = '$lat', 
                                                   tpp.long = '$long' 
                                             WHERE id_login = '$id_login'";
                $db->query($sql); 
                } 
                


        //oracle        
	function detailSPB($noSPB) {
        $oracle = $this->load->database('oracle',true);
        $sql = "SELECT distinct
                              mtrh.REQUEST_NUMBER \"NO_SPB\"
                              ,mtrh.ATTRIBUTE7 \"SO\"
                              ,party.PARTY_NAME \"CUST\"
                              ,case when ship_loc.address1 is null
                               then mtrh.TO_SUBINVENTORY_CODE ||' ('|| mtrh.ATTRIBUTE4
                               else ship_loc.address1
                               end \"ALAMAT\"
                              ,msib.SEGMENT1 \"KODE_ITEM\"
                              ,msib.DESCRIPTION \"NAMA_ITEM\"
                              ,mtrl.quantity \"QTY\"
                              ,msib.PRIMARY_UOM_CODE \"UOM\"
                                    FROM mtl_txn_request_headers mtrh
                                         ,mtl_txn_request_lines mtrl
                                         ,MTL_SYSTEM_ITEMS_B msib
                                         ,oe_order_headers_all ooha
                                         ,hz_parties party
                                         ,hz_cust_accounts cust_acct
                                         ,hz_locations ship_loc
                                         ,hz_cust_site_uses_all ship_su
                                         ,hz_cust_acct_sites_all ship_cas
                                         ,hz_party_sites ship_ps
                                                where mtrh.HEADER_ID(+) = mtrl.header_id
                                                and mtrl.INVENTORY_ITEM_ID = msib.INVENTORY_ITEM_ID
                                                and mtrh.ATTRIBUTE7 = ooha.ORDER_NUMBER(+)
                                                AND ooha.sold_to_org_id = cust_acct.cust_account_id(+)
                                                AND cust_acct.party_id = party.party_id(+)
                                                and ooha.ship_to_org_id = ship_su.site_use_id(+)
                                                AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                                                AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                                                AND ship_loc.location_id(+) = ship_ps.location_id
                                                and mtrh.REQUEST_NUMBER = '$noSPB'";
        $run = $oracle->query($sql);
        return $run->result_array();
        }
        
        function getInterorgTPB($noSPB) {
                $oracle = $this->load->database('oracle',true);
                $sql = "SELECT DISTINCT mtrh.ATTRIBUTE3
                          FROM mtl_txn_request_headers mtrh 
                         WHERE mtrh.REQUEST_NUMBER = '$noSPB'";
                $run = $oracle->query($sql);
                return $run->result_array();
                }

        function getSPB($noSPB) {
                $oracle = $this->load->database('oracle',true);
                $sql = "SELECT DISTINCT mtrh.REQUEST_NUMBER
                          FROM mtl_txn_request_headers mtrh 
                         WHERE mtrh.REQUEST_NUMBER = '$noSPB'";
                $run = $oracle->query($sql);
                return $run->result_array();
                }
}
