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

    public function getWorker($noind,$nick){
        $sqlserver = $this->load->database('personalia',true);
        $sql = $sqlserver->query("select tp.noind,tp.nama, (upper('$nick')) as nama_panggilan,
                                    (
                                        case
                                            when
                                                tss.seksi is null
                                            then
                                                (
                                                    select 
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
                                                    from hrd_khs.tseksi ts where tp.kodesie=ts.kodesie
                                                )
                                            else
                                                tss.seksi
                                        end
                                    ) as seksi
                                ,upper(tsj.nama_jabatan) as jabatan,
                                tp.photo
                                from hrd_khs.tpribadi tp 
                                left join hrd_khs.tseksi_singkatan tss on left(tp.kodesie,7)=tss.kodesie
                                left join hrd_khs.tb_status_jabatan tsj on tp.noind=tsj.noind and tgl_tberlaku='9999-12-31' 
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
        $sql = $pgPersonalia->query("select tp.noind,tp.nama,
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
                                    ,upper(tsj.nama_jabatan) as jabatan,
                                    tp.photo
                                    from hrd_khs.tpribadi tp 
                                    left join hrd_khs.tseksi ts on tp.kodesie=ts.kodesie
                                    left join hrd_khs.tb_status_jabatan tsj on tp.noind=tsj.noind and tgl_tberlaku='9999-12-31' 
                                    where tp.noind='$key'");
        return $sql->result_array();
    }

}
