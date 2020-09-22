<input type="hidden" value="<?= $datatoedit[0]['LKO_ID'] ?>" id="edit_employee_id_weld">
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Tanggal</label></div>
        <div class="col-md-8"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['TANGGAL'] ?>" readonly placeholder="Tanggal Bekerja" id="edit_employee_tgl_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Induk Pekerja</label></div>
        <div class="col-md-8">
            <input type="text" class="form-control" readonly id="edit_employee_ind_weld" value="<?= $datatoedit[0]['NO_INDUK'] ?>" />

        </div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Nama Pekerja</label></div>
        <div class="col-md-8">
            <input type="text" class="form-control" readonly id="edit_employee_name_weld" value="<?= $datatoedit[0]['NAMA_PEKERJA'] ?>" />
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Uraian Pekerjaan</label></div>
        <div class="col-md-8"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['URAIAN_PEKERJAAN'] ?>" id="edit_employee_workdesc_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Pencapaian</label></div>
        <div class="col-md-3"><input autocomplete="off" placeholder="Target Waktu (Angka)" value="<?= $datatoedit[0]['PENCAPAIAN_TGT'] ?>" onkeypress="return angka(event, false)" type="text" id="edit_employee_tgt_weld" class="form-control" /></div>
        <div class="col-md-3"><input autocomplete="off" placeholder="Actual Waktu (Angka)" value="<?= $datatoedit[0]['PENCAPAIAN_ACT'] ?>" onkeypress="return angka(event, false)" type="text" id="edit_employee_act_weld" class="form-control" /></div>
        <div class="col-md-2"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['PENCAPAIAN_PERSEN'] ?>" placeholder="Persentase (%)" id="edit_employee_percent_weld" class="form-control" readonly /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Shift</label></div>
        <div class="col-md-8"><input type="text" value="<?= $datatoedit[0]['SHIFT'] ?>" oninput="this.value = this.value.toUpperCase()" autocomplete="off" placeholder="Shift pekerja (contoh : SATU)" id="edit_employee_shift_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Keterangan</label></div>
        <div class="col-md-8"><input autocomplete="off" value="<?= $datatoedit[0]['KETERANGAN'] ?>" placeholder="Keterangan" type="text" id="edit_employee_ket_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Kondite</label></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_MK'] ?>" id="edit_employee_mk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="MK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_I'] ?>" id="edit_employee_i_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="I" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_BK'] ?>" id="edit_employee_bk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="BK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_TKP'] ?>" id="edit_employee_tkp_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="TKP" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_KP'] ?>" id="edit_employee_kp_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KP" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_KS'] ?>" id="edit_employee_ks_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KS" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_KK'] ?>" id="edit_employee_kk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" value="<?= $datatoedit[0]['KONDITE_PK'] ?>" id="edit_employee_pk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="PK" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12" style="text-align: right;">
        <a class="btn btn-success button_save_edit">Update</a>
    </div>
</div>