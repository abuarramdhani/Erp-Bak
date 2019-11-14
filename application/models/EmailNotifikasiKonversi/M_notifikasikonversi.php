<?php
Defined('BASEPATH') or exit('No Direct Script Access Allowed');

class M_notifikasikonversi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->oracle = $this->load->database('oracle',TRUE);
    }

    public function getConversionValue()
    {
        $sql    =  "SELECT
                        test2.user_conversion_type, test2.test conversion, conversion_date,
                        conversion_rate
                    FROM (SELECT   gdrv.conversion_date, gdrv.conversion_rate,
                                    user_conversion_type, gdrv.FROM_currency, gdrv.to_currency,
                                    gdrv.FROM_currency || '-' || gdrv.to_currency test
                                FROM gl_daily_rates_v gdrv
                            WHERE gdrv.conversion_date = trunc (SYSDATE)
                            ORDER BY user_conversion_type) test1,
                        (SELECT distinct FROM_currency || '-' || to_currency test,
                                            user_conversion_type
                                    FROM gl_daily_rates_v gdrv
                                    WHERE FROM_currency IN ('IDR','USD','EUR','CNY','GBP','SGD','JPY','MYR')
                                        AND to_currency IN ('IDR','USD','EUR','CNY','GBP','SGD','JPY','MYR')
                                        )test2
                    WHERE test1.test(+) = test2.test 
                    AND test1.user_conversion_type(+) = test2.user_conversion_type
                    ORDER BY conversion, user_conversion_type";
        
        $query  = $this->oracle->query($sql);
        return $query->result_array();
    }
}