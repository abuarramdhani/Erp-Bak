<section class="content" id="mcc_here">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-md-12">

                                </div>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="row">
                                        <form id="mcc_frm">
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                    <label style="margin-top: 5px;">Seksi</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_seksi">
                                                        <option></option>
                                                        <?php foreach ($seksi as $s): ?>
                                                            <option value="<?= $s['kodesie']?>"><?= $s['kodesie'].' - ' .$s['seksi']?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <div class="col-md-2">
                                                    <label style="margin-top: 5px;">Cost Center</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_cc">
                                                        <option></option>
                                                        <?php foreach ($cc as $c): ?>
                                                            <option value="<?= $c['CC'].' | '.$c['DSCR']?>"><?= '['.$c['CC'].'] - '.$c['DSCR']?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <div class="col-md-2">
                                                    <label style="margin-top: 5px;">Branch</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_branch">
                                                        <option></option>
                                                        <?php foreach ($branch as $b): ?>
                                                            <option value="<?= $b['FLEX_VALUE']?>"><?= '['.$b['FLEX_VALUE'].'] - '.$b['DESCRIPTION']?></option>    
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-top: 10px;">
                                                <div class="col-md-2">
                                                    <label style="margin-top: 5px;">Jenis Akun</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_akun">
                                                        <option></option>
                                                        <option value="0">Non Produksi</option>
                                                        <option value="1">Produksi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <div class="col-md-8 text-right">
                                                <button class="btn btn-success" id="mccsl"><i class="fa fa-plus"></i> Tambah</button>
                                                <button disabled="" style="display: none;" class="btn btn-success mccbtnhid" id="mccsaveed"><i class="fa fa-check"></i> Save Edit</button>
                                                <button style="display: none;" class="btn btn-danger mccbtnhid" id="mccbtled"><i class="fa fa-remove"></i> Batal</button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 text-center" id="mcctbl" style="margin-top: 20px;">
                                           <img id="mcc_imgw" style="width: 20%;" src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>">
                                       </div>
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
<div id="surat-loading" hidden="" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    window.addEventListener('load', function () {
        setTimeout(
            function() 
            {
                mcc_showTbl();
            }, 1000);
    });
</script>