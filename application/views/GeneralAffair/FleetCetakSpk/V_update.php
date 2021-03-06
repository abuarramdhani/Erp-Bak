<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetCetakSpk/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetCetakSpk/');?>">
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
                                <div class="box-header with-border">Update Fleet Cetak Spk</div>
                                <?php
                                    foreach ($FleetCetakSpk as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">No Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                if ($headerRow['kendaraan_id'] == $row['kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kendaraan_id'].'" '.$selected_data.'>'.$row['nomor_polisi'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalMaintenanceHeader" class="control-label col-lg-4">Tanggal Maintenance</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalMaintenanceHeader" value="<?php echo date('d-m-Y', strtotime($headerRow['tanggal_maintenance'])) ?>" class="date form-control ManajemenKendaraan-daterangepickersingledatewithtime" data-date-format="yyyy-mm-dd" id="txtTanggalMaintenanceHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbMaintenanceKategoriIdHeader" class="control-label col-lg-4">Maintenance Kategori</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMaintenanceKategoriIdHeader" name="cmbMaintenanceKategoriIdHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMaintenanceKategori as $row) {
                                                                if ($headerRow['maintenance_kategori_id'] == $row['maintenance_kategori_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['maintenance_kategori_id'].'" '.$selected_data.'>'.$row['maintenance_kategori'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbIdBengkelHeader" class="control-label col-lg-4">Bengkel</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbIdBengkelHeader" name="cmbIdBengkelHeader" class="select select2" data-placeholder="Choose an option" style="width: 100%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetBengkel as $row) {
                                                                if ($headerRow['id_bengkel'] == $row['bengkel_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['bengkel_id'].'" '.$selected_data.'>'.$row['nama_bengkel'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtNoSuratHeader" class="control-label col-lg-4">No Surat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="No Surat" name="txtNoSuratHeader" id="txtNoSuratHeader" class="form-control" value="<?php echo $headerRow['no_surat']; ?>"/>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="lines_ga_fleet_maintenance_kendaraan_detail">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Fleet Cetak SPK</div>
                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table id="tblFleetMaintenanceKendaraanDetail" class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px">No</th>
                                                                                    <th style="text-align:center;">Action</th>
                                                                                    <th style="text-align:center;">Jenis Maintenance</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailMaintenanceKendaraan">
                                                                                <?php
                                                                                    $no = 1;
                                                                                    if(count($FleetCetakSpkDetail) > 0):
                                                                                    foreach($FleetCetakSpkDetail as $lines1_row):
                                                                                    $encrypted_string = $this->encrypt->encode($lines1_row['spk_detail_id']);     
                                                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                                                ?>
                                                                                <tr>
                                                                                    <td style="text-align:center; width:30px">
                                                                                        <?php echo $no++ ?> 
                                                                                    </td>
                                                                                    <td align="center" width="60px">
                                                                                        <a class="del-row btn btn-xs btn-danger deleteSPKDetail" data-toggle="tooltip" data-placement="bottom" title="Delete Data"  data-id="<?php echo $encrypted_string ?>"><span class="fa fa-times"></span></a>
                                                                                        <input type="hidden" name="FleetSPKIdDetail[]" value="<?php echo $encrypted_string ?>" class="form-control" id="FleetSPKIdDetail" />
                                                                                    </td>
                                                                                    
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Jenis Maintenance" name="txtJenisMaintenanceSPK[]" id="txtJenisMaintenanceSPK" class="form-control" value="<?php echo $lines1_row['jenis_maintenance']; ?>"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach; ?>
                                                                                <?php else: ?>
                                                                                <tr>
                                                                                    <td style="text-align:center; width:30px">1</td>
                                                                                    <td align="center" width="60px">
                                                                                        <a class="del-row btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Data"><span class="fa fa-times"></span></a>
                                                                                    </td>
                                                                                    
                                                                                    <td>
                                                                                        <div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Jenis Maintenance" name="txtJenisMaintenanceLine1[]" id="txtJenisMaintenanceLine1" class="form-control"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endif; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <a class="add-row btn btn-sm btn-success" onclick="TambahBarisCetakSPK()"><i class="fa fa-plus"></i> Add New</a>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>