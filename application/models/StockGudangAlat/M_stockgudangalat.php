<?php defined('BASEPATH') OR die('No direct script access allowed');

class M_stockgudangalat extends CI_Model
{
	// var $oracle;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
      $this->load->library('encrypt');
      $this->dev = $this->load->database('dpostgre', true);
   }

   function insertData($no_po,$nama,$merk,$pilihan,$qty,$tag,$subinv)
   {
      $db = $this->load->database();
      $sql ="INSERT into msg.msg_stok_gdg_alat_tst (no_po, tag, nama, merk, qty, jenis, subinv)
		VALUES ('$no_po','$tag', '$nama', '$merk', '$qty', '$pilihan', '$subinv')";
      $query = $this->dev->query($sql);
      // echo $sql.'<br>';
      // exit();//
      // return $sql;
   }

   function insertTable()
   {
      $db = $this->load->database();
      $sql = "SELECT distinct msgab.no_po, msgab.tag, msgab.nama, msgab.merk, msgab.subinv,
      msgab.qty,
      count(nama) OVER (partition by nama) jml, msgab.jenis, msgab.id FROM
      msg.msg_stok_gdg_alat_tst msgab order by nama asc";
      $query = $this->dev->query($sql);
      return $query->result_array();
   }

   function updateData($tag,$nama,$nama2,$merk,$qty,$pilihan,$no_po)
   {
      $db = $this->load->database();
      $sql = "UPDATE msg.msg_stok_gdg_alat_tst SET tag = '$tag', nama = '$nama2',
             merk = '$merk', qty = '$qty', jenis = '$pilihan', no_po = '$no_po'
      WHERE id = '$nama'";
      // echo $sql;exit();
      // print_r($sql);exit;
      $this->dev->query($sql);
      // $query = $this->db->query($sql);
      // return $query;
      // return $sql;
   }

   function deleteData($id)
   {
      $db = $this->load->database();
      $sql ="DELETE FROM msg.msg_stok_gdg_alat_tst
      WHERE id ='$id'";

      $this->dev->query($sql);
   }

	 // tambahan
	 public function getDataComp($id)
	 {
		$this->db->where('id', $id);
		$query = $this->db->get('msg.msg_stok_gdg_alat_tst');
		return $query->result_array();
	 }

/*
	 | -------------------------------------------------------------------------
	 | API Fo Android
	 | -------------------------------------------------------------------------
	 */

	// ==============================GET DATA AREA=================================
	 public function getAll()
		{
			$response['data'] = $this->db->query("SELECT distinct im.im_master_bon_bplpa.spesifikasi_barang, im.im_master_bon_bplpa.jenis_equipment, im.im_master_bon_bplpa.tag_number_mesin, im.im_master_bon_bplpa.jumlah qty, im.im_master_bon_bplpa.subinv,
				count(im.im_master_bon_bplpa.no_bon) OVER (partition by im.im_master_bon_bplpa.jumlah, im.im_master_bon_bplpa.tag_number_mesin) jumlah
				from im.im_master_bon_bplpa")->result_array();
				if(empty($response)) {
						$response = array(
								'success' => false,
								'message' => 'there is no data available.'
						);
				}
				return $response;
		}


	// ==============================DELETE AREA================================
	  public function Remove($data)
	  {
	    $response['success'] = false;
	    if(!empty($data)){
				if (!empty($data['SPESIFIKASI'])) {
					if (!empty($data['SUB_INV'])) {
						if (!empty($data['TAG'])) {
							if (!empty($data['QTY'])) {
								if (!empty($data['JENIS'])) {
								// DELETE FROM
									$this->db->query("DELETE FROM msg.msg_stok_gdg_alat_tst WHERE msg.msg_stok_gdg_alat_tst.id
									IN(SELECT msg.msg_stok_gdg_alat_tst.id from msg.msg_stok_gdg_alat_tst WHERE msg.msg_stok_gdg_alat_tst.nama= '$data[SPESIFIKASI]' AND msg.msg_stok_gdg_alat_tst.JENIS= '$data[JENIS]'
									AND msg.msg_stok_gdg_alat_tst.subinv = '$data[SUB_INV]'
									AND msg.msg_stok_gdg_alat_tst.tag = '$data[TAG]'
									ORDER BY msg.msg_stok_gdg_alat_tst.id
									ASC LIMIT '$data[QTY]')");
									$response['success'] = true;
								}else {
									$response['message'] = 'JENIS is empty!, can\'t do this action.';
								}
							}else {
								$response['message'] = 'QTY is empty!, can\'t do this action.';
							}
						}else {
							$response['message'] = 'TAG is empty!, can\'t do this action.';
						}
					}else {
						$response['message'] = 'SUB_INV is empty!, can\'t do this action.';
					}
				}else {
					$response['message'] = 'NAME OR SPESIFIKASI is empty!, can\'t do this action.';
				}
	    }else {
	      $response['message'] = 'data posted data is empty!, can\'t do this action.';
	    }
	    return $response;
	  }

		// ==============================EDIT AREA==============================

	    public function edit($data)
	    {

				if (!empty($data['tag'])) {
					if (!empty($data['jenis'])) {
						if (!empty($data['no_bon'])) {
							if (!empty($data['subinv'])) {
								if (!empty($data['spesifikasi_barang'])) {
									$response['success'] = true;
									$this->db->query("UPDATE im.im_master_bon_bplpa SET flag = 'O' WHERE im.im_master_bon_bplpa.id IN
									(SELECT im.im_master_bon_bplpa.id from im.im_master_bon_bplpa where im.im_master_bon_bplpa.no_bon= '$data[no_bon]'
									AND im.im_master_bon_bplpa.jenis_equipment = '$data[jenis]' AND im.im_master_bon_bplpa.spesifikasi_barang = '$data[spesifikasi_barang]'
									and im.im_master_bon_bplpa.flag = 'N' AND im_master_bon_bplpa.tag_number_mesin = '$data[tag]' ORDER BY im.im_master_bon_bplpa.id ASC LIMIT '$data[qty]')
									AND im.im_master_bon_bplpa.no_bon = '$data[no_bon]'
									AND im.im_master_bon_bplpa.subinv = '$data[subinv]'");
								}else {
									$response['message'] = 'spesifikasi_barang is empty!, can\'t do this action.';
								}
							}else {
								$response['message'] = 'sub_inv is empty!, can\'t do this action.';
							}
						}else {
							$response['message'] = 'no_bon is empty!, can\'t do this action.';
						}
					}else {
						$response['message'] = 'jenis is empty!, can\'t do this action.';
					}
	      }else {
	        $response['message'] = 'tag_number_mesin is empty!, can\'t do this action.';
	      }
	      return $response;
	    }

	// ==============================GET DATA AREA==============================
		public function get($id)
		{
			// sementara dev
			$response['data'] = $this->db->query("SELECT distinct im.im_master_bon_bplpa.spesifikasi_barang, im.im_master_bon_bplpa.jenis_equipment, im.im_master_bon_bplpa.tag_number_mesin, im.im_master_bon_bplpa.jumlah qty, im.im_master_bon_bplpa.subinv,
				count(im.im_master_bon_bplpa.no_bon) OVER (partition by im.im_master_bon_bplpa.jumlah, im.im_master_bon_bplpa.tag_number_mesin) jumlah
				from im.im_master_bon_bplpa WHERE im.im_master_bon_bplpa.no_bon = '$id' and im.im_master_bon_bplpa.flag = 'N'")->result_array();
				$response['message'] = 'success fetching';
				$response['success'] = true;
				if(empty($response['data'])) {
						$response = array(
								'data'		=> [],
								'success' => false,
								'message' => 'nomor bom posted data is not found!, can\'t do this action.'
						);
				}
				return $response;
		}


}

?>
