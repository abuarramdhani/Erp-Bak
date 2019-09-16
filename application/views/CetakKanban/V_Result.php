<div class="box box-solid">
    <div class="box-body">
        <!-- <form class="form-horizontal" id="formTerserah" method="post" action="<?= base_url('CetakKanban/Cetak/Report')?>" target="_blank" > -->
            <table id="myTable" class="datatable table table-striped table-responsive table-bordered table-hover" style="font-size: 13px; width: 100%">
                <thead class="bg-info">
                    <tr>
                     <th style="text-align: center; vertical-align: middle;" width="4%">NO</th>
                     <!-- <th><input type="checkbox" name="select-all" class="checkedAll" id="check-all"></th> -->
                     <th style="text-align: center; vertical-align: middle;">Action</th>
                     <th style="text-align: center; vertical-align: middle;">Kegunaan</th>
                     <th style="text-align: center; vertical-align: middle;">Nomor Job</th>
                     <th style="text-align: center; vertical-align: middle;">Kode</th>
                     <th style="text-align: center; vertical-align: middle;">Deskripsi</th>
                     <th style="text-align: center; vertical-align: middle;">Department Class</th>
                     <th style="text-align: center; vertical-align: middle;">QTY</th>
                     <th style="text-align: center; vertical-align: middle;">Sche Start Date</th>
                     <th style="text-align: center; vertical-align: middle;">Shift</th>
                 </tr>
             </thead>

             <tbody>
                <input type="hidden" name="selectedPick" value="">
                <?php $no=0; foreach ($value as $row) { $no++;?>

                <tr data="<?= $no; ?>">
                    <td><?= $no; ?></td>
                    <td class="chkCtk"><center><input type="checkbox" id="inicheck" name="check[]" data-row="<?= $no ?>" value="<?= $no; ?>" onclick="getRow(<?= $no?>)"></center></td>
                    <!-- <form method="post" action="<?= base_url('CetakKanban/Cetak/insertData')?>"> -->
                    <!-- <td><a href="http://produksi.quick.com/print_pdf_prod/print_kanban_prod_odm_v2.php?shift=<?= $row['SHIFT_NUM'] ?>&date=<?= $row['SCHEDULED_START_DATE'] ?>%2000:00:00&dept=<?php echo $row['DEPT_CLASS']  ?>&jobfrom=<?php echo $row['JOB_NUMBER'] ?>&jobto=<?php echo $row['JOB_NUMBER'] ?>&status=<?php echo $row['STATUS_TYPE'] ?>" target="_blank"><span class="btn btn-sm btn-primary" onclick="insertOracle(<?= $no?>)"><span class="fa fa-print"></span><b> print</b></span></a>
                    </td> -->
                    <td class="selectKegunaan">
                        <select type="text" id="selectBambank" name="kegunaan[]" data-row="<?= $no ?>" class="form-control kegunaan" style="width: 100%" disabled>
                            <option value="" disabled 
                            <?php if ($row['TUJUAN'] == NULL) {
                                echo "selected";
                            } ?>
                            >Pilih Kegunaan</option>
                            <option value="UNIT" 
                            <?php if ($row['TUJUAN'] == 'UNIT') {
                                echo "selected";
                            } ?>
                            >UNIT</option>
                            <option value="SPAREPART" 
                            <?php if ($row['TUJUAN'] == 'SPAREPART') {
                                echo "selected";
                            } ?>>SPAREPART</option>
                            <option value="PROTOTYPE" 
                            <?php if ($row['TUJUAN'] == 'PROTOTYPE') {
                                echo "selected";
                            } ?>>PROTOTYPE</option>
                        </select>
                        <input type="hidden" name="WIP_ENTITY_ID[]" class="WIP_ENTITY_ID" data-row="<?= $no ?>"  value="<?php echo $row['WIP_ENTITY_ID'] ?>"></input>
                    </td>
                    <!-- </form> -->
                    <td class="jobNumber"><input type="hidden" name="JOB_NUMBER[]" class="JOB_NUMBER" data-row="<?= $no ?>"  value="<?php echo $row['JOB_NUMBER'] ?>"><?= $row['JOB_NUMBER'] ?></td>
                    <td class="itemCode"><input type="hidden" name="ITEM_CODE[]" class="ITEM_CODE" data-row="<?= $no ?>" value="<?php echo $row['ITEM_CODE'] ?>"><?= $row['ITEM_CODE'] ?></td>
                    <td class="desc"><input type="hidden" name="DESCRIPTION[]" class="DESCRIPTION"  data-row="<?= $no ?>" value="<?php echo $row['DESCRIPTION'] ?>"><?= $row['DESCRIPTION'] ?></td>
                    <td class="deptClass"><input type="hidden" name="DEPT_CLASS[]" class="DEPT_CLASS" data-row="<?= $no ?>" value="<?php echo $row['DEPT_CLASS']  ?>"><?= $row['DEPT_CLASS'] ?></td>
                    <td class="targetPpic"><input type="hidden"  name="TARGET_PPIC[]" class="TARGET_PPIC" data-row="<?= $no ?>" value="<?php echo $row['TARGET_PPIC'] ?>"><?= $row['TARGET_PPIC'].' '.$row['UOM_CODE']?></td>
                    <td class="schDate"><input type="hidden"  name="SCHEDULED_START_DATE[]" class="SCHEDULED_START_DATE" data-row="<?= $no ?>" value="<?php echo $row['SCHEDULED_START_DATE'] ?>"><?= $row['SCHEDULED_START_DATE'] ?></td>
                    <td class="shift"><input type="hidden" name="SHIFT[]" class="SHIFT" data-row="<?= $no ?>" value="<?php echo $row['SHIFT_NUM'] ?>"><?= $row['SHIFT'] ?></td>

                    <input type="hidden" name="SCHEDULED_START_DATE[]" class="SCHEDULED_START_DATE" data-row="<?= $no ?>" value="<?php echo $row['SCHEDULED_START_DATE'] ?>">
                    <input type="hidden" name="NEED_BY[]" class="NEED_BY" data-row="<?= $no ?>" value="<?php echo $row['NEED_BY'] ?>">
                    <input type="hidden" name="TYPE_PRODUCT[]" class="TYPE_PRODUCT" data-row="<?= $no ?>" value="<?php echo $row['TYPE_PRODUCT'] ?>">
                    <input type="hidden" name="OPR_SEQ[]" class="OPR_SEQ" data-row="<?= $no ?>" value="<?php echo $row['OPR_SEQ'] ?>">
                    <input type="hidden"  name="OPERATION[]" class="OPERATION" data-row="<?= $no ?>"  value="<?php echo $row['OPERATION'] ?>">
                    <input type="hidden" name="ACTIVITY[]" class="ACTIVITY" data-row="<?= $no ?>" value="<?php echo $row['ACTIVITY'] ?>">
                    <input type="hidden" name="QR_CODE[]" class="QR_CODE" data-row="<?= $no ?>" value="<?php echo $row['QR_CODE'] ?>">
                    <input type="hidden"  name="UOM_CODE[]" class="UOM_CODE" data-row="<?= $no ?>" value="<?php echo $row['UOM_CODE'] ?>">
                    <input type="hidden" name="ROUTING_CLASS_DESC[]" class="ROUTING_CLASS_DESC" data-row="<?= $no ?>" value="<?php echo $row['ROUTING_CLASS_DESC'] ?>">
                    <input type="hidden" name="UNIT_VOLUME[]" class="UNIT_VOLUME" data-row="<?= $no ?>" value="<?php echo $row['UNIT_VOLUME'] ?>">
                    <input type="hidden" name="KODE_PROSES[]" class="KODE_PROSES"  data-row="<?= $no ?>" value="<?php echo $row['KODE_PROSES'] ?>">
                    <input type="hidden" name="TUJUAN[]" class="TUJUAN" data-row="<?= $no ?>" value="<?php echo $row['TUJUAN'] ?>">
                    <!-- <input type="hidden"  name="RESOURCES[]" class="RESOURCES" data-row="<?= $no ?>" value="<?php echo $row['RESOURCES'] ?>"> -->
                    <!-- <input type="hidden" name="PREVIOUS_OPERATION[]" class="PREVIOUS_OPERATION" data-row="<?= $no ?>"  value="<?php echo $row['PREVIOUS_OPERATION'] ?>"> -->
                    <!-- <input type="hidden" name="PREVIOUS_DEPT_CLASS[]" class="PREVIOUS_DEPT_CLASS" data-row="<?= $no ?>" value="<?php echo $row['PREVIOUS_DEPT_CLASS'] ?>"> -->
                    <!-- <input type="hidden"  name="STATUS_TYPE[]" class="STATUS_TYPE" data-row="<?= $no ?>"  value="<?php echo $row['STATUS_TYPE'] ?>"> -->
                    <!-- <input type="hidden"  name="NEXT_OPERATION[]" class="NEXT_OPERATION" data-row="<?= $no ?>"  value="<?php echo $row['NEXT_OPERATION'] ?>"> -->
                    <!-- <input type="hidden"  name="NEXT_DEPT_CLASS[]" class="NEXT_DEPT_CLASS" data-row="<?= $no ?>" value="<?php echo $row['NEXT_DEPT_CLASS'] ?>"> -->
                    <!-- <input type="hidden"  name="TARGETJS[]" class="TARGETJS" data-row="<?= $no ?>" value="<?php echo $row['TARGETJS'] ?>"> -->
                    <!-- <input type="hidden"  name="TARGETSK[]" class="TARGETSK" data-row="<?= $no ?>" value="<?php echo $row['TARGETSK'] ?>"> -->
                    <!-- <input type="hidden" name="STATUS_STEP[]" class="STATUS_STEP" data-row="<?= $no ?>" value="<?php echo $row['STATUS_STEP'] ?>"> -->
                    <!-- <input type="hidden" name="JML_OP[]" class="JML_OP" data-row="<?= $no ?>" value="<?php echo $row['JML_OP'] ?>"> -->
                    <!-- <input type="hidden" name="NO_MESIN[]" class="NO_MESIN" data-row="<?= $no ?>" value="<?php echo $row['NO_MESIN'] ?>"> -->

                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="row text-center" style="padding-right: 10px">
         <button type="button" title="cetak kanban" id="cetak" class="btn btn-danger btncetak" disabled="disabled" onclick="insertReport()"><i class="fa fa-print"></i><b> print</b><b id="jmlChk"></button>
     </div>
</div>
<!-- <div style="display: none;">
    <form id="formInsert" method="post" action="<?= base_url('CetakKanban/Cetak/insertOracle')?>">

    </form>
</div> -->

<div class="toSend" style="display: none;">
    <form id="formTerserah" method="post" action="<?= base_url('CetakKanban/Cetak/Report')?>" target="_blank">

    </form>
</div>

</div>
<script type="text/javascript">
//     $('.chkCtk').click(function () {
//     //check if checkbox is checked
//     if ($(this).is(':checked')) {

//         $('#cetak').removeAttr('disabled'); //enable input

//     } else {
//         $('#cetak').attr('disabled', true); //disable input
//     }
// });

//     $('#check-all').click(function(event) {
//         if(this.checked) {
//                     // Iterate each checkbox
//                     $('.chkCtk').each(function() {
//                         this.checked = true;
//                         $('#cetak').removeAttr('disabled'); //enable input
//                     });
//                 } else {
//                     $('.chkCtk').each(function() {
//                         this.checked = false;
//                         $('#cetak').attr('disabled', true); //disable input
//                     });
//                 }
//             });

    // tambahan coba cetak yg dicek

    $('.chkCtk').on('click',function(){
            var a = 0;
            var jml = 0;
            var val = '';
            $('input[name="check[]"]').each(function(){
                if ($(this).is(":checked") === true ) {
                    a = 1;
                    jml +=1;
                    val += $(this).val();
                    // document.getElementById("selectBambank").removeAttr("disabled");
                // $('#selectBambank').removeAttr("disabled");

                }
            });
            if (a == 0) {
                $('#cetak').attr("disabled","disabled");
                // $('#selectBambank').attr("disabled","disabled");
                $('#jmlChk').text('');
            }else{
                $('#cetak').removeAttr("disabled");
                // $('#selectBambank').removeAttr("disabled");
                $('#jmlChk').text('('+jml+')');
                // $('input[name="selectedPick"]').val(val);
            }
        });
        $('.checkedAll').on('click', function(){
            var check = 0;
            var a = 0;
            var jml = 0;
            var val = '';
            if ($(this).is(":checked")) {
                check = 1;
            }else{
                check = 0;
            }
            $('input[name="check[]"]').each(function(){
                if (check == 1) {
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false);
                }
            });
            $('input[name="check[]"]').each(function(){
                if ($(this).is(":checked") === true ) {
                    a = 1;
                    jml +=1;
                    val += $(this).val();
                }
            });
            if (a == 0) {
                $('#cetak').attr("disabled","disabled");
                // $('#selectBambank').attr("disabled","disabled");
                $('#jmlChk').text('');
            }else{
                $('#cetak').removeAttr("disabled");
                // $('#selectBambank').removeAttr("disabled");
                $('#jmlChk').text('('+jml+')');
                // $('input[name="selectedPick"]').val(val);
            }
        });

</script>
