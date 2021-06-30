<div class="row">
    <div class="col-md-8">        
    </div>
    <div class="col-md-4">
        <label style="margin-bottom: 7px; margin-top: 7px; float: left;">Scan Item : </label>
        <input type="text" id="inputItemColly" class="form-control" style="width: 300px; float: right;" onkeyup="updateQty(event,this)" autofocus>
        <input type="hidden" id="activeColly">
        <input type="hidden" id="spbcolly" value="<?= $colly[0]['REQUEST_NUMBER'] ?>">
    </div>
</div>
<br>
<?php $no = 1; foreach ($total as $ttl): ?>
    <input type="button" id="btn<?= $ttl['COLLY_NUMBER'] ?>" class="btn <?= $ttl['VERIF'] ?>" onclick="showisiPL('<?= $ttl['COLLY_NUMBER'] ?>')" value="<?= $ttl['COLLY_NUMBER'] ?>" style="width: 110px; margin-bottom: 5px;">
<?php $no++; endforeach; ?>
<hr>
<?php $no = 1; foreach ($total as $ttl): ?>
<input type="hidden" id="auto<?= $ttl['COLLY_NUMBER'] ?>" value="<?= $ttl['AUTO'] ?>">
<div class="row rowhide" id="row<?= $ttl['COLLY_NUMBER'] ?>" style="display: none;">
    <!-- <div class="row"> -->
        <div class="col-md-12" style="padding-left: 30px;padding-right: 30px;">
            <div class="table-responsive">
                <span style="font-weight: bold; font-size: 20px;"><?= $ttl['COLLY_NUMBER'] ?></span>
                <?php
                    if ($ttl['BERAT'] > 0) {
                        $dis = '';
                    }
                    else {
                        $dis = 'disabled';
                    }
                ?>
                <!-- <a href="<?php echo base_url('KapasitasGdSparepart/Packing/cetakSM/'.$ttl['COLLY_NUMBER']) ?>" target="_blank" class="btn btn-danger btn-sm" style="float: right;" <?= $dis ?>><i class="fa fa-file-pdf-o"> Cetak Shipping Mark</i></a> -->
                
                <table class="datatable table table-bordered table-hover table-striped text-center" id="tblColly<?= $ttl['COLLY_NUMBER'] ?>" style="width: 100%;table-layout:fixed">
                    <thead style="background-color:#ffbd73;color:black">
                        <tr>
                            <th style="width: 5%;">NO</th>
                            <th style="width: 20%;">ITEM</th>
                            <th style="width: 65%;">DESCRIPTION</th>
                            <th style="width: 15%;">QTY</th>
                            <th style="width: 15%;">QTY SCAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $norow = 1; foreach ($colly as $c):
                            if ($ttl['COLLY_NUMBER'] == $c['COLLY_NUMBER']) {
                                if ($c['QUANTITY'] == $c['VERIF_QTY']) {
                                    $style = 'bg-success';
                                }
                                else {
                                    $style = '';
                                }
                        ?>
                            <tr id="datarow<?= $ttl['COLLY_NUMBER'] ?>">
                                <td class="<?= $style ?>">
                                    <?= $norow ?>
                                </td>
                                <td class="<?= $style ?>">
                                    <?= $c['ITEM'] ?>        
                                </td>
                                <td class="<?= $style ?>" style="text-align: left;">
                                    <?= $c['DESCRIPTION'] ?>        
                                </td>
                                <td class="<?= $style ?>">
                                    <?= $c['QUANTITY'] ?>
                                    <input type="hidden" id="qty<?= $c['COLLY_NUMBER'].$c['ITEM'] ?>" value="<?= $c['QUANTITY'] ?>">  
                                </td>
                                <td class="<?= $style ?>">
                                    <?= $c['VERIF_QTY'] ?>
                                </td>
                            </tr>
                        <?php } else {
                            $norow = 0;
                        } $norow++; endforeach; ?>
                    </tbody>
                </table>
            </div>    
        </div>
    <!-- </div> -->
    <br>   
</div>
<?php $no++; endforeach; ?>
<div class="row rowshow">
    <center><h2 style="font-weight: bold;">SILAHKAN PILIH COLLY</h2></center>
</div>