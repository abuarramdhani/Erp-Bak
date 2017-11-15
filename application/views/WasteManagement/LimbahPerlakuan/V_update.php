<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('WasteManagement/LimbahPerlakuan/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('WasteManagement/LimbahPerlakuan/');?>">
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
                                <div class="box-header with-border">Update Limbah Perlakuan</div>
                                <?php
                                    foreach ($LimbahPerlakuan as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label class="control-label col-lg-4">Id Limbah Perlakuan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" value="<?php echo $headerRow['id_perlakuan']; ?>" disabled/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="txtLimbahPerlakuanHeader" class="control-label col-lg-4">Limbah Perlakuan</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Limbah Perlakuan" name="txtLimbahPerlakuanHeader" id="txtLimbahPerlakuanHeader" class="form-control" value="<?php echo $headerRow['limbah_perlakuan']; ?>"/>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>