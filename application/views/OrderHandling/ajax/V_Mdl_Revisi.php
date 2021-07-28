<form method="post" enctype="multipart/form-data" action="<?php echo base_url("OrderHandling/StatusOrder/save_revisi_order")?>">
<?php foreach ($data as $key => $value) { ?>
    <div class="panel-body">
        <div class="col-md-3 text-right"><label>Alasan Revisi :</label></div>
        <div class="col-md-9">
            <textarea style="width:100%" disabled><?= $value['reject_reason']?></textarea>
            <input type="hidden" id="id_order" name="id_order" value="<?= $value['order_number']?>">
        </div>
    </div>
    <div class="panel-body" >
        <div class="col-md-3 text-right"><label>Jenis order :</label></div>
        <div class="col-md-9">
            <!-- <input class="form-control" value="<?= $value['order_type_name']?>" readonly> -->
            <select id="jenis_order_handling" name="jenis_order" class="form-control oth_select2" style="width:100%">
                <option value="<?= $value['order_type']?>"><?= $value['order_type_name']?></option>
                <option value="1">Pembuatan Sarana Handling</option>
                <option value="2">Repair Sarana Handling</option>
                <option value="3">Perusakan Komponen Reject</option>
            </select>
        </div>
    </div>
    <div class="panel-body" >
        <div class="col-md-3 text-right"><label>Jenis sarana handling :</label></div>
        <div class="col-md-9">
            <!-- <input class="form-control" value="<?= $value['handling_type_name']?>" readonly> -->
            <select id="sarana_handling" name="sarana_handling" class="form-control oth_select2" style="width:100%" data-placeholder="pilih jenis sarana handling">
                <option value="<?= $value['handling_type']?>"><?= $value['handling_type_name']?></option>
                <?php if ($value['order_type'] == 1) { ?>
                    <option value="1">Sarana Handling Yang Tersedia</option>
                    <option value="2">Buat Baru</option>
                <?php }else if($value['order_type'] == 2) { ?>
                    <option value="1">Sarana Handling Yang Tersedia</option>
                    <option value="2">Lain-lain</option>
                <?php }?>
            </select>
        </div>
    </div>
    <?php if ($value['handling_type'] == 2) {?>
    <div class="panel-body ifsarana">
        <div class="col-md-3 text-right"><label>Nama Handling :</label></div>
        <div class="col-md-9" id="nm_handling">
            <input id="nama_handling" name="nama_handling" class="form-control" autocomplete="off" value="<?= $value['handling_name']?>">
        </div>
    </div>
    <div class="panel-body ifsaranabaru">
        <div class="col-md-3 text-right"><label>Gambar :</label></div>
        <div class="col-md-9">
            <a href="<?php echo base_url("assets/upload/OrderTimHandling/design/".$value['design']."")?>" target="_blank">
                <img style="max-width: 300px;max-height: 300px" src="<?php echo base_url("assets/upload/OrderTimHandling/design/".$value['design']."")?>">
            </a>
            <input type="hidden" id="file_design_name" name="file_design_name" value="<?= $value['design']?>">
            <input type="file" id="file_design" name="file_design" accept=".jpg, .jpeg, .png">
        </div>
    </div>
    <?php }else { ?>
    <div class="panel-body ifsarana">
        <div class="col-md-3 text-right"><label>Nama Handling :</label></div>
        <div class="col-md-9" id="nm_handling">
            <select id="nama_handling" name="nama_handling" class="form-control getsaranahandling" style="width:100%">
                <option value="<?= $value['handling_name']?>"><?= $value['handling_name']?></option>
            </select>
        </div>
    </div>
    <div class="panel-body ifsaranabaru" style="display:none">
    <div class="col-md-3 text-right"><label>Gambar :</label></div>
    <div class="col-md-9">
        <input type="file" id="file_design" name="file_design" class="form-control" accept=".jpg, .jpeg, .png">
        <input type="hidden" id="file_design_name" name="file_design_name" value="<?= $value['design']?>">
    </div>
    </div>
    <?php }?>
    <div class="panel-body" >
        <div class="col-md-3 text-right"><label>Jumlah yang diorder :</label></div>
        <div class="col-md-9">
            <input type="number" id="qty" name="qty" class="form-control" placeholder="masukkan jumlah order" autocomplete="off" value="<?= $value['quantity']?>">
        </div>
    </div>
    <div class="panel-body" >
        <div class="col-md-3 text-right"><label>Due date :</label></div>
        <div class="col-md-9">
            <input id="due_date" name="due_date" class="form-control oth_datepicker" placeholder="masukkan due date order" autocomplete="off" value="<?= $value['due_date']?>">
        </div>
    </div>
    <div class="panel-body" >
        <div class="col-md-3 text-right"><label>Alasan dan tujuan order :</label></div>
        <div class="col-md-9">
            <textarea id="alasan_order" name="alasan_order" class="form-control" placeholder="masukkan alasan dan tujuan order"><?= $value['order_reason']?></textarea>
        </div>
    </div>
    <div class="panel-body text-center">
        <button class="btn btn-success">Submit</button>
    </div>
<?php }?>
</form>