<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('MasterPekerja/Surat/SuratLayout/add');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/Surat/SuratLayout/');?>">
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
                                <div class="box-header with-border">Create Layout Surat</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="txtJenisSurat" class="col-lg-2 control-label">Jenis Surat</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="txtJenisSurat" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="chkStaf" class="col-lg-2 control-label">Surat Staf</label>
                                                    <div class="col-lg-4">
                                                        <input type="checkbox" name="chk1" id="chkStaf"> Staf<br>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="txaFormatSurat" class="col-lg-2 control-label">Format Surat</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="txaFormatSurat" class="form-control" id="MasterPekerja-Surat-txaFormatSurat"></textarea>
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