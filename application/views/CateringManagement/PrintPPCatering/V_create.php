<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('CateringManagement/PrintPPCatering/create');?>" class="form-horizontal">
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
                                <div class="box-header with-border">Create Printpp</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
    											<div class="form-group">
                                                    <label for="txtNoPpHeader" class="control-label col-lg-6">No PP</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="No Pp" name="txtNoPpHeader" id="txtNoPpHeader" class="form-control" style="width:100%" />
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtTglBuatHeader" class="control-label col-lg-6">Tanggal Dibuat</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="<?php echo date('d M Y')?>" name="txtTglBuatHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtTglBuatHeader" style="width:100%" />
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKepadaHeader" class="control-label col-lg-6">Kepada Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKepadaHeader" name="cmbPpKepadaHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="1">SUPPLIER</option>
                                                            <option value="2">SUBKONTRAKTOR</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpJenisHeader" class="control-label col-lg-6">Jenis PP</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpJenisHeader" name="cmbPpJenisHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="1">ASET</option>
                                                            <option value="2">NON ASET</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpNoProposalHeader" class="control-label col-lg-6">No Proposal Pengadaan Aset</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Pp No Proposal" name="txtPpNoProposalHeader" id="txtPpNoProposalHeader" class="form-control" style="width:100%"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpSeksiPemesanHeader" class="control-label col-lg-6">Seksi Pemesan</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpSeksiPemesanHeader" name="cmbPpSeksiPemesanHeader" class="select select2" data-placeholder="Choose an option" style="width:100%">
                                                            <option value=""></option>
                                                            <?php
                                                                foreach ($Section as $row) {
                                                                    echo '<option value="'.$row['er_section_id'].'" >'.$row['section_name'].'</option>';
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
                                                                    echo '<option value="'.$row['branch_id'].'" >'.$row['branch_code'].'</option>';
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
                                                                    echo '<option value="'.$row['cc_id'].'" >'.$row['cc_code'].'</option>';
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
                                                            <option value="1">PRODUKSI</option>
                                                            <option value="2">NON PRODUKSI</option>
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpSubInventHeader" class="control-label col-lg-6">Sub Inventory</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" value="EXP" name="txtPpSubInventHeader" id="txtPpSubInventHeader" class="disabled form-control" style="width:100%" disabled/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpSiepembelianHeader" class="control-label col-lg-6">Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpSiepembelianHeader" name="cmbPpSiepembelianHeader" class="select select-employee-batch select2" data-placeholder="Choose an option" style="width:100%">
                                                           <!--  <option value=""></option>
                                                            <?php
                                                                foreach ($EmployeeAll as $row) {
                                                                    echo '<option value="'.$row['employee_id'].'" >'.$row['employee_name'].'</option>';
                                                                }
                                                            ?> -->
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglSiepembelianHeader" class="control-label col-lg-6">Tgl Sie Pembelian</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglSiepembelianHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglSiepembelianHeader" style="width:100%"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpDireksiHeader" class="control-label col-lg-6">Direksi</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpDireksiHeader" name="cmbPpDireksiHeader" class="select select-employee-batch select2" data-placeholder="Choose an option" style="width:100%">
                                                           <!--  <option value=""></option>
                                                            <?php
                                                                foreach ($EmployeeAll as $row) {
                                                                    echo '<option value="'.$row['employee_id'].'" >'.$row['employee_name'].'</option>';
                                                                }
                                                            ?> -->
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglDireksiHeader" class="control-label col-lg-6">Tgl Direksi</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpTglDireksiHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglDireksiHeader" style="width:100%"/>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">

    											<div class="form-group">
                                                    <label for="cmbPpKadeptHeader" class="control-label col-lg-6">Kepala Departemen</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKadeptHeader" name="cmbPpKadeptHeader" class="select select-employee-batch select2" data-placeholder="Choose an option" style="width:100%">
                                                           <!--  <option value=""></option>
                                                            <?php
                                                                foreach ($EmployeeAll as $row) {
                                                                    echo '<option value="'.$row['employee_id'].'" >'.$row['employee_name'].'</option>';
                                                                }
                                                            ?> -->
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKadeptHeader" class="control-label col-lg-6">Tgl Kadept</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKadeptHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKadeptHeader" style="width:100%"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKaunitHeader" class="control-label col-lg-6">Kepala Unit</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKaunitHeader" name="cmbPpKaunitHeader" class="select select-employee-batch select2" data-placeholder="Choose an option" style="width:100%">
                                                            <!-- <option value=""></option>
                                                            <?php
                                                                foreach ($EmployeeAll as $row) {
                                                                    echo '<option value="'.$row['employee_id'].'" >'.$row['employee_name'].'</option>';
                                                                }
                                                            ?> -->
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKaunitHeader" class="control-label col-lg-6">Tgl Kaunit</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKaunitHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKaunitHeader" style="width:100%"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="cmbPpKasieHeader" class="control-label col-lg-6">Kasie / SPV</label>
                                                    <div class="col-lg-6">
                                                        <select id="cmbPpKasieHeader" name="cmbPpKasieHeader" class="select select-employee-batch select2" data-placeholder="Choose an option" style="width:100%">
                                                          
                                                        </select>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txtPpTglKasieHeader" class="control-label col-lg-6">Tgl Kasie</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="<?php echo date('d M Y')?>" name="txtPpTglKasieHeader" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPpTglKasieHeader" style="width:100%"/>
                                                    </div>
                                                </div>

    											<div class="form-group">
                                                    <label for="txaPpCatatanHeader" class="control-label col-lg-6">Catatan</label>
                                                    <div class="col-lg-6">
                                                        <textarea name="txaPpCatatanHeader" id="txaPpCatatanHeader" class="form-control" placeholder="Pp Catatan" style="width:100%"></textarea>
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
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPeriodeCateringAwalPP" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeCateringAwalPP" style="width:100%"/>
                                                    </div>
                                                    <label class="control-label col-lg-2">Periode Catering Akhir</label>
                                                    <div class="col-lg-2">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPeriodeCateringAkhirPP" class="pp-date date form-control" data-date-format="yyyy-mm-dd" id="txtPeriodeCateringAkhirPP" style="width:100%"/>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2">Lokasi</label>
                                                    <div class="col-lg-2">
                                                        <select class="select2" id="slcLokasiKateringPP" name="slcLokasiKateringPP" data-placeholder="Lokasi" style="width: 100%">
                                                            <option></option>
                                                            <option value="01">Yogyakarta & Mlati</option>
                                                            <option value="02">Tuksono</option>
                                                        </select>
                                                    </div>
                                                    <label class="control-label col-lg-2">Jenis Pesanan</label>
                                                    <div class="col-lg-2">
                                                        <select class="select2" id="slcJenisPesananPP" name="slcJenisPesananPP" data-placeholder="Jenis" style="width: 100%">
                                                            <option></option>
                                                            <option value="1">NASI BOX</option>
                                                            <option value="2">JASA BOGA (NON NASI BOX CATERING)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="button" class="btn btn-primary" id="btnProsesPP">Proses</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row2">
                                            <div class="col-md-12">
                                                <span id="add-row-printpp" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i></span>
                                                <input type="hidden" id="data_counter" name="txt_data_counter" value="0">
                                            </div>
                                        </div>
                                        <table id="printPP" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th width="15%"><center>Kode Barang</center></th>
                                                    <th width="10%"><center>Qty</center></th>
                                                    <th width="10%"><center>Satuan</center></th>
                                                    <th width="20%"><center>Nama Barang</center></th>
                                                    <th width="12%"><center>Branch</center></th>
                                                    <th width="12%"><center>Cost Center</center></th>
                                                    <th width="12%"><center>NBD</center></th>
                                                    <th width="18%"><center>Keterangan</center></th>
                                                    <th width="10%"><center>Supplier</center></th>
                                                    <th width="5%"><center>Action</center></th>
                                                </tr>
                                            </thead>

                                            <tbody id='printpp'>
                                            <tr class="multiRow">
                                                <td>
                                                    <select type="text" placeholder="Pp Kodebarang" name="txtPpKodebarangHeader[]" id="txtPpKodebarangHeader" class="form-control cm_select2" >
                                                        <option></option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Jumlah" name="txtPpJumlahHeader[]" id="txtPpJumlahHeader" class="form-control hapusaja" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Satuan" name="txtPpSatuanHeader[]" id="txtPpSatuanHeader" class="form-control hapusaja"  />
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
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d M Y')?>" name="txtPpNbdHeader[]" class="pp-date date form-control hapusaja" data-date-format="yyyy-mm-dd" id="txtPpNbdHeader" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Keterangan" name="txtPpKeteranganHeader[]" id="txtPpKeteranganHeader" class="form-control hapusaja" />
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="Pp Supplier" name="txtPpSupplierHeader[]" id="txtPpSupplierHeader" class="form-control hapusaja" />
                                                </td>
                                                <td><a href='' class="btn btn-primary btn-sm delete-row-printpp"><i class="fa fa-minus"></i></a></td>
                                            </tr>
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