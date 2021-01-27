<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_update extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->oracle = $this->load->database('oracle', true);
    }
    function get_header_id()
    {
        $sql = "select khs_slide_show_headers_seq.NEXTVAL from dual";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function InsertIdSlideShow($id, $nama, $by, $time)
    {
        $sql = "insert into khs_slide_show_headers kssh (
            kssh.HEADER_ID
            ,kssh.SLIDE_SHOW_NAME
            ,kssh.CREATED_BY
            ,kssh.SLIDE_TRANSITION_TIME
            )
            values(
            $id
            ,'$nama'
            ,'$by'
            ,$time
            )";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function InsertIdSlideShowLine($id, $img)
    {
        $sql = "insert into khs_slide_show_lines kssl(
                kssl.HEADER_ID
                ,kssl.FILE_DIR_ADDRESS
                )values(
                $id
                ,'$img'
                )";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function dataSlideShow($name)
    {
        $sql = "select
        kssh.HEADER_ID
        ,kssh.SLIDE_SHOW_NAME
        ,kssh.SLIDE_TRANSITION_TIME
        ,kssl.FILE_DIR_ADDRESS
        ,kssl.LINE_ID
        from
        khs_slide_show_headers kssh
        ,khs_slide_show_lines kssl
        where
        kssh.HEADER_ID = kssl.HEADER_ID
        AND NVL(kssh.ACTIVE_FLAG, 'Y') != 'N'
        AND NVL(kssl.ACTIVE_FLAG, 'Y') != 'N'
        and kssh.SLIDE_SHOW_NAME = '$name'
        order by kssl.LINE_ID asc";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function dataToEdit($ind)
    {
        $sql = "select * from
        khs_slide_show_headers kssh where kssh.CREATED_BY = '$ind'";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function inactiveSlide($i)
    {
        $sql = "update khs_slide_show_headers set ACTIVE_FLAG = 'N' where HEADER_ID = $i";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function ActiveSlide($i)
    {
        $sql = "update khs_slide_show_headers set ACTIVE_FLAG = NULL where HEADER_ID = $i";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getImg($w)
    {
        $sql = "select * from khs_slide_show_lines kssl where kssl.HEADER_ID = $w order by kssl.LINE_ID";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function UpdateGambar($i, $l)
    {
        $sql = "update khs_slide_show_lines set FILE_DIR_ADDRESS = '$i' where LINE_ID = $l";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getImgtoDelete($i)
    {
        $sql = "select * from khs_slide_show_lines kssl where kssl.LINE_ID = $i";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function inactiveGambar($i)
    {
        $sql = "update khs_slide_show_lines set ACTIVE_FLAG = 'N' where LINE_ID = $i";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function ActiveGambar($i)
    {
        $sql = "update khs_slide_show_lines set ACTIVE_FLAG = NULL where LINE_ID = $i";
        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function DeleteImg($i)
    {
        $sql = "delete from khs_slide_show_lines kssl where kssl.LINE_ID = $i";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function getImgtoDelete2($i)
    {
        $sql = "select * from khs_slide_show_lines kssl where kssl.HEADER_ID = $i";

        $query = $this->oracle->query($sql);
        return $query->result_array();
    }
    public function DeleteHeader($i)
    {
        $sql = "delete from khs_slide_show_headers kssh where kssh.HEADER_ID = $i";

        $query = $this->oracle->query($sql);
        return $sql;
    }
    public function DeleteLine($i)
    {
        $sql = "delete from khs_slide_show_lines kssl where kssl.HEADER_ID = $i";

        $query = $this->oracle->query($sql);
        return $sql;
    }
}
