<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_seksi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->personalia = $this->load->database('personalia', true);
        $this->oracle = $this->load->database('oracle', true);
    }

    public function view($seksi)
    {
        $sql = "SELECT * FROM tm.order
                where seksi = '$seksi'
                ORDER BY no_order";
        return $this->db->query($sql)->result_array();
    }

    function selectIdOrder() 
	{
		$sql = "SELECT MAX (no_order) id 
				FROM tm.order";
				
        return $this->db->query($sql)->result_array();
	}

    public function create($data)
    {
        $this->db->insert('tm.order', $data);
    }

    public function viewById($id,$noind)
    {
        $sql = "SELECT * FROM tm.order WHERE no_order = '$id'
                -- AND noind_pengorder = '$noind'
                ORDER BY no_order ASC";
        return $this->db->query($sql)->result_array();
    }

    public function detectSeksiUnit($noind){
        $sql = "SELECT seksi,unit FROM hrd_khs.tpribadi tp, hrd_khs.tseksi ts
        where tp.kodesie=ts.kodesie
        and tp.keluar='0'
        and tp.noind='$noind'";

        return $this->personalia->query($sql)->result_array();
    }

    public function viewLaporanPerbaikan($id)
    {
        $sql = "SELECT * FROM tm.laporan_perbaikan WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function viewLangkahPerbaikan($id)
    {
        $sql = "SELECT * FROM tm.langkah_perbaikan WHERE id_laporan = '$id'";
        return $this->db->query($sql)->result_array();
    }

    function getIdReparasi($no_induk)
    {
        $sql = "SELECT id_laporan FROM tm.laporan_perbaikan WHERE no_order = '$no_induk'";
        return $this->db->query($sql)->result_array();
    }

    function viewDataReparasi($id,$id_reparasi)
    {
        $sql = "SELECT * FROM tm.reparasi rp, tm.pelaksana_reparasi pr
                WHERE rp.no_order = '$id' AND pr.id_reparasi = '$id_reparasi'";
        return $this->db->query($sql)->result_array();
    }

    public function viewSparePart($id)
    {
        $sql = "SELECT * FROM tm.spare_part WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function viewKeterlambatan($id)
    {
        $sql = "SELECT * FROM tm.keterlambatan WHERE no_order = '$id'";
        return $this->db->query($sql)->result_array();
    }

    public function updateStatus($status,$id)
    {
        $sql = "UPDATE tm.order
        SET status_order ='$status'
        WHERE no_order='$id'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);    
    }

    public function closeOrder($noind,$status,$now,$id)
    {
        $sql = "UPDATE tm.order
        SET noind_mengetahui_order_selesai ='$noind',
            status_order = '$status',
            tgl_mengetahui_order_selesai = '$now'
        WHERE no_order='$id'";
        // echo $sql;
        // exit();
        $query = $this->db->query($sql);    
    }

    function slcIdReparasi($no_order)
    {
        $sql = "SELECT MAX (id_reparasi) id 
        FROM tm.reparasi";
        
        return $this->db->query($sql)->result_array();
    }

    function slcAllReparation($id)
    {
        $sql= "SELECT *,(select string_agg(trim(nama), ', ') 
               from tm.pelaksana_reparasi where id_reparasi = rp.id_reparasi) as nama from tm.reparasi rp where rp.no_order = '$id'";
        
        return $this->db->query($sql)->result_array();
    }

    function SelectNoMesin($nm)
	{	
		$sql = "SELECT 'ODM' ket, kdmr.no_mesin, kdmr.spec_mesin, br.resource_code,
				 br.description, br.disable_date, br.organization_id,
				 br.creation_date
			FROM khs_daftar_mesin_resource kdmr, bom_resources br
		   WHERE br.resource_id = kdmr.resource_id
			 AND kdmr.no_mesin LIKE '%$nm%'
			 AND br.disable_date IS NULL         -- masih aktif
			 AND br.organization_id = 102        --odm
		UNION
		--opm
		SELECT   'OPM' ket, kdmro.no_mesin, kdmro.spec_mesin,
				 gor.resources resource_code, NULL, NULL, NULL, NULL
			FROM khs_daftar_mesin_resource_opm kdmro,
				 gmd_operations gos,
				 gmd_operation_activities goa,
				 gmd_operation_resources gor
		   WHERE gos.oprn_no LIKE '%RESOURCE%'
			 AND gos.oprn_id = goa.oprn_id
			 AND goa.oprn_line_id = gor.oprn_line_id
			 AND gor.resources = kdmro.resources
			 AND kdmro.oprn_line_id = gor.oprn_line_id
			 AND gos.oprn_vers = 1
			 AND kdmro.no_mesin LIKE '%$nm%'
		ORDER BY no_mesin ASC, creation_date DESC";

	$query = $this->oracle->query($sql);
	return $query->result_array();
    }

	function jenisMesin($no_mesin)
	{	
		  //odm
	$sql="SELECT kdmr.spec_mesin 
		FROM khs_daftar_mesin_resource kdmr, bom_resources br
	   WHERE br.resource_id = kdmr.resource_id
		 AND kdmr.no_mesin = '$no_mesin'
		 AND br.disable_date IS NULL                            -- masih aktif
		 AND br.organization_id = 102                           --odm
	UNION
	--opm
	SELECT kdmro.spec_mesin
		FROM khs_daftar_mesin_resource_opm kdmro,
			 gmd_operations gos,
			 gmd_operation_activities goa,
			 gmd_operation_resources gor
	   WHERE gos.oprn_no LIKE '%RESOURCE%'
		 AND gos.oprn_id = goa.oprn_id
		 AND goa.oprn_line_id = gor.oprn_line_id
		 AND gor.resources = kdmro.resources
		 AND kdmro.oprn_line_id = gor.oprn_line_id
		 AND gos.oprn_vers = 1
		 AND kdmro.no_mesin = '$no_mesin'";
		//  ORDER BY SPEC_MESIN DESC
	   
	   $query = $this->oracle->query($sql);
	//    echo "<pre>"; print_r($query->result_array());
	//    exit();
	   return $query->result_array();
	//    return $sql;
    }
    
    function selectKodeSeksi($seksi)
    {
        $sql = "SELECT kode_seksi FROM tm.master_kode_seksi
                WHERE nama_seksi = '$seksi'";

        return $this->db->query($sql)->result_array();
    }

    function checkOrder($no_order)
    {
        $sql = "SELECT MAX (no_order) nomor 
                FROM tm.order WHERE no_order like '$no_order%'";

        return $this->db->query($sql)->result_array();
    }

    function editDataOrder($nomor_order, $nomor_mesin, $nama_mesin, $line, $kerusakan,
             $kondisi_mesin, $need_by_date, $reason_need_by_date, $running_hour) 
    {
        $sql = "UPDATE tm.order
                SET
                nomor_mesin = '$nomor_mesin',
                nama_mesin = '$nama_mesin', 
                line = '$line',
                kerusakan = '$kerusakan',
                kondisi_mesin = '$kondisi_mesin',
                need_by_date = '$need_by_date',
                reason_need_by_date = '$reason_need_by_date',
                running_hour = '$running_hour'
                WHERE no_order  = '$nomor_order'";
        // echo $sql; die;
        
        $query = $this->db->query($sql);
    }

    // public function editDataOrder($data)
    // {
    //     $this->db->update('tm.order', $data);
    // }
    
}