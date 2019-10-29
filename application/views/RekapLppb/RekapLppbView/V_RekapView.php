<style type="text/css">
  .select2-container {
    width: 100% !important;
    padding: 0;

}
  .btn-real-dis{
   /*cursor: pointer;*/
   color: #888;
  }

  .btn-real-ena{
    cursor: pointer;
  }
</style>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                <?php for ($i=0; $i <count($navbulan) ; $i++) { 
                    $month = $navbulan[$i]['bln'];
                    if ($monthnow == ".$month.") {?>
                        <li class="active"><a type="button" name="anaview" data-value="<?= $navbulan[$i]['mon'] ?>" data-toggle="tab"><?= $navbulan[$i]['bln'] ?> 
                        <?php if ($navbulan[$i]['selisih'] > 0) {?>
                            <span class="label label-danger"><?=$navbulan[$i]['selisih']?></span>
                        <?php } else { ?>
                        <?php }?>
                        </a></li>
                    <?php } else { ?>
                        <li><a type="button" name="anaview" data-value="<?= $navbulan[$i]['mon'] ?>" data-toggle="tab"><?= $navbulan[$i]['bln'] ?>
                        <?php if ($navbulan[$i]['selisih'] > 0) {?>
                            <span class="label label-danger"><?=$navbulan[$i]['selisih']?></span>
                        <?php } else { ?>
                        <?php }?></a></li>
                    <?php } 
                } ?>
                <!-- <li><a type="button" data-toggle="tab">DEC</a></li>
                <li><a type="button" data-toggle="tab">NOV</a></li>
                <li><a type="button" data-toggle="tab">OCT</a></li>
                <li class="active"><a type="button" data-toggle="tab">SEPT</a></li>
                <li><a type="button" data-toggle="tab">AUG</a></li>
                <li><a type="button" data-toggle="tab">JUL</a></li>
                <li><a type="button" data-toggle="tab">JUN</a></li>
                <li><a type="button" data-toggle="tab">MEI</a></li>
                <li><a type="button" data-toggle="tab">APR</a></li>
                <li><a type="button" data-toggle="tab">MAR</a></li>
                <li><a type="button" data-toggle="tab">FEB</a></li>
                <li><a type="button" data-toggle="tab">JAN</a></li> -->
                <!-- <li class="pull-left header"><i class="fa fa-tag"></i> Rekap Lpbb - View</li> -->
            </ul>
        </div>
        <div class="col-lg-12">
        <div id="loadingRLView"></div>
            <div id="RekapView">
                <table class="table table-striped table-bordered table-responsive table-hover text-left tblRekapLppbview" id="" style="font-size:14px;">
                    <thead>
                        <tr class="bg-primary">
                            <td width=""><b>No</b></td>
                            <td width=""><b>Item </b></td>
                            <td width="20%"><b>Description</b></td>
                            <td width=""><b>No.PO</b></td>
                            <td width=""><b>No. Receipt</b></td>
                            <td width=""><b>Receipt Date</b></td>
                            <td width=""><b>Sudah LPPB</b></td>
                            <td width=""><b>Kirim QC</b></td>
                            <td width=""><b>Terima QC</b></td>
                            <td width=""><b>Kembali QC</b></td>
                            <td width=""><b>Kirim Gudang</b></td>
                            <td width=""><b>Terima Gudang</b></td>
                            <td width=""><b>Deliver</b></td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    if (empty($data)) {
                    } else {
                    foreach ($data as $key) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $key['ITEM'] ?></td>
                            <td><?= $key['DESCRIPTION'] ?></td>
                            <td><?= $key['PO'] ?></td>
                            <td><?= $key['RECEIPT_NUM'] ?></td>
                            <td><?= $key['RECEIPT_DATE'] ?></td>
                            <td><?= $key['RECEIPT_DATE'] ?></td>
                            <td><?= $key['KIRIM_QC'] ?></td>
                            <td><?= $key['TERIMA_QC'] ?></td>
                            <td><?= $key['KEMBALI_QC'] ?></td>
                            <td><?= $key['KIRIM_GUDANG'] ?></td>
                            <?php 
                            if ($key['TERIMA_GUDANG'] !== null){
                                $tgl1 = $key['TERIMA_GUDANG'];
                                $tgl2 = $key['KIRIM_GUDANG'];
                                $nextdate = date('Y-m-d', strtotime($tgl2 .' +1 day'));
                                $date = date('Y-m-d', strtotime($tgl1));
                                // echo $nextdate;
                                        if ( $date > $nextdate ) {
                                            ?>
                                            <td bgcolor="red">
                                                <?= $key['TERIMA_GUDANG']?>
                                            </td>
                                        <?php }else{?>
                                            <td>
                                                <?= $key['TERIMA_GUDANG']?>
                                            </td>
                            <?php }
                                }else{ ?>
                            <td >
                                <?= $key['TERIMA_GUDANG']?>
                            </td>
                            <?php } ?>
                            <!-- <td><?= $key['DELIVER_DATE'] ?></td> -->
                            <td><?= $key['DELIVER_DATE'] ?></td>
                        </tr><?php
                        $i++; } 
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</section>