<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo $action ?>" class="form-horizontal">
            <div class="col-lg-12">
                <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right">
                                <h1><b>Master Pekerja</b></h1>

                                </div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/MasterPekerja/');?>">
                                        <i class="icon-wrench icon-2x"></i>
                                        <span ><br /></span>
                                    </a>                             
                                </div>
                            </div>
                        </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Master Pekerja
                            </div>
                        <div class="box-body">
                            <div class="panel-body">
                                <?php if (validation_errors() <> '') {
                                echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4><i class="fa fa-times"></i> &nbsp; Error! Please check the following errors:</h4>';
                                echo validation_errors(); 
                                echo "</div>";
                            }
                                ?>
                                <div class="row">
									<div class="form-group">
                                        <label for="txtNoindNew" class="control-label col-lg-4">No Induk</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="No Induk" name="txtNoindNew" id="txtNoindNew" class="form-control" value="<?php echo $noind; ?>" onkeypress="return isNumberKey(event)" maxlength="7"/>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="txtKdHubunganKerja" class="control-label col-lg-4">Kd Hubungan Kerja</label>
                                        <div class="col-lg-4">
                                            <input type="text" placeholder="Kd Hubungan Kerja" name="txtKdHubunganKerja" id="txtKdHubunganKerja" class="form-control" value="<?php echo $kd_hubungan_kerja; ?>" maxlength="2"/>
                                        </div>
                                    </div>
									<div class="form-group">
	                                    <label for="cmbKdStatusKerja" class="control-label col-lg-4">Status Kerja</label>
	                                    <div class="col-lg-4">
	                                        <select style="width:100%" id="cmbKdStatusKerja" name="cmbKdStatusKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                <?php
													foreach ($pr_master_status_kerja_data as $row) {
													$slc1='';if(rtrim($row->kd_status_kerja)==rtrim($kd_status_kerja)){$slc1='selected';}
													echo '<option '.$slc1.' value="'.$row->kd_status_kerja.'">'.$row->status_kerja.'</option>';
                                                    }
                                                ?>
											</select>
	                                    </div>
	                                </div>
									<div class="form-group">
                                            <label for="txtNik" class="control-label col-lg-4">Nik</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Nik" name="txtNik" id="txtNik" class="form-control" value="<?php echo $nik; ?>" onkeypress="return isNumberKey(event)" maxlength="20"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoKk" class="control-label col-lg-4">No KK</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Kk" name="txtNoKk" id="txtNoKk" class="form-control" value="<?php echo $no_kk; ?>" onkeypress="return isNumberKey(event)" maxlength="50"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNama" class="control-label col-lg-4">Nama</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Nama" name="txtNama" id="txtNama" class="form-control" value="<?php echo $nama; ?>" maxlength="20"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbIdKantorAsal" class="control-label col-lg-4">Kantor Asal</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%"  id="cmbIdKantorAsal" name="cmbIdKantorAsal" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_kantor_asal_data as $row) {
															$slc2='';if(rtrim($row->id_kantor_asal)==rtrim($id_kantor_asal)){$slc2='selected';}
                                                            echo '<option '.$slc2.' value="'.$row->id_kantor_asal.'">'.$row->kantor_asal.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbIdLokasiKerja" class="control-label col-lg-4">Lokasi Kerja</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%"  id="cmbIdLokasiKerja" name="cmbIdLokasiKerja" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_lokasi_kerja_data as $row) {
															$slc3='';if(rtrim($row->id_lokasi_kerja)==rtrim($id_lokasi_kerja)){$slc3='selected';}
                                                            echo '<option '.$slc3.' value="'.$row->id_lokasi_kerja.'">'.$row->lokasi_kerja.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="cmbJnsKelamin" class="control-label col-lg-4">Jenis Kelamin</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%"  id="cmbJnsKelamin" name="cmbJnsKelamin" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                            <?php 
																$l='';if($jns_kelamin=='L'){$l='selected';}
																$p='';if($jns_kelamin=='P'){$p='selected';}
															?>
															<option <?php echo $l ?> value="L">LAKI-LAKI</option><option value=""></option>
                                                            <option <?php echo $p ?> value="P">PEREMPUAN</option></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtTempatLahir" class="control-label col-lg-4">Tempat Lahir</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Tempat Lahir" name="txtTempatLahir" id="txtTempatLahir" class="form-control" value="<?php echo $tempat_lahir; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglLahir" class="control-label col-lg-4">Tanggal Lahir</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglLahir" value="<?php echo $tgl_lahir ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglLahir" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtAlamat" class="control-label col-lg-4">Alamat</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Alamat" name="txtAlamat" id="txtAlamat" class="form-control" value="<?php echo $alamat; ?>" maxlength="100"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtDesa" class="control-label col-lg-4">Desa</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Desa" name="txtDesa" id="txtDesa" class="form-control" value="<?php echo $desa; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKecamatan" class="control-label col-lg-4">Kecamatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kecamatan" name="txtKecamatan" id="txtKecamatan" class="form-control" value="<?php echo $kecamatan; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKabupaten" class="control-label col-lg-4">Kabupaten</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kabupaten" name="txtKabupaten" id="txtKabupaten" class="form-control" value="<?php echo $kabupaten; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtProvinsi" class="control-label col-lg-4">Provinsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Provinsi" name="txtProvinsi" id="txtProvinsi" class="form-control" value="<?php echo $provinsi; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKodePos" class="control-label col-lg-4">Kode Pos</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kode Pos" name="txtKodePos" id="txtKodePos" class="form-control" value="<?php echo $kode_pos; ?>" onkeypress="return isNumberKey(event)" maxlength="6"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoHp" class="control-label col-lg-4">No Hp</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Hp" name="txtNoHp" id="txtNoHp" class="form-control" value="<?php echo $no_hp; ?>"  onkeypress="return isNumberKey(event)" maxlength="16"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtGelarD" class="control-label col-lg-4">Gelar D</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Gelar D" name="txtGelarD" id="txtGelarD" class="form-control" value="<?php echo $gelar_d; ?>" maxlength="6"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtGelarB" class="control-label col-lg-4">Gelar B</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Gelar B" name="txtGelarB" id="txtGelarB" class="form-control" value="<?php echo $gelar_b; ?>" maxlength="6"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtPendidikan" class="control-label col-lg-4">Pendidikan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Pendidikan" name="txtPendidikan" id="txtPendidikan" class="form-control" value="<?php echo $pendidikan; ?>"  maxlength="5"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJurusan" class="control-label col-lg-4">Jurusan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jurusan" name="txtJurusan" id="txtJurusan" class="form-control" value="<?php echo $jurusan; ?>" maxlength="30"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtSekolah" class="control-label col-lg-4">Sekolah</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Sekolah" name="txtSekolah" id="txtSekolah" class="form-control" value="<?php echo $sekolah; ?>" maxlength="60"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtStatNikah" class="control-label col-lg-4">Status Nikah</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Stat Nikah" name="txtStatNikah" id="txtStatNikah" class="form-control" value="<?php echo $stat_nikah; ?>" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglNikah" class="control-label col-lg-4">Tanggal Nikah</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglNikah" value="<?php echo $tgl_nikah ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglNikah" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtJmlAnak" class="control-label col-lg-4">Jumlah Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jml Anak" name="txtJmlAnak" id="txtJmlAnak" class="form-control" value="<?php echo $jml_anak; ?>" onkeypress="return isNumberKey(event)" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJmlSdr" class="control-label col-lg-4">Jumlah Saudara</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jml Sdr" name="txtJmlSdr" id="txtJmlSdr" class="form-control" value="<?php echo $jml_sdr; ?>" onkeypress="return isNumberKey(event)" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtDiangkat" class="control-label col-lg-4">Diangkat</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtDiangkat" value="<?php echo $diangkat ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtDiangkat" />
	                                            </div>
	                                        </div>
									<div class="form-group">
	                                            <label for="txtMasukKerja" class="control-label col-lg-4">Masuk Kerja</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtMasukKerja" value="<?php echo $masuk_kerja ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtMasukKerja" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtKodesie" class="control-label col-lg-4">Kodesie</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kodesie" name="txtKodesie" id="txtKodesie" class="form-control" value="<?php echo $kodesie; ?>" maxlength="9"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtGolKerja" class="control-label col-lg-4">Gol Kerja</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Gol Kerja" name="txtGolKerja" id="txtGolKerja" class="form-control" value="<?php echo $gol_kerja; ?>" maxlength="4"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdAsalOutsourcing" class="control-label col-lg-4">Kode Asal Outsourcing</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Asal Outsourcing" name="txtKdAsalOutsourcing" id="txtKdAsalOutsourcing" class="form-control" value="<?php echo $kd_asal_outsourcing; ?>"  onkeypress="return isNumberKey(event)" maxlength="4" />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKdJabatan" class="control-label col-lg-4">Kode Jabatan</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Jabatan" name="txtKdJabatan" id="txtKdJabatan" class="form-control" value="<?php echo $kd_jabatan; ?>"  maxlength="4"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="cmbJabatan" class="control-label col-lg-4">Jabatan</label>
	                                            <div class="col-lg-4">
	                                                <select style="width:100%" id="cmbJabatan" name="cmbJabatan" class="select2" data-placeholder="Choose an option"><option value=""></option>
                                                        <?php
                                                        foreach ($pr_master_jabatan_data as $row) {
															$slc4='';if(rtrim($row->kd_jabatan)==rtrim($kd_jabatan)){$slc4='selected';}
                                                            echo '<option '.$slc4.' value="'.$row->kd_jabatan.'">'.$row->jabatan.'</option>';
                                                        }
                                                        ?></select>
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNpwp" class="control-label col-lg-4">NPWP</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Npwp" name="txtNpwp" id="txtNpwp" class="form-control" value="<?php echo $npwp; ?>"  onkeypress="return isNumberKey(event)" maxlength="20" />
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtNoKpj" class="control-label col-lg-4">No KPJ</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Kpj" name="txtNoKpj" id="txtNoKpj" class="form-control" value="<?php echo $no_kpj; ?>"  onkeypress="return isNumberKey(event)" maxlength="20"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtLmKontrak" class="control-label col-lg-4">Lama Kontrak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Lm Kontrak" name="txtLmKontrak" id="txtLmKontrak" class="form-control" value="<?php echo $lm_kontrak; ?>" onkeypress="return isNumberKey(event)" maxlength="2"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtAkhKontrak" class="control-label col-lg-4">Akhir Kontrak</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtAkhKontrak" value="<?php echo $akh_kontrak ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtAkhKontrak" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtStatPajak" class="control-label col-lg-4">Stat Pajak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Stat Pajak" name="txtStatPajak" id="txtStatPajak" class="form-control" value="<?php echo $stat_pajak; ?>" maxlength="4"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJtAnak" class="control-label col-lg-4">Jt Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jt Anak" name="txtJtAnak" id="txtJtAnak" class="form-control" value="<?php echo $jt_anak; ?>" maxlength="1"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtJtBknAnak" class="control-label col-lg-4">Jt Bkn Anak</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Jt Bkn Anak" name="txtJtBknAnak" id="txtJtBknAnak" class="form-control" value="<?php echo $jt_bkn_anak; ?>" maxlength="1"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglSpsi" class="control-label col-lg-4">Tanggal Spsi</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglSpsi" value="<?php echo $tgl_spsi ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglSpsi" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoSpsi" class="control-label col-lg-4">No Spsi</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Spsi" name="txtNoSpsi" id="txtNoSpsi" class="form-control" value="<?php echo $no_spsi; ?>" onkeypress="return isNumberKey(event)" maxlength="11"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglKop" class="control-label col-lg-4">Tanggal Kop</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglKop" value="<?php echo $tgl_kop ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglKop" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtNoKoperasi" class="control-label col-lg-4">No Koperasi</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="No Koperasi" name="txtNoKoperasi" id="txtNoKoperasi" class="form-control" value="<?php echo $no_koperasi; ?>" onkeypress="return isNumberKey(event)" maxlength="11"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtKeluar" class="control-label col-lg-4">Keluar</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Keluar" name="txtKeluar" id="txtKeluar" class="form-control" value="<?php echo $keluar; ?>" onkeypress="return isNumberKey(event)" maxlength="1"/>
                                            </div>
                                    </div>
									<div class="form-group">
	                                            <label for="txtTglKeluar" class="control-label col-lg-4">Tanggal Keluar</label>
	                                            <div class="col-lg-4">
	                                                <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglKeluar" value="<?php echo $tgl_keluar ?>" class="form-control" data-date-format="yyyy-mm-dd" id="txtTglKeluar" />
	                                            </div>
	                                        </div>
									<div class="form-group">
                                            <label for="txtKdPkj" class="control-label col-lg-4">Kd Pkj</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Kd Pkj" name="txtKdPkj" id="txtKdPkj" class="form-control" value="<?php echo $kd_pkj; ?>" maxlength="9"/>
                                            </div>
                                    </div>
									<div class="form-group">
                                            <label for="txtAnggJkn" class="control-label col-lg-4">Angg Jkn</label>
                                            <div class="col-lg-4">
                                                <input type="text" placeholder="Angg Jkn" name="txtAnggJkn" id="txtAnggJkn" class="form-control" value="<?php echo $angg_jkn; ?>" onkeypress="return isNumberKey(event)" maxlength="1"/>
                                            </div>
                                    </div>
									<input type="hidden" name="txtNoind" value="<?php echo $noind; ?>" />
								</div>
                                
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right">
                                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</section>