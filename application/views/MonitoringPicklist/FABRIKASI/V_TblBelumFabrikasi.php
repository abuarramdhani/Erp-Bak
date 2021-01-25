<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('.tbpickl').dataTable({
                "scrollX": true,
            });
            $('.tbpickl2').dataTable({
                "scrollX": false,
                "scrollY": 500,
                "paging":false
            });
            var refreshId = setInterval(function()
            {
                $("#notiffabrks").load(notiffabrikasi());
            }, 60000);
        });
    </script>
<form method="post" target="_blank" action="<?php echo base_url('MonitoringPicklistFabrikasi/BelumApprove/cetaksemua')?>">
<?php $class = count($data) < 11 ? 'tbpickl' : 'tbpickl2';?>
<div>
<h2 style="text-align:center">Picklist Belum Deliver</h2>
<table class="datatable table table-bordered table-hover table-striped <?= $class?> text-center" style="width: 100%;table-layout:fixed">
    <thead class="bg-primary">
        <tr>
            <th style="width: 5%">No</th>
            <th style="width:5%" class="text-center check_semua">
                <span class='btn check_semua' style="background-color:inherit" id='check_semua' onclick="ceksemua()"><i id="cekall" class="fa fa-square-o"></i></span>
                <input type="hidden" id="tandacekall" value="cek">
            </th>
            <th style="width: 10%">Department</th>
            <th style="width: 8%">No Job</th>
            <th style="width: 8%">Release Job</th>
            <th style="width: 8%">Date Job</th>
            <th style="width: 10%">Picklist</th>
            <th>Item Assy</th>
            <th style="width: 5%">QTY</th>
            <th style="width: 10%">From Subinv</th>
            <th style="width: 15%">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; $i= 1; $x = 0;foreach ($data as $val) { 
    if ($val['DELIVER'] == '') {
        $del = $val['DELIVER'] != '' ? 'disabled' : ''; 
        $cek = $val['DELIVER'] == '' ? 'onclick="inicek('.$no.')"' : '';
        $btn = $val['DELIVER'] == '' ? 'aktif' : '';
        $ctk = $val['DELIVER'] == '' ? 'bisaprint' : '';
        // if ($val['DELIVER'] == '') {  }
        $x++;
        ?>
        <tr>
            <td><input type="hidden" id="jmli" class="jmli" value="<?= $i?>">
                <input type="hidden" id="baris" class="baris" value="<?= $x?>"><?= $no?></td>
            <td><span class="btn check_semua2" style="background-color:inherit" id="cek<?= $no?>" <?= $cek?> <?= $del?>><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka<?= $del?>"></i></span>
                <input type="hidden" class="tandasemua<?= $del?>" name="tandacek[]" id="tandacek<?= $no?>" value="cek">
                <input type="hidden" class="printsemua" name="printsemua[]" id="printcek<?= $no?>" value="cek"></td>
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" class="nojob<?= $del?>" id="nojob<?= $no?>" value="<?= $val['JOB_NO'] ?>"><?= $val['JOB_NO'] ?></td>
            <td><input type="hidden" id="release<?= $no?>" value="<?= $val['REALASE_PPIC']?>"><?= $val['REALASE_PPIC']?></td>
            <td><input type="hidden" id="date<?= $no?>" value="<?= $val['DATE_JOB']?>"><?= $val['DATE_JOB']?></td>
            <td><input type="hidden" class="picklist<?= $del?>" name="picklist[]" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td style="text-align:left"><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC']?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" name="subinv[]" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><button type="button" class="btn btn-success <?= $btn?>" id="btnapp<?= $no?>" onclick="modalapproveFab(<?= $no?>)" <?= $del?>>Approve</button>
            <button formaction="<?php echo base_url('MonitoringPicklistFabrikasi/BelumApprove/printBelumFabrikasi/'.$val['PICKLIST'].'_'.$val['FROM_SUBINV'].''); ?>" id="iniprint<?= $no?>" class="btn btn-danger <?= $ctk?>" disabled>Print</button></td>
        </tr>
    <?php $no++; }
    }?>
    </tbody>
