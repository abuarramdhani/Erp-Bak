<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_quesioner extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
    }

    public function getAllData()
    {
        $mysql_pendataan = $this->load->database('mysql_pendataan',true);
        $query = $mysql_pendataan->query("SELECT
        tbl1.id
        ,gcr.creation_by
        ,tp.nama
        ,qts.seksi
        ,(tbl1.question_1
        +tbl1.question_2
        +tbl1.question_3
        +tbl1.question_4
        +tbl1.question_5
        +tbl1.question_6
        +tbl1.question_7
        +tbl1.question_8
        +tbl1.question_9
        +tbl1.question_10) r_luar_rumah
        ,(tbl1.question_11
        +tbl1.question_12
        +tbl1.question_13
        +tbl1.question_14
        +tbl1.question_15
        +tbl1.question_16) r_dalam_rumah
        ,(tbl1.question_17
        +tbl1.question_18
        +tbl1.question_19
        +tbl1.question_20
        +tbl1.question_21) r_imun
        ,(tbl1.question_22
        +tbl1.question_23
        +tbl1.question_24
        +tbl1.question_25
        +tbl1.question_26
        +tbl1.question_27
        +tbl1.question_28
        +tbl1.question_29
        +tbl1.question_30) r_kesehatan
        ,(tbl1.question_1
        +tbl1.question_2
        +tbl1.question_3
        +tbl1.question_4
        +tbl1.question_5
        +tbl1.question_6
        +tbl1.question_7
        +tbl1.question_8
        +tbl1.question_9
        +tbl1.question_10
        +tbl1.question_11
        +tbl1.question_12
        +tbl1.question_13
        +tbl1.question_14
        +tbl1.question_15
        +tbl1.question_16
        +tbl1.question_17
        +tbl1.question_18
        +tbl1.question_19
        +tbl1.question_20
        +tbl1.question_21
        +tbl1.question_22
        +tbl1.question_23
        +tbl1.question_24
        +tbl1.question_25
        +tbl1.question_26
        +tbl1.question_27
        +tbl1.question_28
        +tbl1.question_29
        +tbl1.question_30) total
        ,tbl1.question_1
        ,tbl1.question_2
        ,tbl1.question_3
        ,tbl1.question_4
        ,tbl1.question_5
        ,tbl1.question_6
        ,tbl1.question_7
        ,tbl1.question_8
        ,tbl1.question_9
        ,tbl1.question_10
        ,tbl1.question_11
        ,tbl1.question_12
        ,tbl1.question_13
        ,tbl1.question_14
        ,tbl1.question_15
        ,tbl1.question_16
        ,tbl1.question_17
        ,tbl1.question_18
        ,tbl1.question_19
        ,tbl1.question_20
        ,tbl1.question_21
        ,tbl1.question_22
        ,tbl1.question_23
        ,tbl1.question_24
        ,tbl1.question_25
        ,tbl1.question_26
        ,tbl1.question_27
        ,tbl1.question_28
        ,tbl1.question_29
        ,tbl1.question_30
        FROM
        (SELECT
        gcr.id
        ,case when gcr.question_1 = 'Y' then 1 else 0 end question_1
        ,case when gcr.question_2 = 'Y' then 1 else 0 end  question_2
        ,case when gcr.question_3 = 'Y' then 1 else 0 end  question_3
        ,case when gcr.question_4 = 'Y' then 1 else 0 end  question_4
        ,case when gcr.question_5 = 'Y' then 1 else 0 end  question_5
        ,case when gcr.question_6 = 'Y' then 1 else 0 end  question_6
        ,case when gcr.question_7 = 'Y' then 1 else 0 end  question_7
        ,case when gcr.question_8 = 'Y' then 1 else 0 end  question_8
        ,case when gcr.question_9 = 'Y' then 1 else 0 end  question_9
        ,case when gcr.question_10 = 'Y' then 1 else 0 end  question_10
        ,case when gcr.question_11 = 'Y' then 1 else 0 end  question_11
        ,case when gcr.question_12 = 'Y' then 1 else 0 end  question_12
        ,case when gcr.question_13 = 'Y' then 1 else 0 end  question_13
        ,case when gcr.question_14 = 'Y' then 1 else 0 end  question_14
        ,case when gcr.question_15 = 'Y' then 1 else 0 end  question_15
        ,case when gcr.question_16 = 'Y' then 1 else 0 end  question_16
        ,case when gcr.question_17 = 'Y' then 1 else 0 end  question_17
        ,case when gcr.question_18 = 'Y' then 1 else 0 end  question_18
        ,case when gcr.question_19 = 'Y' then 1 else 0 end  question_19
        ,case when gcr.question_20 = 'Y' then 1 else 0 end  question_20
        ,case when gcr.question_21 = 'Y' then 1 else 0 end  question_21
        ,case when gcr.question_22 = 'Y' then 1 else 0 end  question_22
        ,case when gcr.question_23 = 'Y' then 1 else 0 end  question_23
        ,case when gcr.question_24 = 'Y' then 1 else 0 end  question_24
        ,case when gcr.question_25 = 'Y' then 1 else 0 end  question_25
        ,case when gcr.question_26 = 'Y' then 1 else 0 end  question_26
        ,case when gcr.question_27 = 'Y' then 1 else 0 end  question_27
        ,case when gcr.question_28 = 'Y' then 1 else 0 end  question_28
        ,case when gcr.question_29 = 'Y' then 1 else 0 end  question_29
        ,case when gcr.question_30 = 'Y' then 1 else 0 end  question_30
        FROM
        pendataan.ga_covid19_risk gcr) tbl1
        inner JOIN pendataan.ga_covid19_risk gcr ON tbl1.id = gcr.id 
        inner JOIN pendataan.tpribadi tp ON gcr.creation_by = tp.noind
        inner JOIN quickc01_dinas_luar_online.t_seksi qts ON tp.kodesie = qts.kodesie");

        return $query->result_array();
    }
}