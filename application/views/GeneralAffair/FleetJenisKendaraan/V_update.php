<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('GeneralAffair/FleetJenisKendaraan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('GeneralAffair/FleetJenisKendaraan/');?>">
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
                                <div class="box-header with-border">Update Fleet Jenis Kendaraan</div>
                                <?php
                                    foreach ($FleetJenisKendaraan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
<<<<<<< HEAD
                                        <div class="row">
=======
                                        <div class="row">
>>>>>>> bf455b425468f660f3b48080e96612f78ed90ffc
											<div class="form-group">
                                                <label for="txtJenisKendaraanHeader" class="control-label col-lg-4">Jenis Kendaraan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jenis Kendaraan" name="txtJenisKendaraanHeader" id="txtJenisKendaraanHeader" class="form-control" value="<?php echo $headerRow['jenis_kendaraan']; ?>"/>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>