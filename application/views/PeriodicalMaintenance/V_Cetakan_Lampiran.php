<pagebreak></pagebreak>
<table style="width: 100%;border:1px solid black;border-collapse:collapse;font-family:Arial, Helvetica, sans-serif">
    <tbody>
    <tr>
        <th style="padding-left:10px;border:1px solid black;border-collapse:collapse;background-color:lightgray;font-size:14pt" colspan="2">LAMPIRAN GAMBAR</th>
    </tr>
        <tr style="text-align:center; vertical-align:middle">
            <?php
        for ($g = 0; $g < sizeof($gambar); $g++) {
        ?>

            <td>
            <div style="float:none; margin: 0 auto">
                                        <center> <img style="max-width: 250px;max-height: 250px"
                    src="<?php echo base_url($gambar[$g]['FILE_DIR_ADDRESS']); ?>"></center>
                                    </div>
               
            </td>
            &nbsp;

            <?php }?>
        </tr>
    </tbody>
</table>