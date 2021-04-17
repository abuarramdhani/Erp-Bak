<?php
defined('BASEPATH') or die('No direct script access allowed');

class C_Input extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_Index', 'index');
    $this->load->model('SystemAdministration/MainMenu/M_user', 'user');
    $this->load->library('../controllers/PerhitunganHargaSparepart/_modules/C_UserData', null, 'user_data');
    $this->load->model('PerhitunganHargaSparepart/M_items', 'items');
    $this->load->model('PerhitunganHargaSparepart/M_calculate_spt', 'calculate_spt');
    $this->user_data->checkLoginSession();
  }

  public function index()
  {
    $view_data = $this->user_data->getUserMenu();
    $view_data->Menu = 'Input';
    $view_data->SubMenuOne = '';

    $this->load->view('V_Header', $view_data);
    $this->load->view('V_Sidemenu', $view_data);
    $this->load->view('PerhitunganHargaSparepart/Marketing/V_Input', $view_data);
    $this->load->view('V_Footer', $view_data);
  }

  public function getItemDetailsByKeyword()
  {
    $keyword = $this->input->get('keyword');

    $result = $this->items->getItemsByKeyword(strtoupper($keyword));

    $this->output
      ->set_status_header(200)
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
  }
  public function getOrderId()
  {
    $n = 1;
    check:
    $cek = $this->calculate_spt->cekOrderId($n);
    if (!empty($cek)) {
      $n++;
      goto check;
    }
    return $n;
  }
  public function save()
  {
    $post = $this->input->post();

    // $rows = array_map(function ($key) use ($post) {
    //   $order_id = $this->getOrderId();
    //   return array_change_key_case([
    //     'order_id' => $order_id,
    //     'product' => $post['product'][$key],
    //     'item_id' => $post['item_id'][$key],
    //     'wrap_flag' => $post['wrap_flag'][$key],
    //     'qty' => $post['qty'][$key],
    //     'category' => $post['category'][$key],
    //     'competitor_flag' => $post['competitor_flag'][$key],
    //     // 'dpp_price_reference' => $post['dpp_price_reference'][$key],
    //     'comments' => $post['comments'][$key],
    //   ], CASE_UPPER);
    // }, array_keys($post['product']));

    for ($g = 0; $g < sizeof($post['product']); $g++) {
      $order_id = $this->getOrderId();
      $rows[0] = array(
        'ORDER_ID' => $order_id,
        'PRODUCT' => $post['product'][$g],
        'ITEM_ID' => $post['item_id'][$g],
        'WRAP_FLAG' => $post['wrap_flag'][$g],
        'QTY' => $post['qty'][$g],
        'CATEGORY' => $post['category'][$g],
        'COMPETITOR_FLAG' => $post['competitor_flag'][$g],
        // 'dpp_price_reference' => $post['dpp_price_reference'][$g],
        'COMMENTS' => $post['comments'][$g],
      );

      $this->calculate_spt->insertRows($rows);

      $k = 1;
      for ($i = 0; $i < 3; $i++) {
        $arrayap[$i] = array(
          'ORDER_ID' => $order_id,
          'APPROVAL_ID' =>  $k,
        );
        $k++;
      }

      $this->calculate_spt->insertApproval($arrayap);
    }

    // echo '<pre>';
    // print_r($rows);
    // print_r($arrayap);
    // exit();
    redirect(base_url('PerhitunganHargaSparepart/Marketing/Input'));
  }
}
