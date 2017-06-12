<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_kompensasilembur extends CI_Model
{

    public $table = 'pr.pr_transaksi_konpensasi_lembur';
    public $table_master_pekerja = 'pr.pr_master_pekerja';
    public $id = 'id_kompensasi_lembur';
    public $order = 'DESC';
	
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // get all data
    function get_all()
    {
    	return $this->db->get($this->table)->result();
    }

	
	// ++++++++++++++++++++++++++++++++ Function Penggajian ++++++++++++++++++++++++++++++++++++
	function getMasterPekerja($varYear){
		$this->db->where('keluar=','0');
		$this->db->where('diangkat<=',$varYear.'-09-30');
		return $this->db->get($this->table_master_pekerja)->result();
	}
	
	    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($year,$noind, $data)
    {
        $this->db->where('extract(year from tanggal)=', $year);
        $this->db->where('noind=', $noind);
        $this->db->update($this->table, $data);
	}
	
	// get komp lembur
	function checkKompLembur($noind,$varYear){
		$this->db->where('noind=',$noind);
		$this->db->where('extract(year from tanggal)=',$varYear);
		return $this->db->get($this->table);
	}
	
	function hitungKompLembur($noind,$varYear){
		$query = "select sum((((cast(gaji_pokok as int)-cast(pot_htm as int))+cast(t_if as int)+cast(t_ik as int)+cast(t_ip as int)+cast(t_ikr as int))*25)/100) as konpensasi_lembur 
						from pr.pr_transaksi_pembayaran_penggajian where noind='$noind' and extract(year from tanggal)='$varYear' and extract(month from tanggal)<cast('12' as int) group by noind";
		$sql		= $this->db->query($query);
		return $sql->result();
	}
	
	function getKomLembur($varYear){
		$query	= "select a.noind,a.nama,a.kd_status_kerja,a.kodesie,coalesce(b.jumlah_konpensasi,'0') as jumlah_konpensasi,b.tanggal from pr.pr_master_pekerja as a
					left join pr.pr_transaksi_konpensasi_lembur as b on a.noind=b.noind and extract(year from b.tanggal)='$varYear'
					where a.keluar='0' and a.diangkat<='$varYear-09-30' and left(a.noind,1) in ('B','J')
					order by b.tanggal,a.noind";
		$sql		= $this->db->query($query);
		return $sql->result();
	}

}

/* End of file M_transaksihutang.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutang/M_transaksihutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */