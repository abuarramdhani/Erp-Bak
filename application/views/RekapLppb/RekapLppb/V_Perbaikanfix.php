<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            // $('.datepickRekap1').datetimepicker({
            //     autoclose: true,
            //     todayHighlight: true,
            //     dateFormat: 'yy-mm-dd H:i:s',
            //     pickTime:true,
            //     pickSeconds: true,
            // });
            $('.datepickBulan').datepicker({
                format: 'M-yyyy',
                viewMode: "months",
                minViewMode: "months",
                autoClose: true
            });
            $('.tblRkapLppb').dataTable({
                "scrollX": true,
            });
            
         });
    </script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('RekapLppb/Perbaikan/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Perbaikan</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <div class="input-group input-group-sm">
                                        <input id="bln" name="bln" class="form-control pull-right datepickBulan" placeholder="<?= $bulan?>" >
                                        <span class="input-group-btn">
                                            <button type="button" onclick="schPerbaikan(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            <!-- <button type="submit" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>     -->
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="panel-body">
                                        <div class="table-responsive"  id="tb_LPPB">
                                        <table class="table table-striped table-bordered table-responsive table-hover text-left tblRkapLppb" style="font-size:14px;">
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
                                            foreach ($data as $key) { 
                                                if ($key['DELIVER_DATE'] != '') { ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $key['ITEM'] ?><input type="hidden" name="txtItem<?= $i ?>" value="<?= $key['ITEM'] ?>"></td>
                                                        <td><?= $key['DESCRIPTION'] ?><input type="hidden" name="txtDescription<?= $i ?>" value="<?= $key['DESCRIPTION'] ?>"></td>
                                                        <td><?= $key['PO'] ?><input type="hidden" name="txtPO<?= $i ?>" value="<?= $key['PO'] ?>"></td>
                                                        <td><?= $key['RECEIPT_NUM'] ?><input type="hidden" name="txtRecNum<?= $i ?>" value="<?= $key['RECEIPT_NUM'] ?>"></td>
                                                        <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateRecDate<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                                                        <td><?= $key['RECEIPT_DATE'] ?><input type="hidden" name="dateSudah<?= $i ?>" value="<?= $key['RECEIPT_DATE'] ?>"></td>
                                                        <td>
                                                            <input type="text" value="<?php if ($key['KIRIM_QC'] !== null){ echo $key['KIRIM_QC']; }?>" onchange="SaveKirimQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKirimQC<?= $i ?>" id="dateKirimQC<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                        </td>
                                                        <td>
                                                            <input value="<?php if ($key['TERIMA_QC'] !== null){ echo $key['TERIMA_QC']; }?>" onchange="SaveTerimaQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaQC<?= $i ?>" id="dateTerimaQC<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                        </td>
                                                        <td>
                                                            <input value="<?php if ($key['KEMBALI_QC'] !== null){ echo $key['KEMBALI_QC']; }?>" onchange="SaveKembaliQC(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKembaliQC<?= $i ?>" id="dateKembaliQC<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                        </td>
                                                        <td>
                                                            <input value="<?php if ($key['KIRIM_GUDANG'] !== null){ echo $key['KIRIM_GUDANG']; }?>" onchange="SaveKirimGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateKirimGudang<?= $i ?>" id="dateKirimGudang<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                        </td>
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
                                                                            <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo $key['TERIMA_GUDANG']; }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                                        </td>
                                                                    <?php }else{?>
                                                                        <td>
                                                                            <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo $key['TERIMA_GUDANG']; }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                                        </td>
                                                        <?php }
                                                            }else{ ?>
                                                        <td>
                                                            <input value="<?php if ($key['TERIMA_GUDANG'] !== null){ echo $key['TERIMA_GUDANG']; }?>" onchange="SaveTerimaGudang(<?=$i?>,'<?= $key['ITEM_ID'] ?>',<?= $key['RECEIPT_NUM'] ?>,<?= $key['PO'] ?>)" name="dateTerimaGudang<?= $i ?>" id="dateTerimaGudang<?= $i ?>" placeholder="dd/mm/yyyy hh:mm:ss"/>
                                                        </td>
                                                        <?php } ?>
                                                        <td>
                                                            <input type="hidden" name="dateDeliver<?= $i ?>" value="<?= $key['DELIVER_DATE'] ?>"><?= $key['DELIVER_DATE'] ?>
                                                        </td>
                                                    </tr>
                                                <?php $i++; }else { ?>
                                                    
                                                <?php  }
                                                 } 
                                            } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
