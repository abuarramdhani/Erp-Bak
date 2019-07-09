<style type="text/css">
    /* .dataTables_wrapper .dataTables_processing {
        position: absolute;
        margin-top: 45px;
        padding-top: 16px;
        padding-bottom: 40px;
        text-align: center;
        font-size: 1.2em;
        z-index: 999;
    } */
    #datepicker, #filterPeriode {
        cursor: pointer;
    }
    .dataTable_Button {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-bottom: 2px;
    }
    .dataTable_Filter {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-bottom: 2px;
    }
    .dataTable_Information {
        width: 350px;
        float: left;
        margin-left: 1px;
        margin-top: 7px;
    }
    .dataTable_Pagination {
        width: 450px;
        float: right;
        margin-right: 1px;
        margin-top: 14px;
    }
    .dataTable_Processing {
        z-index: 999;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-left"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header">
                                <div class="col-lg-9" style="display: flex; justify-content: flex-start;">
                                    <div class="col-md-2">
                                        <label style="margin-top: 6px;" class="control-label">Pilih Periode :</label>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group date" id="datepicker" data-provide="datepicker" data-date="<?= $filterPeriode ?>" style="width: 300px;">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                            <input id="filterPeriode" type="text" class="form-control" placeholder="Periode" value="<?= $filterPeriode ?>" readonly/>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                $(document).off('.datepicker.data-api');
                                                $('#datepicker').datepicker({
                                                    format: 'mm/yyyy',
                                                    minViewMode: 'months'
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="col-lg-3">
                                    <div>
                                        <a href="<?php echo site_url('LKH/TargetWaktu/HapusData') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Hapus Data" title="Hapus Data" >
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                        </a>
                                        <a href="<?php echo site_url('LKH/TargetWaktu/KirimApproval/') ?>" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Kirim Approval ke Atasan" title="Kirim Approval ke Atasan" >
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-check fa-2x"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="box-header" style="margin-top: -10px;">
                                <div class="col-lg-9" style="display: flex; justify-content: flex-start; margin-bottom: -13px; margin-top: -2px;">
                                    <div class="col-md-2">
                                        <label style="margin-top: 6px;" class="control-label">Pilih Pekerja :</label>
                                    </div>
                                    <div class="col-md-5">
                                        <select style="width: 300px; color: black; display: none;" class="form-control" id="slcStatus" required disabled>
                                            <option value="0" selected>Aktif (Default)</option>
                                        </select>
                                        <div class="form-group">
                                            <div class="input-group"style="width: 300px; color: black;">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </div>
                                                <select id="filterPekerja" class="form-control" multiple="multiple" required>
                                                    <?php
                                                        if(!empty($filterPekerja)) {
                                                            foreach((array) $filterPekerja as $i) {
                                                                echo '<option id="'.$i.'" selected>'.$i.'</option>';
                                                            }
                                                        } else {
                                                            echo '<option value=""></option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <form id="formFilterLkhPekerja" action="<?= base_url('LkhPekerjaBatch/TargetWaktu/ListData'); ?>" method="POST">
                                            <input id="currentLkhPekerjaData1" value="<?= $filterPeriode; ?>" hidden/>
                                            <input id="currentLkhPekerjaData2" value="<?= (empty($filterPekerja)) ? '' : implode(',', $filterPekerja);; ?>" hidden/>
                                            <input name="filterPeriode" id="formFilterLkhPekerjaData1" hidden/>
                                            <input name="filterPekerja" id="formFilterLkhPekerjaData2" hidden/>
                                            <button style="margin-top: 2px;" class="btn btn-default btn-sm" type="submit">Tampilkan</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="tblLkhPekerjaListData" style="width: 100%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th style="text-align: center; width: 30px;"><input type="checkbox" id="checkbox-all"/></th>
                                                <th style="text-align: center; width: 90px;">Action</th>
                                                <th class="text-center">Pekerja</th>
                                                <th class="text-center">Record Pekerjaan</th>
                                                <th class="text-center">Record Kondite</th>
                                                <th class="text-center">Status</th>
											</tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function() {
        <?php
            if($this->session->flashdata('delete-lkh-pekerja-respond')) {
                switch($this->session->flashdata('delete-lkh-pekerja-respond')) {
                    case 1:
                        echo "
                            Swal.fire({
                                text: 'Terjadi kesalahan saat menghapus data LKH pekerja',
                                confirmButtonText: 'Tutup',
                                type: 'error'
                            });
                        ";
                        break;
                    case 2:
                        echo "
                            Swal.fire({
                                text: 'Data LKH pekerja telah dihapus',
                                confirmButtonText: 'Tutup',
                                type: 'success'
                            });
                        ";
                        break;
                }
            }
        ?>
        $('#tblLkhPekerjaListData').DataTable({
            //dom: 'Bfrtip',
            dom: '<"dataTable_Button"B><"dataTable_Filter"f>rt<"dataTable_Information"i><"dataTable_Pagination"p>',
            buttons: [
                'pageLength',
				{
					extend: 'collection',
                    text: 'Ekspor Data',
					buttons: [
						{
                            extend: 'copyHtml5',
                            title: '<?= $Title ?>',
                            messageBottom: function() {
                                return $('#tblLkhPekerjaListData_info').text();
                            },
                            exportOptions: {
                                columns: [0, 3, 4, 5, 6]
                            }
						},
						{
							extend: 'excelHtml5',
                            title: '<?= $Title ?>',
                            messageBottom: function() {
                                return $('#tblLkhPekerjaListData_info').text();
                            },
                            exportOptions: {
                                columns: [0, 3, 4, 5, 6]
                            }
						},
						{
							extend: 'csvHtml5',
                            title: '<?= $Title ?>',
                            messageBottom: function() {
                                return $('#tblLkhPekerjaListData_info').text();
                            },
                            exportOptions: {
                                columns: [0, 3, 4, 5, 6]
                            }
						},
						{
							extend: 'pdfHtml5',
                            title: '<?= $Title ?>',
                            messageBottom: function() {
                                return $('#tblLkhPekerjaListData_info').text();
                            },
                            header: true,
							footer: false,
                            exportOptions: {
                                columns: [0, 3, 4, 5, 6]
                            }
						},
						{
							extend: 'print',
                            title: '<?= $Title ?>',
                            messageBottom: function() {
                                return $('#tblLkhPekerjaListData_info').text();
                            },
							autoPrint: true,
							header: true,
							footer: false,
							customize: function (win) {
								$(win.document.body).find('h1').css('font-size', '2rem').css('text-align', 'center').css('padding-bottom', '12px');
								$(win.document.body).find('th').css('font-size', '1rem').css('text-align', 'center');
								$(win.document.body).find('div').removeAttr('style');
							},
							exportOptions: {
								modifier: {
									page: 'current'
                                },
                                columns: [0, 3, 4, 5, 6]
							}
						}
					]
				}
            ],
            language: {
                "processing":       "Memuat data...",
                "loadingRecords":   "Memuat...",
                "search":           "Cari : ",
                "lengthMenu":       "Menampilkan _MENU_ baris per halaman",
                "emptyTable":       "Belum ada data",
                "zeroRecords":      "Tidak ada data yang sesuai dengan kata kunci",
                "infoEmpty":        "Data tidak tersedia",
                "infoFiltered":     "(di filter dari _MAX_ total data)",
                "info":             "Menampilkan data ke _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "first":        "Pertama",
                    "last":         "Terakhir",
                    "next":         "Selanjutnya",
                    "previous":     "Sebelumnya"
                },
                "aria": {
                    "sortAscending":    ": aktifkan untuk mengurutkan data secara ascending",
                    "sortDescending":   ": aktifkan untuk mengurutkan data secara descending"
                },
                "buttons": {
                    "pageLength": {
                        _: "Menampilkan %d baris",
                        '-1': "Tampilkan semua"
                    }
                }
            },
            searching: true,
            processing: true,
            serverSide: true,
            scrollX: true,
            responsive: true,
            drawCallback: function(x) {
                $('#checkbox-all').iCheck('uncheck');
                initCheckbox();
            },
            rowCallback: function(row, data, index) {
                if(data[6] == 'true') $('td', row).css('background-color', '#f44336').css('color', 'white');
            },
            columnDefs: [
                {"targets": [0], "searchable": false, "orderable": false, "visible": false},
                {"targets": [1], "searchable": false, "orderable": false, "visible": true},
                {"targets": [2], "searchable": false, "orderable": false, "visible": true},
                {"targets": [3], "searchable": true,  "orderable": true,  "visible": true},
                {"targets": [4], "searchable": true,  "orderable": false, "visible": true},
                {"targets": [5], "searchable": true,  "orderable": true,  "visible": true},
                {"targets": [6], "searchable": true,  "orderable": true,  "visible": true}
            ],
            order: [
                [2, "asc"]
            ],
            ajax: {
                url : "<?= base_url('LkhPekerjaBatch/TargetWaktu/getList'); ?>",
                type: "POST",
                data: {
                    type: '<?= $type ?>',
                    periode: $('#currentLkhPekerjaData1').val(),
                    pekerja: $('#currentLkhPekerjaData2').val()
                }
            }
        });
    });
</script>