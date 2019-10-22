<style type="text/css">
	.color1{ 
		background-color: #a4c0e0;
	}

    .color2{
		background-color: #d0e0f2;
	} 
    .color3{
		background-color: #e9eff5;
	} 
    .color4{
		background-color: #ddf0e3;
	}
    .color5{
		background-color: #aed4ba;
	}
    .color6{
		background-color: #bcd1e8;
        border: 1px black;
	}
    .color6:hover{
		background-color: #c3d6eb;
	}
	.hh {
		text-align: right;
	}

	/* textarea.form-control{
		border-radius: 10px;
	} */
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	/* .select2-selection{
		border-radius: 20px !important;
	} */

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	/* input.select2-search__field{
		border-radius: 20px !important;
	} */

	/* span.select2-dropdown{
		border-radius: 20px !important;
	} */

	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	/* .btn {
		border-radius: 20px !important;
	} */
	
</style>



<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center" id="myTable" style="width: 100%; table-layout:fixed;">
            <thead class="bg-primary">
                <tr class="text-center">
                    <th width="4%">No</th>
                    <th>No PO</th>
                    <th>No SJ</th>
                    <th>Buyer</th>
                    <th>Pertanggal</th>
                    <th width="20%">Item</th>
                    <th width="8%">Qty PO</th>
                    <th>Diterima</th>
                    <th width="10%">Status</th>
                    <th width="10%">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $q=0; $no=1;foreach ($value as $row) {
                    // echo"<pre>";
                    // print_r($value);
                    // exit; 
                    ?>
                <tr id="addRow<?=$no?>">
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $row['header']['NO_PO'] ?></td>
                    <td><?= $row['header']['NO_SJ'] ?></td>
                    <td><?= $row['header']['BUYER'] ?></td>
                    <!-- <td><?= $row['header']['TANGGAL_DATANG'] ?> <?= $row['header']['WAKTU_DATANG'] ?></td> -->
                    <td><?php date_default_timezone_set('Asia/Jakarta');
                            $date = date('d-M-Y h:i', time());
                            echo $date;?> 
                    </td>
                    <td><?= $row['header']['ITEM_DESCRIPTION'] ?></td>
                    <td><?= $row['header']['PESANAN'] ?></td>
                    <td><?= $row['header']['DITERIMA'] ?></td>
                    <td><?= strtoupper($row['header']['STATUS']) ?></td>
                    <td><button type="button" class="btn color6" onclick="btnRowAdd(<?=$no?>)"><i class="fa fa-info"></i></button></td>
                </tr>
                <?php $status1 = strtoupper($row['header']['STATUS']);
                if ( $status1 == 'CONFIRMITY'){?>
                    <tr class="clone<?=$no?>" style="display:none">
                    <td></td>
                    <td colspan="9">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center" id="" style="width: 100%; table-layout:fixed;">
                                <thead class="bg-danger">
                                    <tr class="text-center">
                                        <th>Menunggu Pembelian</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </td>
                </tr>
                <?php }else if(empty($row['body'])){?>
                    <tr class="clone<?=$no?>" style="display:none">
                    <td></td>
                    <td colspan="9">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center" id="" style="width: 100%; table-layout:fixed;">
                                <thead class="bg-warning">
                                    <tr class="text-center">
                                        <th>Belum Diproses</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </td>
                </tr>
                <?php } else{?>
                    
                <tr class="clone<?=$no?>" style="display:none">
                    <td></td>
                    <td colspan="9">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center" id="" style="width: 100%; table-layout:fixed;">
                                <thead>
                                    <tr class="color2 text-center">
                                        <th width="4%">No</th>
                                        <th>Status</th>
                                        <th>Item</th>
                                        <th width="20%">Description</th>
                                        <th>Date</th>
                                        <th width="9%">Qty</th>
                                        <th>Qty Receipt</th>
                                        <!-- <th width="10%">Sub-inv</th> -->
                                        <th>Receipt</th>
                                        <!-- <th width="8%">Detail</th> -->
                                    </tr>
                                </thead>
                                <tbody class="color3"><?php
                                        $hitung = $row['body'];
                                        $r=0;$no2=1;
                                        // echo"<pre>";
                                        // print_r($hitung);
                                        // exit; 

                                        for ($n=0; $n <count($hitung) ; $n++) { 
                                            $apa[$n] = $hitung[$n]['QTY'];
                                        }
                                        $total = array_sum($apa);
                                        $kekurangan = $row['header']['DITERIMA'] - $total;
                                        $itm = $row['header']['ITEM_DESCRIPTION'];
                                        // echo"<pre>";
                                        // print_r($kekurangan);
                                        // exit; 

                                        foreach ($hitung as $key) {   
                                        ?>
                                    <tr id="addRow2<?=$no2?>">
                                        <td width="3%"><?= $no2; ?></td>
                                        <td> <?php
                                        $status = $key['TRANSACTION_TYPE'];
                                        switch ($status) {
                                            case "RECEIVE":
                                                echo '<span class="label label-success">'; break;
                                            case "TRANSFER":
                                                echo '<span class="label label-info">'; break;
                                            case "ACCEPT":
                                                echo '<span class="label label-success">'; break;
                                            case "REJECT":
                                                echo '<span class="label label-warning">'; break;
                                            case "RETURN TO VENDOR":
                                                echo '<span class="label label-danger">'; break;
                                            case "DELIVER":
                                                echo '<span class="label label-primary">'; break;
                                            default:
                                                echo '<span class="label label-default">';
                                        }
                                        ?><?= $key['TRANSACTION_TYPE'] ?></span></td>
                                        <td><?= $key['ITEM'] ?></td>
                                        <td><?= $key['DESKRIPSI'] ?></td>
                                        <td><?= $key['TGL'] ?></td>
                                        <td><?= $key['QTY'] ?></td>
                                        <td><?= $key['RECEIVED'] ?></td>
                                        <td><?= $key['RECEIPT'] ?></td>
                                        <!-- <td><?= $key['LOKASI'] ?></td> -->
                                        <!-- <td><button type="button" class="btn btn-success btn-sm" onclick="btnRowAdd2(<?=$no?>,<?=$no2?>)"><i class="fa fa-info"></i></button></td> -->
                                    </tr>
                                    <!-- <?php 
                                    $proses = $row['body'][$r]['proses'];
                                    if (empty($proses)) {?>
                                        <tr class="clone2<?=$no?><?=$no2?>" style="display : none">
                                            <td></td>
                                            <td colspan="9">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover text-center" id="" style="width: 100%; table-layout:fixed;">
                                                        <thead class="color5">
                                                            <tr class="text-center">
                                                                <th>Item Belum Diproses</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {?>
                                         <tr class="clone2<?=$no?><?=$no2?>" style="display : none">
                                            <td></td>
                                            <td colspan="9">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover text-center" id="" style="width: 100%; table-layout:fixed;">
                                                        <thead class="color5">
                                                            <tr class="text-center">
                                                                <th>Receipt Num</th>
                                                                <th>Transaction type</th>
                                                                <th>Receipt Date</th>
                                                                <th>PO</th>
                                                                <th>Transaction Date</th>
                                                                <th>Qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="color4"><?php
                                                            $bd = $row['body'][$r]['proses'];
                                                            $s=0;$no3=1;
                                                            foreach ($bd as $lock) {   
                                                            ?>
                                                            <tr class="color4" id="addRow2<?=$no?><?=$no2?><?=$no3?>">
                                                                <td><?= $lock['RECEIPT'] ?></td>
                                                                <td><?= $lock['TRANSACTION_TYPE'] ?></td>
                                                                <td><?= $lock['TGL'] ?></td>
                                                                <td><?= $lock['PO'] ?></td>
                                                                <td><?= $lock['TGL'] ?></td>
                                                                <td><?= $lock['QTY'] ?></td>
                                                            </tr>
                                                        <?php $s++; $no3++; }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr> -->
                                        <!-- <?php
                                    }
                                     ?> -->
                                   <?php $r++; $no2++; }?>

                                   <?php if ($total < $row['header']['DITERIMA'] ) {?>
                                        <tr id="addRow2<?=$no2?>">
                                            <td colspan="9"> <b> <?php echo $itm;?> sejumlah <?php echo $kekurangan;?> belum diproses</b> </td>
                                        </tr>
                                    <?php }else{
                                        // echo $row['header']['DITERIMA'];
                                        // echo $total;
                                    }?>

                                </tbody>
                            </table>
                        </div>
                    </td>
                                </tr><?php } ?>
                <?php $q++;$no++;} ?>
            </tbody>
        </table>
    </div>
</div>