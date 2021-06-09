<?php

use Gnello\OpenFireRestAPI\Client;

/**
 * !!!! Server Openfire harus terinstall plugin rest api !!!!
 */

class Openfire
{
  public function __construct()
  {
    $this->client = new Client($this->config());
  }

  public function config()
  {
    return [
      'client' => [
        'username' => 'admin',
        'password' => '123456',
        'scheme' => 'http',
        'basePath' => '/plugins/restapi/v1/',
        'host' => 'chat.quick.com',
        'port' => '9090',
      ],
    ];
  }

  /**
   * @param String $username
   * @param String $name
   * @param String $email
   * @param String $password
   */
  public function createUser($username, $name, $email, $password)
  {
    # CREATE USER
    $response = $this->client->getUserModel()->createUser([
      "username" => $username,
      "name" => $name,
      // "email" => $email, // we not use email
      "password" => $password
    ]);
  }

  /**
   * Get account pidgin / openfire
   * 
   * @param String $name
   * @return Mixed
   */
  public function getAccount($name)
  {
    try {
      $response = $this->client->getUserModel()->retrieveUser($name);

      if ($response->getStatusCode() !== 200) throw new Exception("Error");

      return json_decode($response->getBody());
    } catch (Exception $e) {
      return false;
    }
  }

  /**
   * Add user to group
   * 
   * @param String $username
   * @param String $groupname
   * @return Mixed
   */
  public function addUserToGroup($username, $groupName)
  {
    try {
      $response = $this->client->getUserModel()->addUserToGroup($username, $groupName);

      if ($response->getStatusCode() !== 200) throw new Exception("Error");

      return json_decode($response->getBody());
    } catch (Exception $e) {
      return false;
    }
  }
}
