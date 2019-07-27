<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_limbahmaster extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLimbahJenis($id = FALSE)
    {
        if ($id === FALSE) {
            $sql = "select limnis.id_jenis_limbah,
                            limnis.kode_limbah,
                            limnis.jenis_limbah as limbah_jenis,
                            liman.limbah_satuan as satuan,
                            liman.id_satuan as satuan_id,
                            limer.id_sumber as sumber_id,
                            limer.sumber as sumber_limbah,
                            limver.id_konversi as konversi_id,
                            limver.konversi as konversi,
                            (select string_agg(limsatall.limbah_satuan_all, ', ') from ga.ga_limbah_satuan_all limsatall where limsatall.id_jenis_limbah = limnis.id_jenis_limbah and limsatall.status = '1') satuan_all
                    from ga.ga_limbah_jenis as limnis
                        left join ga.ga_limbah_sumber as limer
                        on limnis.id_jenis_limbah = limer.id_jenis_limbah
                        left join ga.ga_limbah_satuan as liman
                        on limnis.id_jenis_limbah=liman.id_jenis_limbah
                        left join ga.ga_limbah_konversi as limver
                        on limnis.id_jenis_limbah=limver.id_jenis_limbah";
        } else {
            $sql = "select limnis.id_jenis_limbah,
                            limnis.kode_limbah as limbah_kode,
                            limnis.jenis_limbah as limbah_jenis,
                            liman.limbah_satuan as satuan,
                            liman.id_satuan as satuan_id,
                            limer.id_sumber as sumber_id,
                            limer.sumber as sumber_limbah,
                            limver.id_konversi as konversi_id,
                            limver.konversi as konversi,
                            (select string_agg(limsatall.limbah_satuan_all, ', ') from ga.ga_limbah_satuan_all limsatall where limsatall.id_jenis_limbah = limnis.id_jenis_limbah and limsatall.status = '1') satuan_all
                    from ga.ga_limbah_jenis as limnis
                        left join ga.ga_limbah_sumber as limer
                        on limnis.id_jenis_limbah = limer.id_jenis_limbah
                        left join ga.ga_limbah_satuan as liman
                        on limnis.id_jenis_limbah=liman.id_jenis_limbah
                        left join ga.ga_limbah_konversi as limver
                        on limnis.id_jenis_limbah=limver.id_jenis_limbah
                    where limnis.id_jenis_limbah='".$id."'";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getLimbahJenisID(){
        $query = "select max(cast(id_jenis_limbah as integer))+1 id from ga.ga_limbah_jenis;";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getMaxIDSatuanAll(){
        $query = "select max(cast(id_satuan_all as integer))+1 id from ga.ga_limbah_satuan_all;";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getSatuanLimbahAll(){
        $query = "select distinct trim(limbah_satuan_all) as satuan from ga.ga_limbah_satuan_all order by satuan asc";
        return $this->db->query($query)->result_array();
    }

    public function setLimbahJenis($data)
    {
        return $this->db->insert('ga.ga_limbah_jenis', $data);
    }

    public function setLimbahSatuan($satuan)
    {
        return $this->db->insert('ga.ga_limbah_satuan', $satuan);
    }

    public function setLimbahSumber($sumber)
    {
        return $this->db->insert('ga.ga_limbah_sumber', $sumber);
    }

    public function setLimbahKonversi($konversi)
    {
        return $this->db->insert('ga.ga_limbah_konversi', $konversi);
    }

    public function setLimbahSatuanAll($satuanall){
      $checkSatuan = $satuanall['limbah_satuan_all'];
      $check = "select count(limbah_satuan_all) from ga.ga_limbah_satuan_all where limbah_satuan_all = '$checkSatuan'";
      $check = $this->db->query($check)->row()->count;
      if($check == 0){
        $this->db->insert('ga.ga_limbah_satuan_all', $satuanall);
        return "1";
      }else{
        return "0";
      }
    }

    public function setSatuanAll($satuan){
      $this->db->insert('ga.ga_limbah_satuan_all', $satuan);
    }

    public function updateOffAll($id){
      $off = "update ga.ga_limbah_satuan_all set status = '0' where id_jenis_limbah = '$id'";
      $this->db->query($off);
    }

    public function updateSatuanAll($data){
      //// semua yg berhubungan dg no ind jd tdk aktif pertamanya ////
      $satuan = $data['limbah_satuan_all'];
      $id = $data['id_jenis_limbah'];

      $checkSatuan = $this->db->query("select * from ga.ga_limbah_satuan_all where limbah_satuan_all = '$satuan' and id_jenis_limbah = '$id'")->num_rows();
        if($checkSatuan == '0'){
          $this->db->insert('ga.ga_limbah_satuan_all', $data);
        }else{
          $active = "update ga.ga_limbah_satuan_all set status = '1' where limbah_satuan_all = '$satuan' and id_jenis_limbah = '$id'";
          $this->db->query($active);
        }
    }

    public function updateLimbahJenis($data, $id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->update('ga.ga_limbah_jenis', $data);
    }

    public function updateLimbahSatuan($satuan, $id)
    {
        $this->db->where('id_satuan', $id);
        $this->db->update('ga.ga_limbah_satuan', $satuan);
    }

    public function updateLimbahSumber($sumber, $id)
    {
        $this->db->where('id_sumber', $id);
        $this->db->update('ga.ga_limbah_sumber', $sumber);
    }

    public function updateLimbahKonversi($konversi, $id)
    {
        $this->db->where('id_konversi', $id);
        $this->db->update('ga.ga_limbah_konversi', $konversi);
    }

    public function deleteLimbahJenis($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_jenis');
    }

    public function deleteLimbahSatuan($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_satuan');
    }

    public function deleteLimbahSumber($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_sumber');
    }

    public function deleteLimbahKonversi($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_konversi');
    }

    public function deleteLimbahSatuanAll($id)
    {
        $this->db->where('id_jenis_limbah', $id);
        $this->db->delete('ga.ga_limbah_satuan_all');
    }

}

/* End of file M_limbahjenis.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_limbahjenis.php */
/* Generated automatically on 2017-11-13 08:49:52 */
