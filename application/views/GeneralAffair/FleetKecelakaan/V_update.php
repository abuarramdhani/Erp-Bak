<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKecelakaan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetKecelakaan/');?>">
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
                                <div class="box-header with-border">Update Fleet Kecelakaan</div>
                                <?php
                                    foreach ($FleetKecelakaan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
<<<<<<< HEAD
                                        <div class="row">
=======
                                        <div class="row">
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
											<div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan Id</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($FleetKendaraan as $row) {
                                                                if ($headerRow['kendaraan_id'] == $row['kendaraan_id']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['nomor_polisi'].'" '.$selected_data.'>'.$row['kendaraan_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtTanggalKecelakaanHeader" class="control-label col-lg-4">Tanggal Kecelakaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKecelakaanHeader" value="<?php echo $headerRow['tanggal_kecelakaan'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtTanggalKecelakaanHeader" />
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txaSebabHeader" class="control-label col-lg-4">Sebab</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSebabHeader" id="txaSebabHeader" class="form-control" placeholder="Sebab"><?php echo $headerRow['sebab']; ?></textarea>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtBiayaPerusahaanHeader" class="control-label col-lg-4">Biaya Perusahaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Perusahaan" name="txtBiayaPerusahaanHeader" id="txtBiayaPerusahaanHeader" class="form-control" value="<?php echo $headerRow['biaya_perusahaan']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtBiayaPekerjaHeader" class="control-label col-lg-4">Biaya Pekerja</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Pekerja" name="txtBiayaPekerjaHeader" id="txtBiayaPekerjaHeader" class="form-control" value="<?php echo $headerRow['biaya_pekerja']; ?>"/>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4">Pekerja</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPekerjaHeader" name="cmbPekerjaHeader" class="select select2" data-placeholder="Choose an option">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($EmployeeAll as $row) {
                                                                if ($headerRow['pekerja'] == $row['pekerja']) {
                                                                    $selected_data = "selected";
                                                                } else {
                                                                    $selected_data = "";   
                                                                }
                                                                echo '<option value="'.$row['employee_name'].'" '.$selected_data.'>'.$row['employee_id'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Start Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateHeader" value="<?php echo $headerRow['start_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateHeader" />
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc

											<div class="form-group">
                                                <label for="txtEndDateHeader" class="control-label col-lg-4">End Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateHeader" value="<?php echo $headerRow['end_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateHeader" />
                                                </div>
<<<<<<< HEAD
                                            </div>
=======
                                            </div>
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc


                                        </div>

                                        <div class="col-lg-12">
                                            <br />
                                            <br />
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
														<li class="active"><a href="#lines_ga_fleet_kecelakaan_detail" data-toggle="tab">Fleet Kecelakaan Detail</a></li>
                                                    </ul>
                                                    <div class="tab-content">
														<div class="tab-pane active" id="lines_ga_fleet_kecelakaan_detail">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines of Fleet Kecelakaan Detail</div>
                                                                <div class="panel-body">
                                                                    <div class="table-responsive">
                                                                        <table id="tblFleetKecelakaanDetail" class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                            <thead>
                                                                                <tr class="bg-primary">
                                                                                    <th style="text-align:center; width:30px">No</th>
                                                                                    <th style="text-align:center;">Action</th>
																					<th style="text-align:center;">Kerusakan</th>
																					<th style="text-align:center;">Start Date</th>
																					<th style="text-align:center;">End Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                    $no = 1;
                                                                                    if(count($FleetKecelakaanDetail) > 0):
                                                                                    foreach($FleetKecelakaanDetail as $lines1_row):
                                                                                    $encrypted_string = $this->encrypt->encode($lines1_row['kecelakaan_detail_id']);		
                                                                                    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
                                                                                ?>
                                                                                <tr>
                                                                                    <td style="text-align:center; width:30px">
                                                                                        <?php echo $no++ ?> 
                                                                                    </td>
                                                                                    <td align="center" width="60px">
                                                                                        <a class="del-row btn btn-xs btn-danger disabled" data-toggle="tooltip" data-placement="bottom" title="Delete Data"><span class="fa fa-times"></span></a>
                                                                                        <input type="hidden" name="hdnKecelakaanDetailId[]" value="<?php echo $encrypted_string ?>" class="form-control" id="hdnKecelakaanDetailId" />
                                                                                    </td>
                                                                                    
																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Kerusakan" name="txtKerusakanLine1[]" id="txtKerusakanLine1" class="form-control" value="<?php echo $lines1_row['kerusakan']; ?>"/>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtStartDateLine1[]" value="<?php echo $lines1_row['start_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtStartDateLine1" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>

																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtEndDateLine1[]" value="<?php echo $lines1_row['end_date'] ?>" class="date form-control" data-date-format="yyyy-mm-dd" id="txtEndDateLine1" />
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
                                                                                            <input type="text" placeholder="Kerusakan" name="txtKerusakanLine1[]" id="txtKerusakanLine1" class="form-control"/>
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
                                                                                <?php endif; ?>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>