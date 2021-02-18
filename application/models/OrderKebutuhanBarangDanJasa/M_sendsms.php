<?php 
defined('BASEPATH') or exit ('No direct script access allowed');
class M_sendsms extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function getDataApprover(){
        $query = $this->oracle->query("SELECT
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FULL_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP
                                        from
                                            khs.khs_okbj_approve_hir oah
                                            ,per_people_f ppf
                                            ,khs.KHS_EMAIL_PEKERJA kep
                                        where 1=1
                                            and oah.APPROVER_LEVEL IN (5,8)
                                            and oah.APPROVER = ppf.PERSON_ID
                                            and ppf.NATIONAL_IDENTIFIER = kep.NATIONAL_IDENTIFIER
                                        group by
                                            ppf.NATIONAL_IDENTIFIER
                                            ,ppf.FULL_NAME
                                            ,ppf.SEX
                                            ,kep.EMAIL_INTERNAL
                                            ,kep.NOMOR_MYGROUP"
                                      );
        return $query->result_array();
    }
}