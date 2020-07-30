<?php Defined('BASEPATH') or exit('No direct script accsess allowed');
/**
 * 
 */
class M_databaseqtw extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->mysql        = $this->load->database('recruitment', true);
        $this->personalia   = $this->load->database('personalia', true);
    }

    public function getSekolah()
	{
		$sql = "SELECT kd_sek as id, sekolah as nama_univ from hrd_khs.tsekolah
				order by id";
		return $this->personalia->query($sql)->result_array();
    }
    
    public function getUniv()
	{
		$sql = "SELECT * FROM tb_univ order by id";
		return $this->mysql->query($sql)->result_array();
    }

    public function getAllAgenda()
    {
        $sql = "SELECT id_qtw, '('|| pemandu ||') ' || (SELECT trim(nama) from hrd_khs.tpribadi where noind = pemandu) || ' - ' || dtl_institusi as title, tanggal::date || ' ' || wkt_mulai as start, tanggal::date || ' ' || wkt_selesai as end FROM \"Sie_Pelatihan\".tdabes_qtw where status_qtw = '0' order by tanggal";
        return $this->personalia->query($sql)->result_array();
    }

    public function getAllData($id = false)
    {
        if ($id == true) {
            $where = "where a.id_qtw = '$id'";
        }else{
            $where = "where status_qtw = '0'";
        }
        $sql = "SELECT a.*, (a.pemandu || ' - ' || trim(b.nama)) as nama_pemandu, trim(b.photo) as photo, sum(a.pendamping) + sum(a.peserta) as total_peserta
                from \"Sie_Pelatihan\".tdabes_qtw a
                LEFT JOIN hrd_khs.tpribadi b on a.pemandu = b.noind
                $where
                group by a.id_qtw, a.jenis_institusi, a.dtl_institusi, a.pic, a.nohp_pic, a.alamat, a.prop, a.kab, a.kec, a.desa, a.kd_pos, a.kendaraan, a.jml_kendaraan, a.wkt_mulai, a.wkt_selesai, a.pemandu, a.created_date, a.tanggal, a.tujuan, a.pendamping, a.peserta, a.status_qtw, b.nama, b.photo
                order by a.id_qtw";
        return $this->personalia->query($sql)->result_array();
    }

    public function cekDataPemandu($id)
    {
        $sql = "SELECT pemandu FROM \"Sie_Pelatihan\".tdabes_qtw where id_qtw = '$id'";
        return $this->personalia->query($sql)->row()->pemandu;
    }

    public function getPemandu($tanggal, $term,  $mulai, $selesai, $loker = false)
    {
        if ($loker) {
            $lokasi = "and lokasi_kerja = '$loker'";
        }else{
            $lokasi = '';
        }
        $sql = "SELECT noind, trim(nama) as nama 
                FROM hrd_khs.tpribadi
                WHERE kodesie like '402010%' and keluar = '0' and (nama like '%$term%' or noind like '%$term%') $lokasi
                    and noind not in (
                        SELECT pemandu from \"Sie_Pelatihan\".tdabes_qtw where tanggal = '$tanggal' and (wkt_mulai between '$mulai' and '$selesai' or wkt_selesai between '$mulai' and '$selesai' )
                    )
                order by noind";
        return $this->personalia->query($sql)->result_array();
    }

    public function getDataGrafik($tahun)
    { 
        $sql = "SELECT '0' as no, 'Januari' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '01-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '1' as no, 'Februari' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '02-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '2' as no, 'Maret' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '03-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '3' as no, 'April' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '04-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '4' as no, 'Mei' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '05-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '5' as no, 'Juni' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '06-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '6' as no, 'Juli' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '07-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '7' as no, 'Agustus' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '08-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '8' as no, 'September' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '09-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '9' as no, 'Oktober' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '10-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '10' as no, 'November' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '11-$tahun' and status_qtw = '0') as jumlah group by bulan
                union
                SELECT '11' as no, 'Desember' as bulane, count(*) as jumlah from (SELECT to_char(tanggal, 'MonthYYYY') as bulan from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'MM-YYYY') = '12-$tahun' and status_qtw = '0') as jumlah group by bulan
                ORDER BY no
                ";
        return $this->personalia->query($sql)->result_array();
    }

    public function getDataLabel($params)
    {
        $sql = "SELECT (select noind|| ' - ' ||trim(nama) from hrd_khs.tpribadi where noind = pemandu) as nama_pemandu, to_char(tanggal, 'dd-Month-YYYY') as tanggalan, * from \"Sie_Pelatihan\".tdabes_qtw where to_char(tanggal, 'yyyy-mm') = '$params' and status_qtw = '0' order by tanggal";
        return $this->personalia->query($sql)->result_array();
    }

    //Insert - insert
    public function insertTdabesQtw($array)
    {
        $this->personalia->insert('"Sie_Pelatihan".tdabes_qtw', $array);
        return;
    }

    //Update - update
    public function updatePemandu($id, $set)
    {
       $this->personalia->where('id_qtw', $id);
       $this->personalia->update('"Sie_Pelatihan".tdabes_qtw', $set);
    }

    public function updateQTW($array, $id)
    {
        $this->personalia->where('id_qtw', $id);
        $this->personalia->update('"Sie_Pelatihan".tdabes_qtw', $array);
    }

    public function deleteData($id)
    {
        $this->personalia->where('id_qtw', $id);
        $this->personalia->set('status_qtw', true);
        $this->personalia->update('"Sie_Pelatihan".tdabes_qtw');
        return('sukses');
    }
    
}
