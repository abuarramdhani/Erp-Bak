<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('CateringManagement/PrintPPCatering/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('CateringManagement/PrintPPCatering/');?>">
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
                                    Update Print PP
                                </div>
                                <?php
                                    foreach ($Printpp as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
    											<div class="form-group">
                                                    <label for="txtNoPpHeader" class="control-label col-lg-6">No PP</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="No Pp" name="txtNoPpHeader" id="txtNoPpHeader" class="form-control" style="width:100%" value="<?php echo $headerRow['no_pp']; ?>" />
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtTglBuatHeader" class="control-label col-lg-6">Tanggal Dibuat</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtTglBuatHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtTglBuatHeader" style="width:100%" value="<?php echo date('d M Y',strtotime($headerRow['tgl_buat'])) ?>" />
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKepadaHeader" class="control-label col-lg-6">Kepada Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKepadaHeader" name="cmbPpKepadaHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="1" <?php if ($headerRow['pp_kepada'] == "1") { echo "selected"; }?>>SUPPLIER</option>
                                                            <option value="2" <?php if ($headerRow['pp_kepada'] == "2") { echo "selected"; }?>>SUBKONTRAKTOR</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpJenisHeader" class="control-label col-lg-6">Jenis PP</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpJenisHeader" name="cmbPpJenisHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="1" <?php if ($headerRow['pp_jenis'] == "1") { echo "selected"; }?>>ASET</option>
                                                            <option value="2" <?php if ($headerRow['pp_jenis'] == "2") { echo "selected"; }?>>NON ASET</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpNoProposalHeader" class="control-label col-lg-6">No Proposal Pengadaan Aset</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Pp No Proposal" name="txtPpNoProposalHeader" id="txtPpNoProposalHeader" class="form-control" style="width:100%" value="<?php echo $headerRow['pp_no_proposal']; ?>"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpSeksiPemesanHeader" class="control-label col-lg-6">Seksi Pemesan</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpSeksiPemesanHeader" name="cmbPpSeksiPemesanHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($Section as $row) {
                                                                    if ($headerRow['pp_seksi_pemesan'] == $row['er_section_id']) {
                                                                        $selected_data = "selected";
                                                                    } else {
                                                                        $selected_data = "";   
                                                                    }
                                                                    echo '<option value="'.$row['er_section_id'].'" '.$selected_data.'>'.$row['section_name'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="cmbPpBranchHeader" class="control-label col-lg-6">Branch</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpBranchHeader" name="cmbPpBranchHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($Branch as $row) {
                                                                     if ($headerRow['pp_branch'] == $row['branch_id']) {
                                                                        $selected_data = "selected";
                                                                    } else {
                                                                        $selected_data = "";   
                                                                    }
                                                                    echo '<option '.$selected_data.' value="'.$row['branch_id'].'">'.$row['branch_code'].'</option>';
                                                                }
                                                            ?>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
    										
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <label for="cmbPpCostCenterHeader" class="control-label col-lg-6">Cost Center</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpCostCenterHeader" name="cmbPpCostCenterHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($CostCenter as $row) {
                                                                    if ($headerRow['pp_cost_center'] == $row['cc_id']) {
                                                                        $selected_data = "selected";
                                                                    } else {
                                                                        $selected_data = "";   
                                                                    } 
                                                                    echo '<option '.$selected_data.' value="'.$row['cc_id'].'" >'.$row['cc_code'].'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKatBarangHeader" class="control-label col-lg-6">Barang Untuk</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKatBarangHeader" name="cmbPpKatBarangHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="1" <?php if ($headerRow['pp_kat_barang'] == "1") { echo "selected"; }?>>PRODUKSI</option>
                                                            <option value="2" <?php if ($headerRow['pp_kat_barang'] == "2") { echo "selected"; }?>>NON PRODUKSI</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpSubInventHeader" class="control-label col-lg-6">Sub Inventory</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Pp Sub Invent" name="txtPpSubInventHeader" id="txtPpSubInventHeader" class="form-control" style="width:100%" value="<?php echo $headerRow['pp_sub_invent']; ?>" disabled/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpSiepembelianHeader" class="control-label col-lg-6">Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpSiepembelianHeader" name="cmbPpSiepembelianHeader" class="select select-employee select2" data-placeholder="Choose an option" style="width:100%">
                                                             <option value="<?= $headerRow['pp_siepembelian'];?>" selected><?= $headerRow['siepembelian'] ?></option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglSiepembelianHeader" class="control-label col-lg-6">Tgl Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglSiepembelianHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglSiepembelianHeader" style="width:100%" value="<?php if($headerRow['pp_tgl_siepembelian'] != null) {echo date('d M Y', strtotime($headerRow['pp_tgl_siepembelian'])); } ?>"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpDireksiHeader" class="control-label col-lg-6">Direksi</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpDireksiHeader" name="cmbPpDireksiHeader" class="select select-employee select2" data-placeholder="Choose an option" style="width:100%">
                                                             <option value="<?= $headerRow['pp_direksi'];?>" selected><?= $headerRow['direksi'] ?></option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglDireksiHeader" class="control-label col-lg-6">Tgl Direksi</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglDireksiHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglDireksiHeader" style="width:100%" value="<?php if($headerRow['pp_tgl_direksi'] != null) {echo date('d M Y', strtotime($headerRow['pp_tgl_direksi'])); } ?>"/>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">

    											<div class="form-group">
                                                    <label for="cmbPpKadeptHeader" class="control-label col-lg-6">Kepala Departemen</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKadeptHeader" name="cmbPpKadeptHeader" class="select select-employee select2" data-placeholder="Choose an option" style="width:100%"/>
                                                             <option value="<?= $headerRow['pp_kadept'];?>" selected><?= $headerRow['kadept'] ?></option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKadeptHeader" class="control-label col-lg-6">Tgl Kadept</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKadeptHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKadeptHeader" style="width:100%" value="<?php if($headerRow['pp_tgl_kadept'] != null) {echo date('d M Y', strtotime($headerRow['pp_tgl_kadept'])); } ?>"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKaunitHeader" class="control-label col-lg-6">Kepala Unit</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKaunitHeader" name="cmbPpKaunitHeader" class="select select-employee select2" data-placeholder="Choose an option" style="width:100%">
                                                             <option value="<?= $headerRow['pp_kaunit'];?>" selected><?= $headerRow['kaunit'] ?></option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKaunitHeader" class="control-label col-lg-6">Tgl Kaunit</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKaunitHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKaunitHeader" style="width:100%" value="<?php if($headerRow['pp_tgl_kaunit'] != null) { echo date('d M Y', strtotime($headerRow['pp_tgl_kaunit'])); } ?>"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKasieHeader" class="control-label col-lg-6">Kasie / SPV</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKasieHeader" name="cmbPpKasieHeader" class="select select-employee select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value="<?= $headerRow['pp_kasie'];?>" selected><?= $headerRow['kasie'] ?></option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKasieHeader" class="control-label col-lg-6">Tgl Kasie</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKasieHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKasieHeader" style="width:100%" value="<?php
                                                        if($headerRow['pp_tgl_kasie'] != null) {
                                                          echo date('d M Y', strtotime($headerRow['pp_tgl_kasie'])); }?>"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txaPpCatatanHeader" class="control-label col-lg-6">Catatan</label>
                                                    <div class="col-lg-6">
                                                        <textarea name="txaPpCatatanHeader" id="txaPpCatatanHeader" class="form-control" placeholder="Pp Catatan" style="width:100%"><?php echo $headerRow['pp_catatan']; ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                         <hr>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2">Periode Catering Awal</label>
                                                    <div class="col-lg-2">
                                                        <input value="<?php echo date('d M Y', strtotime($headerRow['pp_catering_tgl_awal'])) ?>" type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPeriodeCateringAwalPP" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeCateringAwalPP" style="width:100%"/>
                                                    </div>
                                                    <label class="control-label col-lg-2">Periode Catering Akhir</label>
                                                    <div class="col-lg-2">
                                                        <input value="<?php echo date('d M Y', strtotime($headerRow['pp_catering_tgl_akhir'])) ?>" type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPeriodeCateringAkhirPP" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeCateringAkhirPP" style="width:100%"/>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2">Lokasi</label>
                                                    <div class="col-lg-2">
                                                        <select class="select2" id="slcLokasiKateringPP" name="slcLokasiKateringPP" data-placeholder="Lokasi" style="width: 100%">
                                                            <option></option>
                                                            <option value="01" <?php echo $headerRow['pp_catering_lokasi'] == '01' ? 'selected' : '' ?>>Yogyakarta & Mlati</option>
                                                            <option value="02" <?php echo $headerRow['pp_catering_lokasi'] == '02' ? 'selected' : '' ?>>Tuksono</option>
                                                        </select>
                                                    </div>
                                                    <label class="control-label col-lg-2">Jenis Pesanan</label>
                                                    <div class="col-lg-2">
                                                        <select class="select2" id="slcJenisPesananPP" name="slcJenisPesananPP" data-placeholder="Jenis" style="width: 100%">
                                                            <option></option>
                                                            <option value="1"<?php echo $headerRow['pp_catering_jenis'] == '1' ? 'selected' : '' ?>>NASI BOX</option>
                                                            <option value="2"<?php echo $headerRow['pp_catering_jenis'] == '2' ? 'selected' : '' ?>>JASA BOGA (NON NASI BOX CATERING)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-primary" id="btnProsesPP">Proses</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                <?php endforeach; ?>
                                        <div class="row2">
                                            <div class="col-md-12">
                                                <span id="add-row-printpp" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i></span>
                                                <input type="hidden" id="data_counter" name="txt_data_counter" value="0">
                                            </div>
                                        </div>
                                
                                        <table id="printPP" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th width="10%"><center>Kode Barang</center></th>
                                                    <th width="10%"><center>Qty</center></th>
                                                    <th width="10%"><center>Satuan</center></th>
                                                    <th width="20%"><center>Nama Barang</center></th>
                                                    <th width="20%"><center>Branch</center></th>
                                                    <th width="20%"><center>Cost Center</center></th>
                                                    <th width="15%"><center>NBD</center></th>
                                                    <th width="20%"><center>Keterangan</center></th>
                                                    <th width="10%"><center>Supplier</center></th>
                                                    <th width="5%"><center>Action</center></th>
                                                </tr>
                                            </thead>
                                            <tbody id='printpp'>
                                            <?php if(count($PrintppDetail) == 0): ?>
                                            <tr class="multiRow">
                                                <td>
                                                    <select type="text" placeholder="Pp Kodebarang" name="txtPpKodebarangHeader[]" id="txtPpKodebarangHeader" class="form-control cm_select2" >
                                                        <option></option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Jumlah" name="txtPpJumlahHeader[]" id="txtPpJumlahHeader" class="form-control" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Satuan" name="txtPpSatuanHeader[]" id="txtPpSatuanHeader" class="form-control" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Nama Barang" name="txtPpNamaBarangHeader[]" id="txtPpNamaBarangHeader" class="form-control cm_namaItem" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Branch" name="txtPpBranchHeader[]" id="txtPpBranchHeader" class="form-control cm_branch" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Cost Center" name="txtPpCostCenterHeader[]" id="txtPpCostCenterHeader" class="form-control cm_costCenter" />
                                                </td>

                                                <td>
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpNbdHeader[]" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpNbdHeader" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Keterangan" name="txtPpKeteranganHeader[]" id="txtPpKeteranganHeader" class="form-control" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Supplier" name="txtPpSupplierHeader[]" id="txtPpSupplierHeader" class="form-control" />
                                                </td>
                                                <td><a href='' class="btn btn-primary btn-sm delete-row-printpp"><i class="fa fa-minus"></i></a></td>
                                            </tr>
                                            <?php else:?>
                                            <?php foreach ($PrintppDetail as $PPDetail): ?>
                                            <tr class="multiRow">
                                               <?php 
                                                    $encrypted_lines_id = $this->encrypt->encode($PPDetail['pp_detail_id']);
                                                    $encrypted_lines_id = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_lines_id);
                                                ?>
                                                <td>
                                                    <input type="hidden" name="txtPpDetailId[]" id="txtPpDetailId" class="form-control" value="<?php echo $encrypted_lines_id; ?>"/>
                                                    <input type="hidden" name="txtPpId[]" id="txtPpId" class="form-control" value="<?php echo $id; ?>"/>
                                                    <select type="text" placeholder="Pp Kodebarang" name="txtPpKodebarangHeader[]" id="txtPpKodebarangHeader" class="form-control cm_select2" value="">
                                                    <option selected value="<?php echo $PPDetail['pp_kode_barang']; ?>"><?php echo $PPDetail['pp_kode_barang']; ?></option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Jumlah" name="txtPpJumlahHeader[]" id="txtPpJumlahHeader" class="form-control " value="<?php echo $PPDetail['pp_jumlah']; ?>"/>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Satuan" name="txtPpSatuanHeader[]" id="txtPpSatuanHeader" class="form-control" value="<?php echo $PPDetail['pp_satuan']; ?>"/>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Nama Barang" name="txtPpNamaBarangHeader[]" id="txtPpNamaBarangHeader" class="form-control" value="<?php echo $PPDetail['pp_nama_barang']; ?>"/>
                                                </td>

                                                <td>
                                                    <input value="<?php echo $PPDetail['pp_branch'] ?>" type="text" placeholder="Pp Branch" name="txtPpBranchHeader[]" id="txtPpBranchHeader" class="form-control cm_branch" />
                                                </td>

                                                <td>
                                                    <input value="<?php echo $PPDetail['pp_cost_center'] ?>" type="text" placeholder="Pp Cost Center" name="txtPpCostCenterHeader[]" id="txtPpCostCenterHeader" class="form-control cm_costCenter" />
                                                </td>

                                                <td>
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpNbdHeader[]" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpNbdHeader" value="<?php echo date('d M Y', strtotime($PPDetail['pp_nbd'])) ?>"/>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Keterangan" name="txtPpKeteranganHeader[]" id="txtPpKeteranganHeader" class="form-control" value="<?php echo $PPDetail['pp_keterangan']; ?>"/>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Supplier" name="txtPpSupplierHeader[]" id="txtPpSupplierHeader" class="form-control" value="<?php echo $PPDetail['pp_supplier']; ?>"/>
                                                </td>
                                                <td><a href='' class="btn btn-primary btn-sm delete-row-update-printpp" data-id="<?php echo $encrypted_lines_id; ?>"><i class="fa fa-minus"></i></a></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                         </table> 

                                        <table width="100%">
                                            <tr>
                                                <td colspan="8">
                                                    <center>
                                                        <a style="margin: 10px; width: 100px;" onclick="window.history.back()" class="btn btn-primary">Back</a>
                                                        <button style="margin: 10px; width: 100px;" class="btn btn-primary">Save</button>
                                                    </center>
                                                </td>
                                            </tr>
                                        </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>