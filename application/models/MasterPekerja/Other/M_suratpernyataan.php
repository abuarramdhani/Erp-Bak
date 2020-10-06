<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_suratpernyataan extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);   
    }

    public function getrsKlinik($txt)
    {
    	$sql = "SELECT * from rs.trauma_center where
   				nmppk like '%$txt%' order by nmppk asc";
   		return $this->db->query($sql)->result_array();
    }

    public function get_lhibkerd($txt)
    {
    	$sql = "SELECT
					*
				from
					hrd_khs.tpribadi t
				where
					(kodesie like '4010101%'
					or noind in ('B0307', 'B0654'))
					and keluar = false
					and (nama like '%$txt%' or noind like '%$txt%')
					order by nama asc;";
		return $this->personalia->query($sql)->result_array();
    }

    public function getDetailPKJ($noind)
    {
    	$sql = "select
					t.*,
					tk.lokasi_kerja 
				from
					hrd_khs.tpribadi t
				left join hrd_khs.tlokasi_kerja tk on
					tk.id_ = t.lokasi_kerja
				where
					noind = '$noind'";
    	return $this->personalia->query($sql)->row_array();
    }

    public function getDetailKlinik($id)
    {
    	$this->db->where('id', $id);
    	return $this->db->get('rs.trauma_center')->row_array();
    }

    public function insSuper($data)
    {
    	$this->personalia->insert('"Surat".tsurat_pernyataan', $data);
    	return $this->personalia->insert_id();
    }

    public function getlSuper()
    {
    	$sql = "select
					tp.*,
					t.nama nama_pekerja,
					t2.nama nama_hubker
				from
					\"Surat\".tsurat_pernyataan tp
				left join hrd_khs.tpribadi t on
					t.noind = tp.pekerja
				left join hrd_khs.tpribadi t2 on
					t2.noind = tp.hubker
				order by
					id desc";
		return $this->personalia->query($sql)->result_array();
    }

    public function getlRS()
    {
    	return $this->db->get('rs.trauma_center')->result_array();
    }

    public function getSuperbyID($id)
    {
    	$sql = "select
					tp.*,
					t.nama nama_pekerja,
					t2.nama nama_hubker
				from
					\"Surat\".tsurat_pernyataan tp
				left join hrd_khs.tpribadi t on
					t.noind = tp.pekerja
				left join hrd_khs.tpribadi t2 on
					t2.noind = tp.hubker
					where tp.id = '$id'
				order by
					id desc";
		return $this->personalia->query($sql)->row_array();
    }

    public function upSuper($data, $id)
    {
    	$this->personalia->where('id', $id);
    	$this->personalia->update('"Surat".tsurat_pernyataan', $data);
    	return $this->personalia->affected_rows() > 0;
    }
}