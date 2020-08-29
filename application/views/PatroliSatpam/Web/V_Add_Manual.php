<style>
    th{
        text-align: center;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <label style="margin-top: 15px;">Add Input Manual</label>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                <form method="post" enctype="multipart/form-data" action="<?=base_url('PatroliSatpam/web/submit_manual')?>">
                                    <div class="col-md-12">
                                        <?php if (isset($aler)): ?>
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <label>Berhasil input Data!</label>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Waktu Scan (Tanggal & Jam)</label>
                                        <br>
                                        <input class="form-control pts_pckrwtime" style="width: 300px" name="waktu" required />
                                        <label>Pekerja / Satpam</label>
                                        <br>
                                        <select class="form-control" style="width: 300px" id="pts_slcallpkj" name="pkj" required=""></select>
                                        <br>
                                        <label>Ronde</label>
                                        <br>
                                        <select class="form-control pts_slcask" style="width: 300px" name="ronde" required/>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <br>
                                        <label>Pos</label>
                                        <br>
                                        <select class="form-control pts_slcask" style="width: 300px" name="pos" required id="pts_numpos" />
                                            <?php foreach ($pos as $key): ?>
                                                <option value="<?=$key?>"><?=$key?></option>    
                                            <?php endforeach ?>
                                        </select>
                                        <br>
                                        <label>Foto Barcode</label>
                                        <input class="form-control" name="barcode" type="file" style="width: 500px"/>
                                        <br>
                                        <label><input class="form-control" type="checkbox" id="pts_chckask" name="temuan"> Pertanyaan</label>
                                        <div id="pts_lstask">
                                            
                                        </div>
                                        <br><br>
                                        <label><input class="form-control" type="checkbox" id="pts_chcktmn" name="temuan"> Temuan</label>
                                        <br>
                                        <div id="pts_endisdiv">
                                            <label>Deskripsi</label>
                                            <textarea required="" class="form-control endis" name="deskripsi" disabled="" style="height: 100px; width: 500px;" /></textarea>
                                            <label>Foto</label>
                                            <input class="form-control endis" name="foto" type="file" disabled="" style="width: 500px" />
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 50px;">
                                        <button type="button" class="btn btn-warning btn-md">Back</button>
                                        <button style="margin-left: 20px;" class="btn btn-primary btn-md" name="for" value="redirect">Simpan</button>
                                        <button style="margin-left: 20px;" class="btn btn-primary btn-md" name="for" value="stay">Simpan & Lanjutkan Mengisi</button>
                                        <label style="color: red">* Pastikan Data sesuai sebelum melakukan Submit!</label>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>