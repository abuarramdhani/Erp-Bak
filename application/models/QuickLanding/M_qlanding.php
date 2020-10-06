<?php
class M_qlanding extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function getDataReport($loc, $from_date, $to_date){
        $landing = $this->load->database('quick_landing', true);

        if (!$loc or $loc == 'all'){
            $loc = "null";
        } else {
            $loc = "'$loc'";
        }

        if (!$from_date){
            $from_date = "null";
        } else {
            $from_date = "'$from_date'";
        }

        if (!$to_date){
            $to_date = "null";
        } else {
            $to_date = "'$to_date'";
        }

        $data = $landing->query("
        SELECT
            1 row,
            tab.button_location
            ,tab.browser
            ,tab.creation_date
        FROM
            track_accessed_button tab
        WHERE
            tab.button_location = ifnull ($loc, tab.button_location)
            AND DATE_FORMAT(tab.creation_date, '%Y-%m-%d') BETWEEN ifnull($from_date, '2020-02-01') AND ifnull($to_date, '2020-08-28');
        ");
        return $data->result_array();
    }

    public function getDataLoc(){
        $landing = $this->load->database('quick_landing', true);
        $data = $landing->query("
            SELECT
                tab.button_location
            FROM
                track_accessed_button tab
            GROUP BY tab.button_location
        ");

        return $data->result_array();
    }

}
?>