<?php
class M_master extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    public function getSeksi($value)
    {
      return $this->personalia->query("select distinct b.seksi, substring(b.kodesie, 1, 7) kodesie
      from hrd_khs.tpribadi a
      left join hrd_khs.tseksi b on a.kodesie = b.kodesie
      where b.seksi is not null
      and substr(b.seksi,1,1) not in ('*','-')
      and b.seksi like '%$value%'")->result_array();
      // $res = $this->personalia->query("select distinct b.seksi
      // from hrd_khs.tpribadi a
      // left join hrd_khs.tseksi b on a.kodesie = b.kodesie
      // where b.seksi is not null
      // and substr(b.seksi,1,1) not in ('*','-')
      // and a.noind = '$value'")->row_array();
      // return $res['seksi'];
    }

    public function updatepicvoip($value)
    {
      $this->oracle->where('KODESIE', $value['kodesie'])->update('KHS_CSM_SEKSI', ['PIC'=>explode(' - ', $value['pic'])[1],'VOIP'=>$value['voip']]);
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function employee($data, $kodesie)
    {
        $sql = "select noind, nama from hrd_khs.tpribadi where kodesie like '$kodesie%' and keluar = 'f'
                and (noind like '%$data%'
              	or nama like '%$data%')
              order by 1";
        $response = $this->personalia->query($sql)->result_array();
        return $response;
    }

    public function getItem($value)
    {
      return $this->oracle->query("SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                                   msib.postprocessing_lead_time
                                 + msib.preprocessing_lead_time
                                 + msib.full_lead_time leadtime,
                                 NVL (msib.minimum_order_quantity, 0) moq,
                                 NVL (msib.min_minmax_quantity, 0) min_stock,
                                 NVL (msib.max_minmax_quantity, 0) max_stock
                            FROM mtl_system_items_b msib
                            WHERE msib.organization_id = 81 AND (msib.segment1 like '%$value%'or msib.description like '%$value%')
                            ORDER BY msib.segment1 ASC")->result_array();
    }

    public function getitempengajuan($value='')
    {
      return $this->oracle->query("SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                                   msib.postprocessing_lead_time
                                 + msib.preprocessing_lead_time
                                 + msib.full_lead_time leadtime,
                                 NVL (msib.minimum_order_quantity, 0) moq,
                                 NVL (msib.min_minmax_quantity, 0) min_stock,
                                 NVL (msib.max_minmax_quantity, 0) max_stock,
                                 kcis.pengajuan_date
                            FROM mtl_system_items_b msib, KHS_CSM_ITEM_SEKSI kcis
                            WHERE msib.organization_id = 81
                            AND msib.inventory_item_id = kcis.item_id
                            AND kcis.status = 1
                            AND (msib.segment1 like '%$value%'or msib.description like '%$value%')
                            ORDER BY msib.segment1 ASC")->result_array();
    }

    public function getItemKebutuhan($value)
    {
      return $this->oracle->query("SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                                   msib.postprocessing_lead_time
                                 + msib.preprocessing_lead_time
                                 + msib.full_lead_time leadtime,
                                 NVL (msib.minimum_order_quantity, 0) moq,
                                 NVL (msib.min_minmax_quantity, 0) min_stock,
                                 NVL (msib.max_minmax_quantity, 0) max_stock
                            FROM mtl_system_items_b msib,
                                 KHS_CSM_ITEM kci
                            WHERE msib.organization_id = 81
                            AND msib.inventory_item_id = kci.item_id
                            AND (msib.segment1 like '%$value%'or msib.description like '%$value%')
                            ORDER BY msib.segment1 ASC")->result_array();
    }

    public function savekebutuhan($post)
    {
      foreach ($post['item_id'] as $key => $value) {
        $cek = $this->oracle->where('ITEM_ID', $value)->where('STATUS', 0)->get('KHS_CSM_ITEM_SEKSI')->result_array();
        if (sizeof($cek)) {
            return [
            'status' => 'wesono',
            'message' => 'Item '.$post['item_code'][$key].' telah ada di database, hapus item tersebut lalu save lagi.'
          ];
        }
      }
      $noind = $this->session->user;
      $kodesie = $this->personalia->query("SELECT substring(kodesie, 1, 7) kodesie from hrd_khs.tpribadi where noind = '$noind'")->row_array();
      $kodesie = $kodesie['kodesie'];
      foreach ($post['item_id'] as $key => $value) {
        $this->oracle->query("INSERT INTO KHS_CSM_ITEM_SEKSI
                              (KODESIE, ITEM_ID, PENGAJUAN_DATE, PENGAJUAN_BY, STATUS)
                              VALUES ('$kodesie',
                                      '$value',
                                      SYSDATE,
                                      '$noind',
                                      0
                                    )");
      }
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function savepengajuankeb($post)
    {
      foreach ($post['item_id'] as $key => $value) {
        $cek = $this->oracle->where('ITEM_ID', $value)->where('STATUS', 0)->get('KHS_CSM_KEBUTUHAN')->result_array();
        if (sizeof($cek)) {
            return [
            'status' => 'wesono',
            'message' => 'Item '.$post['item_code'][$key].' telah di setujui, hapus item tersebut lalu save lagi.'
          ];
        }
      }
      $noind = $this->session->user;
      $kodesie = $this->personalia->query("SELECT substring(kodesie, 1, 7) kodesie from hrd_khs.tpribadi where noind = '$noind'")->row_array();
      $kodesie = $kodesie['kodesie'];
      foreach ($post['item_id'] as $key => $value) {
        $this->oracle->query("INSERT INTO KHS_CSM_KEBUTUHAN
                              (KODESIE, ITEM_ID, REQ_QUANTITY, CREATION_DATE, CREATED_BY, STATUS)
                              VALUES ('$kodesie',
                                      '$value',
                                      '{$post['qty_kebutuhan'][$key]}',
                                      SYSDATE,
                                      '$noind',
                                      0
                                    )");
      }
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function cekmasteritem($post)
    {
      return $this->oracle->where('ITEM_ID', $post)->get('KHS_CSM_ITEM')->result_array();
    }

    public function savemasteritem($post)
    {
      $noind = $this->session->user;
      foreach ($post['item_id'] as $key => $value) {
        $this->oracle->query("INSERT INTO KHS_CSM_ITEM
                              (ITEM_ID, CREATION_DATE, CREATED_BY)
                              VALUES ('$value',
                                       SYSDATE,
                                       '$noind'
                                    )");
      }
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function delkebutuhan($id)
    {
      $this->oracle->query("DELETE FROM KHS_CSM_ITEM_SEKSI WHERE item_id = $id");
      if ($this->oracle->affected_rows()) {
        $c = 'done';
      }else {
        $c= 500;
      }
      return $c;
    }

    public function delpengajuan($id)
    {
      $this->oracle->query("DELETE FROM KHS_CSM_KEBUTUHAN WHERE item_id = $id");
      if ($this->oracle->affected_rows()) {
        $c = 'done';
      }else {
        $c= 500;
      }
      return $c;
    }

    // public function employee($data)
  	// {
  	// 		$sql = "SELECT
  	// 						employee_code,
  	// 						employee_name
  	// 					from
  	// 						er.er_employee_all
  	// 					where
  	// 						resign = '0'
  	// 						and (employee_code like '%$data%'
  	// 						or employee_name like '%$data%')
  	// 					order by
  	// 						1";
  	// 		$response = $this->db->query($sql)->result_array();
  	// 		return $response;
  	// }

  	public function selectKebutuhan($data)
  	{
  		$val = strtoupper($data['search']['value']);
  			$res = $this->oracle
  					->query(
  							"SELECT kdav.*
  							FROM
  									(
  									SELECT
  													skdav.*,
  													ROW_NUMBER () OVER (ORDER BY pengajuan_date DESC) as pagination
  											FROM
  													(
                              SELECT kck.*, TO_CHAR(kck.pengajuan_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                              FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
                              WHERE kck.item_id = msib.inventory_item_id
                              AND msib.organization_id = 81
                              AND (
                                msib.segment1 LIKE '%$val%'
                                OR msib.description LIKE '%$val%'
                                OR kck.pengajuan_date LIKE '%$val%'
                                OR kck.pengajuan_by LIKE '%$val%'
                              )
  													) skdav
  									) kdav
  							WHERE
  									pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
  					)->result_array();
        foreach ($res as $key => $value) {
          $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[PENGAJUAN_BY]'")->row_array();
          $res[$key]['NAMA'] = $get_nama['nama'];
        }
  			return $res;
  	}

  	public function countAllKebutuhan()
  	{
  		return $this->oracle->query(
  			"SELECT
  					COUNT(*) AS \"count\"
  			FROM
  			(SELECT kck.*, msib.segment1, msib.description
        FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
        WHERE kck.item_id = msib.inventory_item_id
        AND msib.organization_id = 81) bla"
  			)->row_array();
  	}

  	public function countFilteredKebutuhan($data)
  	{
  		$val = strtoupper($data['search']['value']);
  		return $this->oracle->query(
  			"SELECT
  						COUNT(*) AS \"count\"
  					FROM
            (
              SELECT kck.*, msib.segment1, msib.description
              FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
              WHERE kck.item_id = msib.inventory_item_id
              AND msib.organization_id = 81
              AND (
                msib.segment1 LIKE '%$val%'
                OR msib.description LIKE '%$val%'
                OR kck.pengajuan_date LIKE '%$val%'
                OR kck.pengajuan_by LIKE '%$val%'
              )
          ) bla"
  			)->row_array();
  	}

    public function ambillistapprove($value='')
    {
      // $kck = $this->oracle->query("select distinct kodesie, count(*) jumlah from KHS_CSM_KEBUTUHAN where status = 0 group by kodesie")->result_array();
      // $data = [];
      // if (empty($kck)) return $data;
      // foreach ($kck as $key => $value) {
      //   $personalia = $this->personalia->query("select distinct seksi from hrd_khs.tseksi where kodesie like '{$value['KODESIE']}%'")->row_array();
      //   $data[] = [
      //     'seksi' => $personalia['seksi'],
      //     'jumlah_item' => $value['JUMLAH'],
      //     'kodesie' => $value['KODESIE']
      //   ];
      // }
      $data = $this->oracle->query("SELECT DISTINCT a.kodesie, b.seksi, b.pic, b.voip, (SELECT count(*) jumlah FROM KHS_CSM_KEBUTUHAN c WHERE c.kodesie = a.kodesie AND c.STATUS = 0) jumlah
			 from KHS_CSM_KEBUTUHAN a
			 LEFT JOIN khs_csm_seksi b ON a.KODESIE = b.KODESIE
			 where status = 0")->result_array();
       foreach ($data as $key => $value) {
         $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[PIC]'")->row_array();
         $data[$key]['NAMA'] = $get_nama['nama'];
       }
      return $data;
    }

    public function seksiygblmmengajuakan($value='')
    {
      $data = $this->oracle->query("SELECT DISTINCT b.seksi, b.pic, b.voip
       from khs_csm_seksi b
       where b.kodesie NOT IN (SELECT DISTINCT kodesie FROM KHS_CSM_KEBUTUHAN)")->result_array();
       foreach ($data as $key => $value) {
         $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[PIC]'")->row_array();
         $data[$key]['NAMA'] = $get_nama['nama'];
       }
      return $data;
    }

    public function ambillistapproveitem($value='')
    {
      // $kck = $this->oracle->query("select distinct kodesie, count(*) jumlah from KHS_CSM_ITEM_SEKSI where status = 0 group by kodesie")->result_array();
      // $data = [];
      // if (empty($kck)) return $data;
      // foreach ($kck as $key => $value) {
      //   $personalia = $this->personalia->query("select distinct seksi from hrd_khs.tseksi where kodesie like '{$value['KODESIE']}%'")->row_array();
      //   $data[] = [
      //     'seksi' => $personalia['seksi'],
      //     'jumlah_item' => $value['JUMLAH'],
      //     'kodesie' => $value['KODESIE']
      //   ];
      // }
      $data = $this->oracle->query("SELECT DISTINCT a.kodesie, b.seksi, b.pic, b.voip, (SELECT count(*) jumlah FROM KHS_CSM_ITEM_SEKSI c WHERE c.kodesie = a.kodesie AND c.STATUS = 0) jumlah
       from KHS_CSM_ITEM_SEKSI a
       LEFT JOIN khs_csm_seksi b ON a.KODESIE = b.KODESIE
       where status = 0")->result_array();
       foreach ($data as $key => $value) {
         $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[PIC]'")->row_array();
         $data[$key]['NAMA'] = $get_nama['nama'];
       }
      return $data;
    }

    public function itemkebutuhanbykodesie($kodesie)
    {
      return $this->oracle->query("SELECT kck.*, TO_CHAR(kck.creation_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                                   FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
                                   WHERE kck.item_id = msib.inventory_item_id
                                   AND msib.organization_id = 81
                                   AND kck.status = 0
                                   AND kck.kodesie = '$kodesie'")->result_array();
    }

    public function itembykodesie($kodesie)
    {
      return $this->oracle->query("SELECT kck.*, TO_CHAR(kck.pengajuan_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                                   FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
                                   WHERE kck.item_id = msib.inventory_item_id
                                   AND msib.organization_id = 81
                                   AND kck.status = 0
                                   AND kck.kodesie = '$kodesie'")->result_array();
    }

    public function updatestatusitemkebutuhan($item_id, $status, $reason)
    {
      if ($reason != '') {
        $this->oracle->query("UPDATE KHS_CSM_KEBUTUHAN SET status = '$status', reason = '$reason' WHERE item_id = $item_id");
      }else {
        $this->oracle->query("UPDATE KHS_CSM_KEBUTUHAN SET status = '$status' WHERE item_id = $item_id");
      }
      if ($this->oracle->affected_rows()) {
        $res = 200;
      }else {
        $res = 0;
      }
      return $res;
    }

    public function updatestatusitem($item_id, $status)
    {
      $this->oracle->query("UPDATE KHS_CSM_ITEM_SEKSI SET status = '$status' WHERE item_id = $item_id");
      if ($this->oracle->affected_rows()) {
        $res = 200;
      }else {
        $res = 0;
      }
      return $res;
    }

    //serverside datatable
    public function selectMasterItem($data)
  	{
  		$val = strtoupper($data['search']['value']);
  			$res = $this->oracle
  					->query(
  							"SELECT kdav.*
  							FROM
  									(
  									SELECT
  													skdav.*,
  													ROW_NUMBER () OVER (ORDER BY segment1 DESC) as pagination
  											FROM
  													(
                              SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                                      msib.postprocessing_lead_time
                                    + msib.preprocessing_lead_time
                                    + msib.full_lead_time leadtime,
                                    NVL (msib.minimum_order_quantity, 0) moq,
                                    NVL (msib.min_minmax_quantity, 0) min_stock,
                                    NVL (msib.max_minmax_quantity, 0) max_stock
                               FROM mtl_system_items_b msib
                               WHERE msib.organization_id = 81
                               AND msib.inventory_item_id IN (SELECT item_id FROM KHS_CSM_ITEM)
                              AND (
                                msib.segment1 LIKE '%$val%'
                                OR msib.description LIKE '%$val%'
                              )
  													) skdav
  									) kdav
  							WHERE
  									pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
  					)->result_array();
  			return $res;
  	}

  	public function countAllMasterItem()
  	{
  		return $this->oracle->query(
  			"SELECT
  					COUNT(*) AS \"count\"
  			FROM
  			(SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                msib.postprocessing_lead_time
              + msib.preprocessing_lead_time
              + msib.full_lead_time leadtime,
              NVL (msib.minimum_order_quantity, 0) moq,
              NVL (msib.min_minmax_quantity, 0) min_stock,
              NVL (msib.max_minmax_quantity, 0) max_stock
         FROM mtl_system_items_b msib
         WHERE msib.organization_id = 81
         AND msib.inventory_item_id IN (SELECT item_id FROM KHS_CSM_ITEM)
       ) bla"
  			)->row_array();
  	}

  	public function countFilteredMasterItem($data)
  	{
  		$val = strtoupper($data['search']['value']);
  		return $this->oracle->query(
  			"SELECT
  						COUNT(*) AS \"count\"
  					FROM
            (
              SELECT msib.inventory_item_id, msib.segment1, msib.description, msib.primary_uom_code,
                      msib.postprocessing_lead_time
                    + msib.preprocessing_lead_time
                    + msib.full_lead_time leadtime,
                    NVL (msib.minimum_order_quantity, 0) moq,
                    NVL (msib.min_minmax_quantity, 0) min_stock,
                    NVL (msib.max_minmax_quantity, 0) max_stock
               FROM mtl_system_items_b msib
               WHERE msib.organization_id = 81
               AND msib.inventory_item_id IN (SELECT item_id FROM KHS_CSM_ITEM)
              AND (
                msib.segment1 LIKE '%$val%'
                OR msib.description LIKE '%$val%'
              )
          ) bla"
  			)->row_array();
  	}

    //pengajuan

    public function selectPengajuan($data)
    {
      $val = strtoupper($data['search']['value']);
        $res = $this->oracle
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY creation_date DESC) as pagination
                        FROM
                            (
                              SELECT kck.*, TO_CHAR(kck.creation_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                              FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
                              WHERE kck.item_id = msib.inventory_item_id
                              AND msib.organization_id = 81
                              AND (
                                msib.segment1 LIKE '%$val%'
                                OR msib.description LIKE '%$val%'
                                OR kck.creation_date LIKE '%$val%'
                                OR kck.created_by LIKE '%$val%'
                              )
                            ) skdav
                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();
        foreach ($res as $key => $value) {
          $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[CREATED_BY]'")->row_array();
          $res[$key]['NAMA'] = $get_nama['nama'];
        }
        return $res;
    }

    public function countAllPengajuan()
    {
      return $this->oracle->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT kck.*, msib.segment1, msib.description
        FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
        WHERE kck.item_id = msib.inventory_item_id
        AND msib.organization_id = 81) bla"
        )->row_array();
    }

    public function countFilteredPengajuan($data)
    {
      $val = strtoupper($data['search']['value']);
      return $this->oracle->query(
        "SELECT
              COUNT(*) AS \"count\"
            FROM
            (
              SELECT kck.*, msib.segment1, msib.description
              FROM KHS_CSM_KEBUTUHAN kck, mtl_system_items_b msib
              WHERE kck.item_id = msib.inventory_item_id
              AND msib.organization_id = 81
              AND (
                msib.segment1 LIKE '%$val%'
                OR msib.description LIKE '%$val%'
                OR kck.creation_date LIKE '%$val%'
                OR kck.created_by LIKE '%$val%'
              )
          ) bla"
        )->row_array();
    }
    // end pengajuan

    public function cekseksi($pic)
    {
      $pic = explode(' - ', $pic)[1];
      $kodesie = $this->personalia->query("SELECT substring(kodesie, 1, 7) kodesie from hrd_khs.tpribadi where noind = '$pic'")->row_array();
      $kodesie = $kodesie['kodesie'];
      $cek = $this->oracle->query("select kodesie from khs_csm_seksi where kodesie = '$kodesie'")->result_array();
      if (sizeof($cek)) {
        return 'wesono';
      }else {
        return $kodesie;
      }
    }

    public function saveseksi($post)
    {
      $this->oracle->insert('KHS_CSM_SEKSI', $post);
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function getdataseksi($value='')
    {
      $data = $this->oracle->query("SELECT a.*, (select count(b.item_id) j from KHS_CSM_ITEM_SEKSI b where b.kodesie = a.kodesie and status = 1) jumlah from khs_csm_seksi a ")->result_array();
      foreach ($data as $key => $value) {
        $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$value[PIC]'")->row_array();
        $data[$key]['NAMA'] = $get_nama['nama'];
      }
      return $data;
    }

    public function detailseksi($kodesie)
    {
      $data = $this->oracle->where('KODESIE', $kodesie)->get('KHS_CSM_SEKSI')->row_array();
      $get_nama = $this->personalia->query("select nama from hrd_khs.tpribadi where noind = '$data[PIC]'")->row_array();
      $data['NAMA'] = $get_nama['nama'];
      return $data;
    }

    public function delseksi($kodesie)
    {
      $this->oracle->delete('KHS_CSM_SEKSI', ['KODESIE' => $kodesie]);
      if ($this->oracle->affected_rows()) {
        return 'done';
      }else {
        return 0;
      }
    }

    public function selectDetailitemseksi($data, $kodesie)
    {
      $val = strtoupper($data['search']['value']);
        $res = $this->oracle
            ->query(
                "SELECT kdav.*
                FROM
                    (
                    SELECT
                            skdav.*,
                            ROW_NUMBER () OVER (ORDER BY segment1 DESC) as pagination
                        FROM
                            (
                              SELECT kck.*, TO_CHAR(kck.pengajuan_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
                              FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
                              WHERE kck.item_id = msib.inventory_item_id
                              AND kck.kodesie = '$kodesie'
                              AND kck.STATUS = 1
                              AND msib.organization_id = 81
                              AND (
                                msib.segment1 LIKE '%$val%'
                                OR msib.description LIKE '%$val%'
                                OR kck.pengajuan_date LIKE '%$val%'
                                OR kck.pengajuan_by LIKE '%$val%'
                              )
                            ) skdav
                    ) kdav
                WHERE
                    pagination BETWEEN {$data['pagination']['from']} AND {$data['pagination']['to']}"
            )->result_array();

        return $res;
    }

    public function countAllDetailitemseksi($kodesie)
    {
      return $this->oracle->query(
        "SELECT
            COUNT(*) AS \"count\"
        FROM
        (SELECT kck.*, TO_CHAR(kck.pengajuan_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
          FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
          WHERE kck.item_id = msib.inventory_item_id
          AND kck.kodesie = '$kodesie'
          AND kck.STATUS = 1
          AND msib.organization_id = 81) bla"
        )->row_array();
    }

    public function countFilteredDetailitemseksi($data, $kodesie)
    {
      $val = strtoupper($data['search']['value']);
      return $this->oracle->query(
        "SELECT
              COUNT(*) AS \"count\"
            FROM
            (
              SELECT kck.*, TO_CHAR(kck.pengajuan_date, 'DD/MM/YYYY HH:MI:SS') tgl_buat, msib.segment1, msib.description, msib.primary_uom_code
              FROM KHS_CSM_ITEM_SEKSI kck, mtl_system_items_b msib
              WHERE kck.item_id = msib.inventory_item_id
              AND kck.kodesie = '$kodesie'
              AND msib.organization_id = 81
              AND kck.STATUS = 1
              AND (
                msib.segment1 LIKE '%$val%'
                OR msib.description LIKE '%$val%'
                OR kck.pengajuan_date LIKE '%$val%'
                OR kck.pengajuan_by LIKE '%$val%'
              )
            )bla")->row_array();
    }
    // end pengajuan

}
