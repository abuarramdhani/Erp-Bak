<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/doCreate');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/MasterData/TargetBenda/');?>">
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
                                <div class="box-header with-border">Create Target Benda</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbKodesieHeader" class="control-label col-lg-4">Kodesie</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKodesieHeader" name="cmbKodesieHeader" class="select cmbKodesie" data-placeholder="Kodesie" style="width: 100%" required>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKodeBarangHeader" class="control-label col-lg-4">Kode Barang</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kode Barang" name="txtKodeBarangHeader" id="txtKodeBarangHeader" class="form-control" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNamaBarangHeader" class="control-label col-lg-4">Nama Barang</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nama Barang" name="txtNamaBarangHeader" id="txtNamaBarangHeader" class="form-control" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKodeProsesHeader" class="control-label col-lg-4">Kode Proses</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kode Proses" name="txtKodeProsesHeader" id="txtKodeProsesHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNamaProsesHeader" class="control-label col-lg-4">Nama Proses</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Nama Proses" name="txtNamaProsesHeader" id="txtNamaProsesHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtJumlahOperatorHeader" class="control-label col-lg-4">Jumlah Operator</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jumlah Operator" name="txtJumlahOperatorHeader" id="txtJumlahOperatorHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTargetUtamaHeader" class="control-label col-lg-4">Target Utama Senin Kamis</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Utama" name="txtTargetUtamaSeninKamis" id="txtTargetUtamaHeader" class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTargetUtamaHeader" class="control-label col-lg-4">Target Utama Senin Kamis Kelas 4</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Utama" name="txtTargetUtamaSeninKamis4" id="txtTargetUtamaHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTargetSementaraHeader" class="control-label col-lg-4">Target Sementara Senin Kamis</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Sementara" name="txtTargetSementaraSeninKamis" id="txtTargetSementaraHeader" class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTargetUtamaHeader" class="control-label col-lg-4">Target Utama Jumat Sabtu</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Utama" name="txtTargetUtamaJumatSabtu" id="txtTargetUtamaHeader" class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTargetUtamaHeader" class="control-label col-lg-4">Target Utama Jumat Sabtu Kelas 4</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Utama" name="txtTargetUtamaJumatSabtu4" id="txtTargetUtamaHeader" class="form-control" required />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTargetSementaraHeader" class="control-label col-lg-4">Target Sementara Jumat Sabtu</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Target Sementara" name="txtTargetSementaraJumatSabtu" id="txtTargetSementaraHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtWaktuSettingHeader" class="control-label col-lg-4">Waktu Setting</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Waktu Setting" name="txtWaktuSettingHeader" id="txtWaktuSettingHeader" class="form-control" required />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTglBerlakuHeader" class="control-label col-lg-4">Tgl Berlaku</label>
                                                <div class="col-lg-4">
                                                    <input type="date" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTglBerlakuHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTglBerlakuHeader" required />
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                    </ul>
                                                    <div class="tab-content">
                                                    </div>
                                                </div>
                                            </div>
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