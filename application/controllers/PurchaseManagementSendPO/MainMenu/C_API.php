<?php
defined('BASEPATH') or exit('No direct script access allowed');

error_reporting(0);

ini_set('display_errors', 0);

class C_API extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PurchaseManagementSendPO/MainMenu/M_log', 'po_log');
        $this->load->model('PurchaseManagementSendPO/MainMenu/M_sysuser', 'sys_user');
        $this->load->model('PurchaseManagementSendPO/MainMenu/M_userinfo', 'user_info');
    }

    private function checkIfInArray($array, $database_field)
    {
        foreach ($array as $key => $val) {
            if (!in_array($key, $database_field)) {
                throw new Exception("Parameter {$key} yang anda berikan tidak sesuai!");
            }
        }
    }

    private function checkUserSession()
    {
        if (!$this->session->user_id) {
            throw new Exception('Silahkan melakukan login terlebih dahulu!');
        }
    }

    public function checkLoginStatus()
    {
        try {
            $this->checkUserSession();

            if ($this->input->method() !== 'get') {
                throw new Exception('Method yang anda berikan tidak sesuai!');
            }

            $data = [
                'status' => 'success',
                'message' => "Anda telah login sebagai {$this->session->national_identifier_number}",
                'user_id' => $this->session->user_id,
                'national_identifier_number' => $this->session->national_identifier_number,
                'name' => $this->session->name,
            ];

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } catch (Exception $e) {            
            $data = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    public function login()
    {
        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('Method yang anda berikan tidak sesuai!');
            }

            $post = $this->input->post();

            if (!count($post)) {
                throw new Exception('Silahkan memberikan parameter terlebih dahulu!');
            }

            $this->form_validation
                ->set_data($post)
                ->set_rules('user_name', 'user name', 'required')
                ->set_rules('user_password', 'user password', 'required')
                ->set_message('required', 'Anda belum memberikan parameter {field}!');

            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors(' ', ' '));
            }

            $this->checkIfInArray($post, [
                'user_name',
                'user_password',
            ]);

            $post['user_password'] = md5($post['user_password']);

            $user_id = $this->sys_user->selectUserIdentity($post);
            $user_information = $this->user_info->selectUserInformation([
                'noind' => $post['user_name']
            ]);

            $this->session->set_userdata([
                'user_id' => $user_id,
                'national_identifier_number' => $post['user_name'],
                'name' => trim($user_information->name),
            ]);

            $data = [
                'status' => 'success',
                'message' => "Berhasil login sebagai {$this->session->national_identifier_number}",
                'user_id' => $this->session->user_id,
                'national_identifier_number' => $this->session->national_identifier_number,
                'name' => $this->session->name,
            ];

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } catch (Exception $e) {
            $data = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    public function logout()
    {
        try {
            $this->checkUserSession();

            if ($this->input->method() !== 'get') {
                throw new Exception('Method yang anda berikan tidak sesuai!');
            }

            $this->session->sess_destroy();

            $data = [
                'status' => 'success',
                'message' => 'Berhasil melakukan logout',
            ];

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } catch (Exception $e) {            
            $data = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    public function updateLog()
    {
        try {
            if ($this->input->method() !== 'post') {
                throw new Exception('Method yang anda berikan tidak sesuai!');
            }

            $post = $this->input->post();

            if (!count($post)) {
                throw new Exception('Silahkan memberikan parameter terlebih dahulu!');
            }

            $this->form_validation
                ->set_data($post)
                ->set_rules('purchasing_approve_by', 'purchasing approve by', 'max_length[128]')
                ->set_rules('management_approve_by', 'management approve by', 'max_length[128]')
                ->set_rules('pha_segment_1', 'pha segment 1', 'required|min_length[10]|regex_match[/-/]')
                ->set_message('max_length', 'Parameter {field} yang anda berikan memiliki panjang lebih dari {param} karakter!')
                ->set_message('min_length', 'Parameter {field} yang anda berikan memiliki panjang kurang dari {param} karakter!')
                ->set_message('regex_match', 'Parameter {field} yang anda berikan tidak memiliki pemisah antara pha segment 1 dengan revision number yang diperlukan!')
                ->set_message('required', 'Anda belum memberikan parameter {field}!');

            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors(' ', ' '));
            }

            $this->checkIfInArray($post, [
                'purchasing_approve_by',
                'management_approve_by',
                'pha_segment_1',
            ]);

            $purchase_order_count = $this->po_log->count([
                'pha_segment_1' => substr($post['pha_segment_1'], 0, strpos($post['pha_segment_1'], '-')),
                'revision_num' => substr($post['pha_segment_1'], strpos($post['pha_segment_1'], '-') + 1),
            ]);

            if ($purchase_order_count === 0) {
                throw new Exception('Tidak ditemukan data dengan pha segment 1 terkait!');
            }

            if (array_key_exists('management_approve_by', $post)) {
                $approved_by_purchasing_count = $this->po_log->count([
                    'pha_segment_1' => substr($post['pha_segment_1'], 0, strpos($post['pha_segment_1'], '-')),
                    'revision_num' => substr($post['pha_segment_1'], strpos($post['pha_segment_1'], '-') + 1),
                    'purchasing_approve_by != ' => null,
                ]);

                if ($approved_by_purchasing_count === 0) {
                    throw new Exception('Silahkan melakukan approve ke purchasing terlebih dahulu!');
                }
            }

            $affected_rows = $this->po_log->update(
                [
                    'pha_segment_1' => substr($post['pha_segment_1'], 0, strpos($post['pha_segment_1'], '-')),
                    'revision_num' => substr($post['pha_segment_1'], strpos($post['pha_segment_1'], '-') + 1),                  
                ],
                array_key_exists('purchasing_approve_by', $post) ? 'purchasing_approve_date' : 'management_approve_date',
                array_intersect_key($post, array_flip([
                    'purchasing_approve_by',
                    'management_approve_by',
                ]))
            );

            $data = [
                'status' => 'success',
                'message' => "Berhasil memperbarui $affected_rows baris data",
            ];

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } catch (Exception $e) {
            $data = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }

    public function getVendorName()
    {
        try {
            if ($this->input->method() !== 'get') {
                throw new Exception('Method yang anda berikan tidak sesuai!');
            }

            $get  = $this->input->get();

            if (!count($get)) {
                throw new Exception('Silahkan memberikan parameter terlebih dahulu!');
            }

            $this->form_validation
                ->set_data($get)
                ->set_rules('pha_segment_1', 'pha segment 1', 'required')
                ->set_message('required', 'Anda belum memberikan parameter {field}!');

            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors(' ', ' '));
            }

            $this->checkIfInArray($get, [
                'pha_segment_1',
            ]);

            $vendor_name = $this->po_log->selectVendorName([
                'pha_segment_1' => substr($get['pha_segment_1'], 0, 8),
                'revision_num' => substr($get['pha_segment_1'], 9),
            ]);

            $data = [
                'status' => 'success',
                'message' => $vendor_name,
            ];

            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } catch (Exception $e) {
            $data = [
                'status' => 'failed',
                'message' => $e->getMessage(),
            ];

            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }
}
