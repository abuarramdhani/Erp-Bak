<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b><?= $Title ?></b></h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PolaShiftSeksi/TukarShift'); ?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <span><br /></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-md-12">
                                    Create Tukar Shift
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-12" style="margin-bottom: 2em;">
                                        <button class="btn btn-primary" onclick="start_introjs()" style="background-color: #007bff; border-color: #007bff;">
                                            <i class="fa fa-mouse-pointer"></i>
                                            Intro Aplikasi
                                        </button>
                                        <!-- <a href="#" class="btn btn-primary" style="background-color: #ffc107; border-color: #ffc107; color: black;">
                                            <i class="fa fa-book"></i>
                                            User Manual
                                        </a>
                                        <a href="#" class="btn btn-primary" style="background-color: #28a745; border-color: #28a745;">
                                            <i class="fa fa-video-camera"></i>
                                            Video Panduan
                                        </a> -->
                                    </div>
                                    <form action="<?php echo base_url('PolaShiftSeksi/TukarShift/saveTS') ?>" method="post">
                                        <div class="row">
                                            <div class="col-md-12" data-step="1" data-intro="Pilih tanggal yang akan ditukar shiftnya">
                                                <div class="col-md-3">
                                                    <label style="margin-top: 5px;">Tanggal</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control ts_datePick pss_dis_cht" name="tgl_tukar" placeholder="Masukan tanggal (dd-mm-yyyy)" />
                                                </div>
                                            </div>
                                            <div class="col-md-12" data-step="2" data-intro="Pilih apakah akan menukar shift dengan pekerja lain atau bukan" style="margin-top: 10px;">
                                                <div class="col-md-3">
                                                    <label style="margin-top: 5px;">Tukar dengan Pekerja lain ?</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="col-md-5">
                                                        <input type="radio" class="" name="tukarpekerja" value="ya" /> Ya
                                                    </label>
                                                    <label class="col-md-5">
                                                        <input checked type="radio" class="pss_dis_ch" name="tukarpekerja" value="tidak" /> Tidak
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12" data-step="3" data-intro="Pilih apakah tukar shift adalah inisiatif perusahaan atau pribadi" style="margin-top: 10px;">
                                                <div class="col-md-3">
                                                    <label style="margin-top: 5px;">Inisiatif Perusahaan ?</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="col-md-5">
                                                        <input type="radio" class="pss_set_range" name="inisiatif" value="perusahaan" /> Perusahaan
                                                    </label>
                                                    <label class="col-md-5">
                                                        <input checked type="radio" class="pss_dis_ch pss_set_range" name="inisiatif" value="pribadi" /> Pribadi
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center" style="margin-top: 20px;">
                                                <button data-step="4" data-intro="Klik tombol untuk menampilkan tampilan memilih pekerja yang akan ditukar shiftnya" type="button" class="btn btn-primary" id="btn_next_tukar">Next</button>
                                            </div>
                                            <div class="col-md-12 pss_formPekerja" style="margin-top: 50px;">
                                            </div>
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
<div id="surat-loading" hidden style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="<?php echo site_url('assets/img/gif/loadingtwo.gif'); ?>" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script>
    $(() => {
        $('#btn_next_tukar').click()
        introJs.fn.onchange(function(e) {
            const step = this._currentStep
            console.log(step)
            switch (step) {
                case 3:
                    (() => {
                        $('#btn_next_tukar').trigger('click')
                        // introJs.fn.addStep({
                        //     element: $('body'),
                        //     intro: '',
                        // })
                    })()
                    break
                case 4:
                    (() => {
                        introJs().addSteps([{
                            element: $('#pss_data_pkj_1 > div').next(),
                            intro: "Pilih pekerja yang akan ditukar shiftnya"
                        }, {
                            element: $('#pss_data_pkj_2 > div').next(),
                            intro: "Jika memilih tukar dengan pekerja lain, maka pilih pekerja yang akan ingin ditukar shiftnya"
                        }, {
                            element: $('select[name=atasan'),
                            intro: "Pilih atasan untuk mengapprove tukar shift yang akan dibuat"
                        }, {
                            element: $('#pss_submit_tukar'),
                            intro: "Klik tombol jika data sudah diisi dengan benar"
                        }])
                    })
                    break;
            }
        })

    })

    function start_introjs() {
        introJs().start()
    }
</script>