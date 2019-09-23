<div class="box box-solid">
    <div class="box-body">
        <form class="form-horizontal" id="formSemua" method="post" action="<?= base_url('CetakKanban/Cetak/Report')?>" target="_blank" >
            <table id="myTable" class="datatable table table-striped table-responsive table-bordered table-hover" style="font-size: 13px; width: 100%">
                <thead class="bg-info">
                    <tr>
                       <th style="text-align: center; vertical-align: middle;" width="4%">NO</th>
                       <th><input type="checkbox" name="select-all" class="checkedAll" id="check-all"></th>
                       <th style="text-align: center; vertical-align: middle;">Nomor Job</th>
                       <th style="text-align: center; vertical-align: middle;">Kode</th>
                       <th style="text-align: center; vertical-align: middle;">Deskripsi</th>
                       <th style="text-align: center; vertical-align: middle;">Department Class</th>
                       <th style="text-align: center; vertical-align: middle;">QTY</th>
                       <th style="text-align: center; vertical-align: middle;">Sche Start Date</th>
                       <th style="text-align: center; vertical-align: middle;">Shift</th>
                       <th style="text-align: center; vertical-align: middle;">Location Code</th> <!---- Penambahan kolom location code --->
                       <th style="text-align: center; vertical-align: middle;">Kegunaan</th>
                       <th style="text-align: center; vertical-align: middle;">Due Date</th>
                   </tr>
               </thead>

               <tbody>
                <input type="hidden" name="selectedPick" value="">
                <?php $no=0; foreach ($value as $row) { $no++;?>

                <tr data="<?= $no; ?>">
                    <td><?= $no; ?></td>
                    <td class="chkCtk"><center><input type="checkbox" id="inicheck" name="check[]" data-row="<?= $no ?>" value="<?= $no; ?>" onclick="getRow(<?= $no?>)"></center></td>
                <td class="jobNumber"><input type="hidden" name="JOB_NUMBER[]" class="JOB_NUMBER" data-row="<?= $no ?>"  value="<?php echo $row['JOB_NUMBER'] ?>"><?= $row['JOB_NUMBER'] ?></td>
                <td class="itemCode"><input type="hidden" name="ITEM_CODE[]" class="ITEM_CODE" data-row="<?= $no ?>" value="<?php echo $row['ITEM_CODE'] ?>"><?= $row['ITEM_CODE'] ?></td>
                <td class="desc"><input type="hidden" name="DESCRIPTION[]" class="DESCRIPTION"  data-row="<?= $no ?>" value="<?php echo $row['DESCRIPTION'] ?>"><?= $row['DESCRIPTION'] ?></td>
                <td class="deptClass"><input type="hidden" name="DEPT_CLASS[]" class="DEPT_CLASS" data-row="<?= $no ?>" value="<?php echo $row['DEPT_CLASS']  ?>"><?= $row['DEPT_CLASS'] ?></td>
                <td class="targetPpic"><input type="hidden"  name="TARGET_PPIC[]" class="TARGET_PPIC" data-row="<?= $no ?>" value="<?php echo $row['TARGET_PPIC'] ?>"><?= $row['TARGET_PPIC'].' '.$row['UOM_CODE']?></td>
                <td class="schDate"><input type="hidden"  name="SCHEDULED_START_DATE[]" class="SCHEDULED_START_DATE" data-row="<?= $no ?>" value="<?php echo $row['SCHEDULED_START_DATE'] ?>"><?= $row['SCHEDULED_START_DATE'] ?></td>
                <td class="shift"><input type="hidden" name="SHIFT[]" class="SHIFT" data-row="<?= $no ?>" value="<?php echo $row['SHIFT_NUM'] ?>"><?= $row['SHIFT'] ?></td>
                <td class="location_code"><?= $row['LOCATION_CODE'] ?></td> <!---- Penambahan kolom location code --->
                <td class="selectKegunaan">
                    <select type="text" id="selectBambank" name="tujuanbaru[]" data-row="<?= $no ?>" class="form-control kegunaan" style="width: 100%" disabled>
                        <option value=""  
                        <?php if ($row['TUJUAN'] == '') {
                            echo "selected";
                        } ?>
                        ></option>
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
                    <input type="hidden" autocomplete="off" name="wipidbaru[]" class="WIP_ENTITY_ID" data-row="<?= $no ?>"  value="<?php echo $row['WIP_ENTITY_ID'] ?>"></input>
                </td>
                <td class="inputDuedate">
                 <div class='input-group date'>
                    <input type="text" name="due_date[]" class="form-control due_date" data-row="<?= $no ?>" value="<?php echo $row['DUE_DATE'] ?>" style="text-align: center; width: 100%" disabled/>
                    <span class="input-group-addon">
                        <span class="fa fa-calendar"></span>
                    </span>
                </div>
            </td>

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
   <button type="button" title="cetak kanban" id="cetak" class="btn btn-danger btncetak" disabled="disabled" onclick="insertReport()"><i class="fa fa-print"></i><b> print</b><b id="jmlChk"></b></button>
</div>
</form>
</div>

<div class="toSend" style="display: none;">
    <form id="formTerserah" method="post" action="<?= base_url('CetakKanban/Cetak/Report')?>" target="_blank">

    </form>
</div>

</div>
<script type="text/javascript">
    $('.due_date').datetimepicker({
        format: 'Y/m/d H:i:s',
        step: 5,
        autoclose: true,
        todayHighlight: true,
        todayBtn: true,
        allowClear: true,
        pickTime: true, 
        pickSeconds: true,
    });

    $('.chkCtk').on('click',function(){
        var a = 0;
        var jml = 0;
        var val = '';
        $('input[name="check[]"]').each(function(){
            if ($(this).is(":checked") === true ) {
                a = 1;
                jml +=1;
                val += $(this).val();
            }
        });
        if (a == 0) {
            $('#cetak').attr("disabled","disabled");
            $('#jmlChk').text('');
        }else{
            $('#cetak').removeAttr("disabled");
            $('#jmlChk').text('('+jml+')');
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
            $('.kegunaan').attr("disabled","disabled");
            $('.due_date').attr("disabled","disabled");
            $('#jmlChk').text('');
        }else{
            $('#cetak').removeAttr("disabled");
            $('.kegunaan').removeAttr("disabled");
            $('.due_date').removeAttr("disabled");
            $('#jmlChk').text('('+jml+')');
        }
    });

</script>
