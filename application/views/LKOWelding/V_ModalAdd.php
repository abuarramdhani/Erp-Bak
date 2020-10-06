<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Tanggal</label></div>
        <div class="col-md-8"><input type="text" autocomplete="off" placeholder="Tanggal Bekerja" id="employee_tgl_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Pekerja</label></div>
        <div class="col-md-8">
            <select class="form-control select2" style="width: 100%;" id="employee_ind_weld" data-placeholder="Select By No Induk / Nama">
                <option></option>
            </select>
            <input type="hidden" id="employee_name_weld" />
        </div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Uraian Pekerjaan</label></div>
        <div class="col-md-8"><input type="text" autocomplete="off" placeholder="Pekerjaan yang dilakukan" id="employee_workdesc_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Pencapaian</label></div>
        <div class="col-md-3"><input autocomplete="off" placeholder="Target Waktu (Angka)" onkeypress="return angka(event, false)" type="text" id="employee_tgt_weld" class="form-control" /></div>
        <div class="col-md-3"><input autocomplete="off" placeholder="Actual Waktu (Angka)" onkeypress="return angka(event, false)" type="text" id="employee_act_weld" class="form-control" /></div>
        <div class="col-md-2"><input type="text" autocomplete="off" placeholder="Persentase (%)" id="employee_percent_weld" class="form-control" readonly /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Shift</label></div>
        <div class="col-md-8"><input type="text" oninput="this.value = this.value.toUpperCase()" autocomplete="off" placeholder="Shift pekerja (contoh : SATU)" id="employee_shift_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Keterangan</label></div>
        <div class="col-md-8"><input autocomplete="off" placeholder="Keterangan" type="text" id="employee_ket_weld" class="form-control" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-3" style="text-align: right;"> <label>Kondite</label></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_mk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="MK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_i_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="I" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_bk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="BK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_tkp_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="TKP" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_kp_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KP" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_ks_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KS" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_kk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="KK" /></div>
        <div class="col-md-1"><input type="text" autocomplete="off" id="employee_pk_weld" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="PK" /></div>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12" style="text-align: right;">
        <a class="btn btn-success button_save_list">Save</a>
    </div>
</div>