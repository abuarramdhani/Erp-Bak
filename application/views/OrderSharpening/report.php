  <table style="width:100%;border: 1px solid black; padding: 0px;font-size: 16px;border-collapse: collapse;">
    <tr style="border: 1px solid black; padding: 1px 2px">
        <td colspan="2" rowspan="2" width="14%" style="border: 1px solid black; padding: 1px 1px; text-align: center">
            <img width="15%" style="height: 100px; width: 100px"
            src="<?= base_url('assets/img/logo.png') ;?>" style="display:block;">
        </td>
        <td rowspan="2" colspan="3" width="50%" style="border: 1px solid black; padding: 10px 2px;
        text-align: center; font-size: 18px; vertical-align: top;">Form Kirim ke:<br> </td>
        <td colspan="3" width="20%" style="font-size: 12px;text-align: center;border: 1px solid black;padding: 5px 0;">
              <?php foreach ($show as $a) {
                        $order = $a[0]['no_order'];
                      ?>
                    <center>
                        <img style="height: 100px; width: 100px" src="<?php echo base_url('img/'.$order.'.png'); ?>" />
                    </center>
              <?php  } ?>
        </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td width="11%" style="height: 30px; padding-left: 10px;border-left: 1px solid black;">Tanggal</td>
        <td width="3%" style="border-top: 1px solid black; border-bottom: 1px solid black;">:</td>
        <td width="18%" style="border: 1px solid black;"> </td>
    </tr>
    <tr style="width:100%;border: 1px solid black; padding: 0px;font-size: 12px;border-collapse: collapse;">
        <td width="15%" style="border-left: 1px solid black; padding: 1px 2px;height: 30px;">Dari</td>
        <td width="3%" style="border-right: 1px solid black; padding: 1px 2px">:</td>
        <td> </td>
        <td width="3%" style="border-left: 1px solid black; padding: 1px 2px">Seksi</td>
        <td width="3%" style="border-right: 1px solid black; padding: 1px 2px">:</td>
        <td colspan="3"> </td>
    </tr>
    <tr style="width:100%;border: 1px solid black; padding: 0px;font-size: 12px;border-collapse: collapse;" >
        <td style="border-left: 1px solid black; padding: 1px 2px;height: 30px;">Untuk</td>
        <td width="3%" style="border-right: 1px solid black; padding: 1px 2px">:</td>
        <td> </td>
        <td width="10%" style="border-left: 1px solid black; padding: 1px 2px">Seksi</td>
        <td width="3%" style="border-right: 1px solid black; padding: 1px 2px;">:</td>
        <td colspan="3"> </td>
    </tr>
    <tr style="width:100%;border: 1px solid black; padding: 0px;font-size: 12px;border-collapse: collapse;" >
        <td style="height: 90px;">Keterangan</td>
        <td style="border-right: 1px solid black;">:</td>
        <td colspan="6"> </td>
    </tr>
    <tr style="width:100%;border: 1px solid black; padding: 0px;font-size: 12px;border-collapse: collapse;" >
        <td style="height: 30px;" >Quantity</td>
        <td style="border-right: 1px solid black;">:</td>
        <td colspan="6"> </td>
    </tr>
  </table>