</table>
</div>
<br>
<div class="col-md-12 text-right">
    <input type="button" class="btn btn-warning" id="appsemua" disabled="disabled" style="width: 150px" onclick="modalapproveFab(0)" value="Approve Selected (0)">
    <input type="submit" class="btn btn-danger" id="ctksemua" disabled="disabled" style="width: 150px" value="Print Selected (0)">
</div>
<form>

<br><br><br>
<div>
<h2 style="text-align:center">Picklist Sudah Deliver</h2>
<table class="datatable table table-bordered table-hover table-striped <?= $class?> text-center" style="width: 100%;table-layout:fixed">
    <thead class="bg-primary">
        <tr>
            <th style="width: 5%">No</th>
            <!-- <th style="width:5%" class="text-center check_semua">
                <span class='btn check_semua' style="background-color:inherit" id='check_semua' onclick="ceksemua()"><i id="cekall" class="fa fa-square-o"></i></span>
                <input type="hidden" id="tandacekall" value="cek">
            </th> -->
            <th style="width: 10%">Department</th>
            <th style="width: 8%">No Job</th>
            <th style="width: 8%">Release Job</th>
            <th style="width: 8%">Date Job</th>
            <th style="width: 10%">Picklist</th>
            <th>Item Assy</th>
            <th style="width: 5%">QTY</th>
            <th style="width: 10%">From Subinv</th>
            <th style="width: 15%">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no2 = 1; foreach ($data as $val) { 
    if ($val['DELIVER'] != '') {
        $del = $val['DELIVER'] != '' ? 'disabled' : ''; 
        $cek = $val['DELIVER'] == '' ? 'onclick="inicek('.$no.')"' : '';
        $btn = $val['DELIVER'] == '' ? 'aktif' : '';
        $ctk = $val['DELIVER'] == '' ? 'bisaprint' : '';
        // if ($val['DELIVER'] == '') {  }
        $x++;
        ?>
        <tr>
            <td><input type="hidden" id="jmli" class="jmli" value="<?= $i?>">
                <input type="hidden" id="baris" class="baris" value="<?= $x?>"><?= $no2?></td>
            <!-- <td><span class="btn check_semua2" style="background-color:inherit" id="cek<?= $no?>" <?= $cek?> <?= $del?>><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka<?= $del?>"></i></span>
                <input type="hidden" class="tandasemua<?= $del?>" name="tandacek[]" id="tandacek<?= $no?>" value="cek">
                <input type="hidden" class="printsemua" name="printsemua[]" id="printcek<?= $no?>" value="cek"></td> -->
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" class="nojob<?= $del?>" id="nojob<?= $no?>" value="<?= $val['JOB_NO'] ?>"><?= $val['JOB_NO'] ?></td>
            <td><input type="hidden" id="release<?= $no?>" value="<?= $val['REALASE_PPIC']?>"><?= $val['REALASE_PPIC']?></td>
            <td><input type="hidden" id="date<?= $no?>" value="<?= $val['DATE_JOB']?>"><?= $val['DATE_JOB']?></td>
            <td><input type="hidden" class="picklist<?= $del?>" name="picklist[]" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td style="text-align:left"><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC']?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><button type="button" class="btn btn-success <?= $btn?>" id="btnapp<?= $no?>" onclick="modalapproveFab(<?= $no?>)" <?= $del?>>Approve</button>
            <button formaction="<?php echo base_url('MonitoringPicklistFabrikasi/BelumApprove/printBelumFabrikasi/'.$val['PICKLIST'].''); ?>" id="iniprint<?= $no?>" class="btn btn-danger <?= $ctk?>" disabled>Print</button></td>
        </tr>
    <?php $no++; $no2++; }
    }?>
    </tbody>
</table>
</div>

