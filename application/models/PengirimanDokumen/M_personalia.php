<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_personalia extends CI_Model
{
    function __construct(){
        parent::__construct();
        // $this->load->database();
        $this->db = $this->load->database('erp_db', true);
        $this->personalia = $this->load->database('personalia', true);
    }

    function queryApproval($status, $level,$start = false, $end = false){
        $kodesie = substr($this->session->kodesie, 0, 7);
        $user = $this->session->user;
        // echo $kodesie;exit();
        if ($level == 1) {
            $akses = " and '$user' in ('P0601', 'A2395', 'B0696', 'B0697', 'J1370') ";
        }else{
            $akses = " and '$user' in ('P0597', 'P0322')";
        }

        if($status == 'pending'){
            if($level == 1){
                $stat = '0';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and td.status='$stat'";
            }else{
                $stat = '1';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and tr.status='$stat' and td.status='$stat'";
            }

            $selecta = "SELECT td.id_data, 
                                td.noind, 
                                emp.employee_name nama,
                                substring(emp.section_code,0,8) kd_sie,
                                tm.keterangan, 
                                td.tanggal_start::date, 
                                td.tanggal_end::date,tr.status, 
                                max(tr.tgl_update)::date tgl_update, 
                                ap.kodesie, 
                                td.alasan,
                                td.lokasi,
                                ( 
                                	case when es.section_name = '-' then 
                                		case when es.unit_name = '-' then 
                                			case when es.field_name = '-' then 
                                				concat('dept ',es.department_name)
                                			else 
                                				concat('bidang ', es.field_name)
                                			end
                                		else 
                                			concat('unit ',es.unit_name)
                                		end
                                	else 
                                		es.section_name
                                	end
                                ) 
                                seksi_name
                        FROM ps.tdata td 
                                inner join ps.tappr ap on td.id_master = ap.id 
                                inner join ps.tmaster tm on tm.id = td.id_master
                                inner join ps.triwayat tr on tr.id_data = td.id_data
                                inner join er.er_employee_all emp on emp.employee_code = td.noind
                                inner join er.er_section es on emp.section_code = es.section_code 
                        WHERE $where $akses
                        GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, ap.kodesie, td.alasan, seksi_name, td.lokasi,es.section_name,es.unit_name,es.field_name,es.department_name
            ;";
        }else{
            if ($status == 'approved') {
                if ($level == 1) {
                    $stat = '1';
                } else {
                    $stat = '3';
                }
            } else {
                if ($level == 1) {
                    $stat = '2';
                } else {
                    $stat = '4';
                }
            }

            if ($start !== FALSE && $end !== FALSE) {
            	$periode = "and td.tanggal_start between '$start' and '$end' and td.tanggal_end between '$start' and '$end' ";
            }else{
            	$periode = "and td.tanggal_start between (now() - interval '1 month')::date and  now()::date and td.tanggal_end between (now() - interval '2 month')::date and  now()::date ";
            }

            $selecta = "SELECT td.id_data,
                                td.noind, 
                                emp.employee_name nama,
                                substring(emp.section_code, 0,8) kd_sie, 
                                tm.keterangan, 
                                td.tanggal_start::date, 
                                td.tanggal_end::date, 
                                tr.status,
                                max(tr.tgl_update)::date tgl_update, 
                                tr.seksi,
                                td.alasan,
                                td.lokasi,
                                ( 
                                	case when es.section_name = '-' then 
                                		case when es.unit_name = '-' then 
                                			case when es.field_name = '-' then 
                                				concat('dept ',es.department_name)
                                			else 
                                				concat('bidang ', es.field_name)
                                			end
                                		else 
                                			concat('unit ',es.unit_name)
                                		end
                                	else 
                                		es.section_name
                                	end
                                ) 
                                seksi_name
                        FROM ps.tdata td
                            inner join ps.tmaster tm on tm.id = td.id_master 
                            inner join ps.triwayat tr on tr.id_data = td.id_data 
                            inner join er.er_employee_all emp on emp.employee_code = td.noind 
                            inner join er.er_section es on emp.section_code = es.section_code 
                        WHERE tr.seksi='$kodesie' and tr.status = '$stat' and tr.level='$level' $periode $akses
                        GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, tr.seksi, td.alasan, seksi_name,td.lokasi
                        order by td.tanggal_start,td.noind
                        ";
        }
        return $this->db->query($selecta)->result_array();
    }

    function queryApprovalJumlah($status, $level){
        $kodesie = substr($this->session->kodesie, 0, 7);
        $user = $this->session->user;
        // echo $kodesie;exit();
        if ($level == 1) {
            $akses = " and '$user' in ('P0601', 'A2395', 'B0696', 'B0697', 'J1370') ";
        }else{
            $akses = " and '$user' in ('P0597', 'P0322')";
        }

        if($status == 'pending'){
            if($level == 1){
                $stat = '0';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and td.status='$stat'";
            }else{
                $stat = '1';
                $where = "ap.kodesie='$kodesie' and ap.tingkat='$level' and tr.status='$stat' and td.status='$stat'";
            }

            $selecta = "select count(*) as jml
				from (
					SELECT count(*)
	                FROM ps.tdata td 
	                        inner join ps.tappr ap on td.id_master = ap.id 
	                        inner join ps.tmaster tm on tm.id = td.id_master
	                        inner join ps.triwayat tr on tr.id_data = td.id_data
	                        inner join er.er_employee_all emp on emp.employee_code = td.noind 
	                WHERE $where $akses
	                GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, ap.kodesie, td.alasan,  td.lokasi
            	) as tbl;";
        }else{
            if ($status == 'approved') {
                if ($level == 1) {
                    $stat = '1';
                } else {
                    $stat = '3';
                }
            } else {
                if ($level == 1) {
                    $stat = '2';
                } else {
                    $stat = '4';
                }
            }

            $selecta = "select count(*) as jml
				from (
					SELECT count(*)
	                FROM ps.tdata td
	                    inner join ps.tmaster tm on tm.id = td.id_master 
	                    inner join ps.triwayat tr on tr.id_data = td.id_data 
	                    inner join er.er_employee_all emp on emp.employee_code = td.noind 
	                WHERE tr.seksi='$kodesie' and tr.status = '$stat' and tr.level='$level' $akses
	                GROUP BY td.id_data,td.noind, emp.employee_name, emp.section_code, tm.keterangan, td.tanggal_start, td.tanggal_end, tr.status, tr.seksi, td.alasan, td.lokasi
                ) as tbl";
        }
        return $this->db->query($selecta)->row()->jml;
    }

    function getNameSeksiByNoind($noind){
        $sql = "SELECT kodesie FROM hrd_khs.tpribadi WHERE noind ='$noind' and keluar='0'";
        $kodesie = substr($this->personalia->query($sql)->row()->kodesie, 0, 7);

        $sql = "SELECT distinct seksi FROM hrd_khs.tseksi where substr(kodesie,0,8) = '$kodesie'";
        return $this->personalia->query($sql)->row()->seksi;
    }

    function allSection(){
		$sql = "select kodesie, coalesce(nullif(trim(seksi), '-'), nullif(trim(unit),'-'), nullif(trim(bidang),'-'), dept) as nama from hrd_khs.tseksi where substring(kodesie, 8,11) = '00' and trim(seksi) <> '-' order by 1";
        return $this->personalia->query($sql)->result_object();
    }

    function updateTdataById($data, $id){
    	$this->db->where('id_data', $id);
    	$this->db->update('ps.tdata', $data);
    }

    function insertRiwayat($triwayat){
    	$this->db->insert('ps.triwayat', $triwayat);
    }

    function getRekap($start,$end,$dokumen,$seksi,$lokasi){
    	$selectRekap = 
        "SELECT td.id_data, 
                td.noind, 
                emp.employee_name nama, 
                substring(emp.section_code,0,8) kodesie, 
                tm.id, 
                tm.keterangan, 
                td.status,
                (case when td.lokasi='01' then concat('JOGJA')  when td.lokasi='02' then concat('TUKSONO') else concat('-') end) as lok,
                td.tanggal_start::date, 
                td.tanggal_end::date, 
                tr.seksi as approver,
                tr.tgl_update as app_time,
                td.alasan
        FROM ps.tdata td 
            inner join er.er_employee_all emp on td.noind = emp.employee_code 
            inner join ps.tmaster tm on td.id_master = tm.id 
            inner join ps.triwayat tr on tr.id_data = td.id_data
        WHERE tanggal_end between '$start' and '$end' 
            and td.status not in ('0') 
            and tr.level = (select max(level) from ps.triwayat where id_data = td.id_data) 
            $dokumen 
            $seksi 
            $lokasi
        ORDER BY tanggal_end asc";
        return $this->db->query($selectRekap)->result_array();
    }

    function changeApproval($id,$kodesie,$approval,$alasan){
    	$sql = "SELECT level FROM ps.triwayat WHERE id_data = '$id' AND seksi = '$kodesie' AND level <> '0' ;";
        $level = $this->db->query($sql)->row()->level;
        if($level == 1){
            if($approval == 'true'){ //true
                $sql  = "UPDATE ps.tdata SET status='1', alasan='' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status='1' WHERE id_data='$id' AND level = '$level';";
            }else{
                $sql  = "UPDATE ps.tdata set status='2', alasan='$alasan' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '2' WHERE id_data='$id' AND level = '1';";
                $sql .= "UPDATE ps.triwayat SET status = '4' WHERE id_data='$id' AND level = '2';";
            }
        }else{
            if($approval == 'true'){ //true
                $sql  = "UPDATE ps.tdata set status='3', alasan='' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '3' WHERE id_data='$id' AND level = '$level';";
            }else{
                $sql  = "UPDATE ps.tdata SET status='4', alasan='$alasan' where id_data='$id';";
                $sql .= "UPDATE ps.triwayat SET status = '2' WHERE id_data='$id' AND level = '1';";
                $sql .= "UPDATE ps.triwayat SET status = '4' WHERE id_data='$id' AND level = '2';";
            }
        }

        $this->db->query($sql);
    }
    
}
