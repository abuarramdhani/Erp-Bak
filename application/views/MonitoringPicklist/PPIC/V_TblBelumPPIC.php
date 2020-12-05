<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
            $(document).ready(function () {
            $('.tbpickl').dataTable({
                "scrollX": true,
            });
            $('.tbpickl2').dataTable({
                "scrollX": true,
                "scrollY": 500,
                "paging":false
            });
        });
    </script>
<?php $class = count($data) < 11 ? 'tbpickl' : 'tbpickl2';?>
<div>
<h2 style="text-align:center">Picklist Belum Deliver</h2>
<table class="datatable table table-bordered table-hover table-striped <?= $class ?> text-center" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th style="width:5%" class="text-center check_semua">
                <span class='btn check_semua' style="background-color:inherit" id='check_semua' onclick="ceksemua()"><i id="cekall" class="fa fa-square-o"></i></span>
                <input type="hidden" id="tandacekall" value="cek">
            </th>
            <th>Department</th>
            <th>No Job</th>
            <th>Picklist</th>
            <th>Item Assy</th>
            <th>QTY</th>
            <th>From Subinv</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; $x = 0; foreach ($data as $val) {
    if ($val['DELIVER'] == '') {
        $del = $val['DELIVER'] != '' ? 'disabled' : '';    
        $cek = $val['DELIVER'] == '' ? 'onclick="inicek('.$no.')"' : '';  
        $btn = $val['DELIVER'] == '' ? 'aktif' : '';
        if ($val['DELIVER'] == '') { $x++; }
    ?>
        <tr>
            <td><input type="hidden" id="baris" class="baris" value="<?= $x?>"><?= $no?></td>
            <td><span class="btn check_semua" style="background-color:inherit" id="cek<?= $no?>" <?= $cek?> <?= $del?>><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka<?= $del?>"></i></span>
                <input type="hidden" class="tandasemua<?= $del?>" id="tandacek<?= $no?>" value="cek"></td>
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" class="nojob<?= $del?>" id="nojob<?= $no?>" value="<?= $val['JOB_NO']?>"><?= $val['JOB_NO']?></td>
            <td class="text-nowrap"><input type="hidden" class="picklist<?= $del?>" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td style="text-align:left"><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC']?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><button type="button" class="btn btn-success <?= $btn?>" id="btnapp<?= $no?>" onclick="approvePPIC(<?= $no?>)" <?= $del?>>Approve</button></td>
        </tr>
    <?php $no++;  }
    }?>
    </tbody>
</table>
</div>
<br>
<div class="col-md-12 text-right">
    <input type="button" class="btn btn-warning" id="appsemua" disabled="disabled" onclick="approvePPIC2()" value="Approve Selected (0)">
</div>

<br><br><br>
<div>
<h2 style="text-align:center">Picklist Sudah Deliver</h2>
<table class="datatable table table-bordered table-hover table-striped <?= $class ?> text-center" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <!-- <th style="width:5%" class="text-center check_semua">
                <span class='btn check_semua' style="background-color:inherit" id='check_semua' onclick="ceksemua()"><i id="cekall" class="fa fa-square-o"></i></span>
                <input type="hidden" id="tandacekall" value="cek">
            </th> -->
            <th>Department</th>
            <th>No Job</th>
            <th>Picklist</th>
            <th>Item Assy</th>
            <th>QTY</th>
            <th>From Subinv</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $no2 = 1; foreach ($data as $val) {
    if ($val['DELIVER'] != '') {
        $del = $val['DELIVER'] != '' ? 'disabled' : '';    
        $cek = $val['DELIVER'] == '' ? 'onclick="inicek('.$no.')"' : '';  
        $btn = $val['DELIVER'] == '' ? 'aktif' : '';
        if ($val['DELIVER'] == '') { $x++; }
    ?>
        <tr>
            <td><input type="hidden" id="baris" class="baris" value="<?= $x?>"><?= $no2?></td>
            <!-- <td><span class="btn check_semua" style="background-color:inherit" id="cek<?= $no?>" <?= $cek?> <?= $del?>><i id="ceka<?= $no?>" class="fa fa-square-o bisacek ceka<?= $del?>"></i></span>
                <input type="hidden" class="tandasemua<?= $del?>" id="tandacek<?= $no?>" value="cek"></td> -->
            <td><input type="hidden" id="dept<?= $no?>" value="<?= $val['DEPARTMENT']?>"><?= $val['DEPARTMENT']?></td>
            <td><input type="hidden" class="nojob<?= $del?>" id="nojob<?= $no?>" value="<?= $val['JOB_NO']?>"><?= $val['JOB_NO']?></td>
            <td class="text-nowrap"><input type="hidden" class="picklist<?= $del?>" id="picklist<?= $no?>" value="<?= $val['PICKLIST']?>"><?= $val['PICKLIST']?></td>
            <td style="text-align:left"><input type="hidden" id="item<?= $no?>" value="<?= $val['PRODUK']?>"><?= $val['PRODUK']?> - <?= $val['PRODUK_DESC']?></td>
            <td><input type="hidden" id="qty<?= $no?>" value="<?= $val['START_QUANTITY']?>"><?= $val['START_QUANTITY']?></td>
            <td><input type="hidden" id="from<?= $no?>" value="<?= $val['FROM_SUBINV']?>"><?= $val['FROM_SUBINV']?></td>
            <td><button type="button" class="btn btn-success <?= $btn?>" id="btnapp<?= $no?>" onclick="approvePPIC(<?= $no?>)" <?= $del?>>Approve</button></td>
        </tr>
    <?php $no++; $no2++; }
    }?>
    </tbody>
</table>
</div>