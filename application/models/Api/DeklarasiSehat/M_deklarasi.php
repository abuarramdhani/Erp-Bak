<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class M_deklarasi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
    }

    function insDeklarasi($data)
    {
        $this->personalia->insert('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function getDeklaraibyNoind($noind)
    {
        $sql = "SELECT
					*
				from
					hrd_khs.deklarasi_sehat
				where
					noind = '$noind'
				order by
					waktu_input desc,
					id_deklarasi desc";
        return $this->personalia->query($sql)->result_array();
    }

    function getDeklaraibyID($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        return $this->personalia->get('hrd_khs.deklarasi_sehat')->row_array();
    }

    function updDeklarasi($data, $id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->update('hrd_khs.deklarasi_sehat', $data);
        return $this->personalia->affected_rows();
    }

    function delDeklarasi($id)
    {
        $this->personalia->where('id_deklarasi', $id);
        $this->personalia->delete('hrd_khs.deklarasi_sehat');
        return $this->personalia->affected_rows();
    }

    function getAllPernyataan()
    {
        $sql = "SELECT * FROM hrd_khs.deklarasi_sehat_pertanyaan dsp order by aspek";
        return $this->personalia->query($sql)->result_array();
    }

    function getAllPernyataanByID($id_deklarasi)
    {
        $sql = "SELECT *,(select 
                    case dsp.aspek
                    when 'aspek_1_a' then b.aspek_1_a
                    when 'aspek_1_b' then b.aspek_1_b
                    when 'aspek_2_a' then b.aspek_2_a
                    when 'aspek_2_b' then b.aspek_2_b
                    when 'aspek_2_c' then b.aspek_2_c
                    when 'aspek_2_d' then b.aspek_2_d
                    when 'aspek_2_e' then b.aspek_2_e
                    when 'aspek_2_f' then b.aspek_2_f
                    when 'aspek_2_g' then b.aspek_2_g
                    when 'aspek_2_h' then b.aspek_2_h
                    when 'aspek_2_i' then b.aspek_2_i
                    when 'aspek_3_a' then b.aspek_3_a
                    end 
                    from hrd_khs.deklarasi_sehat b where id_deklarasi='$id_deklarasi') as status
                    FROM hrd_khs.deklarasi_sehat_pertanyaan dsp order by aspek";
        return $this->personalia->query($sql)->result_array();
    }

    function getDetailPKJ($noind)
    {
        $this->personalia->where('noind', $noind);
        return $this->personalia->get('hrd_khs.tpribadi')->row_array();
    }

    function cekNIK($nik)
    {
        $sql = "SELECT * FROM hrd_khs.tpribadi WHERE trim(nik) = '$nik' AND keluar in ('f', '0') limit 1";
        return $this->personalia->query($sql)->row_array();
    }
}
