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
    }

    private function checkIfInArray($array, $database_field) {
        foreach ($array as $key => $val) {
            if (!in_array($key, $database_field)) {
                throw new Exception("Parameter {$key} yang anda berikan tidak sesuai!");
            }
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
                ->set_rules('pha_segment_1', 'pha segment 1', 'required')
                ->set_message('max_length', 'Parameter {field} yang anda berikan memiliki panjang lebih dari {param} karakter!')
                ->set_message('required', 'Anda belum memberikan parameter {field}!');

            if (!$this->form_validation->run()) {
                throw new Exception(validation_errors(' ', ' '));
            }

            $this->checkIfInArray($post, [
                'purchasing_approve_by',
                'management_approve_by',
                'pha_segment_1',
            ]);

            $affected_rows = $this->po_log->update(
                [
                    'pha_segment_1' => substr($post['pha_segment_1'], 0, 8),
                    'revision_num' => substr($post['pha_segment_1'], 9),                    
                ],
                $post['purchasing_approve_by'] ? 'purchasing_approve_date' : 'management_approve_date',
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
