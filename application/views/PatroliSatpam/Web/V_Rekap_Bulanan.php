<style type="text/css">
    .pts_tblKS tbody tr td:nth-child(1),
    .pts_tblKS tbody tr td:nth-child(3)
    {
        text-align: center;
    }
    .pts_tblKS tbody tr td:nth-child(2)
    {
        text-align: left;
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
                    <?php if ($jenis == 'laporan'): ?>
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <label>Laporan Patroli</label>
                                    <button class="btn btn-danger btn-sm pull-right" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="<?= base_url('PatroliSatpam/web/cetak_laporan') ?>" target="_blank"
                                    onsubmit="setTimeout(function () { window.location.href = baseurl+'PatroliSatpam/web/rekap_bulanan'; }, 1)">
                                        <div class="panel-body">
                                            <div class="col-md-6 offset-col-md-6 row">
                                                <div class="col-md-3">
                                                    <label style="margin-top: 5px;">Periode</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <input required="" class="form-control pts_monthrange pts_loadKs" id="hmmm" name="periode" autocomplete="false" <?=$reon?> value="<?=$periode?>"/>
                                                </div> 
                                            </div>
                                            <div class="col-md-12" id="pts_alertCek">
                                                    
                                            </div>
                                            <div class="col-md-12 row" style="margin-top: 20px;">
                                                <div class="col-md-12">
                                                    <label>Kesimpulan</label>
                                                </div>
                                                <div class="col-md-12">
                                                    <textarea class="pts_kesimpulan"></textarea>
                                                </div>
                                                <div class="col-md-12 text-center" style="margin-top: 10px">
                                                    <button type="button" class="btn btn-success" id="pts_addKs">
                                                        Tambah Kesimpulan
                                                    </button>
                                                </div>
                                                <div class="col-md-12" style="margin-top: 20px;">
                                                    <table class="table table-bordered table-striped table-hover pts_tblKS">
                                                        <thead class="bg-primary">
                                                            <th style="width: 10px;">No</th>
                                                            <th style="text-align: center;">Kesimpulan</th>
                                                            <th style="width: 10px;">Action</th>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                <?php if (empty($periode)): ?>
                                                    <button type="submit" class="btn btn-primary">
                                                        Cetak Laporan
                                                    </button>
                                                <?php else: ?>
                                                    <button name="id" value="<?=$id?>" type="submit" class="btn btn-primary">
                                                        Update Temuan
                                                    </button>
                                                <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>                        
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header with-border">
                                    <label>Pertanyaan dan Temuan</label>
                                    <button class="btn btn-danger btn-sm pull-right" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <div class="box-body">
                                    <form method="post" action="<?= base_url('PatroliSatpam/web/cetak_temuan') ?>" target="_blank" onsubmit="setTimeout(function () { window.location.href = baseurl+'PatroliSatpam/web/rekap_temuan'; }, 1)">
                                        <div class="panel-body">
                                            <div class="col-md-12">
                                                <div class="col-md-1 row text-center">
                                                    <label style="margin-top: 5px;">Tanggal</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <input required="" class="form-control pts_tglrkp" id="hmmm" name="tgl" autocomplete="false"/>
                                                </div>
                                                <div class="col-md-4 text-left">
                                                    <label style="color: red; margin-top: 5px;">*Jangka Waktu maksimal 16 hari</label>
                                                </div> 
                                            </div>
                                            <div class="col-md-4 text-center" style="margin-top: 20px;">
                                                <a type="button" class="btn btn-warning" href="<?=base_url('PatroliSatpam/web/rekap_temuan')?>">
                                                    Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    Cetak Temuan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
               </div>
           </div>
       </div>
   </div>
</section>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<?php if (!empty($periode)): ?>
    <script>
        window.addEventListener('load', function () {
            $('.pts_loadKs').trigger('change');
        })
  </script>    
<?php endif ?>