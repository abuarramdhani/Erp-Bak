<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?php echo $Title;?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMSeleksi/Penjadwalan');?>">
									<i class="icon-pencil icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
          <form method="post" action="<?php echo base_url("ADMSeleksi/Penjadwalan/save")?>">
          <div class="col-ld-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
              </div>
              <div class="box-body">
                <div class="row">
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Kode Tes :</label>
                        </div>
                        <div class="col-lg-3">
                            <select class="select select2 form-control" name="kode_akses_psikotest" id="kode_akses_psikotest" data-placeholder="pilih tipe seleksi">
                            <option></option>
                            <option value="SMK/SMA_Reg">SMK/SMA Reg</option>
                            <option value="D3/S1">D3/S1</option>
                            <option value="OS">OS</option>
                            <option value="Cabang">Cabang</option>
                            <option value="PKL/Magang">PKL/Magang</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <input name="tanggal_surat_psikotest" class="form-control pickerpenjadwalan" id="tanggal_surat_psikotest" placeholder="pilih tanggal surat" autocomplete="off">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Tanggal Tes :</label>
                        </div>
                        <div class="col-lg-3">
                            <input name="tanggal_psikotest" class="form-control pickerpenjadwalan" id="tanggal_psikotest" placeholder="pilih tanggal test" autocomplete="off">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Waktu :</label>
                        </div>
                        <div class="col-lg-2">
                            <input name="waktu_mulai_psikotest" class="form-control waktu_psikotest" id="waktu_mulai_psikotest" value="00:00:00">
                        </div>
                        <div class="col-lg-2">
                            <input name="waktu_selesai_psikotest" class="form-control waktu_psikotest" id="waktu_selesai_psikotest" value="00:00:00">
                        </div>
                        <div class="col-lg-2">
                            <select class="select select2 form-control" name="zona_psikotest" id="zona_psikotest" data-placeholder="zona">
                            <option></option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                            <option value="WITA">WITA</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body" id="tambah_nama_psikotest">
                        <div class="col-lg-2 text-left">
                            <label>Nama Test :</label>
                        </div>
                        <div class="col-lg-3">
                            <select class="select select2 form-control get_nama_psikotest" name="nama_test_psikotest[]" id="nama_test_psikotest1" data-placeholder="pilih nama test"></select>
                        </div>
                        <div class="col-lg-1">
                            <button type="button" class="btn btn-danger" onclick="tambah_nama_psikotest()"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success" onclick="findDataPsikotest(this)">Tarik Data Peserta</button>
                        </div>
                    </div>
                <div class="panel-body" style="margin-top: 20px;" id="view_data_psikotest">
                </div>
              </div>

              </div>
              <div class="panel-footer">
                <div class="row text-right">
                  <a href="<?php echo base_url('ADMSeleksi');?>" type="button" class="btn btn-danger btn-lg btn-rect">Back</a>
                  &nbsp;&nbsp;
                  <a href="<?php echo base_url('ADMSeleksi/Penjadwalan');?>" type="button" class="btn btn-info btn-lg btn-rect">Reset</a>
                  &nbsp;&nbsp;
                  <button type="submit" class="btn btn-success btn-lg" id="btn_save_jadwal_psikotest">Save Data</button>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
