<?php
class M_cetak extends CI_Model {

    var $oracle;
    public function __construct()
    {
    parent::__construct();
    $this->load->database();
    $this->load->library('encrypt');
    $this->oracle = $this->load->database('oracle', true);
    $this->oracle_dev = $this->load->database('oracle_dev',TRUE);
    }

    //cost center
    public function getCostCenter($cost_center) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
        select distinct ffv.FLEX_VALUE COST_CENTER
        ,NVL(SUBSTR(ffvt.DESCRIPTION, 0, INSTR(ffvt.DESCRIPTION, '-')-1), ffvt.DESCRIPTION) SEKSI
        ,NVL(SUBSTR(ffvt.DESCRIPTION, INSTR(ffvt.DESCRIPTION, '-') + 2),ffvt.DESCRIPTION) LINE
        from fa_additions_b fab
        ,FA_ADDITIONS_TL fat
        ,fa_books fb
        ,fa_categories fc
        ,FA_DISTRIBUTION_HISTORY fdh
        ,gl_code_combinations gcc
        ,fnd_flex_values ffv
        ,fnd_flex_values_tl ffvt
        where fab.asset_id = fdh.ASSET_ID
        and fdh.DATE_INEFFECTIVE is null
        and fb.DATE_INEFFECTIVE is null
        and fab.ASSET_ID = fb.ASSET_ID
        and fab.ASSET_CATEGORY_ID = fc.CATEGORY_ID
        and fab.ASSET_ID = fat.ASSET_ID
        and fdh.CODE_COMBINATION_ID = gcc.CODE_COMBINATION_ID
        and gcc.SEGMENT4 = ffv.FLEX_VALUE
        and ffv.FLEX_VALUE_SET_ID = 1013709
        and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
        and fdh.BOOK_TYPE_CODE = 'KHS CORP BOOK'
        and fdh.BOOK_TYPE_CODE = fb.BOOK_TYPE_CODE
        and ffv.FLEX_VALUE = '".$cost_center."'
        and fab.attribute1 is not null";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    //no mesin
    public function getNoMesin($cost_center) {
        $oracle = $this->load->database('oracle', true);
        // $sql = "
        // select fab.attribute1 NO_MESIN
        // from fa_additions_b fab
        // ,FA_ADDITIONS_TL fat
        // ,fa_books fb
        // ,fa_categories fc
        // ,FA_DISTRIBUTION_HISTORY fdh
        // ,gl_code_combinations gcc
        // ,fnd_flex_values ffv
        // ,fnd_flex_values_tl ffvt
        // where fab.asset_id = fdh.ASSET_ID
        // and fdh.DATE_INEFFECTIVE is null
        // and fb.DATE_INEFFECTIVE is null
        // and fab.ASSET_ID = fb.ASSET_ID
        // and fab.ASSET_CATEGORY_ID = fc.CATEGORY_ID
        // and fab.ASSET_ID = fat.ASSET_ID
        // and fdh.CODE_COMBINATION_ID = gcc.CODE_COMBINATION_ID
        // and gcc.SEGMENT4 = ffv.FLEX_VALUE
        // and ffv.FLEX_VALUE_SET_ID = 1013709
        // and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
        // and fdh.BOOK_TYPE_CODE = 'KHS CORP BOOK'
        // and fdh.BOOK_TYPE_CODE = fb.BOOK_TYPE_CODE
        // and ffv.FLEX_VALUE = '".$cost_center."'
        // and fab.attribute1 is not null";
        $sql = "
        select fab.attribute1 NO_MESIN
        from fa_additions_b fab
        ,FA_DISTRIBUTION_HISTORY fdh
        ,gl_code_combinations gcc
        ,fnd_flex_values ffv
        ,fnd_flex_values_tl ffvt
        where fab.asset_id = fdh.ASSET_ID
        and fdh.DATE_INEFFECTIVE is null
        and fdh.CODE_COMBINATION_ID = gcc.CODE_COMBINATION_ID
        and gcc.SEGMENT4 = ffv.FLEX_VALUE
        and ffv.FLEX_VALUE_SET_ID = 1013709
        and ffv.FLEX_VALUE_ID = ffvt.FLEX_VALUE_ID
        and fdh.BOOK_TYPE_CODE = 'KHS CORP BOOK'
        and ffv.FLEX_VALUE = '".$cost_center."'
        and fab.attribute1 is not null";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    //kode barang
    public function getKodeBarang($kode_barang) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
        select nvl(msib.attribute7,msib.DESCRIPTION) description, msib.ATTRIBUTE1 merk from mtl_system_items_b msib
        where msib.SEGMENT1 = '".$kode_barang."'
        AND msib.ORGANIZATION_ID = 102";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function getNamaBarang($kode_barang) {
        $oracle = $this->load->database('oracle', true);
        $sql = "
        select nvl(msib.attribute7,msib.DESCRIPTION) description from mtl_system_items_b msib
        where msib.SEGMENT1 = '".$kode_barang."'
        AND msib.ORGANIZATION_ID = 102";
        $query = $oracle->query($sql);
        return $query->result_array();
    }

    public function cekId ($idunix){
        $sql = "SELECT *
                    FROM kct.kct_kanban_cutting_tools
                   WHERE idunix = '$idunix'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function insert($idunix,$kode_barang,$cost_center,$nama_barang,$no_bppbgt){
      $sql = "INSERT INTO KCT_KANBAN_CUTTING_TOOLS (id,idunix,kode_barang,cost_center,nama_barang,nomor_bppct)
          VALUES (kct_seq.NEXTVAL,'$idunix','$kode_barang','$cost_center','$nama_barang','$no_bppbgt')";
      $query = $this->oracle->query($sql);
    }

}
?>
