<?php

class C_Api extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Trim email from @
   * 
   * example johndoe@email -> johndoe
   * 
   * @param String $email
   * @return String Name
   */
  protected function trimEmail($email)
  {
    return explode('@', $email)[0];
  }

  /**
   * To check zimbra account is exist or not
   * 
   * 
   */
  public function checkZimbra()
  {
    # Load class for create email account
    require_once(APPPATH . 'controllers/ADMSeleksi/Zimbra/Zimbra.php');
    $zimbra = new Zimbra;

    $email = $this->input->post('email');
    $emailName = $this->trimEmail($email);

    $getAccount = $zimbra->getAccount($emailName);

    return response()->json([
      'code' => 200,
      'data' => [
        'exist' => $getAccount ? true : false
      ],
    ], 200);
  }

  /**
   * To check pidgin account is exist or not
   * 
   * 
   */
  public function checkPidgin()
  {
    # Load class for create pidgin account
    require_once(APPPATH . 'controllers/ADMSeleksi/Openfire/Openfire.php');

    $openfire = new Openfire;

    $username = $this->input->post('username');
    // $emailName = $this->trimEmail($email);

    $getAccount = $openfire->getAccount($username);

    return response()->json([
      'code' => 200,
      'data' => [
        'exist' => $getAccount ? true : false
      ],
    ], 200);
  }
}
