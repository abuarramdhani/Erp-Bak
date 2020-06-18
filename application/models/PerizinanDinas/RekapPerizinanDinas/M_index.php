<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_index extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia',TRUE);
    }

    public function getAllNama()
    {
      return $this->personalia->query("SELECT DISTINCT noind, trim(nama) as nama FROM hrd_khs.tpribadi")->result_array();
    }

  	public function IzinApprove($periode)
  	{
  		$sql = "SELECT distinct ti.*,
                (case when ti.jenis_izin = '1' then 'DINAS PUSAT' when ti.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as to_dinas,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in ti.noind)>0) as pekerja,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in ti.atasan_aproval)>0) as atasan
                FROM \"Surat\".tperizinan ti $periode order by ti.created_date DESC, ti.status ";
  		$query = $this->personalia->query($sql);
  		return $query->result_array();
  	}

    public function getTujuanA($periode)
    {
        $sql="SELECT a.izin_id, (select concat(noind, ' - ', trim(nama)) from hrd_khs.tpribadi where a.noind = noind) as pekerja,
                (case when ti.izin_id::int = ta.izin_id::int then ta.tujuan else a.tujuan end) tujuan
                FROM \"Surat\".tperizinan ti
                LEFT JOIN \"Surat\".tpekerja_izin a on a.izin_id::int = ti.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin ta on ta.izin_id::int = ti.izin_id::int and ta.created_date::date = ti.created_date::date and a.noind = ta.noinduk $periode";
        return $this->personalia->query($sql)->result_array();
    }

    public function getPekerja($tanggal)
	{
		$sql = "SELECT distinct ti.izin_id,
                (case when ti.status_jalan = '-' or ti.status_jalan = ''
                        then 'Unapprove'
                    when ti.status_jalan = '0'
                        then 'Belum Berangkat'
                    when ti.status_jalan = '1'
                        then 'Berangkat1'
                    when ti.status_jalan = '2'
                        then 'Sampai Tujuan'
                    when ti.status_jalan = '3'
                        then 'Berangkat 2'
                    when ti.status_jalan = '4'
                        then 'Dinas Telah Selesai'
                    when ti.status_jalan = '5'
                        then 'Reject'
                    else 'Data_Lama'
                    end) as jalan_aja,
                (case when tp.jenis_izin = '1' then 'DINAS PUSAT' when tp.jenis_izin = '2' then 'DINAS TUKSONO' else 'DINAS MLATI' end) as to_dinas,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in ti.noind)>0) as pekerja,
                (select string_agg(concat(noind,' - ',trim(nama)),'<br>') from hrd_khs.tpribadi b where position(b.noind in tp.atasan_aproval)>0) as atasan,
                tp.keterangan, tp.created_date,
                (case when tai.tujuan = ti.tujuan and tai.izin_id::int = ti.izin_id::int and tai.noinduk = ti.noind then tai.tujuan else ti.tujuan end) as tujuan
				FROM \"Surat\".tpekerja_izin ti
                LEFT JOIN \"Surat\".tperizinan tp ON tp.izin_id = ti.izin_id::int
                LEFT JOIN \"Surat\".taktual_izin tai ON tai.izin_id::int = ti.izin_id::int $tanggal
				ORDER BY ti.izin_id DESC";
		return $this->personalia->query($sql)->result_array();
	}

    public function getNoind()
    {
        $sql = "SELECT noind, trim(nama) as nama from hrd_khs.tpribadi where keluar = '0'
                ORDER BY noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getIDIzin()
    {
        $sql = "SELECT izin_id from \"Surat\".tperizinan
                ORDER BY izin_id DESC";
        return $this->personalia->query($sql)->result_array();
    }

    public function getIDIzinbyID($id)
    {
        $sql = "SELECT * from \"Surat\".tperizinan
                where izin_id = '$id' ORDER BY izin_id DESC";
        return $this->personalia->query($sql)->result_array();
    }

    public function hapusIzin($id)
    {
        // $this->personalia->where('izin_id', $id);
        // $this->personalia->delete('"Surat".tperizinan');

        $this->personalia->where('izin_id', $id);
        $this->personalia->delete('"Surat".tpekerja_izin');

        $this->personalia->where('izin_id', $id);
        $this->personalia->delete('"Surat".taktual_izin');
        return true;
    }

} ?>
