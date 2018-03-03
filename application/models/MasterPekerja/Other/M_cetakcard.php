<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_cetakcard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getDataWorker()
    {
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("select tp.*, (ts.seksi) as seksi
                                        from hrd_khs.tpribadi tp
                                        left join hrd_khs.tseksi ts
                                        on tp.kodesie=ts.kodesie
                                        where tp.keluar='0' 
                                        order by tp.noind");
    	return $sql->result_array();
    }

    // public function getWorker($noind,$nick){
    //     $sqlserver = $this->load->database('personalia',true);
    //     $sql = $sqlserver->query("select tp.*, (ts.seksi) as seksi, (upper('$nick')) as nama_panggilan
    //                                     from hrd_khs.tpribadi tp
    //                                     left join hrd_khs.tseksi ts
    //                                     on tp.kodesie=ts.kodesie
    //                                     where tp.keluar='0' and noind='$noind'
    //                                     order by tp.noind");
    //     return $sql->result_array();
    // }

    public function getWorker($noind,$nick){
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("select tp.noind,tp.nama,(upper('$nick')) as nama_panggilan,
                                    case
                                        when
                                            rtrim(ts.seksi)='-'
                                        then
                                            case
                                                when
                                                    rtrim(ts.unit)='-'
                                                then
                                                    case
                                                        when
                                                            rtrim(ts.bidang)='-'
                                                        then
                                                            ts.dept
                                                        else
                                                            ts.bidang
                                                    end
                                                else
                                                    ts.unit
                                            end
                                        else
                                            ts.seksi
                                    end
                                ,upper(tor.jabatan) as jabatan
                                from hrd_khs.tpribadi tp 
                                inner join hrd_khs.tseksi ts on tp.kodesie=ts.kodesie
                                inner join hrd_khs.torganisasi tor on tp.kd_jabatan=tor.kd_jabatan 
                                where tp.noind='$noind'");
        return $sql->result_array();
    }

    public function getPekerja($employee){
        $pgPersonalia = $this->load->database('personalia', true);
        $sql = $pgPersonalia->query("Select * from hrd_khs.tpribadi where upper(nama) like '%$employee%' and keluar=false");
        return $sql->result_array();
    }

    public function DataPekerja($key){
        $pgPersonalia = $this->load->database('personalia', true);
        $sql = $pgPersonalia->query("Select * from hrd_khs.tpribadi where noind='$key' and keluar=false");
        return $sql->result_array();
    }

}
