<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetMaintenanceKendaraan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetMaintenanceKendaraan/');?>">
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
                                <div class="box-header with-border">Update Fleet Maintenance Kendaraan</div>
                                <?php
                                    foreach ($FleetMaintenanceKendaraan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select2" data-placeholder="Choose an option" style="width: 75%">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                if ($headerRow['kode_kendaraan'] == $row['kode_kendaraan']) {
                                                                    $selected_data = "selected";
                                                                } 
                                                                else 
                                                                {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['kode_kendaraan'].'" '.$selected_data.'>'.$row['nomor_polisi'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalMaintenanceHeader" class="control-label col-lg-4">Tanggal Maintenance</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalMaintenanceHeader" value="<?php echo $headerRow['tanggal_maintenance'] ?>" class="date form-control" id="daterangepickersingledatewithtime" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKilometerMaintenanceHeader" class="control-label col-lg-4">Kilometer Maintenance</label>
                                                <div class="col-lg-4">
                                                    <input type="number" step="0.01" placeholder="Kilometer Maintenance" name="txtKilometerMaintenanceHeader" id="txtKilometerMaintenanceHeader" class="form-control" value="<?php echo $headerRow['kilometer_maintenance']; ?>"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbMaintenanceKategoriIdHeader" class="control-label col-lg-4">Kategori Maintenance</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMaintenanceKategoriIdHeader" name="cmbMaintenanceKategoriIdHeader" class="select2" data-placeholder="Choose an option" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMaintenanceKategori as $row) {
                                                                if ($headerRow['kode_kategori_kendaraan'] == $row['kode_kategori_maintenance']) {
                                                                    $selected_data = "selected";
                                                                } 
                                                                else 
                                                                {
                                                                    $selected_data = "";   
                                                                }                                                                
                                                                echo '<option value="'.$row['kode_kategori_maintenance'].'" '.$selected_data.' >'.$row['kategori_maintenance'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                           </div>


											<div class="form-group">
                                                <label for="txaAlasanHeader" class="control-label col-lg-4">Alasan</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaAlasanHeader" id="txaAlasanHeader" class="form-control" placeholder="Alasan"><?php echo $headerRow['alasan']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Waktu Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo $headerRow['waktu_dibuat'];?>" name="txtStartDateHeader" value="<?php echo $headerRow['waktu_dibuat'] ?>" class="date form-control" data-date-format="dd-mm-yyyy H:i:s" id="txtStartDateHeader" disabled=""/>
                                                </div>
                                            </div>
                                            <?php
                                                if(substr($kodesie, 0, 5)=='10103')
                                                    {
                                            ?>
                                            <div class="form-group">
                                                <label for="txtTanggalNonaktif" class="control-label col-lg-4">Aktif</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="CheckAktif" id="CheckAktif" <?php if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?>>
                                                    <input type="text" name="WaktuDihapus" id="WaktuDihapus" hidden="" value="<?php echo $headerRow['waktu_dihapus'];?>">
                                                </div>

                                            </div>
                                            <?php
                                                }
                                            ?>                                             


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
														<li class="active"><a href="#lines_ga_fleet_maintenance_kendaraan_detail" data-toggle="tab">Fleet Maintenance Kendaraan Detail</a></li>
                                                    </ul>
                                                    <div class="tab-content">
														<div class="tab-pane active" id="lines_ga_fleet_maintenance_kendaraan_detail">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Fleet Maintenance Kendaraan Detail</div>
                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table id="tblFleetMaintenanceKendaraanDetail" class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px">No</th>
                                                                                    <th style="text-align:center;">Action</th>
																					<th style="text-align:center;">Jenis Maintenance</th>
																					<th style="text-align:center;">Biaya</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailMaintenanceKendaraan">
                                                                                <?php
                                                                                    $no = 1;
                                                                                    if(count($FleetMaintenanceKendaraanDetail) > 0):
                                                                                    foreach($FleetMaintenanceKendaraanDetail as $lines1_row):
                                                                                    $encrypted_string = $this->encrypt->encode($lines1_row['maintenance_kendaraan_detail_id']);		
                                                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                                                ?>
                                                                                <tr>
                                                                                    <td style="text-align:center; width:30px">
                                                                                        <?php echo $no++ ?> 
                                                                                    </td>
                                                                                    <td align="center" width="60px">
                                                                                        <a class="del-row btn btn-xs btn-danger deleteUpdate" data-toggle="tooltip" data-placement="bottom" title="Delete Data"  data-id="<?php echo $encrypted_string ?>"><span class="fa fa-times"></span></a>
                                                                                        <input type="hidden" name="hdnMaintenanceKendaraanDetailId[]" value="<?php echo $encrypted_string ?>" class="form-control" id="hdnMaintenanceKendaraanDetailId" />
                                                                                    </td>
                                                                                    
																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Jenis Maintenance" name="txtJenisMaintenanceLine1[]" id="txtJenisMaintenanceLine1" class="form-control" value="<?php echo $lines1_row['jenis_maintenance']; ?>"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Biaya" name="txtBiayaLine1[]" id="txtBiayaLine1" class="form-control input_money" value="<?php echo $lines1_row['biaya']; ?>"/>
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

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Biaya" name="txtBiayaLine1[]" id="txtBiayaLine1" class="form-control input_money"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endif; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <a class="add-row btn btn-sm btn-success" onclick="TambahBarisMaintenanceKendaraan()"><i class="fa fa-plus"></i> Add New</a>
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