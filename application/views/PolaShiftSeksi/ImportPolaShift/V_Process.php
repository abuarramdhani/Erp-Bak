<!-- 
Dokumentasi 
Data di inputkan ke table t_shift_pekerja melalui ajax di js paling bawah
tidak menggunakan form submit agak ribet tapi sebenernya enggak :D

Pekerja yang ada di list $gakDue di skip karena tidak memilikki shift
-->
<section class="content">
    <div class="inner" >
        <div class="row">
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
                            <div class="box-header with-border"></div>
                            <div class="box-body">
                                <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                    <?php if (!empty($singGakDue)): ?>
                                        <div class="callout callout-danger">
                                            <label>Pekerja yang belum tergenerate shiftnya :</label>
                                            <?php foreach ($singGakDue as $r): ?>
                                                <p><?= $r ?></p>
                                            <?php endforeach ?>
                                            <label>Silahkan hubungi EDP (15113) untuk generate shift pekerja diatas</label>
                                        </div>    
                                    <?php endif ?>
                                </div>
                                <div class="col-md-12" style="padding-left: 0px; margin-bottom: 20px;">
                                    <div class="col-md-6" style="padding-left: 0px;">
                                    <div class="form-group">
                                        <label for="txtKodesieBaru" class="col-md-3 control-label" style="margin-top: 5px; padding-left: 0px;">Pilih Atasan :</label>
                                        <div class="col-lg-8">
                                            <!-- required name="kodeseksi" -->
                                            <select class="form-control ips_get_atasan" style="width: 100%">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <h4 style="font-weight: bold;">Periode <?php echo $pr ?></h4>
                                <!-- <h4 style="font-weight: bold;">Seksi <?php echo $ks.' - '.$seksi[0]['daftar_tseksi'] ?></h4> -->
                                <table class="table table-striped table-bordered table-hover tabel_polashift">
                                    <thead>
                                        <tr class="">
                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">No</th>
                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Noind</th>
                                            <th class="text-center" style="vertical-align: middle;" rowspan="2">Nama</th>
                                            <th class="text-center" style="vertical-align: middle;" colspan="31">Tanggal</th>
                                        </tr>
                                        <tr class="">
                                            <?php foreach ($head as $h): ?>
                                                <th data-orderable="false" class="text-center ips_head" style="vertical-align: middle;"><?php echo $h ?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($document as $key) {
                                            if (in_array($key['noind'], $gakDue)) {
                                                continue;
                                            }
                                            ?>
                                            <tr class="ips_tr">
                                                <td style="text-align: center;"><?php echo $no; ?></td>
                                                <td class="ips_noind"><?php echo $key['noind']; ?></td>
                                                <td><?php echo $key['nama']; ?></td>
                                                <?php foreach ($key['shift'] as $sh) { ?>
                                                <td class="ips_sh"><?php echo $sh; ?></td>
                                                <?php } ?>
                                            </tr> 
                                            <?php
                                            $no++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer">
                                <div class="row text-right" style="padding-right: 20px;">
                                    <a style="margin-right: 5px;" href="javascript:history.back(1)" class="btn btn-warning btn-lg btn-rect">Back</a>
                                    <button disabled="" type="button" class="btn btn-success btn-lg btn-rect btn_ips_save">Save Data</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<span id="ips_span_hidd" hidden="" data-pr="<?php echo $pr ?>" data-ks="<?php //echo $ks ?>"></span>
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif');?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
//submit data menggunakan ajax ada di custom pss
    $(document).ready(function(){
        var pr = $('#ips_span_hidd').attr('data-pr');
        // var ks = $('#ips_span_hidd').attr('data-ks');
        $('#surat-loading').attr('hidden', false);
        //get tgl
        var ips_tgl = [];
        $('.ips_head').each(function(){
            let tx = $(this).text();
            ips_tgl.push(tx);
        });
        //get noind
        var noind = []
        $('.ips_noind').each(function(){
            let tx = $(this).text();
            noind.push(tx);
        });
        //get array shift
        var sh = []
        sh.push([]);
        var x = 0;
        var y = 0;
        var nl = ips_tgl.length;
        $('.ips_sh').each(function(){
            if (x%nl == 0 && x !== 0) {
                sh.push([]);
                y++;
            }
            let tx = $(this).text();
            sh[y].push(tx);
            x++;
        });
        console.log('tgl',ips_tgl);
        console.log('noind', noind);
        console.log('sh', sh);
        $('#surat-loading').attr('hidden', true);
        // data dari V_Proses
        $('.btn_ips_save').click(function(){
            var atasan = $('.ips_get_atasan').val();
            // alert(atasan);
            $('#surat-loading').attr('hidden', false);
            $.ajax({
                url: baseurl + 'PolaShiftSeksi/ImportPolaShift/save_ods',
                type: "post",
                data: {tgl: ips_tgl, noind: noind, shift: sh, pri: pr, atasan: atasan},
                success: function (response) {
                    $('#surat-loading').attr('hidden', true);
                    ips_swetAlert();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
           });
        });
    });
</script>