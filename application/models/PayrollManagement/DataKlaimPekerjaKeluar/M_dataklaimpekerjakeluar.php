<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dataklaimpekerjakeluar extends CI_Model
{

    public $table = 'pr.pr_transaksi_pembayaran_penggajian';
    public $table_asuransi = 'pr.pr_transaksi_asuransi';
    public $table_pajak = 'pr.pr_transaksi_hitung_pajak';
    public $table_kemahalan = 'pr.pr_transaksi_insentif_kemahalan';
    public $id = 'id_pembayaran_gaji';
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

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	// get data periode
    function checkPeriode($varYear,$varMonth)
    {
        $this->db->where('extract(year from tanggal)=', $varYear);
        $this->db->where('extract(month from tanggal)=', $varMonth);
        return $this->db->get($this->table)->row();
    }
	
	// get data periode
    function getDataPenggajian($varYear,$varMonth)
    {
        $this->db->where('extract(year from tanggal)=', $varYear);
        $this->db->where('extract(month from tanggal)=', $varMonth);
        return $this->db->get($this->table)->result();
    }
	
	function checkAvailNoind(){
		$query = "
			select a.noind
			from pr.pr_data_gajian_personalia as a
			left join pr.pr_master_pekerja as b on a.noind=b.noind
			where b.noind is null
			order by a.noind asc
		";
		$sql	= $this->db->query($query);
		return $sql->result();
	}
	
	function getHutang($noind,$varMonth,$varYear){
		$query	= "select a.no_hutang,a.noind,b.jumlah_transaksi,b.lunas,b.tgl_transaksi 
							from pr.pr_hutang_karyawan as a
							left join pr.pr_transaksi_hutang as b on a.no_hutang=b.no_hutang
							where extract(month from b.tgl_transaksi)='$varMonth' and extract(year from b.tgl_transaksi)='$varYear' and a.noind='$noind'";
		$sql		= $this->db->query($query);
		return $sql->result();
	}
	
	function getTransaksiPajak($varYear,$noind){
		$query	= "select * from pr.pr_transaksi_hitung_pajak where noind='$noind' and extract(year from tanggal)='$varYear' order by tanggal desc limit 1";
		$sql		= $this->db->query($query);
		return $sql->result();
	}
	
	function getMasterPtkp($stat_pajak,$jt_pajak,$date){
		$query	= "select * from pr.pr_master_param_ptkp where periode<='$date' and right(status_pajak,1)='0' and left(status_pajak,1)=left('$stat_pajak',1)";
		$sql		= $this->db->query($query);
		return $sql->result();
	}
	
	function getParameterPPh(){
		$query	= "select a.*,abs((to_number(batas_atas, '9999999999')- to_number(batas_bawah, '9999999999'))) as selisih,
							coalesce((select abs((to_number(batas_atas, '9999999999')- to_number(batas_bawah, '9999999999'))) from pr.pr_master_parameter_tarif_pph as b where b.kd_pph=(a.kd_pph-1)),0) as bef
							from pr.pr_master_parameter_tarif_pph as a
							order by a.kd_pph";
		$sql		= $this->db->query($query);
		return $sql->result();
	}
	
	function getDataGajianPersonalia($varYear,$varMonth,$date){
		$query	= "
		select 
			b.noind,a.kd_status_kerja,a.stat_pajak,a.jt_anak,a.jt_bkn_anak,a.kd_hubungan_kerja,a.no_koperasi, extract(year from age(to_date(a.tgl_lahir,'YYYY-MM-DD'))) as umur,a.masuk_kerja,
			b.tanggal,b.kd_jabatan,b.kodesie,(b.ip) as p_ip,(b.ik) as p_ik,(b.i_f) as p_if,b.if_htg_bln_lalu,(b.ubt) as p_ubt,(b.upamk) as p_upamk,
			(b.um) as p_um,(b.ims) as p_ims,(b.imm) as p_imm,b.lembur,b.htm,b.ijin,coalesce(b.htm_htg_bln_lalu,'0') as htm_htg_bln_lalu,coalesce(b.ijin_htg_bln_lalu,'0') as ijin_htg_bln_lalu,b.pot,
			b.tamb_gaji,b.hl,b.ct,b.putkop,b.plain,b.pikop,b.pspsi,b.putang,b.dl,b.tkpajak,b.ttpajak,
			b.pduka,b.utambahan,b.btransfer,b.denda_ik,b.p_lebih_bayar,b.pgp,b.tlain,b.xduka,b.ket,b.cicil,
			b.ubs,b.ubs_rp,b.p_um_puasa,b.kd_jns_transaksi,
			c.gaji_pokok,c.i_f,
			d.upamk,
			e.insentif_kemahalan,
			f.pot_pensiun,
			g.kd_bank,g.no_rekening,g.nama_pemilik_rekening,
			h.ip,h.ik,h.ims,h.imm,h.pot_duka,h.spsi,
			i.ubt,i.um,
			(j.jkk) as set_jkk,(j.jkm) as set_jkm,j.jht_kary,j.jht_prshn,j.jkn_kary,j.jkn_prshn,j.jpn_kary,j.jpn_prshn,
			k.max_jab,k.persentase_jab,k.max_pensiun,k.persentase_pensiun,
			l.jkk,l.jkm,l.jht_karyawan,l.jht_perusahaan,l.jpk_karyawan,l.jpk_perusahaan,l.batas_umur_jpk,l.batas_jpk,
			m.batas_max_jkn,m.jkn_tg_kary,m.jkn_tg_prshn,
			(case
				when left(a.noind,1)='G'
				then 
					(select jml_std_jam_per_bln from pr.pr_standart_jam_tkpw)
				else
					(select jml_std_jam_per_bln from pr.pr_standart_jam_umum)
			end) as std_jam,
			n.prosentase,
			coalesce(o.thr,'0') as thr, coalesce(o.ubthr,'0') as ubthr,
			coalesce((p.jumlah_klaim),'0') as klaim_cuti,
			(
				select sum(cast(aa.klaim_dl as float8)) 
				from pr.pr_transaksi_klaim_dl as aa 
				where aa.noind=a.noind and extract(year from aa.tanggal)=extract(year from b.tanggal) and extract(month from aa.tanggal)=extract(month from b.tanggal)
				group by aa.noind,COALESCE(to_char(aa.tanggal, 'YYYY-MM'), '') 
			) as klaim_dl,
			q.pot_transfer,q.pot_transfer_tg_prshn,
			r.insentif_kemahalan,
			s.bulan_sakit
			from pr.pr_data_gajian_personalia as b
			left join pr.pr_master_pekerja as a on a.noind=b.noind
			left join pr.pr_riwayat_gaji as c on a.noind=c.noind and c.tgl_berlaku<='$date' and c.tgl_tberlaku>'$date'
			left join pr.pr_riwayat_upamk as d on a.noind=d.noind and d.tgl_berlaku<='$date' and d.tgl_tberlaku>'$date'
			left join pr.pr_riwayat_insentif_kemahalan as e on a.noind=e.noind and e.tgl_berlaku<='$date' and e.tgl_tberlaku>'$date'
			left join pr.pr_master_pot_dana_pensiun as f on a.noind=f.noind
			left join pr.pr_riwayat_rekening_pekerja as g on a.noind=g.noind and g.tgl_berlaku<='$date' and g.tgl_tberlaku>'$date'
			left join pr.pr_master_param_komp_jab as h on a.kd_status_kerja=h.kd_status_kerja and a.kd_jabatan=h.kd_jabatan
			cross join pr.pr_master_param_komp_umum as i 
			left join pr.pr_riwayat_set_asuransi as j on a.kd_status_kerja=j.kd_status_kerja
			cross join pr.pr_master_param_pengurang_pajak as k 
			cross join pr.pr_master_param_tarif_jamsostek as l 
			cross join pr.pr_master_param_bpjs as m
			left join pr.pr_riwayat_penerima_konpensasi_lembur as n on a.kd_status_kerja=n.kd_status_kerja and a.kd_jabatan=n.kd_jabatan and ((date(to_char(now(),'yyyy-mm-dd')) - date(a.masuk_kerja))/30)>='3' and n.tgl_berlaku<='$date' and n.tgl_tberlaku>'$date'
			left join pr.pr_transaksi_hitung_thr as o on a.noind=o.noind and extract(year from b.tanggal)=extract(month from o.tanggal) and extract(month from b.tanggal)=extract(month from o.tanggal)
			left join pr.pr_transaksi_klaim_sisa_cuti as p on a.noind=p.noind and p.periode=COALESCE(to_char(b.tanggal, 'YYYY'), '')
			left join pr.pr_master_bank as q on q.kd_bank_induk=g.kd_bank
			left join pr.pr_riwayat_insentif_kemahalan as r on a.noind=r.noind and r.tgl_berlaku<='$date' and r.tgl_tberlaku>'$date'
			left join pr.pr_daftar_pekerja_sakit as s on a.noind=s.noind and extract(year from b.tanggal)=extract(year from s.tanggal) and extract(month from b.tanggal)>=extract(month from s.tanggal) and extract(month from b.tanggal)<=extract(month from s.tanggal)
			where k.periode_pengurang_pajak<='$date' and l.periode_jst<='$date' and a.noind='B0616' and
				extract(year from b.tanggal)='$varYear' and extract(month from b.tanggal)='$varMonth' and a.noind is not null
				order by b.noind
		";
		$sql	= $this->db->query($query);
		return $sql->result();
	}
	
	function getPekerjaSakit($id){
		$query	= "select * from pr.pr_master_tarif_pekerja_sakit where CAST(coalesce(bulan_awal, '0') AS integer)<='$id' and CAST(coalesce(bulan_akhir, '0') AS integer)>='$id'";
		$sql			= $this->db->query($query);
		return $sql->result();
	}
	
	function getKp($noind,$varYear,$varMonth){
		$this->db->where('substring(periode,1,4)=',$varYear);
		$this->db->where('substring(periode,6,2)=',$varMonth);
		$this->db->where('stat','KP');
		return $this->db->get('pr.pr_komp_tamb')->result();
	}
	
	function getTkp($noind,$varYear,$varMonth){
		$this->db->where('substring(periode,1,4)=',$varYear);
		$this->db->where('substring(periode,6,2)=',$varMonth);
		$this->db->where('stat','TKP');
		return $this->db->get('pr.pr_komp_tamb')->result();
	}
	
    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
	
	function insert_asuransi($data_asuransi)
	{
		$this->db->insert($this->table_asuransi,$data_asuransi);
	}
	
	function insert_transaksi_insentif_kemahalan($data_insentif_kemahalan){
		$this->db->insert($this->table_kemahalan,$data_insentif_kemahalan);
	}
	
	function insert_transaksi_pajak($data_pajak)
	{
		$this->db->insert($this->table_pajak,$data_pajak);
	}

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

// association
	function get_pr_jns_transaksi_data()
	{
		return $this->db->get('pr.pr_jns_transaksi')->result();
	}
	
	// ++++++++++++++++++++++++++++++++ Function Penggajian ++++++++++++++++++++++++++++++++++++
	function getMasterPekerja(){
		$this->db->where('keluar','0');
		return $this->db->get($this->tb_master_pekerja)->result();
	}

}

/* End of file M_transaksihutang.php */
/* Location: ./application/models/PayrollManagement/TransaksiHutang/M_transaksihutang.php */
/* Generated automatically on 2016-11-29 08:18:23 */