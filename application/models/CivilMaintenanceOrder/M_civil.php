<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_civil extends CI_Model
{

	function __construct()
	{
		$this->load->database();
		$this->personalia = $this->load->database('personalia', true);
	}

	public function getTableJenisOrder()
	{
		$sql = "SELECT * from cvl.cvl_jenis_order order by cvl_jenis_order";
		return $this->db->query($sql)->result_array();
	}

	public function addJnsOrder($data, $tbl = 'cvl.cvl_jenis_order')
	{
		$this->db->insert($tbl, $data);
		return $this->db->insert_id();
	}

	public function delJnsOrder($id)
	{
		$this->db->where('jenis_order_id', $id);
		$this->db->delete('cvl.cvl_jenis_order');
		return true;
	}

	public function upJnsOrder($data, $id)
	{
		$this->db->where('jenis_order_id', $id);
		$this->db->update('cvl.cvl_jenis_order', $data);
		return true;
	}

	public function listJnsPkj()
	{
		$sql = "SELECT * from cvl.cvl_jenis_pekerjaan order by cvl_jenis_pekerjaan";
		return $this->db->query($sql)->result_array();
	}

	public function listJnsPkjDetail($id = FALSE)
	{
		if ($id != FALSE) {
			$where = "where a.jenis_pekerjaan_id = " . $id . " ";
		} else {
			$where = "";
		}
		$sql = "select a.jenis_pekerjaan_id,a.jenis_pekerjaan_detail_id,b.jenis_pekerjaan,a.detail_pekerjaan,a.keterangan
				from cvl.cvl_jenis_pekerjaan_detail a
				inner join cvl.cvl_jenis_pekerjaan b 
				on a.jenis_pekerjaan_id = b.jenis_pekerjaan_id
				$where
				order by b.jenis_pekerjaan";
		return $this->db->query($sql)->result_array();
	}

	public function delJnsPkj($id)
	{
		$this->db->where('jenis_pekerjaan_id', $id);
		$this->db->delete('cvl.cvl_jenis_pekerjaan');
		return true;
	}

	public function upJnsPkj($data, $id)
	{
		$this->db->where('jenis_pekerjaan_id', $id);
		$this->db->update('cvl.cvl_jenis_pekerjaan', $data);
		return true;
	}

	public function upJnsPkjDetail($data, $id)
	{
		$this->db->where('jenis_pekerjaan_detail_id', $id);
		$this->db->update('cvl.cvl_jenis_pekerjaan_detail', $data);
		return true;
	}

	public function getStatusOrder()
	{
		$sql = "SELECT * from cvl.cvl_order_status order by status";
		return $this->db->query($sql)->result_array();
	}

	public function delsto($id)
	{
		$this->db->where('status_id', $id);
		$this->db->delete('cvl.cvl_order_status');
		return true;
	}

	public function upsto($data, $id)
	{
		$this->db->where('status_id', $id);
		$this->db->update('cvl.cvl_order_status', $data);
		return true;
	}

	public function getListOrder()
	{
		$sql = "select
					co.*,
					cp.jenis_pekerjaan ,
					(select string_agg(pekerjaan, ',<br>') from cvl.cvl_order_pekerjaan where order_id = co.order_id) as pekerjaan,
					cjo.jenis_order,
					es.section_name,
					el.location_name,
					(select count(*) from cvl.cvl_order_pekerjaan cop where cop.order_id = co.order_id) total_order,
					cos.status,
					cos.status_color,
					(select employee_name from er.er_employee_all eea where employee_code = co.pengorder) dari,
					(select employee_name from er.er_employee_all eea where employee_code = co.penerima_order ) ke
				from
					cvl.cvl_order co
				left join cvl.cvl_jenis_pekerjaan cp on
					cp.jenis_pekerjaan_id = co.jenis_pekerjaan_id
				left join cvl.cvl_jenis_order cjo on
					cjo.jenis_order_id = co.jenis_order_id
				left join er.er_section es on es.section_code = co.kodesie_pengorder
				left join er.er_location el on el.location_code = co.lokasi_pengorder
				left join cvl.cvl_order_status cos on cos.status_id = co.status_id
				order by co.order_id";
		return $this->db->query($sql)->result_array();
	}

	public function getListOrderid($id)
	{
		$sql = "select
					co.*,
					cp.jenis_pekerjaan ,
					cjo.jenis_order,
					es.section_name,
					el.location_name, 
					co.status_id,
					(select employee_name from er.er_employee_all eea where employee_code = co.pengorder) dari,
					(select employee_name from er.er_employee_all eea where employee_code = co.penerima_order ) ke
				from
					cvl.cvl_order co
				left join cvl.cvl_jenis_pekerjaan cp on
					cp.jenis_pekerjaan_id = co.jenis_pekerjaan_id
				left join cvl.cvl_jenis_order cjo on
					cjo.jenis_order_id = co.jenis_order_id
				left join er.er_section es on es.section_code = co.kodesie_pengorder
				left join er.er_location el on el.location_code = co.lokasi_pengorder
				where order_id in ('$id')";
		return $this->db->query($sql);
	}

	public function getDetailPkj($noind)
	{
		$sql = "SELECT
					*,
					t.lokasi_kerja
				from
					hrd_khs.tpribadi t
				left join hrd_khs.tseksi ts on
					ts.kodesie = t.kodesie
				left join hrd_khs.tlokasi_kerja tk on
					tk.id_ = t.lokasi_kerja
				where
					noind in ('$noind')";
		return $this->personalia->query($sql)->result_array();
	}

	public function insertOrder($data)
	{
		$this->db->insert('cvl.cvl_order', $data);
		return $this->db->insert_id();
	}

	public function insertAttachment($data)
	{
		$this->db->insert('cvl.cvl_order_attachment', $data);
	}

	public function updateOrder($data, $id)
	{
		$this->db->where('order_id', $id);
		$this->db->update('cvl.cvl_order', $data);
	}

	public function getListlampiran($id)
	{
		$this->db->where('order_id', $id);
		return $this->db->get('cvl.cvl_order_attachment')->result_array();
	}

	public function delAttachment($id)
	{
		$this->db->where('attachment_id', $id);
		$this->db->delete('cvl.cvl_order_attachment');
	}

	public function getAttachmentbyId($id)
	{
		$this->db->where('attachment_id', $id);
		return $this->db->get('cvl.cvl_order_attachment');
	}

	public function saveThread($data)
	{
		$this->db->insert('cvl.cvl_order_thread', $data);
	}

	public function getSettingbyId($id, $tabel, $index)
	{
		$this->db->where($index, $id);
		return $this->db->get($tabel);
	}

	public function delOrder($id)
	{
		$this->db->where('order_id', $id);
		$this->db->delete('cvl.cvl_order');
	}

	public function insCVP($data)
	{
		$this->db->insert('cvl.cvl_order_pekerjaan', $data);
	}

	public function upCVP($data, $id)
	{
		$this->db->where('pekerjaan_id', $id);
		$this->db->update('cvl.cvl_order_pekerjaan', $data);
	}

	public function delCVP($id)
	{
		$this->db->where('pekerjaan_id', $id);
		$this->db->delete('cvl.cvl_order_pekerjaan');
	}

	public function insCOA($data)
	{
		$this->db->insert('cvl.cvl_order_approver', $data);
	}

	public function upCOA($data, $id)
	{
		$this->db->where('order_approver_id', $id);
		$this->db->update('cvl.cvl_order_approver', $data);
	}

	public function delCOA($id)
	{
		$this->db->where('order_approver_id', $id);
		$this->db->delete('cvl.cvl_order_approver');
	}

	public function getApprover()
	{
		$sql = "SELECT coa.*, ea.employee_name from cvl.cvl_order_approver coa
				left join er.er_employee_all ea on ea.employee_code = coa.approver";
		return $this->db->query($sql)->result_array();
	}

	public function getApproverbyId($id)
	{
		$sql = "SELECT coa.*, ea.employee_name from cvl.cvl_order_approver coa
				left join er.er_employee_all ea on ea.employee_code = coa.approver
				where coa.order_id = '$id'";
		return $this->db->query($sql)->result_array();
	}

	public function getKetByid($id)
	{
		$this->db->where('order_id', $id);
		return $this->db->get('cvl.cvl_order_pekerjaan')->result_array();
	}

	public function insPost($data)
	{
		$this->db->insert('cvl.cvl_order_post', $data);
	}

	public function getChatbyId($id)
	{
		$sql = "SELECT
					cop.*, trim(ea.employee_name) nama 
				from
					cvl.cvl_order_post cop
				left join er.er_employee_all ea on
					ea.employee_code = cop.post_by
				where
					cop.order_id = '$id'
				order by
					cop.post_id desc";

		return $this->db->query($sql)->result_array();
	}

	public function getJenisPekerjaanbyId($id)
	{
		$this->db->where('jenis_pekerjaan_id', $id);
		return $this->db->get('cvl.cvl_jenis_pekerjaan');
	}

	public function getJenisPekerjaanDetailbyId($id)
	{
		$this->db->where('jenis_pekerjaan_detail_id', $id);
		return $this->db->get('cvl.cvl_jenis_pekerjaan_detail');
	}

	public function getJabatanPKJ($noind)
	{
		$this->personalia->where('noind', $noind);
		return $this->personalia->get('hrd_khs.tpribadi');
	}
}
