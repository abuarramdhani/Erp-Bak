<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg">
                                    <i class="fa fa-list fa-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success box-solid">
                            <form name="Orderform" class="form-horizontal" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post" action="<?php echo site_url('Slideshow/UploadFile/Upload'); ?>">
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="col-md-4" style="text-align: right;"><label>Nama Slide Show</label></div>
                                        <div class="col-md-4"><input required placeholder="NAMA_SLIDE_SHOW" autocomplete="off" name="nm_slide_show" type="text" class="form-control"><span style="color: red;">*Gunakan tanda <b> " _ " (Underscore) </b> untuk memisahkan kata </span></div>
                                    </div>
                                    <div id="tambahfile">
                                        <div class="panel-body">
                                            <div class="col-md-4" style="text-align: right;"><label>Gambar</label></div>
                                            <div class="col-md-4"><input required type="file" name="gambarCov[]" class="form-control" accept=".jpg,.png,.jpeg"></div>
                                            <div class="col-md-2"><a class="btn btn-default" onclick="tambahfile()"><i class="fa fa-plus"></i></a></div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-md-12" style="text-align: center;"><button id="save_slide_show" class="btn btn-success">Save</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>