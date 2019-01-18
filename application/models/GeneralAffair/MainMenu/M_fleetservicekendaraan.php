
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_fleetservicekendaraan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        date_default_timezone_set('Asia/Jakarta');
    }
    public function ambildatajenisservice($jenis_service)
    {
    	$this->db->where($jenis_service);
    	return $this->db->get('ga.ga_fleet_jenis_service')->result_array();
    }
    public function ambildatamerk($merk)
    {
    	$this->db->where($merk);
    	return $this->db->get('ga.ga_fleet_merk_kendaraan')->result_array();
    }
    public function updateFleetServiceWhenInsert($ru_where,$ru_data)
    {
    	$this->db->where($ru_where);
    	$this->db->update('ga.ga_fleet_service_kendaraan',$ru_data);
    	return;
    }
    public function cekAda($ru_where)
    {
    	$this->db->where($ru_where);
    	return $this->db->get('ga.ga_fleet_service_kendaraan')->result_array();
    }

    public function setFleetServiceKendaraan($data_simpan)
    {
        return $this->db->insert('ga.ga_fleet_service_kendaraan', $data_simpan);
    }

    public function ambilJenisService($p)
    {
    	$query = "select * from ga.ga_fleet_jenis_service where jenis_service like '%$p%'";
    	$data  = $this->db->query($query);
    	return $data->result_array();

    }

    public function ambilMerkKendaraan($p)
    {
    	$query = "select * from ga.ga_fleet_merk_kendaraan where merk_kendaraan like '%$p%'";
    	$data  = $this->db->query($query);
    	return $data->result_array();

    }
    public function getFleetService($id = FALSE)
    {
        if ($id === FALSE) {
            $ambilService     = "   select        ser.service_id,
            									merk.merk_kendaraan as merk,
            									jen.jenis_service as jenis,
                                                ser.kilometer as jarak,
                                                ser.bulan as lama,
                                                ser.service as status_service,
                                                to_char(ser.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat
                                    from        ga.ga_fleet_service_kendaraan as ser
                                                join    ga.ga_fleet_merk_kendaraan as merk
                                                    on  ser.merk_kendaraan_id=merk.merk_kendaraan_id
                                                join    ga.ga_fleet_jenis_service as jen
                                                    on  jen.jenis_service_id=ser.jenis_service_id
                                    where       ser.end_date = '9999-12-12 00:00:00'
                                    order by    ser.service_id;";

            $query = $this->db->query($ambilService);
    	} else {
            $ambilService     ="  select        ser.service_id,        
            									merk.merk_kendaraan as merk,
                                                ser.kilometer as jarak,
                                                ser.bulan as lama,
                                                ser.service as status_service,
                                                to_char(ser.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(ser.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from        ga.ga_fleet_service_kendaraan as ser
                                                join    ga.ga_fleet_merk_kendaraan as merk
                                                    on  ser.merk_kendaraan_id=merk.merk_kendaraan_id
                                                join    ga.ga_fleet_jenis_service as jen
                                                    on  jen.jenis_service_id=ser.jenis_service_id
                                    where       ser.service_id=$id
                                    order by    ser.service_id;";
            $query              =   $this->db->query($ambilService);
    		// $query = $this->db->get_where('ga.ga_fleet_kendaraan', array('kendaraan_id' => $id));
    	}

    	return $query->result_array();
    }

    public function getFleetServiceKendaraanDeleted($id = FALSE)
    {
        if ($id === FALSE) {
            $ambilKendaraan     = "  select     ser.service_id,
            									merk.merk_kendaraan as merk,
            									jen.jenis_service as jenis,
                                                ser.kilometer as jarak,
                                                ser.bulan as lama,
                                                ser.service as status_service,
                                                to_char(ser.start_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dibuat,
                                                to_char(ser.end_date, 'DD-MM-YYYY HH24:MI:SS') as waktu_dihapus
                                    from        ga.ga_fleet_service_kendaraan as ser
                                                join    ga.ga_fleet_merk_kendaraan as merk
                                                    on  ser.merk_kendaraan_id=merk.merk_kendaraan_id
                                                join    ga.ga_fleet_jenis_service as jen
                                                    on  jen.jenis_service_id=ser.jenis_service_id
                                    where       ser.end_date != '9999-12-12 00:00:00'
                                    order by    ser.service_id;";

            $query = $this->db->query($ambilKendaraan);
        } 

        return $query->result_array();
    }   
  

}

/* End of file M_fleetkendaraan.php */
/* Location: ./application/models/GeneralAffair/MainMenu/M_fleetkendaraan.php */
/* Generated automatically on 2017-08-05 13:23:25 */