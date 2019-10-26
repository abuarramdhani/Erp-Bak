<section class="content">
    <div class="inner" >
        <div class="row">
            <form id="MasterPekerja-SuratUsiaLanjut-FormCreate" method="post" action="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>" class="form-horizontal" >
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/ImportPolaShift');?>">
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
                                <div class="box-header with-border">Create Surat Pemberitahuan Usia Lanjut</div>
                                    <div class="box-body">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="txtTanggalCetak" class="col-lg-4 control-label">Periode Shift</label>
                                                        <div class="col-lg-8">
                                                           <input class="form-control p2k3_tanggal_periode"  autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" placeholder="Masukkan Periode" value=""/>
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label for="txtKodesieBaru" class="col-lg-4 control-label">Seksi</label>
                                                        <div class="col-lg-8">
                                                            <select required name="txtKodesieBaru" class="mpk-kdbaru select2" id="MasterPekerja-DaftarSeksi" style="width: 100%">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                     <div class="form-group">
                                                        <label class="form-label text-center col-lg-12">Upload Document Approval</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lb_approval" class="control-label col-lg-4">Document Approval : </label>
                                                        <div class="col-lg-7">
                                                            <div class="input-group ">
                                                                <input type="file" name="k3_approval" class="form-control" required/>
                                                            </div>
                                                        </div>
                                                            
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-12 text-center">
                                                            <button type="submit" class="btn btn-primary">Upload Approval</button>
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>