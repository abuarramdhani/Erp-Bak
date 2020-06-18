<?php
class M_trackingpengirimanbarang extends CI_Model {
  public function __construct()
  {
    $this->load->database();
    $this->load->library('encrypt');
  }
  public function checkSourceLogin($employee_code)
    {
        $db = $this->load->database();
        $sql = "select eea.employee_code, es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$employee_code' ";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }


    public function cekSource($nomor_ind)
    {
        $db = $this->load->database();
        $sql = "select 
                eea.employee_code, 
                eea.employee_name, 
                es.section_name
                    from er.er_employee_all eea, er.er_section es
                    where eea.section_code = es.section_code
                    and eea.employee_code = '$nomor_ind'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function filterUser($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select username from tp_login where username = '$id_login'";
        $runQuery = $db->query($sql);
        return $runQuery->num_rows();
        // return $runQuery->result_array();
    }
    public function addKacab($nomor_induk,$nama_kacab,$section_name,$status,$alamat_cabang,$password)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "insert into tp_login 
                    (nik, 
                    nama_pekerja, 
                    username, 
                    password, 
                    last_update_date, 
                    kacab, 
                    alamat_cabang,
                    section_name)
                values 
                    ('$nomor_induk',
                    '$nama_kacab',
                    '$nomor_induk',
                    '$password', 
                    now(), 
                    '$status', 
                    '$alamat_cabang',
                    '$section_name')";
        $runQuery = $db->query($sql);
    }

