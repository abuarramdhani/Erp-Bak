<?php

use Zimbra\Admin\AdminFactory;
use Zimbra\Enum\AccountBy;
use Zimbra\Struct\AccountSelector;
use Zimbra\Struct\KeyValuePair;

class Zimbra
{
  public $soap_url = 'https://mail.quick.com:7071/service/admin/soap';
  private $user = 'admin';
  private $password = 'sys123456';

  // Distribution MANDATORY IN KHS
  public $mandatoryDistributions = [
    // semua pekerja
    [
      'id' => 'd04fa221-a634-4483-8c0c-bd96b0e130ec',
      'displayName' => 'Semua Pekerja CV KHS'
    ],
    // semua seksi
    [
      'id' => 'c4e5ab3d-bfbc-4f7b-ab46-b4231b2c2498',
      'displayName' => 'Semua Seksi CV Karya Hidup Sentosa'
    ]
  ];

  public $departemenDistributions = [
    # 'id of departemen' => [
    # departement_id
    #  id
    #  displayName
    # ]
    [
      'id' => 'b262a5d7-2943-44b9-b50d-83fa96154416', // id of distribution
      'departement_id' => 1, // kodesie -> (3)1010201, first digit of kodesie
      'location_code' => false, // false is not have specific code
      'displayName' => 'Departemen Keuangan' // Display name of id
    ],
    [
      'id' => 'c93b1b4d-26e7-4700-ad3c-fdbfa33fd619',
      'departement_id' => 2,
      'location_code' => false,
      'displayName' => 'Departemen Pemasaran'
    ],
    [
      'id' => '646b657d-9dc0-46e7-97fd-24f19675142a',
      'departement_id' => 3,
      'location_code' => false,
      'displayName' => 'Departemen Produksi'
    ],
    [
      'id' => 'a8c372ce-095b-4b67-a041-6f8a2f44f14b',
      'departement_id' => 3,
      'location_code' => '01',
      'displayName' => 'Departemen Produksi - Pusat'
    ],
    [
      'id' => '8e1b2b2f-b7fe-4458-b915-d16e63c312b0',
      'departement_id' => 3,
      'location_code' => '02',
      'displayName' => 'Departemen Produksi - Tuksono'
    ],
    [
      'id' => 'fe9d5306-e20c-44d0-9611-e7986ce7be18',
      'departement_id' => 4,
      'location_code' => false,
      'displayName' => 'Departemen Personalia'
    ]
  ];

  # Target email address
  public $email;

  public function __construct()
  {
    $this->api = AdminFactory::instance($this->soap_url);
    $this->connect();
  }

  public function connect()
  {
    $this->api->auth($this->user, $this->password);

    return $this->api;
  }

  /**
   * Get account
   * 
   * @param String $name Name
   */
  public function getAccount($name)
  {
    try {
      $account = $this->api->getAccount(new AccountSelector(AccountBy::NAME(), $name));
      return $account;
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * @param Array $distributionList Array<Array<Id>>
   * 
   */
  public function addDistributions($distributionList)
  {
    if (!$this->email) throw new Exception("Email is empty or not setted");
    // convert to object
    foreach ($distributionList as $list) {
      $this->api->addDistributionListMember($list['id'], [
        $this->email
      ]);
    }
  }

  /**
   * Add user to distribution of related departement
   * 
   * @param String $kodesie
   * @param String $location_code
   * 
   * @return Void
   */
  public function addRelatedDepartemenDistributions($kodesie, $location_code)
  {
    // filter with departemen distribuion
    $dept_id = substr($kodesie, 0, 1);
    $param = compact([
      'dept_id',
      'location_code'
    ]);

    $foundedDistributions = array_filter($this->departemenDistributions, function ($item) use ($param) {
      return $item['departement_id'] == $param['dept_id'] && ($item['location_code'] == $param['location_code'] || $item['location_code'] === false);
    });

    // add distribution list
    $this->addDistributions($foundedDistributions);
  }

  /**
   * This is to create account
   * @param String $email
   * @param String $password
   * @param String $displayName
   */
  public function createAccount($email, $password, $displayName)
  {
    /**
     * @param String email address, must with domain
     * @param String password
     * @param Array|Optional array of \KeyValuePair
     */
    $this->api->createAccount($email, $password, [
      new KeyValuePair('displayName', $displayName), // displayname
      // new KeyValuePair('givenName', 'Coba'), // firstname
      new KeyValuePair('zimbraMailMessageLifetime', '186d'), // default setting from khs
      new KeyValuePair('zimbraMailTrashLifetime', '30d'),
      new KeyValuePair('zimbraMailSpamLifetime', '30d'),
    ]);

    $this->email = $email;
  }
}
