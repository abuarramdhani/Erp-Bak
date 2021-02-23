<?php

use function PHPSTORM_META\type;

defined('BASEPATH') or exit("No direct script is allowed");

function dd($var)
{
  echo "<pre>";
  print_r($var);
  die;
}

class C_Civil_Monitoring extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('html');

    $this->load->library('form_validation');
    $this->load->library('session');
    // $this->load->library('encrypt');
    // $this->load->library('upload');
    $this->load->library('General');

    $this->load->model('SystemAdministration/MainMenu/M_user');
    $this->load->model('CivilMaintenanceOrder/M_civil_monitoring', 'MonitoringModel');
    $this->load->model('CivilMaintenanceOrder/M_civil', 'CivilModel');

    if ((bool)$this->session->is_logged === false) redirect('');
  }

  /**
   * Monitoring Page
   */
  public function index()
  {
    $user = $this->session->user;

    $data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Civil Maintenance Order', '', '', '');

    $main = [
      'allOrders' => $this->MonitoringModel->getAllOrders(),
      'allStatus' => $this->CivilModel->getStatusOrder()
    ];

    /**
     * Experimental to find slug
     */
    // function get_slug()
    // {
    //   $base_url = base_url();
    //   $current_url = current_url();

    //   return explode($base_url, $current_url)[1];
    // }

    // print_r(get_slug());
    // die;

    // dd($main);

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CivilMaintenanceOrder/Order/V_Monitoring', $main);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Schedule Page
   */
  public function schedule($order_id)
  {
    $user = $this->session->user;

    $data  = $this->general->loadHeaderandSidemenu('Civil Maintenance', 'Civil Maintenance Order', '', '', '');

    $main = [
      'order_id' => $order_id
    ];

    $this->load->view('V_Header', $data);
    $this->load->view('V_Sidemenu', $data);
    $this->load->view('CivilMaintenanceOrder/Order/V_Monitoring_Schedule', $main);
    $this->load->view('V_Footer', $data);
  }

  /**
   * Rest API
   * POST
   * to update kolom tanggal terima
   */
  public function update_acc_date()
  {
    try {
      $order_id = $this->input->post('order_id');
      $date = $this->input->post('date');

      if (!$order_id || !$date) throw new Exception("Param is required");

      // format to right format
      $date = date_create_from_format('d/m/Y', $date)->format('Y-m-d') ?: date('Y-m-d');

      $update = $this->MonitoringModel->update_acc_date($order_id, $date);
      if (!$update)  throw new Exception("Error updating");

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'message' => 'Successfully',
          'date' => $date
        )));
    } catch (\Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode(array(
          'message' => $e->getMessage()
        )));
    }
  }

  /**
   * Rest API
   * POST
   * to update order status
   */
  public function update_order_status()
  {
    try {
      $order_id = $this->input->post('order_id');
      $status_id = $this->input->post('status_id');

      if (!$order_id || !$status_id) throw new Exception("Params is required");

      $update = $this->MonitoringModel->update_order_status($order_id, $status_id);
      if (!$update)  throw new Exception("Error updating");

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'message' => 'Successfully',
        )));
    } catch (\Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode(array(
          'message' => $e->getMessage()
        )));
    }
  }

  /**
   * Rest API
   * GET
   * to get all schedule by order id
   */
  public function get_schedule()
  {
    $order_id = $this->input->get('order_id');

    try {
      if (!$order_id) throw new Exception("Order id is invalid");

      $order =  $this->MonitoringModel->getOrder($order_id); // array
      if (!$order) throw new Exception("Order is not found");

      $schedule = $this->MonitoringModel->getSchedule($order_id); // array
      $schedule_detail = $this->MonitoringModel->getScheduleDetail($order_id); // array

      // $param = [
      //   'order' => $order,
      //   'end' => count($schedule_detail) - 1
      // ];

      // $schedule = array_map(function ($index, $item) use ($param) {
      //   $item->status = $param['order']->tgl_close ? 'closed' : '';

      //   return $item;
      // }, array_keys($schedule), $schedule);


      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'schedule' => $schedule,
          'schedule_detail' => $schedule_detail
        )));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode(array(
          'message' => $e->getMessage()
        )));
    }
  }

  /**
   * Rest API
   * POST
   * to update schedule by order id and date
   */
  public function update_schedule()
  {
    $user = $this->session->user; // string
    $order_id = $this->input->post('order_id'); // integer
    $tanggal =  $this->input->post('tanggal'); // Y-m-d
    $status =  $this->input->post('status'); // start|progress|end
    $keterangan = $this->input->post('detail'); // string
    $jobs = $this->input->post('jobs'); // array

    try {
      if (empty($order_id) || empty($tanggal)) throw new Exception("One or more param is missing");

      // update jadwal
      if ($jobs && is_array($jobs)) {
        $insertOrUpdate = $this->MonitoringModel->updateSchedule($order_id, $status, $tanggal, $jobs);
      }

      // update jadwal detail
      $insertOrUpdate = $this->MonitoringModel->updateScheduleDetail($order_id, $tanggal, $keterangan);

      // update tanggal selesai order jika statusny adalah end
      if ($status == 'end') {
        // update tanggal selesai / close
        $this->MonitoringModel->updateCloseDate($order_id, $tanggal, $user);
        // ubah status 
        $this->MonitoringModel->update_order_status($order_id, 3); // DONE
      } else {
        // remove closedate and user
        $this->MonitoringModel->updateCloseDate($order_id, NULL, NULL);
        // ubah status 
        $this->MonitoringModel->update_order_status($order_id, 2); // WIP
      }

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'message' => 'Success update schedule'
        )));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode(array(
          'message' => $e->getMessage()
        )));
    }
  }

  /**
   * Rest API
   * POST
   * to remove schedule by order id and date
   */
  public function remove_schedule()
  {
    $order_id = $this->input->post('order_id');
    $tanggal = $this->input->post('tanggal');

    try {
      if (!$order_id || !$tanggal) throw new Exception("Param failed");

      $delete = $this->MonitoringModel->removeSchedule($order_id, $tanggal);

      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(200)
        ->set_output(json_encode(array(
          'message' => 'Success remove schedule'
        )));
    } catch (Exception $e) {
      return $this->output
        ->set_content_type('application/json')
        ->set_status_header(400)
        ->set_output(json_encode(array(
          'message' => $e->getMessage()
        )));
    }
  }
}
