<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-5">
                            <div class="text-right"><h1><b>Kecelakaan Kerja</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#mpk_mdladdrk">
                                    <i class="icon-plus icon-2x"></i>
                                </button>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="col-md-1" style="padding-left: 0px;">
                                        <label style="margin-top: 5px;">periode</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" id="mpk_rkpr" value="<?=$pr?>">
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" id="mpk_btnshwtbl">
                                            Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: 20px;" id="mpk_rkdivtbl">
                                    <div style="" class="col-md-12 text-center">
                                        <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="mpk_mdladdrk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Tambah Data</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="mpk_frmrkc">
                <label>Noind</label>
                <select style="width: 100%" class="form-control mpk_slcpkj" name="noind">
                    <option></option>
                    <?php foreach ($pkj as $key): ?>
                        <option value="<?=$key['pekerja']?>"><?=$key['pekerja']?></option>    
                    <?php endforeach ?>
                </select>
                <label>Seksi</label>
                <input disabled="" class="form-control diz">
                <label>Departemen</label>
                <input disabled="" class="form-control diz">
                <label>Tanggal</label>
                <input class="form-control mpk_rknopr" style="width: 300px;" name="tanggal">
                <label>Keterangan</label>
                <br>
                <select class="form-control mpk_slcpkjcas" style="width: 300px;" name="keterangan">
                    <option value="Ringan">Ringan</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Berat">Berat</option>
                </select>
                <br>
                <label>Kondisi</label>
                <input class="form-control" name="kondisi">
                <label>Penyebab</label>
                <input class="form-control" name="penyebab">
                <label>Tindakan</label>
                <input class="form-control" name="tindakan">
            </form>
            </div>
            <div class="modal-footer">
                <label style="color: red; float: left;">*Pastikan Data Sudah Sesuai</label>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="mpk_btnsbfrm">Submit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mpk_mdluprk" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Edit Data</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="mpk_frmrkcup">
                <label>Noind</label>
                <select style="width: 100%" class="form-control mpk_slcpkj" name="noind">
                    <option></option>
                    <?php foreach ($pkj as $key): ?>
                        <option value="<?=$key['pekerja']?>"><?=$key['pekerja']?></option>    
                    <?php endforeach ?>
                </select>
                <label>Seksi</label>
                <input disabled="" class="form-control diz">
                <label>Departemen</label>
                <input disabled="" class="form-control diz">
                <label>Tanggal</label>
                <input class="form-control mpk_rknopr" style="width: 300px;" name="tanggal">
                <label>Keterangan</label>
                <br>
                <select class="form-control mpk_slcpkjcas" style="width: 300px;" name="keterangan">
                    <option value="Ringan">Ringan</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Berat">Berat</option>
                </select>
                <br>
                <label>Kondisi</label>
                <input class="form-control mpkinf" name="kondisi">
                <label>Penyebab</label>
                <input class="form-control mpkinf" name="penyebab">
                <label>Tindakan</label>
                <input class="form-control mpkinf" name="tindakan">
                <input hidden="" name="id" id="mpk_idrkk">
            </form>
            </div>
            <div class="modal-footer">
                <label style="color: red; float: left;">*Pastikan Data Sudah Sesuai</label>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="mpk_btnupfrm">Update</button>
            </div>
        </div>
    </div>
</div>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
window.addEventListener("load", function(){
    $('#mpk_btnshwtbl').click();
    loadingOnAjax('#surat-loading');
});
</script>