<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }

    public function getKategori(){
    	$query = $this->db->query("select  concat(kg.id_kategori,'-',kd.id_kategori_detail) as id_kategori,
											concat(kg.kategori,'-',kd.kategori_detail) as kategori
									from	sm.sm_kategori as kg
									join sm.sm_kategori_detail as kd
									on	kg.id_kategori=kd.id_kategori
									order by id_kategori");
    	return $query->result_array();
    }

    public function addData($start,$end,$user_id,$tgl_proses,$kat_detail,$kat,$hari,$periode,$tanggalloop){
    	$query = $this->db->query("insert into sm.sm_jadwal (start_date,end_date,create_by,create_date,id_kategori_detail,id_kategori,index_hari,periode_jadwal,tanggal_jadwal) values ('$start','$end','$user_id','$tgl_proses','$kat_detail','$kat','$hari','$periode','$tanggalloop')");
    	return $query;
    }

    public function rekapData($start,$end,$kat,$kat_detail,$hari,$periode){
    	$query = $this->db->query("select jd.*,
                                            (select concat(kg.kategori,'-',kd.kategori_detail) 
                                            from sm.sm_kategori as kg
                                            join sm.sm_kategori_detail as kd
                                            on kg.id_kategori=kd.id_kategori
                                            where kg.id_kategori=jd.id_kategori and kd.id_kategori_detail=jd.id_kategori_detail) as kategori
                                    from sm.sm_jadwal as jd
                                    where jd.tanggal_jadwal between '$start' and '$end' and jd.id_kategori='$kat' and jd.id_kategori_detail='$kat_detail' and jd.index_hari='$hari' and jd.periode_jadwal='$periode'
                                    order by jd.tanggal_jadwal");
    	return $query;
    }

    public function UpdateDataMonitoring($id,$pic,$ket,$status){
        $query = $this->db->query("update sm.sm_jadwal 
                                    set pic='$pic',keterangan='$ket',status='$status' 
                                    where id_jadwal='$id'");
        return $query;
    }

    public function listMonitoring($kat,$kat_detail,$hari,$periode,$tanggalloop){
        $query = $this->db->query("select * from sm.sm_jadwal where id_kategori='$kat' and id_kategori_detail='$kat_detail' and index_hari='$hari' and periode_jadwal='$periode' and tanggal_jadwal='$tanggalloop'");
        return $query;
    }

    public function alertBathroom(){
        $query = $this->db->query("select x.*,
                                        (
                                            case    when    (
                                                                current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal
                                                            )
                                                            then    0
                                                    else    1
                                            end
                                        ) as overdue,
                                                                        (select concat(kg.kategori,'-',kd.kategori_detail) 
                                                                        from sm.sm_kategori as kg
                                                                        join sm.sm_kategori_detail as kd
                                                                        on kg.id_kategori=kd.id_kategori
                                                                        where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori 
                                                                    from sm.sm_jadwal as x
                                                                    where x.status=false 
                                                                        and (current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal) 
                                                                        and x.id_kategori=1
                                union
                                select x.*,
                                        (
                                            case    when    current_date>x.tanggal_jadwal
                                                            then    1
                                                    else    0
                                            end
                                        ) as overdue,
                                            (select concat(kg.kategori,'-',kd.kategori_detail) 
                                            from sm.sm_kategori as kg
                                            join sm.sm_kategori_detail as kd
                                            on kg.id_kategori=kd.id_kategori
                                            where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori
                                        from sm.sm_jadwal as x
                                        where x.status=false and (x.tanggal_jadwal::date<now()::date) and x.id_kategori=1
                                order by tanggal_jadwal");
        return $query->result_array();
    }

    public function alertFloorParking(){
        $query = $this->db->query("select x.*,
                                        (
                                            case    when    (
                                                                current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal
                                                            )
                                                            then    0
                                                    else    1
                                            end
                                        ) as overdue,
                                                                        (select concat(kg.kategori,'-',kd.kategori_detail) 
                                                                        from sm.sm_kategori as kg
                                                                        join sm.sm_kategori_detail as kd
                                                                        on kg.id_kategori=kd.id_kategori
                                                                        where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori 
                                                                    from sm.sm_jadwal as x
                                                                    where x.status=false 
                                                                        and (current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal)
                                                                        and x.id_kategori=2
                                union
                                select x.*,
                                        (
                                            case    when    current_date>x.tanggal_jadwal
                                                            then    1
                                                    else    0
                                            end
                                        ) as overdue,
                                            (select concat(kg.kategori,'-',kd.kategori_detail) 
                                            from sm.sm_kategori as kg
                                            join sm.sm_kategori_detail as kd
                                            on kg.id_kategori=kd.id_kategori
                                            where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori
                                        from sm.sm_jadwal as x
                                        where x.status=false and (x.tanggal_jadwal::date<now()::date) and x.id_kategori=2
                                order by tanggal_jadwal");
        return $query->result_array();
    }

    public function alertTrashCan(){
        $query = $this->db->query("select x.*,
                                        (
                                            case    when    (
                                                                current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal
                                                            )
                                                            then    0
                                                    else    1
                                            end
                                        ) as overdue,
                                                                        (select concat(kg.kategori,'-',kd.kategori_detail) 
                                                                        from sm.sm_kategori as kg
                                                                        join sm.sm_kategori_detail as kd
                                                                        on kg.id_kategori=kd.id_kategori
                                                                        where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori 
                                                                    from sm.sm_jadwal as x
                                                                    where x.status=false 
                                                                        and (current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal)
                                                                        and x.id_kategori=3
                                union
                                select x.*,
                                        (
                                            case    when    current_date>x.tanggal_jadwal
                                                            then    1
                                                    else    0
                                            end
                                        ) as overdue,
                                            (select concat(kg.kategori,'-',kd.kategori_detail) 
                                            from sm.sm_kategori as kg
                                            join sm.sm_kategori_detail as kd
                                            on kg.id_kategori=kd.id_kategori
                                            where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori
                                        from sm.sm_jadwal as x
                                        where x.status=false and (x.tanggal_jadwal::date<now()::date) and x.id_kategori=3
                                order by tanggal_jadwal");
        return $query->result_array();
    }

    public function alertLand(){
        $query = $this->db->query("select x.*,
                                        (
                                            case    when    (
                                                                current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal
                                                            )
                                                            then    0
                                                    else    1
                                            end
                                        ) as overdue,
                                                                        (select concat(kg.kategori,'-',kd.kategori_detail) 
                                                                        from sm.sm_kategori as kg
                                                                        join sm.sm_kategori_detail as kd
                                                                        on kg.id_kategori=kd.id_kategori
                                                                        where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori 
                                                                    from sm.sm_jadwal as x
                                                                    where x.status=false 
                                                                        and (current_date between (x.tanggal_jadwal - interval '7 day') and x.tanggal_jadwal)
                                                                        and x.id_kategori=4
                                union
                                select x.*,
                                        (
                                            case    when    current_date>x.tanggal_jadwal
                                                            then    1
                                                    else    0
                                            end
                                        ) as overdue,
                                            (select concat(kg.kategori,'-',kd.kategori_detail) 
                                            from sm.sm_kategori as kg
                                            join sm.sm_kategori_detail as kd
                                            on kg.id_kategori=kd.id_kategori
                                            where kg.id_kategori=x.id_kategori and kd.id_kategori_detail=x.id_kategori_detail) as kategori
                                        from sm.sm_jadwal as x
                                        where x.status=false and (x.tanggal_jadwal::date<now()::date) and x.id_kategori=4
                                order by tanggal_jadwal");
        return $query->result_array();
    }

}