<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetKecelakaan/update/'.$id);?>" class="form-horizontal" enctype="multipart/form-data">
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
                                <div class="box-header with-border">Update Kecelakaan</div>
                                <?php
                                    foreach ($FleetKecelakaan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="cmbKendaraanIdHeader" class="control-label col-lg-4">Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbKendaraanIdHeader" name="cmbKendaraanIdHeader" class="select2" data-placeholder="Choose an option" style="width: 75%" required="">
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
                                                <label for="txtTanggalKecelakaanHeader" class="control-label col-lg-4">Tanggal Kecelakaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('Y-m-d')?>" name="txtTanggalKecelakaanHeader" value="<?php echo $headerRow['tanggal_kecelakaan'] ?>" class="date form-control ManajemenKendaraan-daterangepickersingledatewithtime" data-date-format="yyyy-mm-dd"  required="" value="<?php echo $headerRow['tanggal_kecelakaan'];?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaSebabHeader" class="control-label col-lg-4">Sebab</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaSebabHeader" id="txaSebabHeader" class="form-control" placeholder="Sebab" required="" ><?php echo $headerRow['sebab']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBiayaPerusahaanHeader" class="control-label col-lg-4">Biaya Perusahaan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Perusahaan" name="txtBiayaPerusahaanHeader" id="txtBiayaPerusahaanHeader" class="form-control input_money" value="<?php echo $headerRow['biaya_perusahaan']; ?>" required="" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtBiayaPekerjaHeader" class="control-label col-lg-4">Biaya Pekerja</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Biaya Pekerja" name="txtBiayaPekerjaHeader" id="txtBiayaPekerjaHeader" class="form-control input_money" value="<?php echo $headerRow['biaya_pekerja']; ?>" required="" />
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="cmbPekerjaHeader" class="control-label col-lg-4">Pekerja</label>
                                                <div class="col-lg-4">
                                                    <select id="cmbPekerjaHeader" name="cmbPekerjaHeader" class="select2" data-placeholder="Pilih" style="width: 75%" required="">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($EmployeeAll as $row) {
                                                                if($headerRow['id_pekerja'] == $row['id_pekerja'])
                                                                {
                                                                    $selected_data = "selected";
                                                                }
                                                                else
                                                                {
                                                                    $selected_data = "";
                                                                }
                                                                echo '<option value="'.$row['id_pekerja'].'" '.$selected_data.'>'.$row['daftar'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4">Asuransi</label>
                                                <?php
                                                    $asuransiYa     = '';
                                                    $asuransiTidak  = '';
                                                    $status_input   = 'disabled';
                                                    if($headerRow['status_asuransi']==1)
                                                    {
                                                        $asuransiYa     =   'checked';
                                                        $status_input   =   '';
                                                    }
                                                    elseif($headerRow['status_asuransi']==0)
                                                    {
                                                        $asuransiTidak  =   'checked';
                                                    }
                                                ?>
                                                <div class="col-lg-2">
                                                    <input type="radio" name="radioAsuransi" value="1" required="" <?php echo $asuransiYa;?>><label>Ya</label>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input type="radio" name="radioAsuransi" value="0" required="" <?php echo $asuransiTidak;?>><label>Tidak</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4"><span class="hidden">Asuransi</span></label>
                                                <div class="col-lg-2">
                                                    <label for='txtTanggalCekAsuransi' class="control-label">Tanggal Cek Asuransi</label>
                                                </div>
                                                <div class="col-lg-3">
                                                        <input type="text" name="txtTanggalCekAsuransi" id="ManajemenKendaraan-daterangepickersingledate" maxlength="10" class="date form-control" data-date-format="yyyy-mm-dd" required="" value="<?php echo $headerRow['tanggal_cek_asuransi'];?>" <?php echo $status_input;?>>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4"><span class="hidden">Asuransi</span></label>
                                                <div class="col-lg-2">
                                                    <label for='txtTanggalMasukBengkel' class="control-label">Tanggal Masuk Bengkel</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="text" maxlength="10" placeholder="<?php echo date('d-m-Y H:i')?>" name="txtTanggalMasukBengkel" class="ManajemenKendaraan-daterangepickersingledatewithtime date form-control" data-date-format="yyyy-mm-dd" required="" value="<?php echo $headerRow['tanggal_masuk_bengkel'];?>" <?php echo $status_input;?>/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4"><span class="hidden">Asuransi</span></label>
                                                <div class="col-lg-2">
                                                    <label for='txtTanggalMasukBengkel' class="control-label">Foto Masuk Bengkel</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="file" placeholder="Foto Masuk Bengkel" name="FotoMasukBengkel" id="FotoMasukBengkel" class="form-control" <?php echo $status_input;?>/>
                                                    <?php
                                                        if($status_input=='disabled')
                                                        {
                                                            echo '  <span class="hidden>"';
                                                        }
                                                    ?>
                                                    <a id="linkFotoMasukBengkel" target="_blank" href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$headerRow['foto_masuk_bengkel']);?>" <?php echo $status_input;?>><?php echo $headerRow['foto_masuk_bengkel'];?></a>
                                                    <input type="text" name="FotoMasukBengkelawal" id="FotoMasukBengkelawal" hidden="" value="<?php echo $headerRow['foto_masuk_bengkel'];?>">
                                                    <?php
                                                        if($status_input=='disabled')
                                                        {
                                                            echo '  </span>';
                                                        }
                                                    ?>
                                                </div>                                                
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4"><span class="hidden">Asuransi</span></label>
                                                <div class="col-lg-2">
                                                    <label for='txtTanggalKeluarBengkel' class="control-label">Tanggal Keluar Bengkel</label>
                                                </div>
                                                <div class="col-lg-3">
                                                        <input type="text" maxlength="10" placeholder="<?php echo date('d-m-Y H:i')?>" name="txtTanggalKeluarBengkel" class="ManajemenKendaraan-daterangepickersingledatewithtime date form-control" data-date-format="yyyy-mm-dd" required="" value="<?php echo $headerRow['tanggal_keluar_bengkel'];?>" <?php echo $status_input;?>/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="radioAsuransi" class="control-label col-lg-4"><span class="hidden">Asuransi</span></label>
                                                <div class="col-lg-2">
                                                    <label for='txtTanggalKeluarBengkel' class="control-label">Foto Keluar Bengkel</label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="file" placeholder="Foto Keluar Bengkel" name="FotoKeluarBengkel" id="FotoKeluarBengkel" class="form-control" <?php echo $status_input;?>/>
                                                    <?php
                                                        if($status_input=='disabled')
                                                        {
                                                            echo '  <span class="hidden>"';
                                                        }
                                                    ?>
                                                    <a id="linkFotoKeluarBengkel" target="_blank" href="<?php echo base_url('assets/upload/GA/Kendaraan/'.$headerRow['foto_keluar_bengkel']);?>" <?php echo $status_input;?>><?php echo $headerRow['foto_keluar_bengkel'];?></a>
                                                    <input type="text" name="FotoKeluarBengkelawal" id="FotoKeluarBengkelawal" hidden="" value="<?php echo $headerRow['foto_keluar_bengkel'];?>">
                                                    <?php
                                                        if($status_input=='disabled')
                                                        {
                                                            echo '  </span>';
                                                        }
                                                    ?>                                                    
                                                </div>                                                
                                            </div> 

                                            <div class="form-group">
                                                <label for="txtStartDateHeader" class="control-label col-lg-4">Waktu Dibuat</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="<?php echo $headerRow['waktu_dibuat'];?>" name="txtStartDateHeader" value="<?php echo $headerRow['waktu_dibuat'] ?>" class="date form-control" data-date-format="dd-mm-yyyy H:i:s" id="txtStartDateHeader" disabled=""/>
                                                    <input type="text" name="WaktuDihapus" id="WaktuDihapus" hidden="" value="<?php echo $headerRow['waktu_dihapus'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label for="txtTanggalNonaktif" class="control-label col-lg-4">Aktif</label>
                                                <div class="col-lg-4">
                                                    <input type="checkbox" name="CheckAktif" id="CheckAktif" <?php if($headerRow['waktu_dihapus']=='12-12-9999 00:00:00'){echo 'checked';};?>>
                                                    
                                                </div>

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
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="DetailKecelakaan">
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
                                                                                        <a class="del-row btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Data" onclick="delSpesifikRow(this)" data-id="<?php echo $encrypted_string ?>" id="deleteUpdateKecelakaan"><span class="fa fa-times"></span></a>
                                                                                        <input type="hidden" name="hdnKecelakaanDetailId[]" value="<?php echo $encrypted_string ?>" class="form-control" id="hdnKecelakaanDetailId" />
                                                                                    </td>
                                                                                    
																					<td>
																						<div class="form-group">
                                                                                            <div class="col-lg-12">
                                                                                            <input type="text" placeholder="Kerusakan" name="txtKerusakanLine1[]" id="txtKerusakanLine1" class="form-control" value="<?php echo $lines1_row['kerusakan']; ?>"/>
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

                                                                                </tr>
                                                                                <?php endif; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <a class="add-row btn btn-sm btn-success" onclick="TambahBarisKecelakaanDetail()"><i class="fa fa-plus"></i> Add New</a>
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