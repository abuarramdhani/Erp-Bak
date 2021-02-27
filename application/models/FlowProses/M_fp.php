<?php
class M_fp extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
        $this->design = $this->load->database('design', true);
        $this->personalia = $this->load->database('personalia', true);
        $this->lantuma = $this->load->database('lantuma',TRUE);
    }

    public function update_adjuvant($value)
    {
      $this->db->where('id', $value['id'])->update('md.md_adjuvant', $value);
    }

    public function getMemo($type)
    {
      if ($type == 'Product') {
        // code...
        $res = $this->design->select('mm.memo_number, mp.product_name, mm.memo_id, mm.tanggal_distribusi')->join('md.md_product as mp', 'mp.product_id = mm.product_id')->where('mm.jenis_memo', $type)->where('mm.tanggal_distribusi !=', null)->order_by('mm.memo_id', 'desc')->get('md.md_memo as mm')->result_array();
        foreach ($res as $key => $value) {
          $res[$key]['status'] = $this->db->where('memo_number', $value['memo_number'])->get('md.md_component_approved')->num_rows();
        }
      }else {
        $res = $this->design->select('mm.memo_number, mp.product_name, mm.bukti_id memo_id')->join('md.md_product as mp', 'mp.product_id = mm.product_id')->where('mm.jenis_memo', $type)->where('mm.tanggal_distribusi !=', null)->order_by('mm.bukti_id', 'desc')->get('md.md_bukti as mm')->result_array();
        foreach ($res as $key => $value) {
          $res[$key]['status'] = $this->db->where('memo_number', $value['memo_number'])->get('md.md_component_approved')->num_rows();
        }
      }
      return $res;
    }

    // detail memo area
    public function getComponentMemo($memo, $type)
    {
      if ($type == 'Product') {
        $type = 'md.md_product_component';
      }else {
        $type = 'md.md_product_component_prototype';
      }
      return $this->design->select('component_code, component_name, product_component_id, memo_number, product_id, revision, revision_date')->where('memo_number', $memo)->get($type)->result_array();
    }

    public function getMemoLine($memo_id, $memoNumber=false, $type)
    {
      if ($type == 'Product') {
        $table = 'md.md_product_component';
      }else {
        $table = 'md.md_product_component_prototype';
      }
      $sql = "SELECT
                mpch.history_id,
                mpch.jenis,
                mpchparent.history_id historyparent,
                (
                    case
                        when mpch.history_id_parent is null then mpc.product_component_id
                        else mpchparent.product_component_id
                    end
                ) product_component_id,
                (
                    case
                        when mpch.history_id_parent is null then mpc.component_name
                        else mpchparent.component_name
                    end
                ) nama_komponen,
                mpch.component_code component_code_old,
                (
                    case
                        when mpch.history_id_parent is null then mpc.component_code
                        else mpchparent.component_code
                    end
                ) kodebaru,
                (
                    case
                        when mpch.history_id_parent is null then mpc.revision
                        else mpchparent.revision
                    end
                ) norevisi,
                (
                    case
                        when mpch.history_id_parent is null then mpc.information
                        else mpchparent.information
                    end
                ) detailperubahan,
                (
                    case
                        when mpch.history_id_parent is null then mpc.change_type
                        else mpchparent.change_type
                    end
                ) sifatperubahan,
                (
                    case
                        when mpch.history_id_parent is null then mpc.status_design
                        else mpchparent.status_design
                    end
                ) gambarkerjalama,
                (
                    case
                        when mpch.history_id_parent is null then mpc.status_component
                        else mpchparent.status_component
                    end
                ) statuskomponen,
                (
                    case
                        when mpch.history_id_parent is null then mpc.revision_date
                        else mpchparent.revision_date
                    end
                ) revision_date,
                (
                    case
                        when mpchparent.revision_date is null then '01-01-1970'
                        else mpc.revision_date
                    end
                ) oldrevisiondate,
                mpc.status,
                mpch.product_id
            FROM
                md.md_product_component_history mpch,
                md.md_product_component_history mpchparent,
                $table mpc
            WHERE
                mpc.product_component_id = mpch.product_component_id
                and mpch.memo_number_after = '$memoNumber'
                and(
                    case
                        when mpch.history_id_parent is null then mpchparent.history_id = mpch.history_id
                        and mpc.memo_id = $memo_id
                        else mpch.history_id_parent = mpchparent.history_id
                        and mpchparent.memo_id = $memo_id
                    end
                )
                -- ini untuk memo line
                ORDER BY kodebaru asc";

        $query = $this->design->query($sql);
        return $query->result_array();
    }

    public function getMemoLineNew($memo_id, $memoNumber=false, $type)
    {
      $this->design->select('*');
      if ($type == 'Product') {
        $this->design->from('md.md_product_component');
      }else {
        $this->design->from('md.md_product_component_prototype');
      }
      $this->design->where('memo_number', $memoNumber);
      $this->design->where('memo_id', $memo_id);
      if ($type == 'Product') {
        $this->design->where('new_component = 1');
      }else {
        $this->design->where('new_component = 0');
      }
      $this->design->order_by("component_code", "asc");
      $query = $this->design->get();
      return $query->result_array();
    }

    public function kpsrMemoProduct($memo, $type)
    {
      return $this->design->query("select product_component_id, history_id from md.md_product_component_history
                               where memo_number_before = '{$memo}'
                               and jenis = '$type'")->result_array();
    }

    public function cek_kom_in_histo($product_component_id, $type)
    {
      if ($type == 'Product') {
        $table = 'md.md_product_component';
      }else {
        $table = 'md.md_product_component_prototype';
      }
       return $this->design->query("select
                        ch.product_component_id,
                        ch.product_id,
                        ch.component_name,
                        ch.component_code,
                        ch.change_detail,
                        ch.information,
                        ch.change_type,
                        ch.status_design,
                        ch.status_component,
                        ch.revision_date,
                        pc.status
                        from md.md_product_component_history ch,
                        $table pc
                        where ch.product_component_id = '{$product_component_id}'
                        and ch.product_component_id = pc.product_component_id
                        and ch.jenis = 'Product'
                        and ch.revision = (select min(revision)
                                          from md.md_product_component_history
                                          where product_component_id = '{$product_component_id}'
                                          and jenis = '$type')")->row_array();
    }

    public function getMemoLineNewUniqueUpdate($memo_id, $memoNumber=false, $id, $type)
    {
        if ($type == 'Product') {
          $table = 'md.md_product_component';
        }else {
          $table = 'md.md_product_component_prototype';
        }
        $sql = "SELECT
            mpch.history_id,
            mpchparent.history_id historyparent,
            (
                case
                    when mpch.history_id_parent is null then mpc.product_component_id
                    else mpchparent.product_component_id
                end
            ) product_component_id,
            (
                case
                    when mpch.history_id_parent is null then mpc.component_name
                    else mpchparent.component_name
                end
            ) nama_komponen,
            (

               SELECT component_code FROM md.md_product_component_history WHERE product_component_id = '$id' AND revision = (SELECT MAX(REVISION) FROM md.md_product_component_history Where product_component_id = '$id' and jenis = 'Product')

            ) component_code_old,
            (
                case
                    when mpch.history_id_parent is null then mpc.component_code
                    else mpchparent.component_code
                end
            ) kodebaru,
            (
                case
                    when mpch.history_id_parent is null then mpc.revision
                    else mpchparent.revision
                end
            ) norevisi,
            (
                case
                    when mpch.history_id_parent is null then mpc.information
                    else mpchparent.information
                end
            ) detailperubahan,
            (
                case
                    when mpch.history_id_parent is null then mpc.change_type
                    else mpchparent.change_type
                end
            ) sifatperubahan,
            (
                case
                    when mpch.history_id_parent is null then mpc.status_design
                    else mpchparent.status_design
                end
            ) gambarkerjalama,
            (
                case
                    when mpch.history_id_parent is null then mpc.status_component
                    else mpchparent.status_component
                end
            ) statuskomponen,
            (
                case
                    when mpch.history_id_parent is null then mpc.revision_date
                    else mpchparent.revision_date
                end
            ) revision_date,
            (
                case
                    when mpchparent.revision_date is null then '01-01-1970'
                    else mpc.revision_date
                end
            ) oldrevisiondate,
            mpc.status,
            mpc.product_id
        FROM
            md.md_product_component_history mpch,
            md.md_product_component_history mpchparent,
            $table mpc
        WHERE
            mpc.product_component_id = mpch.product_component_id
            and mpch.memo_number_after = '$memoNumber'
            and(
                case
                    when mpch.history_id_parent is null then mpchparent.history_id = mpch.history_id
                    and mpc.memo_id = $memo_id
                    else mpch.history_id_parent = mpchparent.history_id
                    and mpchparent.memo_id = $memo_id
                end
            )
          -- ini untuk memo line
        ORDER BY kodebaru asc";

        $query = $this->design->query($sql);
        return $query->result_array();
    }

    public function getimgCek($id, $type)
    {
      if ($type == 'Product') {
        $where = "(jenis = '$type' OR jenis is null)";
      }else {
        $where = "jenis = '$type'";
      }
      $query = "SELECT product_component_id, file_location, file_name FROM md.md_product_component_design WHERE product_component_id = '$id' and $where and history_id is NULL";
      $sql = $this->design->query($query);
      return $sql->row_array();
    }

    // detail memo area end ========================================




    function getTool($param)
    {
      return $this->lantuma->query("SELECT * from torder tto WHERE (tto.fs_nm_tool like '%$param%' or tto.fs_no_order like '%$param%') order by fs_nm_tool asc")->result_array();
    }

    public function getFFVT($param)
    {
      // echo $param;die;
      return $this->oracle->query("SELECT ffv.FLEX_VALUE
                                  ,ffvt.DESCRIPTION
                                  from fnd_flex_values ffv
                                  , fnd_flex_values_tl ffvt
                                  where ffv.FLEX_VALUE_SET_ID = 1013823
                                  and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
                                  and ffv.PARENT_FLEX_VALUE_LOW = 'C'
                                  and substr(ffv.FLEX_VALUE,1,1)in ('A',
                                  'B',
                                  'E',
                                  'F',
                                  'H',
                                  'I',
                                  'J',
                                  'M',
                                  'P')
                                  --and UPPER(ffvt.DESCRIPTION) like '%$param%'")->result_array();
    }


    public function getUnsetProses($id)
    {
      $proses = $this->db->distinct()->select('product_component_id')->where('product_id', $id)->get('md.md_operation')->result_array();

      // if ($type == 'product') {
        $response = $this->design->select('mc.*, mp.product_name')
                            ->join('md.md_product mp', 'mp.product_id = mc.product_id')
                            ->where('mc.product_id', $id)
                            ->order_by('mc.component_code', 'DESC')
                            ->get('md.md_product_component mc')->result_array();

        $cek_memo = $this->db->query("select * from md.md_component_approved where product_id = '$id' and memo_number like '%PRG%'")->result_array();
        foreach ($cek_memo as $key => $value) {
          foreach ($response as $key2 => $val) {
            if ($value['product_component_id'] == $val['product_component_id']) {
              $val['received'] = substr($value['created_date'], 0, 10);
              $tampung[] = $val;
            }
          }
        }
        if (!empty($tampung)) {
          usort($tampung, function ($a, $b) {
              return $a['product_component_code'] > $b['product_component_code'] ? 1 : -1;
          });
        }
       // $response = !empty($tampung)?$tampung:[];

      // }elseif ($type == 'prototype') {
        $response2 = $this->design->select('mc.*, mp.product_name')
                            ->join('md.md_product mp', 'mp.product_id = mc.product_id')
                            ->where('mc.product_id', $id)
                            ->order_by('mc.component_code', 'DESC')
                            ->get('md.md_product_component_prototype mc')->result_array();

        $cek_memo2 = $this->db->query("select * from md.md_component_approved where product_id = '$id' and memo_number like '%PROTO%'")->result_array();
        foreach ($cek_memo2 as $key => $value) {
          foreach ($response2 as $key2 => $val) {
            if ($value['product_component_id'] == $val['product_component_id']) {
              $val['received'] = substr($value['created_date'], 0, 10);
              $tampung[] = $val;
            }
          }
        }
        if (!empty($tampung)) {
          usort($tampung, function ($a, $b) {
              return $a['product_component_code'] > $b['product_component_code'] ? 1 : -1;
          });
        }

        $response = !empty($tampung)?$tampung:[];
      // }

      foreach ($response as $key => $value) {
        foreach ($proses as $key2 => $val) {
          if (trim($val['product_component_id']) == trim($value['product_component_id'])) {
            unset($response[$key]);
          }
        }
      }
      array_values($response);
      return $response;
    }

    public function getFileName($id, $jenis)
    {
      $res = $this->design->select('file_name, file_location')
                          ->where('product_component_id', $id)
                          ->where('jenis', $jenis)
                          ->where('history_id', NULL)
                          ->get('md.md_product_component_design')->row_array();
      return $res;
    }

    public function report($jenis, $product_id)
    {
      // if ($jenis == 'product') {
      //   $table = 'md.md_product_component';
      // }else {
      //   $table = 'md.md_product_component_prototype';
      // }
      $response1 = $this->design->select('product_component_id, product_component_code, component_name, component_code, qty, material_type')->where('product_id', $product_id)->order_by('product_component_id', 'desc')->get('md.md_product_component')->result_array();
      $response2 = $this->design->select('product_component_id, product_component_code, component_name, component_code, qty, material_type')->where('product_id', $product_id)->order_by('product_component_id', 'desc')->get('md.md_product_component_prototype')->result_array();

      // if ($jenis == 'product') {
        $cek_memo = $this->db->query("select * from md.md_component_approved where product_id = '$product_id' and memo_number like '%PRG%'")->result_array();
        foreach ($cek_memo as $key => $value) {
          foreach ($response1 as $key2 => $val) {
            if ($value['product_component_id'] == $val['product_component_id']) {
              $tampung[] = $val;
            }
          }
        }
       // $response = !empty($tampung)?$tampung:[];
      // }else {
        $cek_memo2 = $this->db->query("select * from md.md_component_approved where product_id = '$product_id' and memo_number like '%PROTO%'")->result_array();
        foreach ($cek_memo2 as $key => $value) {
          foreach ($response2 as $key2 => $val) {
            if ($value['product_component_id'] == $val['product_component_id']) {
              $tampung[] = $val;
            }
          }
        }
       $response = !empty($tampung)?$tampung:[];
      // }


      $oracle_item = $this->db->where('product_id', $product_id)->get('md.md_oracle_item')->result_array();
      if (!empty($response)) {
        foreach ($response as $key => $val) {
          $response[$key]['oracle_code'] = null;
          $response[$key]['oracle_desc'] = null;
          foreach ($oracle_item as $key4 => $item_ora) {
            if ($item_ora['product_component_id'] === $val['product_component_id']) {
              $response[$key]['oracle_code'] = $item_ora['code_component'];
              $response[$key]['oracle_desc'] = $item_ora['description'];
            }
          }
        }
        foreach ($response as $key => $val) {
          $opr = $this->db->select('md.md_operation.product_component_id, md.md_operation.sequence, md.md_operation.machine_req, md.md_operation_std.operation_std, md.md_operation.destination, ')
                          ->join('md.md_operation_std', 'md.md_operation_std.id = md.md_operation.operation_process', 'left')
                          ->where('product_component_id', $val['product_component_id'])
                          ->order_by('md.md_operation.sequence', 'asc')
                          ->get('md.md_operation')->result_array();
          $opr_count = count($opr);
          if (!empty($opr)) {
            $response[$key]['count'] = $opr_count;
            foreach ($opr as $key2 => $va) {
              $proses[] = $va;
            }
            foreach ($proses as $key3 => $v) {
              if ($val['product_component_id'] == $v['product_component_id']) {
                if ($v['sequence'] != 1) {
                   $seq = $v['sequence'];
                }else {
                  $seq = '';
                }
                $proses[$key3]['product_component_code'] = $val['product_component_code'];
                $proses[$key3]['component_name'] = $val['component_name'];
                $proses[$key3]['component_code'] = $val['component_code'].$seq;
                $proses[$key3]['qty'] = $val['qty'];
                $proses[$key3]['material_type'] = $val['material_type'];
                $proses[$key3]['oracle_code'] = $val['oracle_code'];
                $proses[$key3]['oracle_desc'] = $val['oracle_desc'];
              }
            }
            // return $proses;
            unset($response[$key]);
          }
        }

        if (empty($proses)) {
          $proses = [];
        }
        $final = array_merge($response, $proses);
        usort($final, function ($a, $b) {
            return $a['component_code'] > $b['component_code'] ? 1 : -1;
        });
        return $final;
      }

    }

    public function getProductName($id)
    {
     return $this->design->select('product_name')->where('product_id', $id)->get('md.md_product')->row_array();
    }

    public function employee($data)
    {
        $sql = "SELECT
                employee_code,
                employee_name
              from
                er.er_employee_all
              where
                resign = '0'
                and (employee_code like '%$data%'
                or employee_name like '%$data%')
              order by
                1";
        $response = $this->db->query($sql)->result_array();
        return $response;
    }

    public function GetComp($product_id)
    {
      // if ($type == 'product') {
        $res =  $this->design->select('mc.*, mp.product_name')
                            ->join('md.md_product mp', 'mp.product_id = mc.product_id')
                            ->where('mc.product_id', $product_id)
                            ->order_by('mc.product_component_code', 'ASC')
                            ->get('md.md_product_component mc')->result_array();

        $cek_memo = $this->db->query("select * from md.md_component_approved where product_id = '$product_id' and memo_number like '%PRG%'")->result_array();
        foreach ($cek_memo as $key => $value) {
          foreach ($res as $key2 => $val) {
            if ($val['product_component_id'] == $value['product_component_id']) {
              $val['received'] = substr($value['created_date'], 0, 10);
              $tampung[] = $val;
            }
          }
        }
        if (!empty($tampung)) {
          usort($tampung, function ($a, $b) {
              return $a['product_component_code'] > $b['product_component_code'] ? 1 : -1;
          });
        }
        // return !empty($tampung)?$tampung:[];
      // }elseif ($type == 'prototype') {
        $res2 =  $this->design->select('mc.*, mp.product_name')
                            ->join('md.md_product mp', 'mp.product_id = mc.product_id')
                            ->where('mc.product_id', $product_id)
                            ->order_by('mc.product_component_code', 'ASC')
                            ->get('md.md_product_component_prototype mc')->result_array();

        $cek_memo2 = $this->db->query("select * from md.md_component_approved where product_id = '$product_id' and memo_number like '%PROTO%'")->result_array();
        foreach ($cek_memo2 as $key => $value) {
          foreach ($res2 as $key2 => $val) {
            if ($val['product_component_id'] == $value['product_component_id']) {
              $val['received'] = substr($value['created_date'], 0, 10);
              $tampung[] = $val;
            }
          }
        }
        if (!empty($tampung)) {
          usort($tampung, function ($a, $b) {
              return $a['product_component_code'] > $b['product_component_code'] ? 1 : -1;
          });
        }
        return !empty($tampung)?$tampung:[];

      // }else {
      //   return 0;
      // }
    }

    public function getProduct($value='')
    {
      return $this->design->order_by('product_id', 'DESC')->get('md.md_product')->result_array();
    }

      // datatable serverside
	    // public $order_column = array(null , null,"product_component_code", "component_code", "revision_date", "material_type" );

	    public function make_query()
	    {
        $this->design->select('md.*, mp.product_name');
          $this->design->from('md.md_product_component md');
          $this->design->join('md.md_product mp', 'mp.product_id = md.product_id');

	        if (isset($_POST["search"]["value"])) {
            if (is_numeric($_POST["search"]["value"]) == 1) {
              $this->design->where("md.product_id", $_POST["search"]["value"]);
            }else {
              $this->design->like("md.product_component_code", $_POST["search"]["value"]);
              $this->design->or_like("md.component_code", $_POST["search"]["value"]);
              $this->design->or_like("md.component_name", $_POST["search"]["value"]);
              $this->design->or_like("md.material_type", $_POST["search"]["value"]);
            }
	        }
	        if (isset($_POST["order"])) {
	            // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } else {
	            $this->design->order_by('component_code', 'asc');
	        }
	    }

	    public function make_datatables()
	    {
	        $this->make_query();
	        if ($_POST["length"] != -1) {
	            $this->design->limit($_POST['length'], $_POST['start']);
	        }
	        $query = $this->design->get();
	        return $query->result();
	    }

	    public function get_filtered_data()
	    {
	        $this->make_query();
	        $query = $this->design->get();
	        return $query->num_rows();
	    }

	    public function get_all_data()
	    {
          $this->design->select('*');
          $this->design->from('md.md_product_component md');
          $this->design->join('md.md_product mp', 'mp.product_id = md.product_id');
	        return $this->design->count_all_results();
	    }

      // datatable Prototype
      public function make_query_proto()
      {
        $this->design->select('md.*, mp.product_name');
          $this->design->from('md.md_product_component_prototype md');
          $this->design->join('md.md_product mp', 'mp.product_id = md.product_id');

          if (isset($_POST["search"]["value"])) {
            if (is_numeric($_POST["search"]["value"]) == 1) {
              $this->design->where("md.product_id", $_POST["search"]["value"]);
            }else {
              $this->design->like("md.product_component_code", $_POST["search"]["value"]);
              $this->design->or_like("md.component_code", $_POST["search"]["value"]);
              $this->design->or_like("md.component_name", $_POST["search"]["value"]);
              $this->design->or_like("md.material_type", $_POST["search"]["value"]);
            }
          }
          if (isset($_POST["order"])) {
              // $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          } else {
              $this->design->order_by('component_code', 'asc');
          }
      }

      public function make_datatables_proto()
      {
          $this->make_query_proto();
          if ($_POST["length"] != -1) {
              $this->design->limit($_POST['length'], $_POST['start']);
          }
          $query = $this->design->get();
          return $query->result();
      }

      public function get_filtered_data_proto()
      {
          $this->make_query_proto();
          $query = $this->design->get();
          return $query->num_rows();
      }

      public function get_all_data_proto()
      {
          $this->design->select('*');
          $this->design->from('md.md_product_component_prototype md');
          $this->design->join('md.md_product mp', 'mp.product_id = md.product_id');
          return $this->design->count_all_results();
      }

      public function getOrg($id)
      {
        $res = $this->oracle->query("SELECT distinct organization_id, organization_code from mtl_parameters  where organization_code like '%$id%'")->result_array();
        return $res;
      }

      public function getOracleItem($term, $org)
      {
        $res = $this->oracle->query("SELECT msib.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION from mtl_system_items_b msib 
                                     WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'            
                                     AND msib.ORGANIZATION_ID = 81
                                     AND (msib.segment1 LIKE '%$term%' or msib.description LIKE '%$term%')")->result_array();
         return $res;
      }

      public function getOracleItemPenolong($term)
      {
        $res = $this->oracle->query("SELECT msib.INVENTORY_ITEM_ID, msib.SEGMENT1, msib.DESCRIPTION, msib.PRIMARY_UOM_CODE from mtl_system_items_b msib 
                                     WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'    
                                     AND (msib.ORGANIZATION_ID = 102 or msib.ORGANIZATION_ID = 101)         
                                     AND (msib.segment1 LIKE '%$term%' or msib.description LIKE '%$term%')")->result_array();
         return $res;
      }

      public function cekOracleProses($term)
      {
        $res = $this->oracle->query("SELECT distinct msib.SEGMENT1, msib.INVENTORY_ITEM_ID, msib.DESCRIPTION from mtl_system_items_b msib 
                                     WHERE msib.INVENTORY_ITEM_STATUS_CODE = 'Active'            
                                     AND TO_CHAR(msib.segment1) = '$term'")->result_array();
        return $res;
      }

      public function getDestinasi($param)
      {
        $res = $this->oracle->query("SELECT DISTINCT bd.DEPARTMENT_CLASS_CODE
              -- ,bd.DESCRIPTION
              -- ,bd.DEPARTMENT_CODE
              -- ,br.RESOURCE_CODE
              -- ,br.DESCRIPTION
              from bom_departments bd
              ,bom_department_resources bdr
              ,bom_resources br
              where bd.DISABLE_DATE is null
              and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID
              and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
              and bdr.RESOURCE_ID = br.RESOURCE_ID
              and br.DISABLE_DATE is null
              and br.RESOURCE_TYPE = 1
              and br.AUTOCHARGE_TYPE = 1
              order by bd.DEPARTMENT_CLASS_CODE asc
              -- and (bd.DEPARTMENT_CLASS_CODE like '%$param%' or bd.DESCRIPTION like '%$param%')")->result_array();
         // if (!empty($res)) {
         //   return $res;
         // }else {
         //   return $this->oracle->like('DEPARTMENT_CLASS_CODE', $param, 'both')->or_like('DESCRIPTION', $param, 'both')->get('flow_proses_destinasi_tambahan')->result_array();
         // }
         $res2 = $this->oracle->query("SELECT * FROM flow_proses_destinasi_tambahan")->result_array();

           $done = array_merge($res, $res2);
           usort($done, function ($a, $b) {
               return $a['DEPARTMENT_CLASS_CODE'] > $b['DEPARTMENT_CLASS_CODE'] ? 1 : -1;
           });
           return $done;
      }

      public function getDestinasiForSearch($param)
      {
        $res = $this->oracle->query("SELECT DISTINCT bd.DEPARTMENT_CLASS_CODE
              ,bd.DESCRIPTION
              -- ,bd.DEPARTMENT_CODE
              -- ,br.RESOURCE_CODE
              -- ,br.DESCRIPTION
              from bom_departments bd
              ,bom_department_resources bdr
              ,bom_resources br
              where bd.DISABLE_DATE is null
              and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID
              and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
              and bdr.RESOURCE_ID = br.RESOURCE_ID
              and br.DISABLE_DATE is null
              and br.RESOURCE_TYPE = 1
              and br.AUTOCHARGE_TYPE = 1
              and (bd.DEPARTMENT_CLASS_CODE like '%$param%' or bd.DESCRIPTION like '%$param%')")->result_array();
         if (!empty($res)) {
           return $res;
         }else {
           // return $this->oracle->like('DEPARTMENT_CLASS_CODE', $param, 'both')->or_like('DESCRIPTION', $param, 'both')->get('flow_proses_destinasi_tambahan')->result_array();
           return $this->oracle->query("SELECT * FROM flow_proses_destinasi_tambahan WHERE (
                                         DEPARTMENT_CLASS_CODE LIKE '%$param%'
                                         OR DESCRIPTION LIKE '%$param%'
                                       )")->result_array();
         }
      }

      public function getResource1()
      {
        return $this->oracle->query("SELECT gob.OPRN_NO ,
        substr(gor.ATTRIBUTE1,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES resource_code
				,crmt.RESOURCE_DESC description
				,gor.ATTRIBUTE1
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE1 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE2,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE2
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE2 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE3,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE3
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE3 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE4,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE4
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE4 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE5,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE5
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE5 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE6,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE6
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE6 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE7,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE7
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE7 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE8,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE8
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE8 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE9,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE9
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE9 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE10,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE10
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE10 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE11,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE11
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE11 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE12,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE12
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE12 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE13,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE13
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE13 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE14,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE14
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE14 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE15,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE15
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE15 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE16,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE16
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE16 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE17,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE17
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE17 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE18,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE18
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE18 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE19,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE19
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE19 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE20,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE20
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE20 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE21,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE21
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE21 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE22,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE22
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE22 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE23,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE23
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE23 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE24,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE24
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE24 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE25,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE25
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE25 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE26,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE26
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE26 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE27,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE27
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE27 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE28,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE28
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE28 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE29,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE29
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE29 is not null
				union
				select gob.OPRN_NO ,
        substr(gor.ATTRIBUTE30,3,3) var2, decode(gob.OPRN_NO,'FDT-RESOURCE','FDT','FDY-RESOURCE','FDY','PTAS-RESOURCE','PTAS','SM-RESOURCE','SM') var1, gor.RESOURCES
				,crmt.RESOURCE_DESC
				,gor.ATTRIBUTE30
				from gmd_operations_b gob
				,GMD_OPERATION_ACTIVITIES goa
				,GMD_OPERATION_RESOURCES gor
				,cr_rsrc_mst_tl crmt
				where gob.OPRN_NO in ('FDT-RESOURCE','FDY-RESOURCE','PTAS-RESOURCE','SM-RESOURCE')
				and gor.OPRN_LINE_ID = goa.OPRN_LINE_ID
				and gor.RESOURCES=crmt.RESOURCES
				and goa.OPRN_ID = gob.OPRN_ID
				and gob.OPRN_VERS = 1
				and gor.ATTRIBUTE30 is not null")->result_array();
      }

      public function getResource2()
      {
        return $this->oracle->query("SELECT br.RESOURCE_CODE, bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE1    
        from bom_resources br ,bom_department_resources bdr ,bom_departments bd  
        where br.DISABLE_DATE is null  
        and br.RESOURCE_TYPE = 1            
        and br.AUTOCHARGE_TYPE = 1            
        and br.ATTRIBUTE1 is not null            
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE2,3,3) var2  ,br.ATTRIBUTE2 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE2 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE3 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE3 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE4 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE4 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE5 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE5 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE6 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE6 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE7 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE7 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE8 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE8 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE9 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE9 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE10 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE10 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE11
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE11 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE12 
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE12 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE13
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE13 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE14
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE14 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID
  			union
  			select br.RESOURCE_CODE,
        bd.DEPARTMENT_CLASS_CODE var1, br.DESCRIPTION,
        substr(br.ATTRIBUTE1,3,3) var2  ,br.ATTRIBUTE15
  			from bom_resources br, bom_department_resources bdr ,bom_departments bd  
  			where br.DISABLE_DATE is null
  			and br.RESOURCE_TYPE = 1
  			and br.AUTOCHARGE_TYPE = 1
  			and br.ATTRIBUTE15 is not null
        and bdr.RESOURCE_ID = br.RESOURCE_ID            
        and bd.DEPARTMENT_ID = bdr.DEPARTMENT_ID            
        and bd.ORGANIZATION_ID = br.ORGANIZATION_ID")->result_array();
      }





}