    public function getKacabData()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select id_login, nik, username, nama_pekerja, last_update_date, kacab, alamat_cabang, section_name from tp_login";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function deleteKacab($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "delete from tp_login where id_login = '$id_login'";
        $runQuery = $db->query($sql);
    }

    public function DiactivatedUser($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tp_login set kacab = 'N' where id_login = '$id_login'";
        $runQuery = $db->query($sql);
    }

    public function activatedUser($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tp_login set kacab = 'Y' where id_login = '$id_login'";
        $runQuery = $db->query($sql);
    }

    public function getSPBDetail($id)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "
          SELECT distinct
                mtrh.REQUEST_NUMBER NO_SPB
                ,mtrh.ATTRIBUTE7 SO 
                ,party.PARTY_NAME CUST 
                ,case when ship_loc.address1 is null
                 then mtrh.TO_SUBINVENTORY_CODE ||' ('|| mtrh.ATTRIBUTE4
                 else ship_loc.address1
                 end ALAMAT 
                ,msib.SEGMENT1 KODE_ITEM 
                ,msib.DESCRIPTION NAMA_ITEM 
                ,mtrl.quantity QTY 
                ,msib.PRIMARY_UOM_CODE UOM 
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
                        and mtrh.REQUEST_NUMBER = '$id'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function ambilDataDetailProses($id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "SELECT 
                m.no_spb NO_SPB, 
                m.so SO,
                m.cust CUST,
                m.alamat ALAMAT, 
                m.kode_item KODE_ITEM, 
                m.nama_item NAMA_ITEM,
                m.qty QTY,
                m.uom UOM, 
                m.confirmation_status CON_ID, 
                m.line_id LINE_ID, 
                n.confirmation CON_HEAD, 
                n.note NOTE
                from tpb_spb m
                left join tpb n on n.no_SPB = m.no_spb
                where m.no_spb = '$id'";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }


    public function ambilDataconfirmation_status($id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "SELECT 
                no_spb NO_SPB, 
                so SO,
                cust CUST,
                alamat ALAMAT, 
                kode_item KODE_ITEM,
                nama_item NAMA_ITEM,
                qty QTY,
                uom UOM,
                line_id LINE_ID
                from tpb_spb
                where no_spb = '$id'";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function countN($id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select count(confirmation_status)count_N from tpb_spb where no_spb = '$id' and confirmation_status = 'N'";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function countY($id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select count(confirmation_status)count_Y from tpb_spb where no_spb = '$id' and confirmation_status = 'Y'";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function saveStatusHeader($headerStatus,$note,$no_spb)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tpb 
                set confirmation_status = '$headerStatus',
                note = '$note'
                where no_spb = $no_spb";
        $runQuery = $db->query($sql);
    }

    public function saveStatusLine($arry,$line_id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tpb_spb 
                set confirmation_status = '$arry'
                where line_id = $line_id";
        $runQuery = $db->query($sql);
    }

    public function selectHeader($id)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "
          SELECT distinct
                 mtrh.REQUEST_NUMBER NO_SPB
                ,mtrh.ATTRIBUTE7 SO
                ,party.PARTY_NAME CUST
                ,ship_loc.address1 ALAMAT
                -- ,msib.SEGMENT1 KODE_ITEM
                -- ,msib.DESCRIPTION NAMA_ITEM
                -- ,mtrl.quantity QTY
                -- ,msib.PRIMARY_UOM_CODE UOM
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
                        and mtrh.ATTRIBUTE7 = ooha.ORDER_NUMBER
                        AND ooha.sold_to_org_id = cust_acct.cust_account_id(+)
                        AND cust_acct.party_id = party.party_id(+)
                        and ooha.ship_to_org_id = ship_su.site_use_id(+)
                        AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                        AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                        AND ship_loc.location_id(+) = ship_ps.location_id
                        and mtrh.REQUEST_NUMBER = '$id'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function selectLines($id)
    {
        $oracle = $this->load->database('oracle',true);
        $sql = "
          SELECT distinct
                -- mtrh.REQUEST_NUMBER NO_SPB
                -- ,mtrh.ATTRIBUTE7 SO
                -- ,party.PARTY_NAME CUST
                -- ,ship_loc.address1 ALAMAT
                 msib.SEGMENT1 KODE_ITEM
                ,msib.DESCRIPTION NAMA_ITEM
                ,mtrl.quantity QTY
                ,msib.PRIMARY_UOM_CODE UOM
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
                        and mtrh.ATTRIBUTE7 = ooha.ORDER_NUMBER
                        AND ooha.sold_to_org_id = cust_acct.cust_account_id(+)
                        AND cust_acct.party_id = party.party_id(+)
                        and ooha.ship_to_org_id = ship_su.site_use_id(+)
                        AND ship_su.cust_acct_site_id = ship_cas.cust_acct_site_id(+)
                        AND ship_cas.party_site_id = ship_ps.party_site_id(+)
                        AND ship_loc.location_id(+) = ship_ps.location_id
                        and mtrh.REQUEST_NUMBER = '$id'";
        $run = $oracle->query($sql);
        return $run->result_array();
    }

    public function onSorting()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select distinct
                tpb.no_spb,
                tpb.nama_pekerja,
                tpb.kendaraan,
                tpb.status,
                tpb.confirmed_by,
                tpl.username,
                tpb.last_update_date,
                tpb.start_date,
                tpb.end_date
                from tpb tpb
                left join tp_login tpl on tpb.nama_pekerja = tpl.nama_pekerja
                where status = 'onSorting'
                order by tpb.last_update_date desc";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

     public function onProcess()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select distinct
                tpb.no_spb,
                tpb.nama_pekerja,
                tpb.kendaraan,
                tpb.status,
                tpb.confirmed_by penerima,
                tpl.username,
                tpb.last_update_date,
                tpb.confirmation
                from tpb tpb
                left join tp_login tpl on tpb.nama_pekerja = tpl.nama_pekerja
                where status = 'onProcess'
                order by tpb.last_update_date desc";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

     public function onFinish()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select distinct
                tpb.no_spb,
                tpb.nama_pekerja,
                tpb.kendaraan,
                tpb.status,
                tpb.confirmed_by penerima,
                tpl.username,
                tpb.last_update_date,
                tpb.start_date,
                tpb.end_date,
                tpb.confirmation
                from tpb tpb
                left join tp_login tpl on tpb.nama_pekerja = tpl.nama_pekerja
                where status = 'onFinish'
                order by tpb.end_date desc";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function insertDataSetup($id_pekerja,$nama_pekerja,$jk,$nomer_kendaraan)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "insert into tp_login
                        (nik,
                        nama_pekerja,
                        username,
                        password,
                        kendaraan,
                        nomor_kendaraan,
                        last_update_date)
                values ('$id_pekerja',
                        '$nama_pekerja',
                        '$id_pekerja',
                        '123456',
                        '$jk',
                        '$nomer_kendaraan',
                         now())";
        $runQuery = $db->query($sql);
    }

    public function getKendaraan()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select id_kendaraan, nomor_kendaraan, kendaraan from tp_kendaraan";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function selectNoJK($id_jk)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "select id_kendaraan, nomor_kendaraan, kendaraan from tp_kendaraan where id_kendaraan = $id_jk";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function getTPBLogin()
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = " select id_login,concat (nik ,' - ', nama_pekerja) nama_pekerja, concat (kendaraan,' - ', nomor_kendaraan) kendaraan from tp_login";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function deleteUser($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "delete from tp_login where id_login = '$id_login'";
        $runQuery = $db->query($sql);
    }

    public function getData($id_login)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = " select id_login, section_name, kacab, nik, username, nama_pekerja, kendaraan, nomor_kendaraan, alamat_cabang from tp_login where id_login = '$id_login'";
        $runQuery = $db->query($sql);
        return $runQuery->result_array();
    }

    public function updateDataKacab($id_login,$nama_kacab,$alamat_cabang,$status,$section_name,$nomor_induk)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tp_login
                set username = '$nomor_induk',
                    nama_pekerja='$nama_kacab',
                    nik ='$nomor_induk',
                    kacab ='$status',
                    last_update_date = now(),
                    section_name='$section_name',
                    alamat_cabang = '$alamat_cabang'
                where id_login = $id_login";
        $runQuery = $db->query($sql);
    }

    public function updateData($id_login,$nama_pekerja,$kendaraan,$no_kendaraan,$username)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "update tp_login
                set nik = '$username',
                    nama_pekerja='$nama_pekerja',
                    username='$username',
                    kendaraan='$kendaraan',
                    last_update_date = now(),
                    nomor_kendaraan='$no_kendaraan'
                where id_login = $id_login";
        $runQuery = $db->query($sql);
    }

    public function tambahOptionJK($kendaraan,$no_kendaraan)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "insert tp_kendaraan (kendaraan, nomor_kendaraan) values ('$kendaraan','$no_kendaraan')";
        $runQuery = $db->query($sql);
    }

    public function delSPB($id)
    {
        $db = $this->load->database('tpb_sql', true);
        $sql = "delete from tpb where no_SPB = $id and status = 'onFinish'";
        $runQuery = $db->query($sql);
    }


    function getLocation($no_spb)
    {
      $db = $this->load->database('tpb_sql', true);
      $query = "SELECT tpp.id_login, tpp.long, tpp.lat FROM
                  tpb t left join tp_login tpl
                  on t.nama_pekerja = tpl.nama_pekerja
                  right join tp_position tpp
                  on tpl.id_login = tpp.id_login
                  where t.no_spb = '$no_spb'";
      return $db->query($query)->result_array();
    }

}
