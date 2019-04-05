<?php
class M_settingminmaxopm extends CI_Model {

  var $oracle;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle_dev', true);
    }

  public function TampilRoutingClass()
  {
    $sql = "SELECT DISTINCT(FRH.ROUTING_CLASS) FROM fm_rout_hdr frh";

    $query = $this->oracle->query($sql);
    return $query->result_array();
  }
  
  public function TampilDataMinMax($route)
  {
      $sql = "SELECT DISTINCT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP
        FROM mtl_system_items_b msib ,
          gmd_recipe_validity_rules grvr ,
          gmd_recipes_b grb ,
          gmd_routings_b grtb
        WHERE msib.INVENTORY_ITEM_ID  = grvr.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID      = grvr.ORGANIZATION_ID
        AND grvr.RECIPE_ID            = grb.RECIPE_ID
        AND grvr.VALIDITY_RULE_STATUS = 700
        AND grvr.END_DATE            IS NULL
        AND grb.RECIPE_STATUS         = 700
        AND grb.ROUTING_ID            = grtb.ROUTING_ID
        AND grtb.ROUTING_CLASS        = '$route'
        ORDER BY msib.segment1";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function TampilDataItemMinMax($route,$itemcode)
  {
      $sql = "SELECT DISTINCT msib.segment1,
          msib.DESCRIPTION,
          msib.PRIMARY_UOM_CODE,
          msib.MIN_MINMAX_QUANTITY MIN,
          msib.MAX_MINMAX_QUANTITY MAX,
          msib.ATTRIBUTE9 ROP
        FROM mtl_system_items_b msib ,
          gmd_recipe_validity_rules grvr ,
          gmd_recipes_b grb ,
          gmd_routings_b grtb
        WHERE msib.INVENTORY_ITEM_ID  = grvr.INVENTORY_ITEM_ID
        AND msib.ORGANIZATION_ID      = grvr.ORGANIZATION_ID
        AND grvr.RECIPE_ID            = grb.RECIPE_ID
        AND grvr.VALIDITY_RULE_STATUS = 700
        AND grvr.END_DATE            IS NULL
        AND grb.RECIPE_STATUS         = 700
        AND grb.ROUTING_ID            = grtb.ROUTING_ID
        AND grtb.ROUTING_CLASS        = '$route'
        AND msib.SEGMENT1             = '$itemcode'";
      $query = $this->oracle->query($sql);
      return $query->result_array();
  }

  public function save($itemcode, $min, $max, $rop)
  {
      $sql = "UPDATE mtl_system_items_b msib
        set msib.MIN_MINMAX_QUANTITY = '$min',
        msib.MAX_MINMAX_QUANTITY = '$max',
        msib.ATTRIBUTE9 = '$rop'
        where msib.SEGMENT1 = '$itemcode'";
      $query = $this->oracle->query($sql);
  }



// -------------------------- BATAS TERPAKAI ----------------------------------------//

  public function IO($cb)
  {
    $sql = "SELECT distinct mp.ORGANIZATION_CODE
                  FROM hr_all_organization_units hou
                      ,mtl_secondary_inventories msi
                      ,hr_locations_all hla
                      ,org_organization_definitions ood
                      ,mtl_parameters mp
                 WHERE hou.name not LIKE '%(OU)%'
                   AND hou.name not LIKE '%Master Item'
                   AND hou.name not LIKE 'Setup%'
                   AND hla.BILL_TO_SITE_FLAG <> 'N'
                   AND msi.organization_id = hou.organization_id
                   AND hla.location_id = hou.location_id
                   AND ood.organization_id = hou.organization_id
                   AND hou.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND hla.LOCATION_CODE = '$cb'";
    
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

    public function ORG_ALL()
    {
        $sql = "SELECT distinct mp.ORGANIZATION_CODE
                  FROM hr_all_organization_units hou
                      ,mtl_secondary_inventories msi
                      ,hr_locations_all hla
                      ,org_organization_definitions ood
                      ,mtl_parameters mp
                 WHERE hou.name not LIKE '%(OU)%'
                   AND hou.name not LIKE '%Master Item'
                   AND hou.name not LIKE 'Setup%'
                   AND hla.BILL_TO_SITE_FLAG <> 'N'
                   AND msi.organization_id = hou.organization_id
                   AND hla.location_id = hou.location_id
                   AND ood.organization_id = hou.organization_id
                   AND hou.ORGANIZATION_ID = mp.ORGANIZATION_ID";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function ORG()
    {
        $sql = "SELECT distinct hla.LOCATION_CODE
                  FROM hr_all_organization_units hou
                      ,mtl_secondary_inventories msi
                      ,hr_locations_all hla
                      ,org_organization_definitions ood
                      ,mtl_parameters mp
                 WHERE hou.name not LIKE '%(OU)%'
                   AND hou.name not LIKE '%Master Item'
                   AND hou.name not LIKE 'Setup%'
                   AND hla.BILL_TO_SITE_FLAG <> 'N'
                   AND msi.organization_id = hou.organization_id
                   AND hla.location_id = hou.location_id
                   AND ood.organization_id = hou.organization_id
                   AND hou.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND hla.LOCATION_CODE NOT LIKE 'MLATI-DM'
                   AND hla.LOCATION_CODE NOT LIKE 'PT. KI Semarang'
                   ORDER BY hla.LOCATION_CODE";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function subInvView($organisasi)
    {
        $sql = "SELECT msi.SECONDARY_INVENTORY_NAME
                  FROM HR_ALL_ORGANIZATION_UNITS hou
                      ,mtl_secondary_inventories msi
                      ,hr_locations_all hla
                      ,org_organization_definitions ood
                      ,mtl_parameters mp
                 WHERE hou.name not like '%(OU)%'
                   AND hou.name not like '%Master Item'
                   AND hou.name not like 'Setup%'
                   AND hla.BILL_TO_SITE_FLAG <> 'N'
                   AND msi.organization_id = hou.organization_id
                   AND hla.location_id = hou.location_id
                   AND ood.organization_id = hou.organization_id
                   AND hou.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND mp.ORGANIZATION_CODE = '$organisasi'";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    
  public function subInv($cb,$organisasi)
  {
    $sql = "SELECT msi.SECONDARY_INVENTORY_NAME
                  FROM HR_ALL_ORGANIZATION_UNITS hou
                      ,mtl_secondary_inventories msi
                      ,hr_locations_all hla
                      ,org_organization_definitions ood
                      ,mtl_parameters mp
                 WHERE hou.name not like '%(OU)%'
                   AND hou.name not like '%Master Item'
                   AND hou.name not like 'Setup%'
                   AND hla.BILL_TO_SITE_FLAG <> 'N'
                   AND msi.organization_id = hou.organization_id
                   AND hla.location_id = hou.location_id
                   AND ood.organization_id = hou.organization_id
                   AND hou.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND mp.ORGANIZATION_CODE = '$organisasi'
                   AND hla.LOCATION_CODE = '$cb'";
    
    $query = $this->oracle->query($sql);
    return $query->result_array();
  }

    public function Barang($organisasi)
    {
        $sql = "SELECT DISTINCT msib.SEGMENT1
                  FROM mtl_system_items_b msib, 
                       mtl_parameters mp
                 WHERE msib.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                   AND mp.ORGANIZATION_CODE LIKE '%$organisasi%'";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function Deskripsi($barang)
    {
        $sql = "SELECT DISTINCT msib.DESCRIPTION 
                  FROM mtl_system_items_b msib, 
                       mtl_parameters mp
                 WHERE msib.ORGANIZATION_ID = mp.ORGANIZATION_ID
                   AND msib.INVENTORY_ITEM_STATUS_CODE = 'Active'
                   AND msib.SEGMENT1 LIKE '%$barang%'";
        
        $query = $this->oracle->query($sql);
        return $query->result_array();
    }

    public function getUsulan($no_fppb,$no_fppbb,$barang){
      $sql = "SELECT usulan_kacab, preview FROM bi.bi_penanganan_line WHERE no_fppb = '$no_fppb' AND no_fppbb = '$no_fppbb' AND kode_barang = '$barang'";
       $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function NoFppbAll($kode)
    {
      $sql = "SELECT DISTINCT bph1.id
                              ,bpl1.id id_barang
                              ,bpl1.kode_barang 
                              ,bpl1.deskripsi 
                              ,bpl1.jumlah 
                              ,bpl1.kategori_masalah
                              ,bpl1.no_fppb
                          FROM bi.bi_pemindahan_line bpl1
                              ,bi.bi_pemindahan_header bph1
                              ,bi.bi_penanganan_header bph2
                         WHERE bph1.no_fppb = bpl1.no_fppb
                           AND bph1.cabang = bph2.cabang
                           AND bph1.no_fppb = '$kode'";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPemindahanEdit($id)
    {
        $sql = "SELECT *
                  FROM bi.bi_pemindahan_line bpl,
                       bi.bi_pemindahan_header bph 
                 WHERE bpl.id = '$id'
                   AND bpl.no_fppb = bph.no_fppb";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPenangananEdit($id)
    {
        $sql = "SELECT DISTINCT bpp.id 
                      ,bph.no_fppbb 
                      ,bph.cabang 
                      ,bpp.no_fppb
                      ,bpp.kode_barang 
                      ,bpl.deskripsi 
                      ,bpl.jumlah 
                      ,bpl.kategori_masalah
                      ,bpp.usulan_kacab
                      ,bpp.preview
                  FROM bi.bi_penanganan_header bph 
                      ,bi.bi_penanganan_line bpp 
                      ,bi.bi_pemindahan_line bpl
                 WHERE bph.no_fppbb = bpp.no_fppbb
                   AND bpp.kode_barang = bpl.kode_barang
                   AND bpp.id = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getFPPBAll()
    {
        $sql = "SELECT no_fppb 
                FROM bi.bi_pemindahan_header";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getFPPBCabang($cabang)
    {        
        $sql = "SELECT DISTINCT bpl1.no_fppb
                  FROM bi.bi_pemindahan_line bpl1 
                      ,bi.bi_pemindahan_header bph1 
                      ,bi.bi_penanganan_header bph2
                 WHERE bph1.no_fppb = bpl1.no_fppb
                   AND bph1.cabang = bph2.cabang
                   AND bph2.cabang = '$cabang'
                   ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getPemindahanView($tanggalan1,$tanggalan2,$organisasi=FALSE,$gudang_asal=FALSE,$gudang_tujuan=FALSE)
    {
        if ($tanggalan1==FALSE&&$tanggalan2==FALSE) {
              $tanggal = " ";
            }else{
              $tanggal = "WHERE tanggal BETWEEN '$tanggalan1' AND '$tanggalan2'";

              $tanggal = str_replace('-', '/', $tanggal);
            }

        if ($organisasi==FALSE) {
              $w_org = "";
            }else{
              $w_org = "AND organisasi = '$organisasi'";
            }

        if ($gudang_asal==FALSE) {
              $w_asal = " ";
            }else{
              $w_asal = "AND gudang_asal = '$gudang_asal'";
            }

        if ($gudang_tujuan==FALSE) {
              $w_tujuan = " ";
            }else{
              $w_tujuan = "AND gudang_tujuan = '$gudang_tujuan'";
            }

        $sql = "SELECT * 
                  FROM bi.bi_pemindahan_header 
                 $tanggal
                 $w_org
                 $w_asal
                 $w_tujuan ";
                 
        // echo $sql;
        // exit();
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getDetailPemindahan($id)
    {
      $sql = "SELECT bph.id 
                    ,bph.no_fppb
                    ,bph.tanggal 
                    ,bph.cabang 
                    ,bph.organisasi 
                    ,bph.gudang_asal 
                    ,bph.gudang_tujuan 
                    ,bpl.kode_barang 
                    ,bpl.deskripsi 
                    ,bpl.jumlah 
                    ,bpl.gambar 
                    ,bpl.kategori_masalah 
                    ,bpl.detail_masalah
                FROM bi.bi_pemindahan_header bph 
                    ,bi.bi_pemindahan_line bpl
              WHERE bph.no_fppb = bpl.no_fppb
                AND bph.id = '$id'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function getDetailPenanganan($id)
    {
      $sql = "SELECT DISTINCT bph2.id 
                    ,bph2.no_fppbb
                    ,bph2.tanggal 
                    ,bph2.cabang
                    ,bpl2.no_fppb 
                    ,bpl2.kode_barang 
                    ,bpl1.deskripsi 
                    ,bpl1.jumlah 
                    ,bpl1.kategori_masalah
                FROM bi.bi_penanganan_header bph2
                    ,bi.bi_penanganan_line bpl2 
                    ,bi.bi_pemindahan_line bpl1
               WHERE bph2.no_fppbb = bpl2.no_fppbb
                 AND bpl1.kode_barang = bpl2.kode_barang
                 AND bph2.id = '$id'";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function cekcekan($nomor)
    {
        $sql = "SELECT * 
                  FROM bi.bi_pemindahan_header 
                 WHERE no_fppb = '$nomor'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function cekNomor($nomor)
    {
        $sql = "SELECT * 
                  FROM bi.bi_pemindahan_header 
                 WHERE no_fppb = '$nomor' 
                   AND flag = 'y'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

  
    public function cekFPPBB($nomor)
    {
        $sql = "SELECT * 
                  FROM bi.bi_penanganan_header 
                 WHERE no_fppbb = '$nomor'
                 AND flag = 'y'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function PenangananHeader($tanggalan1,$tanggalan2,$cabang=FALSE)
    {
      if ($tanggalan1==FALSE&&$tanggalan2==FALSE) {
              $tanggal = " ";
            }else{
              $tanggal = "WHERE tanggal BETWEEN '$tanggalan1' AND '$tanggalan2'";

              $tanggal = str_replace('-', '/', $tanggal);
            }

        if ($cabang==FALSE) {
              $w_org = "";
            }else{
              $w_org = "AND cabang = '$cabang'";
            }

      $sql = "SELECT DISTINCT * FROM bi.bi_penanganan_header
              $tanggal
              $w_org";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    public function HeaderPenanganan($id)
    {
      $sql = "SELECT * FROM bi.bi_penanganan_header
              WHERE id = '$id'
              ORDER BY no_fppbb";

      $query = $this->db->query($sql);
      return $query->result_array();
    }

    //  public function TampilTabelPenanganan($fppb)
    // {
    //     $sql = "SELECT * 
    //               FROM bi.bi_penanganan_line bpl2 ,bi.bi_pemindahan_line bpl1
    //              WHERE no_fppb = '$fppb'";

    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }

    public function gambar($id)
    {
        $sql = "SELECT gambar 
                  FROM bi.bi_pemindahan_line 
                 WHERE id = '$id'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function TampilTabelPemindahan($fppb)
    {
        $sql = "SELECT * 
                  FROM bi.bi_pemindahan_line 
                 WHERE no_fppb = '$fppb'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function TampilTabelPenanganan($fppb=FALSE)
    {
      if ($fppb==FALSE) {
              $www = "";
            }else{
              $www = "AND bpl2.no_fppbb = '$fppb'";
            }

        $sql = "SELECT DISTINCT bpl2.id
                      ,bpl2.no_fppb no_fppb
                      ,bpl2.kode_barang 
                      ,bpl1.deskripsi 
                      ,bpl1.jumlah 
                      ,bpl1.kategori_masalah 
                      ,bpl1.detail_masalah
                  FROM bi.bi_pemindahan_line bpl1 
                      ,bi.bi_penanganan_line bpl2 
                      ,bi.bi_penanganan_header bph2
                 WHERE bpl1.kode_barang = bpl2.kode_barang
                   AND bph2.no_fppbb = bpl2.no_fppbb
                   $www
                   ";

        $query = $this->db->query($sql);
        return $query->result_array();
    }


    public function InsertPemindahanHeader($no,$tanggal,$cabang,$organisasi,$asal,$tujuan)
    {
        $sql = "INSERT INTO bi.bi_pemindahan_header(no_fppb,tanggal,cabang,organisasi,gudang_asal,gudang_tujuan) 
                values('$no','$tanggal','$cabang','$organisasi','$asal','$tujuan')";

        $query = $this->db->query($sql);
    }

    public function FlaggingPemindahanHeader($no)
    {
        $sql = "UPDATE bi.bi_pemindahan_header 
                   SET flag = 'y' 
                 WHERE no_fppb = '$no'";

        $query = $this->db->query($sql);
    }


    public function FlaggingPenangananHeader($no)
    {
        $sql = "UPDATE bi.bi_penanganan_header 
                   SET flag = 'y' 
                 WHERE no_fppbb = '$no'";

        $query = $this->db->query($sql);
    }


    public function InsertPemindahanLine($no,$kode,$jumlah,$gambar,$kategori,$detail,$deskripsi)
    {
        $sql = "INSERT INTO bi.bi_pemindahan_line(no_fppb ,kode_barang, jumlah, gambar, kategori_masalah, detail_masalah, deskripsi) 
                values('$no','$kode','$jumlah','$gambar','$kategori','$detail','$deskripsi')";

        $query = $this->db->query($sql);
    }


    public function UpdatePemindahanLine($no,$kode,$jumlah,$gambar,$kategori,$detail,$deskripsi,$id)
    {
        $sql = "UPDATE bi.bi_pemindahan_line 
                   SET no_fppb = '$no', kode_barang='$kode', jumlah='$jumlah', gambar='$gambar', kategori_masalah='$kategori', detail_masalah ='$detail', deskripsi='$deskripsi', id = '$id' 
                 WHERE id='$id'";

        $query = $this->db->query($sql);
    }

    public function UpdatePemindahanLineWithoutPict($no,$kode,$jumlah,$kategori,$detail,$deskripsi,$id)
    {
        $sql = "UPDATE bi.bi_pemindahan_line 
                   SET no_fppb = '$no', kode_barang='$kode', jumlah='$jumlah', kategori_masalah='$kategori', detail_masalah ='$detail', deskripsi='$deskripsi', id = '$id' 
                 WHERE id='$id'";

        $query = $this->db->query($sql);
    }


    public function UpdatePenangananLine($id,$no,$usulan,$nono,$preview,$kode)
    {
        $sql = "UPDATE bi.bi_penanganan_line
                   SET id = '$id', no_fppb = '$no', usulan_kacab = '$usulan', no_fppbb = '$nono', preview = '$preview', kode_barang = '$kode'
                 WHERE id = '$id'";

        $query = $this->db->query($sql);
    }


    public function DeletePemindahanLine($id)
    {
        $sql = "DELETE FROM bi.bi_pemindahan_line 
                WHERE id='$id'";

        $query = $this->db->query($sql);
    }


    public function DeletePenangananLine($id)
    {
        $sql = "DELETE FROM bi.bi_penanganan_line 
                WHERE id='$id'";

        $query = $this->db->query($sql);
    }

    public function InsertPenangananHeader($no_fppbb,$tanggal,$cabang)
    {
        $sql = "INSERT INTO bi.bi_penanganan_header(no_fppbb,tanggal,cabang) 
                values('$no_fppbb','$tanggal','$cabang')";

        $query = $this->db->query($sql);
    }

    public function InsertPenangananLine($fppb,$usulan,$fppbb,$preview,$kode)
    {
        $sql = "INSERT INTO bi.bi_penanganan_line(no_fppb,usulan_kacab,no_fppbb,preview,kode_barang) 
                values('$fppb','$usulan','$fppbb','$preview','$kode')";

        $query = $this->db->query($sql);
    }
    
}
?>