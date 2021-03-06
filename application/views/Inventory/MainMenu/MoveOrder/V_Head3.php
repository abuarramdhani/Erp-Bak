<table class="table table-head" style="padding-bottom: 8px">
    <tr>
        <td width="35%">
            <h4>CV. KARYA HIDUP SENTOSA</h4>
        </td>
        <td class="ver-center" rowspan="2">
            <h3>PICK LIST GUDANG (MO) (ODM)</h3>
        </td>
    </tr>
    <tr>
        <td>
            <h4>YOGYAKARTA</h4>
        </td>
    </tr>
</table>
<table class="table table-head" style="margin-top: -10px;">
    <?php 
    $count = sizeof($dataall['line']);
    foreach ($dataall['head'] as $key => $value) { ?>
                <tr>
                    <td width="15%">Tanggal Cetak</td>
                    <td width="30%">: <?php echo $value['PRINT_DATE']; ?></td>
                    <td width="15%">Hal</td>
                    <td width="30%">{PAGENO}/[pagetotal]</td>
                    <td width="10%" class="ver-top" rowspan="6" width="15%" style="text-align: center;" >
                        <img style="width: 67px; height: auto" src="<?php echo base_url('assets/img/'.$value['MOVE_ORDER_NO'].'.png') ?>">
                        <?php 
                            if (strlen($value['MOVE_ORDER_NO'])>11) {
                                $no_mo = substr_replace($value['MOVE_ORDER_NO'], '<br>', 12, 0);
                            }else{
                                $no_mo = $value['MOVE_ORDER_NO'];
                            }
                        ?>
                        <?= $no_mo; ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Subinv</td>
                    <td width="30%">: <?php echo $value['LOKASI'] ?></td>
                    <td width="15%">Job No</td>
                    <td>: <?php echo $value['JOB_NO'] ?></td>
                </tr>
                <tr>
                    <td>Locator</td>
                    <td>: <?= $dataall['line'][0]['LOKATOR']?></td>
                    <td>Department</td>
                    <td>: <?php echo $value['DEPARTMENT'] ?></td>
                </tr>
                <tr>
                    <td>Produk</td>
                    <td>: <?php echo $value['KATEGORI_PRODUK'] ?></td>
                    <td>Kode Assembly</td>
                    <td>: <?php echo $value['PRODUK'] ?></td>
                </tr>
                <tr>
                    <td>Tanggal Dipakai</td>
                    <td>: <?php echo $value['DATE_REQUIRED'] ?></td>
                    <td>Nama Assembly</td>
                    <td>: <?php  echo $value['PRODUK_DESC']?><br></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $value['SCHEDULE'] ?></td>
                    <td>Total Qty / Jml Item</td>
                    <td>: <?php echo $value['START_QUANTITY'] ?> / <?php echo $count?></td>
                </tr>
    <?php } ?>
            </table>
            
