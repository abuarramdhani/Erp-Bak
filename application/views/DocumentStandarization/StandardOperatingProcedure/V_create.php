<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/SOP/create');?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/SOP/');?>">
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
                                <div class="box-header with-border">Create Standard Operating Procedure</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtSopNameHeader" class="control-label col-lg-4">Nama SOP</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Sop Name" name="txtSopNameHeader" id="txtSopNameHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtCdIdHeader" class="control-label col-lg-4">Context Diagram</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbContextDiagram" name="cmbContextDiagram" class="select2" data-placeholder="Pilih" style="width: 100%" required="">
                                                        <option value=""></option>
                                                    </select>                                                    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNoKontrolHeader" class="control-label col-lg-4">Nomor Kontrol</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Kontrol" name="txtNoKontrolHeader" id="txtNoKontrolHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtNoRevisiHeader" class="control-label col-lg-4">Nomor Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Revisi" name="txtNoRevisiHeader" id="txtNoRevisiHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtTanggalHeader" class="control-label col-lg-4">Tanggal Revisi</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d-m-Y')?>" name="txtTanggalHeader" class="date form-control daterangepickersingledate" data-date-format="dd-mm-yyyy" id="txtTanggalHeader" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtJmlHalamanHeader" class="control-label col-lg-4">Jumlah Halaman</label>
                                                <div class="col-lg-4">
                                                    <input type="number" name="txtJmlHalamanHeader" id="txtJmlHalamanHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txaSopInfoHeader" class="control-label col-lg-4">Info / Keterangan</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopInfoHeader" id="txaSopInfoHeader" class="form-control" placeholder="Sop Info"></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDibuatHeader" class="control-label col-lg-4">Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Dibuat" name="txtDibuatHeader" id="txtDibuatHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiperiksa1Header" class="control-label col-lg-4">Diperiksa 1</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diperiksa 1" name="txtDiperiksa1Header" id="txtDiperiksa1Header" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiperiksa2Header" class="control-label col-lg-4">Diperiksa 2</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diperiksa 2" name="txtDiperiksa2Header" id="txtDiperiksa2Header" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtDiputuskanHeader" class="control-label col-lg-4">Diputuskan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Diputuskan" name="txtDiputuskanHeader" id="txtDiputuskanHeader" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtSopFileHeader" class="control-label col-lg-4">Upload File</label>
                                                <div class="col-lg-4">
                                                    <input type="file" placeholder="Sop File" name="txtSopFileHeader" id="txtSopFileHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group hidden">
                                                <label for="txaSopTujuanHeader" class="control-label col-lg-4">Sop Tujuan</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopTujuanHeader" id="txaSopTujuanHeader" class="form-control" placeholder="Sop Tujuan"></textarea>
                                                </div>
                                            </div>

											<div class="form-group hidden">
                                                <label for="txaSopRuangLingkupHeader" class="control-label col-lg-4">Sop Ruang Lingkup</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopRuangLingkupHeader" id="txaSopRuangLingkupHeader" class="form-control" placeholder="Sop Ruang Lingkup"></textarea>
                                                </div>
                                            </div>

											<div class="form-group hidden">
                                                <label for="txaSopReferensiHeader" class="control-label col-lg-4">Sop Referensi</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopReferensiHeader" id="txaSopReferensiHeader" class="form-control" placeholder="Sop Referensi"></textarea>
                                                </div>
                                            </div>

											<div class="form-group hidden">
                                                <label for="txaSopDefinisiHeader" class="control-label col-lg-4">Sop Definisi</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSopDefinisiHeader" id="txaSopDefinisiHeader" class="form-control" placeholder="Sop Definisi"></textarea>
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