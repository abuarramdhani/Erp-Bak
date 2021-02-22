<?php 
defined('BASEPATH') or exit ('No direct script access allowed');
class M_sendsms extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getDataApprover()
    {
        $query = $this->oracle->query("SELECT
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME||' '||ppf.LAST_NAME FULL_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                            ,oah.APPROVER
                                        FROM
                                            khs.khs_okbj_approve_hir oah
                                            ,per_people_f ppf
                                            ,khs.KHS_EMAIL_PEKERJA kep
                                        WHERE 1=1
                                            AND oah.APPROVER_LEVEL IN (5,8,10)
                                            AND oah.APPROVER = ppf.PERSON_ID
                                            AND ppf.NATIONAL_IDENTIFIER = kep.NATIONAL_IDENTIFIER
                                        GROUP BY
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME
                                            ,ppf.LAST_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                            ,oah.APPROVER"
                                      );
        return $query->result_array();
    }

    public function getDataPengelola()
    {
        $query = $this->oracle->query("SELECT
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME||' '||ppf.LAST_NAME FULL_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                        FROM
                                            mtl_system_items_b msib
                                            ,per_people_f ppf
                                            ,khs.KHS_EMAIL_PEKERJA kep
                                        WHERE 1=1
                                            AND msib.ORGANIZATION_ID = 81
                                            AND msib.ATTRIBUTE24 IS NOT NULL
                                            AND msib.ATTRIBUTE24 = ppf.PERSON_ID
                                            AND ppf.NATIONAL_IDENTIFIER = kep.NATIONAL_IDENTIFIER
                                        GROUP BY 
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME
                                            ,ppf.LAST_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                    ");
        return $query->result_array();
    }

    public function getDataPuller()
    {
        $query = $this->oracle->query("SELECT
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME||' '||ppf.LAST_NAME FULL_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                        FROM
                                            per_people_f ppf
                                            ,khs.KHS_EMAIL_PEKERJA kep
                                        WHERE 1=1
                                            AND ppf.NATIONAL_IDENTIFIER = kep.NATIONAL_IDENTIFIER
                                            AND ppf.NATIONAL_IDENTIFIER = 'B0647'
                                        GROUP BY 
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FIRST_NAME
                                            ,ppf.LAST_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                    ");
        return $query->result_array();
    }
}