<?php if ($tukar == 'ya'): ?>    
    <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_1">
        <div class="col-md-12 text-center" style="margin-top: 10px;">
            <label>Pekerja 1</label>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Noind</label>
            </div>
            <div class="col-md-9">
                <select required="" id="pss_core_noind" class="form-control pss_noind" name="noind[]" style="width: 100%">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Nama</label>
            </div>
            <div class="col-md-9">
                <input class="form-control pss_nama" placeholder="Nama" readonly="" />
            </div>
        </div>
        <?php $no = 1; foreach ($arrTgl as $key): ?>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Tanggal <?= $no; ?></label>
            </div>
            <div class="col-md-3" style="padding-right: 0px;">
                <input name="tgl[]" class="form-control pss_tgl" placeholder="Tanggal" readonly="" />
            </div>
            <div class="col-md-6">
                <input class="form-control pss_shift" placeholder="Shift" readonly="" />
                <input hidden="" name="kd_sh[]" class="kd_sift" />
            </div>
        </div>
        <?php $no++; endforeach ?>
    </div>
    <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_2">
        <div class="col-md-12 text-center" style="margin-top: 10px;">
            <label>Pekerja 2</label>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Noind</label>
            </div>
            <div class="col-md-9">
                <select required="" class="form-control pss_noind" name="noind[]" style="width: 100%">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Nama</label>
            </div>
            <div class="col-md-9">
                <input class="form-control pss_nama" placeholder="Nama" readonly="" />
            </div>
        </div>
        <?php $no = 1; foreach ($arrTgl as $key): ?>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Tanggal <?= $no; ?></label>
            </div>
            <div class="col-md-3" style="padding-right: 0px;">
                <input class="form-control pss_tgl" placeholder="Tanggal" readonly="" />
            </div>
            <div class="col-md-6">
                <input class="form-control pss_shift" placeholder="Shift" readonly="" />
                <input hidden="" name="kd_sh_2[]" class="kd_sift"/>
            </div>
        </div>
        <?php $no++; endforeach ?>
    </div>

<?php else: ?>

    <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_1">
        <div class="col-md-12 text-center" style="margin-top: 10px;">
            <label>Pekerja 1</label>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Noind</label>
            </div>
            <div class="col-md-9">
                <select required="" id="pss_core_noind" class="form-control pss_noind_to_all" style="width: 100%">
                    <option></option>
                </select>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Nama</label>
            </div>
            <div class="col-md-9">
                <input class="form-control pss_nama" placeholder="Nama" readonly="" />
            </div>
        </div>
        <?php $no = 1; foreach ($arrTgl as $key): ?>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Tanggal <?= $no; ?></label>
            </div>
            <div class="col-md-3" style="padding-right: 0px">
                <input name="tgl[]" class="form-control pss_tgl" placeholder="Tanggal" readonly="" />
            </div>
            <div class="col-md-6">
                <input class="form-control pss_shift" placeholder="Shift" readonly="" />
                <input hidden="" name="kd_sh[]" class="kd_sift"/>
            </div>
        </div>
        <?php $no++; endforeach ?>
    </div>
    <div class="col-md-6 pss_data_pkj" style="" id="pss_data_pkj_2">
        <div class="col-md-12 text-center" style="margin-top: 10px;">
            <label>Pekerja 2</label>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Noind</label>
            </div>
            <div class="col-md-9">
                <input readonly="" class="form-control pss_noind_input" name="noind[]" placeholder="Masukan Noind" />
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Nama</label>
            </div>
            <div class="col-md-9">
                <input class="form-control pss_nama" placeholder="Nama" readonly="" />
            </div>
        </div>
        <?php $no = 1; foreach ($arrTgl as $key): ?>
        <div class="col-md-12" style="margin-top: 10px;">
            <div class="col-md-3">
                <label style="margin-top: 5px;">Tanggal <?= $no; ?></label>
            </div>
            <div class="col-md-3" style="padding-right: 0px;">
                <input class="form-control pss_tgl" placeholder="Tanggal" readonly="" />
            </div>
            <div class="col-md-6">
                <select disabled="" class="form-control pss_list_shift" name="kd_sh_2[]" required="" style="width: 100%">
                    <option></option>
                </select>
            </div>
        </div>
        <?php $no++; endforeach ?>
    </div>

<?php endif ?>

<div class="col-md-12 text-center" style="margin-top: 30px;">
    <select class="form-control pss_selc2" style="width: 300px;" name="atasan" required disabled="">
        <option value=""></option>
        <?php foreach ($approval1 as $appr1) { ?>
        <?php if (isset($_POST['slc_approval1']) && $_POST['slc_approval1'] == $appr1['noind']){ $selected = "selected";}else{$selected ="";} ?>
        <option value="<?php echo $appr1['noind'] ?>" <?php echo $selected ?>><?php echo $appr1['noind']." - ".$appr1['nama'] ?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-12 text-center" style="margin-top: 30px;">
    <button class="btn btn-success btn-lg" id="pss_submit_tukar" type="submit">Save</button>
</div>