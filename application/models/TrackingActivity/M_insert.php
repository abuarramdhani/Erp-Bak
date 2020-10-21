<?php defined('BASEPATH') or die('No direct script access allowed');

class M_insert extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
        $this->oracle = $this->load->database('oracle', true);
    }

    public function insertData($data)
    {
        if (!empty($data['id'])) {
            if (!empty($data['long'])) {
                if (!empty($data['lat'])) {
                    $response['success'] = true;
                    $this->oracle->query("INSERT into KHS_TRACKING_GPS_LOG (DEVICE_ID,LOG_TIME,LONGITUDE,LATITUDE)
                                    VALUES ('$data[id]',sysdate, $data[long],$data[lat])");
                } else {
                    $response['message'] = 'latitude is empty!, can\'t do this action.';
                }
            } else {
                $response['message'] = 'longitude is empty!, can\'t do this action.';
            }
        } else {
            $response['message'] = 'device id is empty!, can\'t do this action.';
        }
        return $response;
    }
}
