<?php
Defined('BASEPATH') or exit('No direct Script access allowed');
/**
 * 
 */
class M_rekapabsen extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database();
		$this->personalia = $this->load->database('personalia',TRUE);
	}

    // public function tampilData($tgl,$shift,$tempat_makan){
    //     $tgl = $this->input->post('tanggal_makan');
    //     $shift = $this->input->post('shift_makan');
    //     $tempat_makan = $this->input->post('tempat_makan');

    //     return $this->personalia->query($sql)->result_array();
    // }



    public function cari($tanggal,$shift,$tempat)
    {
        // echo $tanggal."-".$shift."-".$tempat;exit();
        if ($shift==1) {
            $shift=" ('1','4','5','8','18') ";
        }elseif ($shift==2) {
            $shift=" ('2') ";
        }else{
            $shift=" ('3') ";
        }

        if (isset($tempat) and !empty($tempat)) {
            $tmpt = " and tp.tempat_makan='$tempat'";
        }else{
            $tmpt = '';}

        $sql="select tpr.tanggal, tpr.noind, tp.nama,
                case when (select count (*) from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal )>= 1 then (select waktu from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal  = tpr.tanggal order by tanggal limit 1)
                    else '0'
                        end wkt1,
                case when (select count (*) from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal)>= 2 then(select waktu from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal order by tanggal limit 1 offset 1)
                    else '0'
                        end wkt2,
                case when(select count(*) from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal)>= 3 then( select waktu from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal order by tanggal limit 1 offset 2)
                    else '0'
                        end wkt3,
                case when(select count(*) from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal)>= 4 then(select waktu from \"FrontPresensi\".tpresensi ftp where ftp.noind = tpr.noind and ftp.tanggal = tpr.tanggal order by tanggal limit 1 offset 3)
                    else '0'
                        end wkt4,
                tp.tempat_makan
            from
             hrd_khs.tpribadi tp inner join \"FrontPresensi\".tpresensi tpr on
             tpr.noind = tp.noind inner join \"Presensi\".tshiftpekerja ts on
             ts.noind = tp.noind
            where
             tpr.tanggal = '$tanggal'
             $tmpt
             and ts.kd_shift in $shift
             and tp.keluar = '0'
            group by
             tpr.tanggal,
             tpr.noind,
             tp.nama,
             tp.tempat_makan
            order by
             tp.tempat_makan;";
    return $this->personalia->query($sql)->result_array();
    }
}
?>