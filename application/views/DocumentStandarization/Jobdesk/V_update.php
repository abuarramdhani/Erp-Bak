<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('DocumentStandarization/Jobdesk/update/'.$id);?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/Jobdesk/');?>">
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
                                <div class="box-header with-border">Update Jobdesk</div>
                                <?php
                                    foreach ($Jobdesk as $headerRow):
                                ?>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label for="txtJdNameHeader" class="control-label col-lg-4">Jd Name</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Jd Name" name="txtJdNameHeader" id="txtJdNameHeader" class="form-control" value="<?php echo $headerRow['jd_name']; ?>"/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txaJdDetailHeader" class="control-label col-lg-4">Jd Detail</label>
                                                <div class="col-lg-4">
                                                    <textarea name="txaJdDetailHeader" id="txaJdDetailHeader" class="form-control" placeholder="Jd Detail"><?php echo $headerRow['jd_detail']; ?></textarea>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="txtKodesieHeader" class="control-label col-lg-4">Kodesie</label>
                                                <div class="col-lg-4">
                                                    <input type="text" placeholder="Kodesie" name="txtKodesieHeader" id="txtKodesieHeader" class="form-control" value="<?php echo $headerRow['kodesie']; ?>"/>
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
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>