<?php
// echo "<pre>";
// print_r ($outpartAll);
// exit();
?>
<style type="text/css">
    .zui-table {
    border: none;
    border-right: solid 1px #DDEFEF;
    border-collapse: separate;
    border-spacing: 0;
    font: normal 13px Arial, sans-serif;
}
.zui-table thead th {
    background-color: #DDEFEF;
    border: none;
    color: #336B6B;
    padding: 10px;
    text-align: left;
    text-shadow: 1px 1px 1px #fff;
    white-space: nowrap;
}
.zui-table tbody td {
    border-bottom: solid 1px #DDEFEF;
    color: #333;
    padding: 10px;
    text-shadow: 1px 1px 1px #fff;
    white-space: nowrap;
}
.zui-wrapper {
    position: relative;
}
.zui-scroller {
    margin-left: 141px;
    overflow-x: scroll;
    overflow-y: visible;
    padding-bottom: 5px;
    width: 300px;
}
.zui-table .zui-sticky-col {
    border-left: solid 1px #DDEFEF;
    border-right: solid 1px #DDEFEF;
    left: 0;
    position: absolute;
    top: auto;
    width: 120px;
}
</style>
<div class="row">
    <div class="col-md-12" >
        <div class="table">
            <div class="panel panel-default">
                <div class="panel-body">
                    <!-- <div class="zui-wrapper">
                        <div class="zui-scroller">
                            <table class="zui-table" style="overflow-x:scroll;max-width:100%;max-height: 80vh;">
                                <thead>
                                     <tr class="bg-primary">
                                        <th class="zui-sticky-col" class="bg-primary" style="position:sticky;top:0;" width="30px" rowspan="2">No</th>
                                        <th class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Edit</th>
                                        <th class="bg-primary" style="position:sticky;top:0;" width="250px" rowspan="2">Nama Subkont</th>
                                        <th class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Mobil</th>
                                        <th class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">No SPBS</th>
                                        <th class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Job</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl SPBS Dibuat</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Diterima PPB</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Kirim</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="150px" rowspan="2">Kode Komponen</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="300px" rowspan="2">Nama Komponen</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">QTY</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="40px" rowspan="2">UOM</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Subinventory</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">Jam</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="60px" rowspan="2">Lama (m : s)</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Tanggal Transact</th>
                                        <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Minta</th>
                                        <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Kirim</th>
                                        <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Mulai</th>
                                        <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="zui-sticky-col">DeMarcus Cousins</td>
                                        <td>15</td>
                                        <td>C</td>
                                        <td>6'11"</td>
                                        <td>08-13-1990</td>
                                        <td>$4,917,000</td>
                                        <td>Kentucky/USA</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
                    <div class="table" style="overflow-x:scroll;max-width:100%;max-height: 80vh;">
                        <div class="table-wrap">
                            <table class="table table-bordered table-hover text-center main-table"  style="width: 1900px;padding-bottom: 0" name="tblOutPart1" id="tblOutPart1">
                                <thead style="position:sticky;top:0;">
                                <tr class="bg-primary">
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="30px" rowspan="2">No</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="50px" rowspan="2">Edit</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="250px" rowspan="2">Nama Subkont</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Mobil</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="70px" rowspan="2">No SPBS</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">No Job</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl SPBS Dibuat</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Diterima PPB</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Tgl Kirim</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="150px" rowspan="2">Kode Komponen</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="300px" rowspan="2">Nama Komponen</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">QTY</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="40px" rowspan="2">UOM</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" rowspan="2">Subinventory</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="100px" colspan="2">Jam</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="60px" rowspan="2">Lama (m : s)</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Tanggal Transact</th>
                                    <th  class="bg-primary" style="position:sticky;top:0;" width="200px" rowspan="2">Keterangan</th>
                                </tr>
                                <tr class="bg-primary">
                                    <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Minta</th>
                                    <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Kirim</th>
                                    <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Mulai</th>
                                    <th class="bg-primary" style="position:sticky;top:38.5px;border-top: 1px solid red;">Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $totalSemua = array();
                                $qty_kirim = 0;
                                $qty_minta = 0;
                                $lama = 0;

                                $subinv = '';
                                $no_spbs = 0;
                                $no = 1; foreach($outpartAll as $all){

                                    $qty_kirim += $all['QTY_KIRIM'];

                                    $qty_minta += $all['QTY_DIMINTA'];

                                    

                                    if (empty($all['TRANSACTION_DATE'])) {
                                        $style = 'background-color:#c1382e;color:white';
                                    }else{
                                        $style = 'background-color:#69dd49 ;color:black';
                                    }

                                    if($all['KETERANGAN'] == 'B'){
                                        $style = 'background-color:#f39c12 ;color:black';
                                    }

                        if($subinv != $all['SUBINV'] && $no_spbs != $all['NO_SPBS']){
                                        $lama += $all['LAMA'];
                                        $subinv = $all['SUBINV'];
                                        $no_spbs = $all['NO_SPBS'];
                        }

                            ?>
                                <tr style="<?php echo $style; ?>"  class="GridViewScrollItem">
                                    <td class="fixed-side"><?php echo $no++; ?></td>
                                    <td class="fixed-side"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Modalku<?php echo $all['NO_SPBS']; ?>">Edit</button></td>
                                    <td class="fixed-side" style="text-align: left;"><?php echo $kontraktor[] = $all['NAMA_SUBKON']; ?></td>
                                    <td><?php echo $all['NO_MOBIL']; ?></td>
                                    <td><?php echo $all['NO_SPBS']; ?></td>
                                    <td><?php echo $all['NO_JOB']; ?></td>
                                    <td><?php echo $all['TGL_SPBS']; ?></td>
                                    <td><?php echo $all['TGL_TERIMA']; ?></td>
                                    <td><?php echo $all['TGL_KIRIM']; ?></td>
                                    <td><?php echo $all['ITEM_CODE']; ?></td>
                                    <td style="text-align: left;"><?php echo $all['ITEM_DESC']; ?></td>
                                    <td><?php echo $all['QTY_DIMINTA']; ?></td> 
                                    <td><?php echo $all['QTY_KIRIM']; ?></td>
                                    <td><?php echo $all['UOM']; ?></td>
                                    <td><?php echo $all['SUBINV']; ?> </td>
                                    <td><?php echo $all['JAM_MULAI']; ?></td>
                                    <td><?php echo $all['JAM_SELESAI']; ?></td>
                                    <td class="lama"><?php 
                                    echo $waktuku[$all['NAMA_SUBKON']] = sprintf('%02d:%02d', (int) $all['LAMA'], fmod($all['LAMA'], 1) * 60); ?>
                                    </td>
<!-- <td><?php echo empty($all['TRANSACTION_DATE']) ? '' : date_format(date_create($all['TRANSACTION_DATE']),'M-d-Y h:i:s'); ?></td> -->
                                    <td><?php echo $all['TRANSACTION_DATE']; ?></td>
                                    <td><?php echo $all['KETERANGAN']; ?></td>
                                    <?php 
                                    // $jumlah = 1;  
                                    $lama = explode(':',$waktuku[$all['NAMA_SUBKON']]);
                                    $m = $lama[0];
                                    $s = $lama[1];
                                    $total = ($m*60)+$s;
                                    if (!isset($count_total[$all['NAMA_SUBKON']])) {
                                        $count_total[$all['NAMA_SUBKON']] = $total;
                                    }else{
                                        $count_total[$all['NAMA_SUBKON']] = $count_total[$all['NAMA_SUBKON']]+$total;
                                    }
                                    $rata = '';
                                    // if (isset($waktuku[$all['NAMA_SUBKON']])) {
                                    //     $jumlah++;
                                    // }else{
                                    //     $jumlah=1;
                                    // }
                                    $rata = $count_total[$all['NAMA_SUBKON']]/$count_sub[$all['NAMA_SUBKON']];
                                        $totalSemua[$all['NAMA_SUBKON']] = array('NAMA_SUBKONTRAKTOR' => $all['NAMA_SUBKON'],
                                        'RATA' => $rata,
                                        'TOTAL' => $count_total[$all['NAMA_SUBKON']],
                                        'JUMLAH' => $count_sub[$all['NAMA_SUBKON']]);   
                                    ?>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <table class="table text-center" style="width: 1700px;padding: 0">
                                <tr class="bg-default">
                                    <td width="1200px"></td>
                                    <td width="750px" style="text-align: left;"><b>TOTAL</b></td>
                                    <td width="75px"><?php echo $qty_minta; ?></td>
                                    <td width="75px"><?php echo $qty_kirim; ?></td>
                                    <td width="400px"></td>
                                    <!-- <td width="60px" class="rerata"></td> -->
                                    <!-- <td width="60px"><b><?php echo sprintf('%02d:%02d', (int) $lama, fmod($lama, 1) * 60); ?></b></td> -->
                                </tr>
                        </table>
                        <table class="table text-center" style="width: 1700px;padding: 0">
                        <?php 
                            $lamaAll = 0;
                            if (!$totalSemua){
                               $rataAll = 0;
                            }else{
                                foreach ($totalSemua as $key => $v) {
                                    $lamaAll = $v['RATA']+$lamaAll;
                                }
                                    $rataAll = $lamaAll/count($totalSemua);
                            }
                        ?>
                                <tr class="bg-default">
                                    <td width="1200px"></td>
                                    <td width="750px" style="text-align: left;"><b>RERATA</b></td>
                                    <td width="75px"></td>
                                    <td width="75px"></td>
                                    <!-- <td width="400px" class="rerata"><?php echo gmdate('i:s',$rataAll) ?></td> -->
                                    <td width="400px" class="rerata"><?php echo round($rataAll) ?></td>
                                    <!-- <td width="60px"><b><?php echo sprintf('%02d:%02d', (int) $lama, fmod($lama, 1) * 60); ?></b></td> -->
                                </tr>
                        </table>
                        <!-- <?php echo "<pre>";print_r($totalSemua);;
                        ?> -->
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php foreach($outpartAll as $all) {?>
<div class="modal fade" id="Modalku<?php echo $all['NO_SPBS']; ?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="box-header with border" id="formModalLabel">Ubah Data</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="<?=base_url('MonitoringBarangGudang/Pengeluaran/updateData/')?>" method="post">
                <div class="modal-body">
                    <input hidden name="spbs" id="spbs" value="<?= $all['NO_SPBS']?>"/>
                    <input hidden name="inv_id" id="inv_id" value="<?= $all['INVENTORY_ITEM_ID']?>"/>
                    <input hidden name="terimaDate" value="<?= $all['TGL_TERIMA']?>"/>
                    <div class="form-group">
                        <label for="kirimDate">Tanggal Kirim</label>
                        <input type="date" class="form-control" id="kirimDate" name="kirimDate" placeholder="<?php echo $all['TGL_KIRIM']; ?>">
                </div>
                    <div class="form-group">
                        <label for="nomorMobil">Nomor Mobil</label>
                    <!-- <input type="number" class="form-control" id="noMobil" placeholder="<?php echo $all['NO_MOBIL']; ?>">-->
                    <!-- <select class="form-control" id="sel1" name="noMobil">
                            <?php foreach ($NO_MOBIL as $key => $nm) { ?>
                                <option><?=$nm['NO_MOBIL']?></option>
                            <?php } ?>
                        </select> -->
                    <input type="text" class="form-control" id="sel1" name="noMobil">
                            <!-- <option></option>
                            <?php foreach ($NO_MOBIL as $key => $nm) { 
                                if ($nm['NO_MOBIL']==$all['NO_MOBIL']) {
                                    $selected = 'selected="selected"';
                                }else{
                                        $selected = '';
                                }
                                ?>
                                <option <?php echo $selected ?>>
                                    <?php echo $nm['NO_MOBIL'] ?>
                                </option>
                                    <?php } ?> -->
                        </select>
                        <!-- <option id="nomorMobil" name="nomorMobil" onchange="getNomorCar();"></option> -->
                        <!--input type="text" class="form-control" id="nomorMobil" name="nomorMobil" placeholder="<?php echo $all['NO_MOBIL']; ?>"-->
                    </div>

                    <div class="form-group">
                    <label for="qtyKirim">QTY Kirim</label>
                        <input class="form-control" type="number" name="qtyKirim" id="qtyKirim">
                    </div>
                    <div class="form-group">
                        <label for="jamMulai">Jam Mulai</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="jamMulaiMPBG" name="jamMulaiMPBG" type="text" class="form-control input-small jamMulaiMPBG">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jamMulai">Jam Selesai</label>
                        <div class="input-group bootstrap-timepicker timepicker">
                            <input id="jamAkhirMPBG" name="jamAkhirMPBG" type="text" class="form-control input-small jamAkhirMPBG">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-time"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                        <input class="form-control" type="text" name="keterangan" id="keterangan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="BtnSubmit" onclick="updateData(this)">Ubah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>