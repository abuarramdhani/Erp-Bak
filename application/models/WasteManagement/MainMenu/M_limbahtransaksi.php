<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahtransaksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getLimbahTransaksi($id = FALSE)
    {
    	if ($id === FALSE) {
    		$sql = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id";
    	} else {
    		$sql = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id
                    WHERE limsi.id_transaksi = '".$id."'";
    	}

        $query = $this->db->query($sql);
    	return $query->result_array();
    }

    function LimbahWaiting(){
        $sql    = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            limnis.id_jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id
                        where limsi.konfirmasi='0'
                        order by creation_date desc";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function setLimbahTransaksi($data)
    {
        return $this->db->insert('ga.ga_limbah_transaksi', $data);
    }

    public function updateLimbahTransaksi($data, $id)
    {
        $this->db->where('id_transaksi', $id);
        $this->db->update('ga.ga_limbah_transaksi', $data);
    }

    public function deleteLimbahTransaksi($id)
    {
        $this->db->where('id_transaksi', $id);
        $this->db->delete('ga.ga_limbah_transaksi');
    }

    public function getJenisLimbah()
    {
        $sqlgetJenisLimbah = "SELECT * FROM ga.ga_limbah_jenis";
        $query = $this->db->query($sqlgetJenisLimbah);
        return $query->result_array();
    }

    public function getSeksi()
    {
        $sqlgetSeksi = "SELECT * FROM dm.dm_seksi";
        $query = $this->db->query($sqlgetSeksi);
        return $query->result_array();
    }

    public function getPerlakuan()
    {
        $sqlperlakuan = "SELECT * FROM ga.ga_limbah_perlakuan
                            order by id_perlakuan";
        $query = $this->db->query($sqlperlakuan);
        return $query->result_array();
    }

    public function getSatuan()
    {
        $sqlSatuan = "SELECT * FROM ga.ga_limbah_satuan";
        $query = $this->db->query($sqlSatuan);
        return $query->result_array();
    }

    public function getUser()
    {
        $sqlgetUser = "SELECT * FROM ga.ga_limbah_user";
        $query = $this->db->query($sqlgetUser);
        return $query->result_array();
    }

    public function filterLimbahKeluar($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbah = FALSE)
    {   
        $condition = '';
        if($jenislimbah == '' && $tanggalawal == '') {
            $condition = '';
        } else if($jenislimbah == true || $tanggalawal == true) {
            if($jenislimbah == true && $tanggalawal == true) {
                $condition = "and limar.jenis_limbah='$jenislimbah' and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";
            } elseif($jenislimbah != '') {
                $condition = "and limar.jenis_limbah='$jenislimbah'";    
            } elseif($tanggalawal != '') {
                $condition = "and limar.tanggal_keluar BETWEEN '$tanggalawal' AND '$tanggalakhir'";    
            }
        }

        $sqlfilterData = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            WHERE limar.konfirmasi_status='1' $condition 
                            Order By limar.tanggal_keluar ";

        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }

    public function filterLimbahMasuk($tanggalawal = FALSE,$tanggalakhir = FALSE, $jenislimbah = FALSE)
    {
        $condition = '';
        if($jenislimbah == '' && $tanggalawal == '') {
            $condition = '';
        } else if($jenislimbah == true || $tanggalawal == true) {
            if($jenislimbah == true && $tanggalawal == true) {
                $condition = "and limsi.jenis_limbah='$jenislimbah' and limsi.tanggal_transaksi BETWEEN '$tanggalawal' AND '$tanggalakhir'";
            } elseif($jenislimbah != '') {
                $condition = "and limsi.jenis_limbah='$jenislimbah'";   
            } elseif($tanggalawal != '') {
                $condition = "and limsi.tanggal_transaksi BETWEEN '$tanggalawal' AND '$tanggalakhir'";    
            }
        }

        $sqlfilterData = "SELECT limsi.*,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan,
                            dmsi.nama_seksi
                    from ga.ga_limbah_transaksi as limsi
                        left join ga.ga_limbah_jenis limnis
                            on limsi.jenis_limbah = limnis.id_jenis_limbah
                        left join ga.ga_limbah_perlakuan as liman
                            on limsi.perlakuan = liman.id_perlakuan
                        left join dm.dm_seksi as dmsi
                            on limsi.sumber_limbah=dmsi.seksi_id
                    WHERE limsi.konfirmasi='1' $condition
                    Order By limsi.tanggal_transaksi";
        $query = $this->db->query($sqlfilterData);
        return $query->result_array();
    }

    function kirimApprove($id)
    {
        $queryApprove   = " UPDATE  ga.ga_limbah_transaksi
                                SET     konfirmasi = 1      
                                WHERE   id_transaksi = '$id'";
        $sqlApprove     =   $this->db->query($queryApprove);
    }

    function kirimReject($id)
    {
        $queryReject   = " UPDATE  ga.ga_limbah_transaksi
                                SET     konfirmasi = 2      
                                WHERE   id_transaksi = '$id'";
        $sqlReject     =   $this->db->query($queryReject);
    }

    public function TotalLimbahBulanan($tanggalawal,$tanggalakhir)
    {
        $sqlTotalLimbahBulanan = "select            x.id_jenis_limbah,
                x.id_perlakuan,
                x.sumber,
                x.satuan,
                x.bulan,
                x.periode,
                (
                    select      limnis.jenis_limbah
                    from        ga.ga_limbah_jenis as limnis
                    where       limnis.id_jenis_limbah=x.id_jenis_limbah
                ) as jenis_limbah,
                (
                    select      liman.limbah_perlakuan
                    from        ga.ga_limbah_perlakuan as liman
                    where       liman.id_perlakuan=x.id_perlakuan
                ) as limbah_perlakuan,
                (
                    (
                        (
                            select      coalesce(sum(limsi.jumlah),0)
                            from        ga.ga_limbah_transaksi as limsi
                            where       limsi.jenis_limbah=x.id_jenis_limbah
                                        and     limsi.perlakuan=x.id_perlakuan
                                        and     to_char(limsi.tanggal_transaksi,'MM-YYYY')=x.periode
                        )
                        +
                        (
                            select      coalesce(sum(limar.jumlah_keluar),0)
                            from        ga.ga_limbah_keluar as limar
                            where       limar.jenis_limbah=x.id_jenis_limbah
                                        and     limar.perlakuan=x.id_perlakuan
                                        and     to_char(limar.tanggal_keluar,'MM-YYYY')=x.periode
                        )
                    )
                    *
                    (
                        select      coalesce((limver.konversi),0)
                        from        ga.ga_limbah_konversi as limver
                        where       limver.id_jenis_limbah=x.id_jenis_limbah
                    )
                )as total_limbah
    from            (
                    select distinct     limsi.jenis_limbah as id_jenis_limbah,
                                        limsi.perlakuan as id_perlakuan,
                                        limsi.jenis_sumber as sumber,
                                        limsi.satuan as satuan,
                                        date_part('month', limsi.tanggal_transaksi) as bulan,
                                        to_char(limsi.tanggal_transaksi,'MM-YYYY') as periode 
                    from                ga.ga_limbah_transaksi as limsi
                    where               limsi.konfirmasi='1'
                    union
                    select distinct     limar.jenis_limbah as id_jenis_limbah,
                                        limar.perlakuan as id_perlakuan,
                                        limar.sumber_limbah as sumber,
                                        limar.satuan as satuan,
                                        date_part('month', limar.tanggal_keluar) as bulan,
                                        to_char(limar.tanggal_keluar,'MM-YYYY') as periode
                    from                ga.ga_limbah_keluar as limar
                    where               limar.konfirmasi_status='1'
                    order by            id_jenis_limbah,
                                        id_perlakuan
                ) as x
    where to_date(x.periode,'MM-YYYY') between to_date(to_char('$tanggalawal'::date,'MM-YYYY'),'MM-YYYY') and to_date(to_char('$tanggalakhir'::date,'MM-YYYY'),'MM-YYYY')";
        $query = $this->db->query($sqlTotalLimbahBulanan);
        return $query->result_array();
    }

    public function getLimbahKeluar($id = FALSE)
    {
        if ($id === FALSE) {
            $query = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan";                          
        } else {
            $query = "SELECT limar.* ,
                            limnis.jenis_limbah,
                            liman.limbah_perlakuan
                        from ga.ga_limbah_keluar as limar
                            left join ga.ga_limbah_jenis as limnis
                            on limar.jenis_limbah = limnis.id_jenis_limbah
                            left join ga.ga_limbah_perlakuan as liman
                            on limar.perlakuan = liman.id_perlakuan
                            WHERE id_limbah_keluar = '".$id."'";
        }
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    public function selectSatuanLimbah($id_JenisLimbah){
        $sql="select * from ga.ga_limbah_satuan where id_jenis_limbah='".$id_JenisLimbah."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function selectSumberLimbah($id_JenisLimbah){
        $sql="select * from ga.ga_limbah_sumber where id_jenis_limbah='".$id_JenisLimbah."'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function HeaderExcel() {
        $sql = "select  limnis.id_jenis_limbah,
                        limnis.jenis_limbah,
                        limer.sumber
                from ga.ga_limbah_jenis as limnis
                left join ga.ga_limbah_sumber as limer
                on limnis.id_jenis_limbah=limer.id_jenis_limbah";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function PeriodeSebelum($tanggalawal)
    {
        $sqlPeriodeSebelum = "select            x.id_jenis_limbah,
                x.id_perlakuan,
                x.sumber,
                x.satuan,
                x.bulan,
                x.periode,
                (
                    select      limnis.jenis_limbah
                    from        ga.ga_limbah_jenis as limnis
                    where       limnis.id_jenis_limbah=x.id_jenis_limbah
                ) as jenis_limbah,
                (
                    select      liman.limbah_perlakuan
                    from        ga.ga_limbah_perlakuan as liman
                    where       liman.id_perlakuan=x.id_perlakuan
                ) as limbah_perlakuan,
                (
                    (
                        (
                            select      coalesce(sum(limsi.jumlah),0)
                            from        ga.ga_limbah_transaksi as limsi
                            where       limsi.jenis_limbah=x.id_jenis_limbah
                                        and     limsi.perlakuan=x.id_perlakuan
                                        and     to_char(limsi.tanggal_transaksi,'MM-YYYY')=x.periode
                        )
                        +
                        (
                            select      coalesce(sum(limar.jumlah_keluar),0)
                            from        ga.ga_limbah_keluar as limar
                            where       limar.jenis_limbah=x.id_jenis_limbah
                                        and     limar.perlakuan=x.id_perlakuan
                                        and     to_char(limar.tanggal_keluar,'MM-YYYY')=x.periode
                        )
                    )
                    *
                    (
                        select      coalesce((limver.konversi),0)
                        from        ga.ga_limbah_konversi as limver
                        where       limver.id_jenis_limbah=x.id_jenis_limbah
                    )
                )as total_limbah
            from            (
                    select distinct     limsi.jenis_limbah as id_jenis_limbah,
                                        limsi.perlakuan as id_perlakuan,
                                        limsi.jenis_sumber as sumber,
                                        limsi.satuan as satuan,
                                        date_part('month', limsi.tanggal_transaksi) as bulan,
                                        to_char(limsi.tanggal_transaksi,'MM-YYYY') as periode 
                    from                ga.ga_limbah_transaksi as limsi
                    where               limsi.konfirmasi='1'
                    union
                    select distinct     limar.jenis_limbah as id_jenis_limbah,
                                        limar.perlakuan as id_perlakuan,
                                        limar.sumber_limbah as sumber,
                                        limar.satuan as satuan,
                                        date_part('month', limar.tanggal_keluar) as bulan,
                                        to_char(limar.tanggal_keluar,'MM-YYYY') as periode
                    from                ga.ga_limbah_keluar as limar
                    where               limar.konfirmasi_status='1'
                    order by            id_jenis_limbah,
                                        id_perlakuan
                ) as x
            where to_date(x.periode, 'MM-YYYY') = '$tanggalawal'::date-interval '1 month'";
        $query = $this->db->query($sqlPeriodeSebelum);
        return $query->result_array();
    }

}

/* End of file M_limbahtransaksi.php */
/* Location: ./application/models/WasteManagement/MainMenu/M_limbahtransaksi.php */
/* Generated automatically on 2017-08-01 11:38:56 */