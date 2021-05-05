<div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <label>TAMBAH REQUEST MISCELLANEOUS</label>
</div>
<div class="modal-body">
    <div class="panel-body text-center"><label>Pilih IO</label></div>
    <div class="panel-body">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <select name="io" id="io" class="form-control select2" style="width:100%" data-placeholder="Pilih IO" required>
                <option></option>
                <?php foreach ($data as $key => $value) {
                    echo '<option value="'.$value['ORGANIZATION_CODE'].'">'.$value['ORGANIZATION_CODE'].'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="panel-body text-center">
        <?php if ($ket == 'kasie') { ?>
        <button class="btn btn-success" formaction="<?php echo base_url('MiscellaneousKasie/Request/tambahrequest') ?>">Submit</button>
        <?php }else { ?>
        <button class="btn btn-success" formaction="<?php echo base_url('MiscellaneousSeksiLain/Request/tambahrequest') ?>">Submit</button>
        <?php } ?>
        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:20px">Cancel</button>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>