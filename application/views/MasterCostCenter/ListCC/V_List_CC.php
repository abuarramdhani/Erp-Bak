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
                                        <div class="col-md-12 text-center" id="mcctbl" style="margin-top: 10px;">
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
<div class="modal fade" id="mcc_modal_edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLabel">Edit Data</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="mcc_frm">
                    <label style="margin-top: 5px;">Seksi</label>
                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_seksi">
                        <option></option>
                        <?php foreach ($seksi as $s): ?>
                            <option value="<?= $s['kodesie']?>"><?= $s['kodesie'].' - ' .$s['seksi']?></option>    
                        <?php endforeach ?>
                    </select>
                    <label style="margin-top: 5px;">Cost Center</label>
                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_cc">
                        <option></option>
                        <?php foreach ($cc as $c): ?>
                            <option value="<?= $c['CC'].' | '.$c['DSCR']?>"><?= '['.$c['CC'].'] - '.$c['DSCR']?></option>    
                        <?php endforeach ?>
                    </select>
                    <label style="margin-top: 5px;">Branch</label>
                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_branch">
                        <option></option>
                        <?php foreach ($branch as $b): ?>
                            <option value="<?= $b['FLEX_VALUE']?>"><?= '['.$b['FLEX_VALUE'].'] - '.$b['DESCRIPTION']?></option>    
                        <?php endforeach ?>
                    </select>
                    <label style="margin-top: 5px;">Jenis Akun</label>
                    <select style="width: 100%" class="form-control MCC_slc2" name="mcc_akun">
                        <option></option>
                        <option value="0">Non Produksi</option>
                        <option value="1">Produksi</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="mccsaveed" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </div>
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