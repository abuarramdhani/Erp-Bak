<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetMaintenanceKendaraan/create');?>" class="form-horizontal">
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
                                <div class="box-header with-border">Create Fleet Maintenance Kendaraan</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                echo '<option value="'.$row['nomor_polisi'].'" >'.$row['kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtTanggalMaintenanceHeader" class="control-label col-lg-4">Tanggal Maintenance</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalMaintenanceHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalMaintenanceHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKilometerMaintenanceHeader" class="control-label col-lg-4">Kilometer Maintenance</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kilometer Maintenance" name="txtKilometerMaintenanceHeader" id="txtKilometerMaintenanceHeader" class="form-control" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="cmbMaintenanceKategoriIdHeader" class="control-label col-lg-4">Maintenance Kategori Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbMaintenanceKategoriIdHeader" name="cmbMaintenanceKategoriIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetMaintenanceKategori as $row) {
                                                                echo '<option value="'.$row['maintenance_kategory'].'" >'.$row['maintenance_kategori_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtEndDateHeader" class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateHeader" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateHeader" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaAlasanHeader" class="control-label col-lg-4">Alasan</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaAlasanHeader" id="txaAlasanHeader" class="form-control" placeholder="Alasan"></textarea>
                                                </div>
                                            </div>


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
																					<th style="text-align:center;">Start Date</th>
																					<th style="text-align:center;">End Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
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
                                                                                            <input type="text" placeholder="Biaya" name="txtBiayaLine1[]" id="txtBiayaLine1" class="form-control"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateLine1[]" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateLine1" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateLine1[]" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateLine1" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <a class="add-row btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>