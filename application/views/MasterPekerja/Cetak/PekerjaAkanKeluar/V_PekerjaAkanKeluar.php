<style>
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:before {
        bottom: .5em;
    }

    table#tb1.dataTable tbody tr:hover {
        background-color: #ffaa;
    }

    table#tb2.dataTable tbody tr:hover {
        background-color: #ffaa;
    }

    table#tb3.dataTable tbody tr:hover {
        background-color: #ffaa;
    }

    .red {
        background-color: red !important;
    }

    #box1 {
        height: 25px;
        width: 25px;
        background: #3059fc;
    }

    #box2 {
        height: 25px;
        width: 25px;
        background: #ed0707;
    }

    #box3 {
        height: 25px;
        width: 25px;
        background: #383434;
    }
</style>

<section class="content">
    <div class="panel panel-group">
        <div class="panel panel-primary">
            <div class="panel panel-heading">
                <h3>Data Pekerja Akan Keluar</h3>
            </div>
            <div class="panel panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="nav-tabs-custom" style="position: relative;">
                            <button class="btn btn-fullscreen hidden" style="position: absolute; top: 0; right: 1em;">
                                <ion-icon name="expand-outline"></ion-icon>
                                <i class="ion-android-contract"></i>
                            </button>
                            <ul class="nav nav-tabs">
                                <!-- Nav Tabs -->
                                <li class="active">
                                    <a href="#tab_1" role="tab" data-toggle="tab">Pekerja Akan Keluar</a>
                                </li>
                                <li class="">
                                    <a href="#tab_2" role="tab" data-toggle="tab">Pekerja Selesai Diperbantukan</a>
                                </li>
                                <li class="">
                                    <a href="#tab_3" role="tab" data-toggle="tab">Pekerja Dimutasi</a>
                                </li>
                            </ul>

                            <!-- Tab Panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" role="tabpanel" id="tab_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="inner-box bordered">
                                                <div class="form-group">
                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            <!-- checkbox -->
                                                            <label>
                                                                <input type="checkbox" class="minimal" id="cbOS">
                                                                Os
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label style="margin-bottom: 7px;">Asal os :</label>
                                                            <select class="form-control select2" style="width: 100%;" id="fcAsalOs" placeholder="-" disabled>
                                                                <?php foreach ($outSourcing as $os) : ?>
                                                                    <option><?= $os['asal_outsourcing'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r1" id="rP1" class="flat-blue"> Periode :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="reservation1" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r1" id="rB1" class="flat-blue">Per Bulan :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="datepicker1" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group" style="text-align: right;margin-top: 28px;">
                                                            <button type="button" class="btn btn-primary" id="btnCari">Cari</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <section class="col-md-12">
                                                    <div class="col-md-1" style="margin-top: 10px; float: left; margin-bottom: 20px;">
                                                        <button type="button" class="btn btn-success" id="tab1_excel">EXCEL</button>
                                                    </div>
                                                    <div class="col-md-1" style="margin-top: 10px; margin-bottom: 20px;">
                                                        <button type="button" class="btn btn-danger" id="tab1_pdf">PDF</button>
                                                    </div>
                                                </section>
                                                <section class="content">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="box">
                                                                <div class="box-body">
                                                                    <div class="table-responsive">
                                                                        <table id="tb1" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>No Induk</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Seksi</th>
                                                                                    <th>Unit</th>
                                                                                    <th>Bidang</th>
                                                                                    <th>Departemen</th>
                                                                                    <th>Masuk Kerja</th>
                                                                                    <th>Diangkat</th>
                                                                                    <th>Tanggal Keluar</th>
                                                                                    <th>Akhir Kontrak</th>
                                                                                    <th>Lama Kontrak</th>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Asal OS</th>
                                                                                    <th>Lokasi Kerja</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <?php $no = 1; ?>
                                                                                <!-- <?= date("Y-m-d"); ?> -->
                                                                                <?php foreach ($dataPersonal as $data) : ?>
                                                                                    <tr style="color: <?php if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 't') {
                                                                                                            echo "#fc0303";
                                                                                                        } else if ($data['tglkeluar'] > date("Y-m-d") && $data['keluar'] == 'f') {
                                                                                                            echo "#000";
                                                                                                        } else {
                                                                                                            echo "#3059fc";
                                                                                                        } ?>;">
                                                                                        <td><?= $no++ ?></td>
                                                                                        <td><?= $data['noind']; ?></td>
                                                                                        <td><?= $data['nama']; ?></td>
                                                                                        <td><?= $data['seksi']; ?></td>
                                                                                        <td><?= $data['unit'] ?></td>
                                                                                        <td><?= $data['bidang'] ?></td>
                                                                                        <td><?= $data['dept'] ?></td>
                                                                                        <td><?= $data['masukkerja'] ?></td>
                                                                                        <td><?= $data['diangkat'] ?></td>
                                                                                        <td><?= $data['tglkeluar'] ?></td>
                                                                                        <td><?= $data['akhkontrak'] ?></td>
                                                                                        <td><?= $data['lmkontrak'] ?></td>
                                                                                        <td><?= $data['ket'] ?></td>
                                                                                        <td><?= $data['asal_outsourcing'] ?></td>
                                                                                        <td><?= $data['lokasi_kerja'] ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                                <section>
                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box1"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang sudah keluar</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box2"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang harus diproses keluar</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box3"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang akan keluar</p>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="inner-box bordered">
                                                <div class="form-group">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <!-- checkbox -->
                                                            <label>
                                                                <input type="checkbox" class="minimal" id="cbOSperbantuan">
                                                                Outsourcing
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r2" id="rP2" class="flat-blue"> Periode :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="reservation2" placeholder="09/21/2020 - 09/21/2020" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r2" id="rB2" class="flat-blue">Per Bulan :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="datepicker2" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group" style="text-align: right;margin-top: 28px;">
                                                        <button type="button" class="btn btn-primary" id="btnCariDiperbantukan">Cari</button>
                                                    </div>
                                                </div>

                                                <section style="float: left;" class="col-md-12">
                                                    <div class="col-md-1" style="margin-top: 10px; margin-bottom: 20px;">
                                                        <button type="button" class="btn btn-success" id="tab2_excel">EXCEL</button>
                                                    </div>
                                                    <div class="col-md-1" style="margin-top: 10px; margin-bottom: 20px;">
                                                        <button type="button" class="btn btn-danger" id="tab2_pdf">PDF</button>
                                                    </div>

                                                </section>

                                                <section class="content">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="box">
                                                                <div class="box-body">
                                                                    <div class="table-responsive" style="overflow-x: auto;">
                                                                        <table id="tb2" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>No Induk</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Seksi/Unit Asal</th>
                                                                                    <th>Diperbantukan Ke</th>
                                                                                    <th>Gol Kerja</th>
                                                                                    <th>Pekerjaan</th>
                                                                                    <th>Periode (Lama)</th>
                                                                                    <th>Keterangan</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $no = 1; ?>
                                                                                <?php foreach ($dataDiperbantukan as $data) : ?>
                                                                                    <tr style="color:<?php if ($data['fd_tgl_selesai'] < date('Y-m-d') &&  $data['berlaku'] == '1') {
                                                                                                            echo "#fc0303";
                                                                                                        } elseif ($data['fd_tgl_selesai'] < date('Y-m-d') && $data['berlaku'] == '0') {
                                                                                                            echo "#3059fc";
                                                                                                        } else {
                                                                                                            echo "#000";
                                                                                                        } ?> ;">
                                                                                        <td><?= $no++ ?></td>
                                                                                        <td><?= $data['noind'] ?></td>
                                                                                        <td><?= $data['nama'] ?></td>
                                                                                        <td><?= $data['seksi_awal'] ?></td>
                                                                                        <td><?= $data['seksi_perbantuan'] ?></td>
                                                                                        <td><?= $data['golkerja'] ?></td>
                                                                                        <td><?= $data['pekerjaan'] ?></td>
                                                                                        <td><?= $data['lama'] ?></td>
                                                                                        <td><?= $data['ket'] ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

                                                <section>
                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box1"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang masa perbantuannya sudah habis</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box2"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang harus diproses masa perbantuannya</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div class="col-md-1" style="padding-right: 0px;width: 40px;">
                                                            <div id="box3"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p>Pekerja yang akan selesai perbantuannya</p>
                                                        </div>
                                                    </div>
                                                </section>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="tab_3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="inner-box bordered">
                                                <div class="form-group">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <!-- checkbox -->
                                                            <label>
                                                                <input type="checkbox" class="minimal" id="cbOsMutasi">
                                                                Outsourcing
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r3" id="rP3" class="flat-blue"> Periode :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control pull-right" id="reservation3" placeholder="09/21/2020 - 09/21/2020" disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="radio" name="r3" id="rB3" class="flat-blue">Per Bulan :
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="datepicker3" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group" style="text-align: right;margin-top: 28px;">
                                                        <button type="button" class="btn btn-primary" id="btnCariDimutasi">Cari</button>
                                                    </div>
                                                </div>
                                                <section style="float: left;" class="col-md-12">
                                                    <div class="col-md-1" style="margin-top: 10px;margin-bottom:20px;">
                                                        <button type="button" class="btn btn-success" id="tab3_excel"> EXCEL</button>
                                                    </div>
                                                    <div class="col-md-1" style="margin-top: 10px;margin-bottom:20px;">
                                                        <button type="button" class="btn btn-danger" id="tab3_pdf">PDF</button>
                                                    </div>

                                                </section>
                                                <section class="content">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="box">
                                                                <div class="box-body">
                                                                    <div class="table-responsive" style="overflow-x: auto;">
                                                                        <table id="tb3" class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No</th>
                                                                                    <th>No Induk</th>
                                                                                    <th>Nama</th>
                                                                                    <th>Seksi/Unit Asal</th>
                                                                                    <th>Dimutasi Ke</th>
                                                                                    <th>Gol Kerja</th>
                                                                                    <th>Pekerjaan</th>
                                                                                    <th>Mulai Berlaku</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $no = 1; ?>
                                                                                <?php foreach ($dataDimutasi as $data) : ?>
                                                                                    <tr>
                                                                                        <td><?= $no++ ?></td>
                                                                                        <td><?= $data['noind']; ?></td>
                                                                                        <td><?= $data['nama']; ?></td>
                                                                                        <td><?= $data['seksi_lama']; ?></td>
                                                                                        <td><?= $data['seksi_baru']; ?></td>
                                                                                        <td><?= $data['golkerjabr']; ?></td>
                                                                                        <td><?= $data['pekerjaan']; ?></td>
                                                                                        <td><?= $data['tglberlaku']; ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

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

    </div>
    <script>
        $(function() {
            $('#reservation1, #reservation2, #reservation3').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            })

            $('#datepicker1, #datepicker2, #datepicker3').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: 'mm/yyyy'
            })

            let array_of_color_tb1 = [];
            let array_of_color_tb2 = [];

            let set_color_tb1 = function(data) {
                const today = moment().format('YYYY-MM-DD')

                return data.map(item => {
                    console.log(item.keluar)
                    if (moment(today).isBefore(item.tglkeluar) && item.keluar == 't') return 'red';
                    if (moment(today).isBefore(item.tglkeluar) && item.keluar == 'f') return 'black';
                    return '#3059fc'
                })
            }

            let set_color_tb2 = function(data) {
                const today = moment().format('YYYY-MM-DD')

                return data.map(item => {
                    console.log(item.berlaku)
                    if (moment(today).isAfter(item.fd_tgl_selesai) && item.berlaku == '1') return 'red';
                    if (moment(today).isAfter(item.fd_tgl_selesai) && item.berlaku == '0') return '#3059fc';
                    return 'black'
                })
            }

            const tb1 = $('#tb1').DataTable({
                "createdRow": function(row, data, dataIndex) {
                    if (array_of_color_tb1.length) {
                        const color = array_of_color_tb1[dataIndex];
                        console.log(color)
                        $(row).css({
                            color: color
                        })
                    }
                },
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    leftColumns: 4
                }

            })
            const tb2 = $('#tb2').DataTable({
                "createdRow": function(row, data, index) {
                    if (array_of_color_tb2.length) {
                        const color = array_of_color_tb2[index];
                        console.log(color)
                        $(row).css({
                            color: color
                        })
                    }
                }
            })
            const tb3 = $('#tb3').DataTable()

            /**
             * Button cari pekerjaakankeluar tab
             */

            $('button#btnCari').click(function() {
                // library buat request api
                const data = {
                    with_os: $('#cbOS').is(':checked'),
                    os_name: $('#fcAsalOs').val(),
                    rangeDate: $('#rP1').is(':checked') ? $('#reservation1').val() : null,
                    datepicker: $('#rB1').is(':checked') ? $('#datepicker1').val() : null
                }

                var loading = baseurl + "assets/img/gif/loadingquick.gif";
                if (data.rangeDate == null && data.datepicker == null) {
                    return swal.fire({
                        title: "Peringatan",
                        text: "Anda Belum Melilih Bulan atau Periode !",
                        type: "warning",
                        allowOutsideClick: false
                    })
                } else {
                    $.ajax({
                        method: 'GET',
                        url: baseurl + 'MasterPekerja/PekerjaAkanKeluar/get_pekerja_keluar',
                        // beforeSend: function() {
                        //     swal.fire({
                        //         html: "<div><img style='width: 320px; height:auto;'src='" + loading + "'><br> <p>Sedang Proses....</p></div>",
                        //         customClass: "swal-wide",
                        //         showConfirmButton: false,
                        //         allowOutsideClick: false
                        //     })
                        // },
                        data: data,
                        dataType: 'json',
                        success(response) {
                            // ketika api request berhasil
                            swal.close();
                            console.table(response.data)
                            array_of_color_tb1 = set_color_tb1(response.data)
                            const mapArray = response.data.map((item, index) => {
                                let it = Object.values(item)
                                it.unshift(index + 1)
                                console.log(it)
                                return it
                            })
                            tb1.clear()
                            tb1.rows.add(mapArray)
                            tb1.draw()
                        }
                    })
                }
            })

            //CariPekerjaDiperbantukan
            $('button#btnCariDiperbantukan').click(function() {
                const data = {
                    with_os: $('#cbOSperbantuan').is(':checked'),
                    datepicker: $('#rB2').is(':checked') ? $('#datepicker2').val() : null,
                    rangeDate: $('#rP2').is(':checked') ? $('#reservation2').val() : null
                }
                var loading = baseurl + "assets/img/gif/loadingquick.gif"

                if (data.datepicker == null && data.rangeDate == null) {
                    return swal.fire({
                        title: "Peringatan",
                        text: "Anda Belum Memilih Bulan atau Periode !",
                        type: "warning",
                        allowOutsideClick: false
                    })
                } else {
                    $.ajax({
                        method: 'GET',
                        url: baseurl + 'MasterPekerja/PekerjaAkanKeluar/get_pekerja_diperbantukan',
                        beforeSend: function() {
                            swal.fire({
                                html: "<div><img style='width: 320px; height:auto;'src='" + loading + "'><br> <p>Sedang Proses....</p></div>",
                                customClass: "swal-wide",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            })
                        },
                        data: data,
                        dataType: 'json',
                        success(response) {
                            swal.close();
                            console.log(response.data)
                            array_of_color_tb2 = set_color_tb2(response.data)
                            const mapArray = response.data.map((item, index) => {
                                let it = Object.values(item)
                                it.unshift(index + 1)
                                console.log(it)
                                return it
                            })
                            tb2.clear()
                            tb2.rows.add(mapArray)
                            tb2.draw()
                        }
                    })
                }
            })

            //CariPekerjaDimutasi
            $('button#btnCariDimutasi').click(function() {
                const data = {
                    with_os: $('#cbOsMutasi').is(':checked'),
                    datepicker: $('#rB3').is(':checked') ? $('#datepicker3').val() : null,
                    rangeDate: $('#rP3').is(':checked') ? $('#reservation3').val() : null
                }
                var loading = baseurl + "assets/img/gif/loadingquick.gif"
                if (data.datepicker == null && data.rangeDate == null) {
                    return swal.fire({
                        title: "Peringatan",
                        text: "Anda Belum Memilih Bulan atau Periode !",
                        type: "warning",
                        allowOutsideClick: false
                    })
                } else {
                    $.ajax({
                        method: 'GET',
                        url: baseurl + 'MasterPekerja/PekerjaAkanKeluar/get_pekerja_dimutasi',
                        beforeSend: function() {
                            swal.fire({
                                html: "<div><img style='width: 320px; height:auto;'src='" + loading + "'><br> <p>Sedang Proses....</p></div>",
                                customClass: "swal-wide",
                                showConfirmButton: false,
                                allowOutsideClick: false
                            })
                        },
                        data: data,
                        dataType: 'json',
                        success(response) {
                            swal.close()
                            console.log(response.data)
                            const mapArray = response.data.map((item, index) => {
                                let it = Object.values(item)
                                it.unshift(index + 1)
                                console.log(it)
                                return it
                            })
                            tb3.clear()
                            tb3.rows.add(mapArray)
                            tb3.draw()
                        }
                    })
                }

            })


            /**
            EXPORT TO PDF AND PHP
             */

            $(document).ready(function() {
                /**
                 * Excel PHP
                 */
                $('button#tab1_excel').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export'
                    const data = {
                        with_os: $('#cbOS').is(':checked'),
                        os_name: $('#fcAsalOs').val(),
                        rangeDate: $('#rP1').is(':checked') ? $('#reservation1').val() : null,
                        datepicker: $('#rB1').is(':checked') ? $('#datepicker1').val() : null
                    }
                    const param = $.param(data)
                    if (data.rangeDate == null && data.datepicker == null) {
                        swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        window.location.href = `${url}?${param}`
                    }

                })

                $('button#tab1_pdf').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export_pdf'
                    const data = {
                        with_os: $('#cbOS').is(':checked'),
                        os_name: $('#fcAsalOs').val(),
                        rangeDate: $('#rP1').is(':checked') ? $('#reservation1').val() : null,
                        datepicker: $('#rB1').is(':checked') ? $('#datepicker1').val() : null
                    }

                    const param = $.param(data) //Dinggo njukuk data
                    if (data.rangeDate == null && data.datepicker == null) {
                        swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        console.log(param);
                        window.location.href = `${url}?${param}`
                    }
                })

                $('button#tab2_excel').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export_excel_diperbantukan'
                    const data = {
                        with_os: $('#cbOSperbantuan').is(':checked'),
                        rangeDate: $('#rP2').is(':checked') ? $('#reservation2').val() : null,
                        datepicker: $('#rB2').is(':checked') ? $('#datepicker2').val() : null
                    }
                    const param = $.param(data)
                    if (data.datepicker == null && data.rangeDate == null) {
                        return swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        window.location.href = `${url}?${param}`
                    }

                })

                $('button#tab2_pdf').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export_pdf_diperbantukan'

                    const data = {
                        with_os: $('#cbOSperbantuan').is(':checked'),
                        rangeDate: $('#rP2').is(':checked') ? $('#reservation2').val() : null,
                        datepicker: $('#rB2').is(':checked') ? $('#datepicker2').val() : null
                    }
                    const param = $.param(data)
                    if (data.rangeDate == null && data.datepicker == null) {
                        swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        window.location.href = `${url}?${param}`
                    }

                })

                $('button#tab3_excel').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export_excel_mutasi'

                    const data = {
                        with_os: $('#cbOsMutasi').is(':checked'),
                        datepicker: $('#rB3').is(':checked') ? $('#datepicker3').val() : null,
                        rangeDate: $('#rP3').is(':checked') ? $('#reservation3').val() : null
                    }

                    const param = $.param(data)
                    if (data.rangeDate == null && data.datepicker == null) {
                        swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        window.location.href = `${url}?${param}`
                    }

                })

                $('button#tab3_pdf').click(function(event) {
                    event.preventDefault()

                    const url = baseurl + 'MasterPekerja/PekerjaAkanKeluar/export_pdf_mutasi'

                    const data = {
                        with_os: $('#cbOsMutasi').is(':checked'),
                        datepicker: $('#rB3').is(':checked') ? $('#datepicker3').val() : null,
                        rangeDate: $('#rP3').is(':checked') ? $('#reservation3').val() : null
                    }

                    const param = $.param(data)
                    if (data.rangeDate == null && data.datepicker == null) {
                        swal.fire({
                            title: "Peringatan",
                            text: "Anda Belum Memilih Bulan atau Periode !",
                            type: "warning",
                            allowOutsideClick: false
                        })
                    } else {
                        window.location.href = `${url}?${param}`
                    }

                })
            });
        })

        $(window).load(() => {
            $('#cbOS,#cbOSperbantuan,#cbOsMutasi').iCheck({
                checkboxClass: 'icheckbox_square-blue',
            })
            $('#tb1').DataTable();
            $('input[type=checkbox]#cbOS').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('select#fcAsalOs').prop('disabled', !checked)
            });

            $('input[type=radio]#rP1').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#reservation1').prop('disabled', !checked)
            });

            $('input[type=radio]#rB1').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#datepicker1').prop('disabled', !checked)
            });

            $('input[type=radio]#rP2').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#reservation2').prop('disabled', !checked)
            });

            $('input[type=radio]#rB2').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#datepicker2').prop('disabled', !checked)
            });

            $('input[type=radio]#rP3').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#reservation3').prop('disabled', !checked)
            });

            $('input[type=radio]#rB3').on('ifToggled', function() {
                const checked = $(this).is(':checked')
                $('input#datepicker3').prop('disabled', !checked)
            });
        })
    </script>
</section>