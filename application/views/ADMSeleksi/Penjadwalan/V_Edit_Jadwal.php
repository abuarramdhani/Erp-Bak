<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b><?= $Title?></b></h1>
							</div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ADMSeleksi/MonitoringPenjadwalan');?>">
									<i class="icon-pencil icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
          <form method="post" action="<?php echo base_url("ADMSeleksi/MonitoringPenjadwalan/save_edit")?>">
          <div class="col-ld-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
              </div>
              <div class="box-body">
                <div class="row">
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Kode Akses :</label>
                        </div>
                        <div class="col-lg-3">
                            <?php
                            $kode = explode('_', $data[0]['kode_test']);
                            $kode1 = $kode[0] == 'SMK/SMA' ? $kode[0].' '.$kode[1] : $kode[0];
                            $kode2 = $kode[0] == 'SMK/SMA' ? $kode[0].'_'.$kode[1] : $kode[0];
                            ?>
                            <input class="form-control" value="<?= $kode1?>" readonly>
                            <input type="hidden" name="kode_akses_psikotest" class="form-control" id="kode_akses_psikotest" value="<?= $kode2?>">
                            <!-- <select class="select select2 form-control" name="kode_akses_psikotest" id="kode_akses_psikotest" data-placeholder="pilih tipe seleksi">
                            <option valuew="<?= $kode2?>"><?= $kode1?></option>
                            <option value="SMK/SMA_Reg">SMK/SMA Reg</option>
                            <option value="D3/S1">D3/S1</option>
                            <option value="OS">OS</option>
                            <option value="Cabang">Cabang</option>
                            <option value="PKL/Magang">PKL/Magang</option>
                            </select> -->
                        </div>
                        <div class="col-lg-3">
                            <input name="tanggal_surat_psikotest" class="form-control" id="tanggal_surat_psikotest" autocomplete="off" readonly value="<?= DateTime::createFromFormat('Y-m-d', $data[0]['tgl_surat'])->format('d/m/Y')?>">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Tanggal Tes :</label>
                        </div>
                        <div class="col-lg-3">
                            <input name="tanggal_psikotest" class="form-control pickerpenjadwalan" id="tanggal_psikotest" value="<?= DateTime::createFromFormat('Y-m-d', $data[0]['tgl_test'])->format('d/m/Y')?>">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-2 text-left">
                            <label>Waktu :</label>
                        </div>
                        <div class="col-lg-2">
                            <input name="waktu_mulai_psikotest" class="form-control waktu_psikotest" id="waktu_mulai_psikotest" value="<?= $data[0]['waktu_mulai']?>">
                        </div>
                        <div class="col-lg-2">
                            <input name="waktu_selesai_psikotest" class="form-control waktu_psikotest" id="waktu_selesai_psikotest" value="<?= $data[0]['waktu_selesai']?>">
                        </div>
                        <div class="col-lg-2">
                            <select class="select select2 form-control" name="zona_psikotest" id="zona_psikotest" data-placeholder="zona">
                            <option value="<?= $data[0]['zona']?>"><?= $data[0]['zona']?></option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                            <option value="WITA">WITA</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body" id="tambah_nama_psikotest">
                        <?php
                        // $nama_test = explode(';', $data[0]['id_test']);
                        for ($t=0; $t < count($tes); $t++) { 
                            $test = $this->M_penjadwalan->get_namates2($tes[$t]['id_test']);
                            if ($t == 0) { ?>
                                <div class="col-lg-2 text-left">
                                    <label>Nama Test :</label>
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control" value="<?= $test[0]['nama_tes']?>" readonly>
                                    <input type="hidden" name="nama_test_psikotest[]" class="form-control" id="nama_test_psikotest" value="<?= $tes[$t]['id_test']?>">
                                    <!-- <select class="select select2 form-control get_nama_psikotest" name="nama_test_psikotest[]" id="nama_test_psikotest0">
                                        <option value="<?= $tes[$t]['id_test']?>"><?= $test[0]['nama_tes']?></option>
                                    </select> -->
                                </div>
                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-danger" onclick="tambah_nama_psikotest()"><i class="fa fa-plus"></i></button>
                                </div>
                            <?php }else { ?>
                                <div class="tambah_nama_psikotest">
                                    <br><br>
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-3">
                                    <input class="form-control" value="<?= $test[0]['nama_tes']?>" readonly>
                                    <input type="hidden" name="nama_test_psikotest[]" class="form-control" id="nama_test_psikotest" value="<?= $tes[$t]['id_test']?>">
                                    <!-- <select class="select select2 form-control get_nama_psikotest" name="nama_test_psikotest[]" id="nama_test_psikotest1">
                                        <option value="<?= $tes[$t]['id_test']?>"><?= $test[0]['nama_tes']?></option>
                                    </select> -->
                                    </div>
                                    <!-- <div class="col-md-1">
                                        <button type="button" class="btn btn-danger tombolhapus1"><i class="fa fa-minus"></i></button>
                                    </div> -->
                                </div>
                            <?php }
                            }
                        ?>
                    </div>
                    <div class="panel-body" style="margin-top: 20px;" id="view_data_psikotest">
                        <table class="table table-bordered table-hover table-striped text-center" id="tb_peserta_psikotest" style="width: 100%;">
                            <thead style="background-color:#63E1EB">
                                <tr class="text-nowrap">
                                    <!-- <th style="width:7%;">No</th> -->
                                    <th>Nama Peserta</th>
                                    <th>No. Handphone</th>
                                    <th>Kode Akses</th>
                                    <th style="width:15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <input type="hidden" name="peserta_terhapus">
                                <?php $no = 1; foreach ($data as $key => $value) {?>
                                <tr id="tr_peserta<?= $no?>">
                                    <!-- <td><?= $no?></td> -->
                                    <td><?= $value['nama_peserta']?>
                                        <input type="hidden" name="nama_peserta[]" id="nama_peserta<?= $no?>" value="<?= $value['nama_peserta']?>">
                                        <input type="hidden" name="pendidikan[]" id="pendidikan<?= $no?>" value="<?= $value['pendidikan']?>">
                                        <input type="hidden" name="nik[]" id="nik<?= $no?>" value="<?= $value['nik']?>"></td>
                                    <td><input type="hidden" name="no_hp[]" id="no_hp<?= $no?>" value="<?= $value['no_hp']?>"><?= $value['no_hp']?></td>
                                    <td><input type="hidden" name="kode_akses[]" id="kode_akses<?= $no?>" value="<?= $value['kode_akses']?>"><?= $value['kode_akses']?></td>
                                    <td><button type="button" class="btn btn-xs btn-danger" onclick="delete_peserta_psikotest2(<?= $no?>)"><i class="fa fa-trash"></i> Delete</button>
                                        <button type="button" class="btn btn-xs btn-info" style="margin-left:10px" onclick="preview_chat_psikotest(<?= $no?>)"><i class="fa fa-eye"></i> Preview</button>
                                    </td>
                                </tr>
                                <?php $no++; }?>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
              <div class="panel-footer">
                <div class="row text-right">
                  <a href="<?php echo base_url('ADMSeleksi/MonitoringPenjadwalan');?>" type="button" class="btn btn-danger btn-lg btn-rect">Back</a>
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
