<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class M_patrolis extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
        $this->dl = $this->load->database('dinas_luar', true);
		date_default_timezone_set("Asia/Bangkok");
    }

    public function getPos($noind, $shift, $ronde)
    {
    	$sql = "SELECT
        ttq.*,
        case
            when zub.scan > 0 then
        case
            when zub.pertanyaan > 0 and zub.temuan > 0 then '2'
                else '1' end
        else '0' end status
            from
                \"Satpam\".titik_qrcode ttq
            left join (
                select
                    1 as scan,
                    tp.noind,
                    tp.id_patroli,
                    tp.pos ,
                    tp.tgl_shift,
                    (select count(*) from \"Satpam\".tjawaban tj
                    where tj.id_patroli = tp.id_patroli) pertanyaan,
                    (select count(*) from \"Satpam\".ttemuan tt 
                    where tt.id_patroli = tp.id_patroli) temuan
                from
                    \"Satpam\".tpatroli tp
                where
                    -- tp.noind = '$noind'
                    tp.tgl_shift = '$shift'
                    and tp.ronde = $ronde) zub on
                zub.pos = ttq.id order by ttq.id";
    	return $this->personalia->query($sql)->result_array();
    }

    public function getPosbyId($id)
    {
    	$sql = "SELECT * from \"Satpam\".titik_qrcode where id = '$id' order by id";
    	return $this->personalia->query($sql)->result_array();
    }

    public function getAllPos()
    {
        $sql = "SELECT * from \"Satpam\".titik_qrcode order by id";
        return $this->personalia->query($sql)->result_array();
    }


    public function ins_patroli($data)
    {
    	$this->personalia->insert('"Satpam".tpatroli', $data);
        $d['success'] = $this->personalia->affected_rows() > 0;
    	$d['id'] = $this->personalia->insert_id();
        return $d;
    }

    public function ins_temuan($data)
    {
    	$this->personalia->insert('"Satpam".ttemuan', $data);
    	return $this->personalia->affected_rows() > 0;
    }

    public function cek_pos($noind, $ronde, $pos, $shift)
    {
    	$sql = "SELECT
					*
				from
					\"Satpam\".tpatroli
				where
					-- noind = '$noind'
					tgl_shift = '$shift'
					and ronde = $ronde
					and pos = $pos";
		return $this->personalia->query($sql)->result_array();
    }

    public function chek_temuan($id)
    {
    	$sql = "select * from \"Satpam\".ttemuan t where id_patroli = $id";
    	return $this->personalia->query($sql)->result_array();
    }

    public function chek_jawaban($id)
    {
    	$sql = "select * from \"Satpam\".tjawaban t where id_patroli = $id";
    	return $this->personalia->query($sql)->result_array();
    }

    public function getlist_pertanyaan($id)
    {
    	$sql = "select * from \"Satpam\".tpertanyaan t where id_pertanyaan in ($id) order by id_pertanyaan";
    	return $this->personalia->query($sql)->result_array();
    }

     public function getAll_pertanyaan()
    {
        $sql = "select * from \"Satpam\".tpertanyaan t order by id_pertanyaan";
        return $this->personalia->query($sql)->result_array();
    }


    public function getlist_pertanyaan_done($id)
    {
    	$sql = "select tj.*, tp.pertanyaan from \"Satpam\".tjawaban tj
				left join \"Satpam\".tpertanyaan tp on tp.id_pertanyaan = tj.id_pertanyaan
				where id_patroli = $id order by tp.id_pertanyaan";
    	return $this->personalia->query($sql)->result_array();
    }

    public function insBJawaban($data)
    {
    	$this->personalia->insert_batch('"Satpam".tjawaban', $data);
    	return true;
    }

    public function insAttach($data)
    {
        $this->personalia->insert('"Satpam".tattachment', $data);
        return true;
    }

    public function getAttchId($id)
    {
        $this->personalia->where('id_patroli', $id);
        return $this->personalia->get('"Satpam".tattachment')->result_array();
    }

    public function getProfile($noind)
    {
        if (date('H:i:s') < '12:00:00') 
            $date = date('Y-m-d', strtotime('-1 days'));
        else
            $date = date('Y-m-d');

        $sql = "SELECT noind, trim(nama) nama, '$date' shift, path_photo
                from hrd_khs.tpribadi where noind = '$noind'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getRonde($tgl_shift, $ronde)
    {
        $sql = "SELECT
                tp.ronde,
                case
                    when count(distinct(tp.id_patroli)) = count(distinct(tt.id_patroli))
                    and count(distinct(tp.id_patroli)) = count(distinct(tj.id_patroli))
                    and count(distinct(tp.id_patroli)) = (select count(*) from \"Satpam\".titik_qrcode tq) then 1
                    else 0 end selesai
                from
                    \"Satpam\".tpatroli tp
                left join \"Satpam\".ttemuan tt on
                    tt.id_patroli = tp.id_patroli
                left join \"Satpam\".tjawaban tj on
                    tj.id_patroli = tp.id_patroli
                where
                    tgl_shift = '$tgl_shift'
                    and ronde = $ronde
                group by
                    ronde";
                    // echo $sql;exit();
        return $this->personalia->query($sql)->row_array();
    }

    public function insertPertanyaan($data)
    {
        $this->personalia->insert('"Satpam".tpertanyaan', $data);
        return $this->personalia->affected_rows() > 0;
    }

    public function hapusPertanyaan($id)
    {
        $this->personalia->where('id_pertanyaan', $id);
        $this->personalia->delete('"Satpam".tpertanyaan');
        return $this->personalia->affected_rows() > 0;
    }

    public function updatePertanyaan($data, $id)
    {
        $this->personalia->where('id_pertanyaan', $id);
        $this->personalia->update('"Satpam".tpertanyaan', $data);
        return $this->personalia->affected_rows() > 0;
    }

    public function insertTitik($data)
    {
        $this->personalia->insert('"Satpam".titik_qrcode', $data);
        return $this->personalia->affected_rows() > 0;
    }

    public function getIdTitik()
    {
        $sql = "SELECT max(id) id from \"Satpam\".titik_qrcode";
        return $this->personalia->query($sql)->row()->id+1;
    }

    public function updateTitik($data, $id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->update('"Satpam".titik_qrcode', $data);
        return $this->personalia->affected_rows() > 0;
    }

    public function deleteLoaksi($id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->delete('"Satpam".titik_qrcode');
        return $this->personalia->affected_rows() > 0;
    }

    public function getPekerjaTpribadi($param)
    {
        $sql = "SELECT * from hrd_khs.tpribadi where (noind like '%$param%' or nama like '%$param%') and keluar = false";
        return $this->personalia->query($sql)->result_array();
    }

    public function getRekapDataHarian($pr, $pkj)
    {
        $and = '';
        if (!empty($pkj)) {
            $pkj = implode("', '", $pkj);
            $and = "and tt.noind in ('$pkj')";
        }
        $sql = "SELECT
                    tt.*,
                    trim(tp.nama) nama,
                    tq.latitude lat_asli,
                    tq.longitude long_asli
                from
                    \"Satpam\".tpatroli tt
                left join hrd_khs.tpribadi tp on
                    tp.noind = tt.noind
                    left join \"Satpam\".titik_qrcode tq on tq.id = tt.pos
                where tt.tgl_shift::date >= '$pr[0]' and tt.tgl_shift <= '$pr[1]' $and
                order by tgl_shift, ronde, pos";
                // echo $sql;;exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function getKolomRekap($tgl)
    {
        $sql = "SELECT 
                distinct pos,
                (SELECT case when kode = 'Tidak Scan' then concat(jam_patroli::text,'N') else jam_patroli::text end jam_patroli from \"Satpam\".tpatroli tp1 
                where tp1.tgl_shift = tp0.tgl_shift and ronde = 1 and tp1.pos = tp0.pos) r1,
                (select case when kode = 'Tidak Scan' then concat(jam_patroli::text,'N') else jam_patroli::text end jam_patroli from \"Satpam\".tpatroli tp2 
                where tp2.tgl_shift = tp0.tgl_shift and ronde = 2 and tp2.pos = tp0.pos) r2,
                (select case when kode = 'Tidak Scan' then concat(jam_patroli::text,'N') else jam_patroli::text end jam_patroli from \"Satpam\".tpatroli tp3 
                where tp3.tgl_shift = tp0.tgl_shift and ronde = 3 and tp3.pos = tp0.pos) r3,
                (select case when kode = 'Tidak Scan' then concat(jam_patroli::text,'N') else jam_patroli::text end jam_patroli from \"Satpam\".tpatroli tp4
                where tp4.tgl_shift = tp0.tgl_shift and ronde = 4 and tp4.pos = tp0.pos) r4
                FROM \"Satpam\".tpatroli tp0
                where tgl_shift::date = '$tgl'
                order by pos;";
        return $this->personalia->query($sql)->result_array();
    }

    public function getSatpambyShift($tgl)
    {
        $sql = "select
                    distinct tp.noind,
                    trim(tp.nama) nama
                from
                    \"Satpam\".tpatroli tr
                left join hrd_khs.tpribadi tp on
                    tp.noind = tr.noind
                where
                    tgl_shift = '$tgl'";
                    // echo $sql;exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function getKesimpulanbyId($pr)
    {
        $this->personalia->where('periode', $pr);
        return $this->personalia->get('"Satpam".tkesimpulan')->result_array();
    }

    public function ins_kesimpulan($arr)
    {
        $this->personalia->insert('"Satpam".tkesimpulan', $arr);
        return $this->personalia->affected_rows() != 0;
    }

    public function hapusKesimpulan($id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->delete('"Satpam".tkesimpulan');
        return $this->personalia->affected_rows() > 0;
    }

    public function upkesimpulan($data, $id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->update('"Satpam".tkesimpulan', $data);
        return $this->personalia->affected_rows() > 0;
    }

    public function getPutaranperLok($awal, $akhir)
    {
        $sql = "SELECT id,lokasi,
                (select count(*) from \"Satpam\".tpatroli t 
                where t.pos = tq.id 
                and t.tgl_shift >= '$awal' and t.tgl_shift <= '$akhir') putaran
                FROM \"Satpam\".titik_qrcode tq
                order by tq.id";
                // echo $sql;exit();
        return $this->personalia->query($sql)->result_array();
    }

    public function getPatroliCT($tgl, $ronde)
    {
        $sql = "select id_patroli, ronde, pos from \"Satpam\".tpatroli tp
                where tp.tgl_shift = '$tgl' and tp.ronde = '$ronde'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getJawabanCT($tgl)
    {
        $sql = "SELECT tp.id_patroli, tp.pos, tp.ronde,
                (SELECT string_agg(tj.id_pertanyaan::text, ',') from \"Satpam\".tjawaban tj where tj.id_patroli = tp.id_patroli) ask,
                (SELECT string_agg(tj.jawaban::text, ',') from \"Satpam\".tjawaban tj where tj.id_patroli = tp.id_patroli)
                jawaban
                FROM \"Satpam\".tpatroli tp
                where tp.tgl_shift = '$tgl'
                order by tp.pos;";
        return $this->personalia->query($sql)->result_array();
    }

    public function getTemuanCT($tgl)
    {
        $sql = "select string_agg(tt.deskripsi, '|') deskripsi , tp.pos from \"Satpam\".ttemuan tt
                left join \"Satpam\".tpatroli tp on tp.id_patroli = tt.id_patroli
                where tp.tgl_shift = '$tgl'
                and tt.deskripsi not like '%Tidak ada Temuan%'
                group by tp.pos;";
        return $this->personalia->query($sql)->result_array();
    }

    public function getAttachCT($tgl)
    {
        $sql = "select string_agg(ta.nama_file, '|') nama_file , tp.pos from \"Satpam\".tattachment ta
                left join \"Satpam\".tpatroli tp on tp.id_patroli = ta.id_patroli
                where tp.tgl_shift = '$tgl'
                group by tp.pos";
        return $this->personalia->query($sql)->result_array();
    }

    public function insCetakan($data)
    {
        $this->personalia->insert('"Satpam".trekap', $data);
    }

    public function upCetakan($data, $id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->update('"Satpam".trekap', $data);
    }

    public function getRekapID()
    {
        $sql = "select COALESCE(max(id), 0) max from \"Satpam\".trekap";
        return $this->personalia->query($sql)->row()->max+1;
    }

    public function getTrekapJenis($jns)
    {
        $this->personalia->where('jenis', $jns);
        return $this->personalia->get('"Satpam".trekap')->result_array();
    }

    public function getRekapbyID($id)
    {
        $this->personalia->where('id', $id);
        return $this->personalia->get('"Satpam".trekap')->result_array();
    }

    public function getRekapbyPeriode($pr)
    {
        $this->personalia->where('periode', $pr);
        return $this->personalia->get('"Satpam".trekap');
    }

    public function delTrekap($id)
    {
        $this->personalia->where('id', $id);
        $this->personalia->delete('"Satpam".trekap');
        return $this->personalia->affected_rows() > 0;
    }

    public function getTTD($noind)
    {
        $sql = "SELECT * from hrd_khs.tpribadi t where noind = '$noind'";
        return $this->personalia->query($sql)->result_array();
    }

    public function getApproval1($id)
    {
        $sql =  "SELECT approval_1 noind, trim(tp.nama) nama from \"Satpam\".trekap tr
                left join hrd_khs.tpribadi tp on tp.noind = tr.approval_1
                where tr.id = '$id'";
        return $this->personalia->query($sql)->row_array();
    }
    public function getApproval2($id)
    {
        $sql =  "SELECT approval_2 noind, trim(tp.nama) nama from \"Satpam\".trekap tr
                left join hrd_khs.tpribadi tp on tp.noind = tr.approval_2
                where tr.id = '$id'";
        return $this->personalia->query($sql)->row_array();
    }

    public function posTerakhir($shift)
    {
        $sql = "SELECT
                    *
                from
                    \"Satpam\".tpatroli t
                where
                    tgl_shift = '$shift'
                order by
                    id_patroli desc
                limit 1";
        $row = $this->personalia->query($sql)->num_rows();
        if ($row < 1) {
            return 0;
        }else{
            return $this->personalia->query($sql)->row()->ronde;
        }
    }

    public function getScann($shift, $ronde)
    {
        $sql = "SELECT
                    count(distinct(tp.id_patroli)) patroli,
                    count(distinct(tt.id_patroli)) temuan,
                    count(distinct(tj.id_patroli)) jawaban,
                    (select count(*) from \"Satpam\".titik_qrcode) jumlah
                from
                    \"Satpam\".tpatroli tp
                left join \"Satpam\".ttemuan tt on
                    tt.id_patroli = tp.id_patroli
                left join \"Satpam\".tjawaban tj on
                    tj.id_patroli = tp.id_patroli
                where
                    tgl_shift = '$shift'
                    and ronde = $ronde";
                    // echo $sql;exit();
        return $this->personalia->query($sql)->row_array();
    }

    public function loginSatpam($user,$password)
    {
        $sql = "select * from t_pekerja where keluar='0' and noind='$user' and (pass_word='$password' or token='$password')";
        return $this->dl->query($sql)->num_rows() > 0;
    }

    public function p_jam_terakhir()
    {
        $sql = "select tgl_server tgl from \"Satpam\".tpatroli t order by id_patroli desc limit 1";
        if($this->personalia->query($sql)->num_rows() > 0)
            return $this->personalia->query($sql)->row()->tgl;
        else
            return 0;
    }
}