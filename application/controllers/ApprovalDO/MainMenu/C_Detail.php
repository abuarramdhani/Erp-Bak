<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Detail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('session');
        $this->checkSession();

        $this->load->model('ApprovalDO/M_detail');
        $this->load->model('SystemAdministration/MainMenu/M_user');
    }
    
    private function checkSession()
    {
        if ( ! $this->session->is_logged ) {
            redirect();
        }
    }

    public function checkDetailDO($id)
    {
        $exp_id  = explode('-', $id);
        $user_id = $this->session->userid;
        $resp_id = $this->session->responsibility_id;

		$data['Menu']           = $this->session->last_menu;
		$data['SubMenuOne']     = $this->session->last_submenu;
		$data['UserMenu']       = $this->M_user->getUserMenu($user_id, $resp_id);
		$data['UserSubMenuOne'] = $this->M_user->getMenuLv2($user_id, $resp_id);
        $data['UserSubMenuTwo'] = $this->M_user->getMenuLv3($user_id, $resp_id);
        $data['DOSONumber']     = [
            'NO_DO' => $exp_id[1],
            'NO_SO' => $exp_id[2],
        ];
        $data['DetailType']     = $exp_id[0];
        $data['ApproverList']   = [
            [
                'name'          => 'B0354 - Wawan Kartika Hadi',
                'id'            => 'B0354',
                'email_address' => 'wawan_kartika@quick.com'
            ],
            [
                'name'          => 'B0377 - Y. Dadung Senoaji',
                'id'            => 'B0377',
                'email_address' => 'y_dadung@quick.com'
            ],
            [
                'name'          => 'B0621 - Ricky Setyawan',
                'id'            => 'B0621',
                'email_address' => 'ricky_setyawan@quick.com'
            ],
            [
                'name'          => 'B0342 - Gatot Sutrisno',
                'id'            => 'B0342',
                'email_address' => 'gatot_sutrisno@quick.com'
            ],
            [
                'name'          => 'B0543 - Cahyono Hadi',
                'id'            => 'B0543',
                'email_address' => 'cahyono_hadi@quick.com'
            ],
            [
                'name'          => 'B0328 - Bambang Pudjijono',
                'id'            => 'B0328',
                'email_address' => 'bambang_pudjijono@quick.com'
            ]
        ];
        switch ($exp_id[0]) {
            case 'ListBackorder':
                $data['DetailDO'] = $this->M_detail->getDetailBackorder($exp_id[2]);
                break;
            case 'LaunchPickRelease' :
                $data['DetailDO'] = $this->M_detail->getDetailLaunchPickRelease($exp_id[2]);
                break;
            case 'ApprovalSPB':
            case 'ListSPB' :
            case 'RequestedSPB':
            case 'ApprovedSPB':
            case 'RejectedSPB':
            case 'PendingSPB':
                $data['DetailDO'] = $this->M_detail->getDetailSPB($exp_id[1]);
                break;
            default:
                $data['DetailDO'] = $this->M_detail->getDetailDO($exp_id[1]);
                break;
        }

        switch ($exp_id[0]) {
            case 'ListDO':
            case 'ListSPB':
                $data['ButtonType'] = 
                    '<button type="button" title="Select Approver" class="btn btn-primary pull-right btnADOSelectApprover">
                        <i class="fa fa-location-arrow"></i>&nbsp; Select Approver
                    </button>';
                break;
            case 'Approval':
            case 'ApprovalSPB':
                $data['ButtonType'] = 
                    '<button type="button" title="Pending" class="btn btn-default pull-right btnADOPending">
                        <i class="fa fa-clock-o"></i>&nbsp; Pending
                    </button>
                    <button type="button" title="Reject" class="btn btn-danger pull-right btnADOReject" style="margin-right: 10px">
                        <i class="fa fa-remove"></i>&nbsp; Reject
                    </button>
                    <button type="button" title="Approve" class="btn btn-primary pull-right btnADOApprove" style="margin-right: 10px">
                        <i class="fa fa-check-square-o"></i>&nbsp; Approve
                    </button>';
                break;
            case 'RequestedSPB':
            case 'Requested':
                $data['ButtonType'] = 
                    '<button type="button" title="Approval Requested" class="btn btn-primary pull-right" disabled>
                        <i class="fa fa-check"></i>&nbsp; Approval Requested
                    </button>';
                break;
            case 'ApprovedSPB':
            case 'Approved':
                $data['ButtonType'] = 
                    '<button type="button" title="Approved" class="btn btn-success pull-right" disabled>
                        <i class="fa fa-check-circle-o"></i>&nbsp; Approved
                    </button>';
                break;
            case 'RejectedSPB':
            case 'Rejected':
                $data['ButtonType'] = 
                    '<button type="button" title="Rejected" class="btn btn-danger pull-right" disabled>
                        <i class="fa fa-remove"></i>&nbsp; Rejected
                    </button>';
                break;
            case 'PendingSPB':
            case 'Pending':
                if ( $data['UserMenu'][0]['user_group_menu_name'] === 'Approval DO KACAB' ) {
                    $data['ButtonType'] = 
                        '<button type="button" title="Pending" class="btn btn-default pull-right" style="margin-right: 10px" disabled>
                            <i class="fa fa-clock-o"></i>&nbsp; Pending
                        </button>';
                } else if ( $data['UserMenu'][0]['user_group_menu_name'] === 'Approval DO Admin' ) {
                    $data['ButtonType'] = 
                        '<button type="button" title="Select Approver" class="btn btn-primary pull-right btnADOSelectApprover">
                            <i class="fa fa-location-arrow"></i>&nbsp; Select Approver
                        </button>
                        <button type="button" title="Pending" class="btn btn-default pull-right" style="margin-right: 10px" disabled>
                            <i class="fa fa-clock-o"></i>&nbsp; Pending
                        </button>';
                }
                break;
            case 'LaunchPickRelease':
                $data['ButtonType'] =
                    '<button type="button" title="Launch Pick Release" class="btn btn-primary pull-right btnADOLaunchRelease">
                        <i class="fa fa-dropbox"></i>&nbsp; Launch Pick Release
                    </button>';
                break;
            default:
                $data['ButtonType'] = '';
                break;
        }

		$this->load->view('V_Header', $data);
		$this->load->view('V_Sidemenu', $data);
        $this->load->view('ApprovalDO/MainMenu/V_DetailDO', $data);
        $this->load->view('V_Footer', $data);
    }

}