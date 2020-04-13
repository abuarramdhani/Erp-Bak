<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_monitoringpengpesananluar extends CI_Model
{
  var $oracle;
  function __construct()
  {
    parent::__construct();
    $this->load->database();
      $this->load->library('encrypt');
      // $this->oracle = $this->load->database('oracle', true);
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

    public function customer()
    {
        $db = $this->load->database();
        $sql = "select id_customer, nama_customer from om.om_mppl_customer";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function item()
    {
        $db = $this->load->database();
        $sql = "select id_kode_item id, nama_item from om.om_mppl_item";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }


    public function cariDeskripsiR($id)
    {
        $db = $this->load->database();
        $sql = "select nama_item from om.om_mppl_item where id_kode_item = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
        
    }

    public function saveJudul($id_rekap_pengiriman,$no_po,$id_cust)
    {
        $db = $this->load->database();
        $sql = "insert into om.om_mppl_count_pengiriman (id_rekap_pengiriman, no_po, id_customer) 
        values ($id_rekap_pengiriman,'$no_po','$id_cust')";
        $runQuery = $this->db->query($sql);
        echo $sql;
    }

    public function deskripsiUom($id)
    {
        $db = $this->load->database();
        $sql = "select kode_item, id_kode_item id, nama_item, uom from om.om_mppl_item where id_kode_item = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }
    public function deskripsiUomApp($id)
    {
        $db = $this->load->database();
        $sql = "select kode_item, id_kode_item id, nama_item, uom from om.om_mppl_item where id_kode_item = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function saveHeaderPo($customer,$no_po,$issuedate,$needbydate,$judulFile,$usr)
    {
        $db = $this->load->database();
        $sql = "insert into om.om_mppl_rekap_po (no_po, tanggal_issued, need_by_date, status, lampiran, id_customer, last_update_date, created_by) values ('$no_po', '$issuedate', '$needbydate', 'Open', '$judulFile', '$customer', now(), '$usr')";
        $runQuery = $this->db->query($sql);
    }

    public function getID()
    {
        $db = $this->load->database();
        $sql = "select max (id_rekap_po) id from om.om_mppl_rekap_po";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function saveLinePo($kode_item,$deskripsi,$qty_order,$uom,$id_header,$usrname)
    {
        $db = $this->load->database();
        $sql = "insert into om.om_mppl_rekap_po_line 
                (id_kode_item, 
                nama_item, 
                ordered_qty, 
                uom, 
                id_rekap_po, 
                created_by, 
                creation_date) 
                    values 
                        ('$kode_item', 
                        '$deskripsi', 
                        '$qty_order', 
                        '$uom', 
                        '$id_header', 
                        '$usrname',
                         now())";
        $runQuery = $this->db->query($sql);
    }

    public function getData()
    {
        $db = $this->load->database();
        $sql = "select distinct 
                  dvc.nama_customer,
                  dvrpo.no_po,
                  TO_CHAR(dvrpo.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
                  TO_CHAR(dvrpo.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
                  dvrpo.tanggal_issued tanggal_issued_order,
                  dvrpo.need_by_date need_by_date_order,
                  dvrpo.status,
                  dvrpo.lampiran,
                  dvrp.no_so,
                  TO_CHAR(dvrpo.last_update_date :: DATE, 'DD Mon YYYY') last_update_date ,
                  dvrpo.last_update_date,
                  dvrpo.id_rekap_po
                      from om.om_mppl_rekap_po dvrpo
                      left join om.om_mppl_customer dvc on dvc.id_customer = dvrpo.id_customer
                      left join om.om_mppl_rekap_pengiriman dvrp on dvrp.no_po = dvrpo.no_po
                      group by 
                            dvc.nama_customer,
                            dvrpo.no_po,
                            dvrpo.tanggal_issued,
                            dvrpo.need_by_date,
                            dvrpo.status,
                            dvrpo.lampiran,
                            dvrp.no_so,
                            dvrpo.last_update_date,
                            dvrpo.id_rekap_po
                                    order by dvrpo.last_update_date desc";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
      
    }

    public function insertStatusOpen($id)
    {
        $db = $this->load->database();
        $sql = "update om.om_mppl_rekap_po set status = 'Open' where id_rekap_po = $id";
        $runQuery = $this->db->query($sql);
    }

    public function cariIDPO($id)
    {
        $db = $this->load->database();
        $sql = "select distinct id_rekap_po id from om.om_mppl_rekap_pengiriman_line where id_rekap_pengiriman = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function ambilSummary($id)
    {
        $db = $this->load->database();
        $sql = "select sum(outstanding_qty) as outstanding_qty from om.om_mppl_rekap_pengiriman_line where id_rekap_pengiriman = $id";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function saveStatusPO($no_po)
    {
        $db = $this->load->database();
        $sql = "update om.om_mppl_rekap_po set status = 'Close' where no_po = '$no_po'";
        $runQuery = $this->db->query($sql);
        // echo $sql;
    }

    public function deletePo($id)
    {
        $db = $this->load->database();
        $sql = "delete from om.om_mppl_rekap_po where id_rekap_po = '$id'";
        $runQuery1 = $this->db->query($sql);
        $sql2 = "delete from om.om_mppl_rekap_po_line where id_rekap_po = '$id'";
        $runQuery2 = $this->db->query($sql2);
    }

    public function cari_Id_Peng($no_po)
    {
        $db = $this->load->database();
        $sql = "select id_rekap_pengiriman id from om.om_mppl_rekap_pengiriman where no_po = '$no_po'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function deletePeng($id)
    {
        $db = $this->load->database();
        $sql = "delete from om.om_mppl_rekap_pengiriman where id_rekap_pengiriman = '$id'";
        $runQuery1 = $this->db->query($sql);
        $sql2 = "delete from om.om_mppl_rekap_pengiriman_line where id_rekap_pengiriman = '$id'";
        $runQuery2 = $this->db->query($sql2);
        $sql3 = "delete from om.om_mppl_action_detail where id_rekap_pengiriman = '$id'";
        $runQuery3 = $this->db->query($sql3);
        $sql4 = "delete from om.om_mppl_count_pengiriman where id_rekap_pengiriman = '$id'";
        $runQuery4 = $this->db->query($sql4);
    }

    public function tarikdatamodal($id)
    {
        $db = $this->load->database();
        $sql = "select drp.id_rekap_po, 
                drp.id_kode_item, 
                de.nama_item, 
                drp.ordered_qty, 
                drp.uom, 
                de.kode_item 
                from om.om_mppl_rekap_po_line drp 
                left join om.om_mppl_item de 
                on drp.id_kode_item = de.id_kode_item 
                where drp.id_rekap_po = '$id'";
        $runQuery = $this->db->query($sql);
        return $runQuery->result_array();
    }

    public function editData($id)
    {
      $db = $this->load->database();
      $sql = "select a.no_po,
              TO_CHAR(a.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
              TO_CHAR(a.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
              a.status, 
              a.lampiran, 
              b.nama_customer,
              a.id_customer, 
              a.id_rekap_po, 
              a.last_update_date, 
              a.created_by 
                  from om.om_mppl_rekap_po a
                  left join om.om_mppl_customer b on b.id_customer = a.id_customer
                      where a.id_rekap_po ='$id'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }
   
    public function dataLine($id)
    {
       $db = $this->load->database();
       $sql = " select 
                a.id_kode_item, 
                a.ordered_qty, 
                a.id_rekap_po,
                a.uom,
                b.nama_item,
                b.kode_item
                from om.om_mppl_rekap_po_line a
                  left join om.om_mppl_item b on a.id_kode_item =  b.id_kode_item 
                where id_rekap_po = '$id'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function updateHeaderPo($customer,$no_po,$issuedate,$needbydate,$judulFile2,$usrname,$id)
    {
      $db = $this->load->database();
      $sql = "update om.om_mppl_rekap_po 
              set no_po = '$no_po', 
              tanggal_issued = '$issuedate', 
              need_by_date = '$needbydate', 
              status = 'Open', 
              lampiran = '$judulFile2', 
              id_customer = '$customer', 
              last_update_date = now(), 
              created_by = '$usrname'
              where id_rekap_po = $id";
      $runQuery = $this->db->query($sql);
    }

    public function hapusLine($id)
    {
      $db = $this->load->database();
      $sql = "delete from om.om_mppl_rekap_po_line where id_rekap_po = $id";
      $runQuery = $this->db->query($sql);
    }

    public function insertLines($kode_item,$deskripsi,$qty_order,$uom,$id,$usrname)
    {
      $db = $this->load->database();
      $sql = "insert into om.om_mppl_rekap_po_line 
                (id_kode_item, 
                nama_item, 
                ordered_qty, 
                uom, 
                id_rekap_po, 
                created_by, 
                creation_date) 
                    values 
                        ('$kode_item', 
                        '$deskripsi', 
                        '$qty_order', 
                        '$uom', 
                        '$id', 
                        '$usrname',
                         now())";
      $runQuery = $this->db->query($sql);
    }

    public function getPO($id)
    {
      $db = $this->load->database();
      $sql = "select a.no_po, 
              a.id_customer 
              from om.om_mppl_rekap_po a 
              left join om.om_mppl_rekap_pengiriman b on a.no_po = b.no_po 
              where a.id_customer = $id 
              and b.no_so is null ";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilRekapPO($no_po)
    {
      $db = $this->load->database();
      $sql = "select id_rekap_po from om.om_mppl_rekap_po where no_po = '$no_po'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilDataLines($id)
    {
      $db = $this->load->database();
      $sql = "select 
                a.id_line_rp, 
                a.id_kode_item, 
                a.ordered_qty, 
                a.id_rekap_po, 
                a.created_by, 
                a.uom, 
                b.kode_item,
                b.nama_item
                from 
                om.om_mppl_rekap_po_line a left join om.om_mppl_item b 
                on a.id_kode_item = b.id_kode_item 
                where id_rekap_po = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ekspedisi()
    {
      $db = $this->load->database();
      $sql = "select  id_ekspedisi, nama_ekspedisi from om.om_mppl_ekspedisi";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function saveIP($delivery_date,$customer,$no_po,$no_so,$no_dosp,$keterangan,$ekspedisi,$usrname)
    {
      $db = $this->load->database();
      $sql = "insert into om.om_mppl_rekap_pengiriman 
                      (no_po, 
                      delivery_date, 
                      no_so, 
                      no_dosp, 
                      keterangan, 
                      id_ekspedisi, 
                      id_customer, 
                      last_update_date, 
                      created_by)
              values ('$no_po',
                      '$delivery_date',
                      '$no_so',
                      '$no_dosp',
                      '$keterangan',
                      '$ekspedisi',
                      '$customer',
                      now(),
                      '$usrname')";
      $runQuery = $this->db->query($sql);
      echo $sql;

    }

    public function IdHeader()
    {
      $db = $this->load->database();
      $sql = "select max (id_rekap_pengiriman) id from om.om_mppl_rekap_pengiriman";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function cariRekapPo($no_po)
    {
      $db = $this->load->database();
      $sql = "select id_rekap_po id from om.om_mppl_rekap_po where no_po = '$no_po'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      echo $sql;

    }

    public function saveLineIp($kodeitem,$nama_item,$ordered,$delivered,$acc,$outpo,$uom,$idHeaderYa,$idNomerRekap,$usr)
    {
      $db = $this->load->database();
      $sql = "insert into om.om_mppl_rekap_pengiriman_line 
                        (kode_item, 
                        id_rekap_pengiriman, 
                        delivered_qty, 
                        accumulation, 
                        outstanding_qty, 
                        created_by, 
                        creation_date, 
                        id_rekap_po,
                        nama_item,
                        uom,
                        ordered_qty)
                    values ('$kodeitem',
                        '$idHeaderYa',
                        '$delivered',
                        '$acc',
                        '$outpo',
                        '$usr',
                        now(),
                        '$idNomerRekap',
                        '$nama_item',
                        '$uom',
                        '$ordered')";
      $runQuery = $this->db->query($sql);
      $sql1 = "select id_line_rp from om.om_mppl_rekap_pengiriman_line where id_rekap_pengiriman = '$idHeaderYa'";
      $runQuery1 = $this->db->query($sql1);
      return $runQuery1->result_array();
      // echo $sql;
    }

    public function getEntry($id)
    {

      $db = $this->load->database();
      $sql = "select max(entry)+1 as entry from om.om_mppl_action_detail where id_rekap_pengiriman = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      
    }

    public function getEntry2($id)
    {

      $db = $this->load->database();
      $sql = "select max(entry) as entry from om.om_mppl_action_detail where id_rekap_pengiriman = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      
    }

    public function saveActionDetail($delivery_date, $kodeitem, $delivered_qty, $no_po, $id_rekap_pengiriman, $uom, $ordered_qty, $nama_item, $accumulation, $outstanding_qty, $no_so, $no_dosp, $keterangan, $id_ekspedisi,$id_line_rp)
    {
      $db = $this->load->database();
      $sql = "insert into om.om_mppl_action_detail (delivery_date, kode_item, delivered_qty, no_po, id_rekap_pengiriman, uom, ordered_qty, nama_item, accumulation, outstanding_qty, no_so, no_dosp, keterangan, id_ekspedisi, entry, id_line_rp) 
              values ('$delivery_date', '$kodeitem', '$delivered_qty', '$no_po', '$id_rekap_pengiriman', '$uom', $ordered_qty, '$nama_item', $accumulation, $outstanding_qty, '$no_so', '$no_dosp', '$keterangan', '$id_ekspedisi', 1,'$id_line_rp')";
      $runQuery = $this->db->query($sql);
      echo $sql;
    }

    public function saveActionDetail2($delivery_date,$kodeitem, $delivered_qty, $no_po, $id_rekap_pengiriman, $uom, $ordered_qty, $nama_item, $accumulation, $outstanding_qty, $no_so, $no_dosp, $keterangan, $id_ekspedisi,$id_line_rp,$entry)
    {
      $db = $this->load->database();
      $sql = "insert into om.om_mppl_action_detail (delivery_date, kode_item, delivered_qty, no_po, id_rekap_pengiriman, uom, ordered_qty, nama_item, accumulation, outstanding_qty, no_so, no_dosp, keterangan, id_ekspedisi, entry, id_line_rp) 
              values ('$delivery_date', '$kodeitem', '$delivered_qty', '$no_po', '$id_rekap_pengiriman', '$uom', $ordered_qty, '$nama_item', $accumulation, $outstanding_qty, '$no_so', '$no_dosp', '$keterangan', '$id_ekspedisi', '$entry','$id_line_rp')";
      $runQuery = $this->db->query($sql);
      echo $sql;
    }


    public function UpdateActionDetail($delivery_date,$kodeitem, $delivered_qty, $no_po, $id_rekap_pengiriman, $uom, $ordered_qty, $nama_item, $accumulation, $outstanding_qty, $no_so, $no_dosp, $keterangan, $id_ekspedisi,$entry,$id_action)
    {
      $db = $this->load->database();
      $sql = "update om.om_mppl_action_detail set 
              delivery_date = '$delivery_date',
              kode_item = '$kodeitem', 
              delivered_qty = '$delivered_qty', 
              no_po = '$no_po', 
              uom = '$uom', 
              ordered_qty = '$ordered_qty',
              nama_item = '$nama_item', 
              accumulation = '$accumulation', 
              outstanding_qty = '$outstanding_qty', 
              no_so = '$no_so', 
              no_dosp = '$no_dosp', 
              keterangan = '$keterangan', 
              id_ekspedisi = '$id_ekspedisi', 
              entry = '$entry'
              where id_rekap_pengiriman = '$id_rekap_pengiriman' 
              and no_po = '$no_po' 
              and no_so = '$no_so' 
              and no_dosp = '$no_dosp' 
              and id_action_detail = '$id_action'";
      $runQuery = $this->db->query($sql);
      echo $sql;
    }

    public function UpdateHeaderIp($no_dosp,$no_so,$keterangan,$id_ekspedisi,$delivery_date,$id_rekap_pengiriman)
    {
      $db = $this->load->database();
      $sql = "update om.om_mppl_rekap_pengiriman
              set 
              no_dosp = '$no_dosp',
              no_so = '$no_so',
              keterangan = '$keterangan',
              id_ekspedisi = '$id_ekspedisi',
              delivery_date = '$delivery_date'
              where id_rekap_pengiriman = $id_rekap_pengiriman
              ";
      $runQuery = $this->db->query($sql);
    }

    public function UpdateLineIp($kodeitem,$nama_item,$ordered,$delivered,$acc,$outpo,$uom,$idLine)
    {
      $db = $this->load->database();
      $sql = "update om.om_mppl_rekap_pengiriman_line 
              set 
              kode_item = '$kodeitem',
              nama_item = '$nama_item',
              ordered_qty = '$ordered',
              delivered_qty = '$delivered',
              accumulation = '$acc',
              outstanding_qty = '$outpo',
              uom = '$uom'
              where id_line_rp = $idLine
              ";
      $runQuery = $this->db->query($sql);
      // echo $sql;
      
    }

    public function startCounting($id)
    {
      $db = $this->load->database();
      $sql = "select count(no_po) as count from om.om_mppl_count_pengiriman where id_rekap_pengiriman = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

      public function startCountingTmbh($id)
    {
      $db = $this->load->database();
      $sql = "select count(no_po)+1 as count from om.om_mppl_count_pengiriman where id_rekap_pengiriman = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

     public function startCountingDsh($id)
    {
      $db = $this->load->database();
      $sql = "select count(no_po) as count, no_po from om.om_mppl_count_pengiriman where id_rekap_pengiriman = $id
      group by no_po";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function pengiriman($id)
    {
      $db = $this->load->database();
      $sql = "select sum(delivered_qty) from om.om_mppl_rekap_pengiriman_line where id_rekap_po = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function getHistory($id)
    {
      $db = $this->load->database();
      $sql = "select 
              TO_CHAR(a.delivery_date :: DATE, 'DD Mon YYYY') delivery_date,
              a.kode_item, 
              a.delivered_qty, 
              a.no_po, 
              a.id_rekap_pengiriman, 
              a.uom, 
              a.ordered_qty, 
              a.nama_item, 
              a.accumulation,
              a.outstanding_qty,
              a.no_so,
              a.no_dosp,
              a.keterangan, 
              a.id_ekspedisi,
              a.entry,
              b.nama_ekspedisi
              from om.om_mppl_action_detail a
              left join om.om_mppl_ekspedisi b on b.id_ekspedisi = a.id_ekspedisi
              where a.id_rekap_pengiriman = $id
              order by a.entry";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function tarikdataExcel($parameter)
    {
      $db = $this->load->database();
      $sql = "select dc.nama_customer, 
              dpo.id_customer, 
              dpo.no_po, 
              TO_CHAR(dpo.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
              TO_CHAR(dpo.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
              di.kode_item,
              di.nama_item,
              dpl.ordered_qty, 
              dpl.uom, 
              dpo.status 
                  from om.om_mppl_rekap_po dpo
                       ,om.om_mppl_rekap_po_line dpl
                       ,om.om_mppl_item di
                       ,om.om_mppl_customer dc
                  where dpo.id_rekap_po = dpl.id_rekap_po
                  and dpl.id_kode_item = di.id_kode_item 
                  and dpo.id_customer = dc.id_customer
                  $parameter
                  order by dpo.id_customer, dpo.no_po, dpo.tanggal_issued
              ";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function tarikdataExcelPeng($parameter)
    {
      $db = $this->load->database();
      $sql = "select 
a.entry,
d.nama_customer,
c.no_po,
TO_CHAR(e.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
TO_CHAR(e.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
              TO_CHAR(a.delivery_date :: DATE, 'DD Mon YYYY') delivery_date,
              b.nama_ekspedisi,
              a.no_so,
              a.no_dosp,
              a.keterangan,
              a.kode_item, 
              a.nama_item, 
              a.ordered_qty, 
              a.uom, 
              a.delivered_qty,
              a.accumulation,
              a.outstanding_qty
from om.om_mppl_action_detail a
left join om.om_mppl_ekspedisi b on b.id_ekspedisi = a.id_ekspedisi
left join om.om_mppl_rekap_pengiriman c on c.id_rekap_pengiriman = a.id_rekap_pengiriman
left join om.om_mppl_customer d on d.id_customer = c.id_customer
left join om.om_mppl_rekap_po e on e.no_po = a.no_po
$parameter
              order by c.no_po,a.delivery_date, a.kode_item";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilDataPengiriman()
    {
      $db = $this->load->database();
      $sql = "select distinct
              dc.nama_customer,
              (select max(dad.entry) from om.om_mppl_action_detail dad where dad.no_po = drp.no_po) entry,
              drp.no_po, 
              TO_CHAR(drpo.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
              TO_CHAR(drpo.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
              TO_CHAR(drp.delivery_date :: DATE, 'DD Mon YYYY') delivery_date,
              drpo.tanggal_issued tanggal_issued_order,
              drpo.need_by_date need_by_date_order,
              drp.delivery_date delivery_date_order,
              drpo.status,
              drp.no_so, 
              drp.no_dosp, 
              drp.keterangan,
              de.nama_ekspedisi,
              drp.id_rekap_pengiriman,
              drp.last_update_date,
              (select count(dcp.no_po) from om.om_mppl_count_pengiriman dcp where dcp.no_po = drp.no_po) count
              from om.om_mppl_rekap_pengiriman drp
              left join om.om_mppl_rekap_po drpo on drpo.no_po = drp.no_po
              left join om.om_mppl_customer dc on dc.id_customer = drp.id_customer
              left join om.om_mppl_ekspedisi de on de.id_ekspedisi = drp.id_ekspedisi
              left join om.om_mppl_action_detail dad on dad.id_rekap_pengiriman = drp.id_rekap_pengiriman
        group by dc.nama_customer,
              drp.no_po, 
              drpo.tanggal_issued, 
              drpo.need_by_date, 
              drp.delivery_date, 
              drp.no_so, 
              drp.no_dosp, 
              drp.keterangan,
              de.nama_ekspedisi,
              drp.id_rekap_pengiriman,
              drp.last_update_date,
              dad.entry,
              drpo.status
              order by last_update_date desc
              ";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilDataHistory()
    {
      $db = $this->load->database();
      $sql = "select distinct
              dc.nama_customer,
              (select max(dad.entry) from om.om_mppl_action_detail dad where dad.no_po = drp.no_po) entry,
              drp.no_po, 
              TO_CHAR(drpo.tanggal_issued :: DATE, 'DD Mon YYYY') tanggal_issued,
              TO_CHAR(drpo.need_by_date :: DATE, 'DD Mon YYYY') need_by_date,
              drpo.status, 
              TO_CHAR(drp.delivery_date :: DATE, 'DD Mon YYYY') delivery_date,
              drpo.tanggal_issued tanggal_issued_order,
              drpo.need_by_date need_by_date_order,
              drp.delivery_date delivery_date_order,
              drp.no_so, 
              drp.no_dosp, 
              drp.keterangan,
              de.nama_ekspedisi,
              drp.id_rekap_pengiriman,
              (select count(dcp.no_po) from om.om_mppl_count_pengiriman dcp where dcp.no_po = drp.no_po) count
              from om.om_mppl_rekap_pengiriman drp
              left join om.om_mppl_rekap_po drpo on drpo.no_po = drp.no_po
              left join om.om_mppl_customer dc on dc.id_customer = drp.id_customer
              left join om.om_mppl_ekspedisi de on de.id_ekspedisi = drp.id_ekspedisi
              left join om.om_mppl_action_detail dad on dad.id_rekap_pengiriman = drp.id_rekap_pengiriman
        group by dc.nama_customer,
              drp.no_po, 
              drpo.tanggal_issued, 
              drpo.need_by_date, 
              drp.delivery_date, 
              drp.no_so, 
              drp.no_dosp, 
              drp.keterangan,
              de.nama_ekspedisi,
              drp.id_rekap_pengiriman,
              dad.entry,
              drpo.status
        order by delivery_date desc
              ";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function getDataDetail($id_rekap_pengiriman)
    {
      $db = $this->load->database();
      $sql ="select kode_item, 
              nama_item, 
              ordered_qty, 
              uom, 
              delivered_qty, 
              accumulation, 
              outstanding_qty,
              id_rekap_pengiriman 
              from om.om_mppl_rekap_pengiriman_line 
              where id_rekap_pengiriman = $id_rekap_pengiriman
              order by delivered_qty desc";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function headerPengiriman($id)
    {
      $db = $this->load->database();
      $sql ="select 
              id_customer, 
              id_rekap_pengiriman, 
              no_po, 
              no_so, 
              no_dosp, 
              keterangan, 
              id_ekspedisi,
              TO_CHAR(delivery_date :: DATE, 'DD Mon YYYY') delivery_date
              from om.om_mppl_rekap_pengiriman where id_rekap_pengiriman = $id";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      
    }

    public function getDataLinePeng($id,$entry)
    {
      $db = $this->load->database();
      $sql ="select 
            kode_item, 
            delivered_qty, 
            no_po, 
            id_rekap_pengiriman, 
            uom, 
            ordered_qty, 
            nama_item, 
            accumulation,
            id_line_rp,
            outstanding_qty,
            id_action_detail
            from om.om_mppl_action_detail where id_rekap_pengiriman = $id and entry = $entry";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
      
    }

    public function getPO2()
    {
      $db = $this->load->database();
      $sql ="select distinct no_po from om.om_mppl_rekap_pengiriman";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilListItem()
    {
      $db = $this->load->database();
      $sql ="select nama_item, uom, id_kode_item, kode_item from om.om_mppl_item";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilListEkspedisi()
    {
      $db = $this->load->database();
      $sql ="select id_ekspedisi, nama_ekspedisi from om.om_mppl_ekspedisi";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    public function ambilListCustomer()
    {
      $db = $this->load->database();
      $sql ="select id_customer, nama_customer from om.om_mppl_customer";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
    }

    // function setting is here 

    public function saveSetItem($kode_item,$nama_item,$uom)
    {
      $db = $this->load->database();
      $sql ="insert into om.om_mppl_item (kode_item, nama_item, uom) values ('$kode_item','$nama_item','$uom')";
      $runQuery = $this->db->query($sql);
    }

    public function saveSetCustomer($nama_customer)
    {
      $db = $this->load->database();
      $sql ="insert into om.om_mppl_customer (nama_customer) values ('$nama_customer')";
      $runQuery = $this->db->query($sql);
    }

    public function saveSetEkspedisi($nama_ekspedisi)
    {
      $db = $this->load->database();
      $sql ="insert into om.om_mppl_ekspedisi (nama_ekspedisi) values ('$nama_ekspedisi')";
      $runQuery = $this->db->query($sql);
    }

    public function deleteItem($id_kode_item)
    {
      $db = $this->load->database();
      $sql ="delete from om.om_mppl_item where id_kode_item = '$id_kode_item'";
      $runQuery = $this->db->query($sql);
    }

    public function deleteEkspedisi($id_ekspedisi)
    {
      $db = $this->load->database();
      $sql ="delete from om.om_mppl_ekspedisi where id_ekspedisi = '$id_ekspedisi'";
      $runQuery = $this->db->query($sql);
    }

    public function deleteCustomer($id_customer)
    {
      $db = $this->load->database();
      $sql ="delete from om.om_mppl_customer where id_customer = '$id_customer'";
      $runQuery = $this->db->query($sql);
    }

   public function ambilDataItem($id_kode_item)
   {
      $db = $this->load->database();
      $sql ="select nama_item, uom, id_kode_item, kode_item from om.om_mppl_item where id_kode_item = '$id_kode_item'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
   }

   public function ambilDataCustomer($id_customer)
   {
      $db = $this->load->database();
      $sql ="select id_customer, nama_customer from om.om_mppl_customer where id_customer = '$id_customer'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
   }

   public function ambilDataEkspedisi($id_ekspedisi)
   {
      $db = $this->load->database();
      $sql ="select id_ekspedisi, nama_ekspedisi from om.om_mppl_ekspedisi where id_ekspedisi = '$id_ekspedisi'";
      $runQuery = $this->db->query($sql);
      return $runQuery->result_array();
   }

   public function UpdateItem($id,$kode_item,$nama_item,$uom)
   {
      $db = $this->load->database();
      $sql =" update om.om_mppl_item 
              set
              kode_item = '$kode_item',
              nama_item = '$nama_item',
              uom = '$uom'
              where id_kode_item = '$id'";
      $runQuery = $this->db->query($sql);
   }

   public function UpdateEkspedisi($id,$nama)
   {
      $db = $this->load->database();
      $sql =" update om.om_mppl_ekspedisi
              set
              nama_ekspedisi = '$nama'
              where id_ekspedisi = '$id'";
      $runQuery = $this->db->query($sql);
   }

   public function UpdateCustomer($id,$nama)
   {
      $db = $this->load->database();
      $sql =" update om.om_mppl_customer
              set
              nama_customer = '$nama'
              where id_customer = '$id'";
      $runQuery = $this->db->query($sql);
   }

}

?>