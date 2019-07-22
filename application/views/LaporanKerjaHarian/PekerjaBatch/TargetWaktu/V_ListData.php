<style type="text/css">
    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        /* margin-top: 45px;
        padding-top: 16px;
        padding-bottom: 40px; */
        text-align: center;
        font-size: 1.2em;
        z-index: 999;
    }
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
    .fade-transition {
        -webkit-transition: background-color 1000ms linear;
        -moz-transition: background-color 1000ms linear;
        -o-transition: background-color 1000ms linear;
        -ms-transition: background-color 1000ms linear;
        transition: background-color 1000ms linear;
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
                                    <div class="col-lg-2 text-left">
                                        <label style="margin-top: 6px;" class="control-label">Pilih Periode :</label>
                                    </div>
                                    <div class="col-lg-5 text-left">
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
                                        <a onclick="javascript:reloadDataTables();" data-toggle="tooltip" data-placement="left" style="float:right;margin-top:-0.5%;" alt="Refresh Halaman" title="Refresh Data">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh fa-2x"></i></button>
                                        </a>
                                        <a onclick="javascript:openDeleteDataBatchModal();" data-toggle="tooltip" data-placement="left" style="float:right;margin-right:3%;margin-top:-0.5%;" alt="Hapus Data Kegiatan (Batch)" title="Hapus Data Kegiatan (Batch)">
                                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash fa-2x"></i></button>
                                        </a>
                                        <a onclick="javascript:openKirimApprovalModal();" data-toggle="tooltip"  data-placement="left" style="float:right;margin-right:3%;margin-top:-0.5%;" alt="Kirim Approval ke Atasan" title="Kirim Approval ke Atasan">
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
                                        <div class="form-group">
                                            <div class="input-group"style="width: 300px; color: black;">
                                                <div class="input-group-addon">
                                                    <i class="glyphicon glyphicon-user"></i>
                                                </div>
                                                <select id="filterPekerja" class="form-control" multiple="multiple">
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
                                        <form id="formFilterLkhPekerja" action="<?= base_url('LkhPekerjaBatch/TargetWaktu/'.$type); ?>" method="POST">
                                            <input id="currentLkhPekerjaData1" value="<?= $filterPeriode; ?>" hidden/>
                                            <input id="currentLkhPekerjaData2" value="<?= (empty($filterPekerja)) ? '' : implode(',', $filterPekerja);; ?>" hidden/>
                                            <input name="filterPeriode" id="formFilterLkhPekerjaData1" hidden/>
                                            <input name="filterPekerja" id="formFilterLkhPekerjaData2" hidden/>
                                            <button id="btnFilterLkh" style="margin-top: 2px;" class="btn btn-default btn-sm" type="submit">Tampilkan</button>
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
                                                <th style="text-align: center; width: 120px;">Status</th>
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
<div class="modal fade" id="modalKirimApproval" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Kirim Approval</h4>
            </div>
            <div class="modal-body">
                <div>
                    <span id="approvalDataCount"></span><br/>
                    <b>Pilih Approver:</b>
                </div>
                <div style="margin-top: 8px;">
                    <select class="form-control" id="slcApprover1" style="width: 100%"></select>
                </div>
                <div style="margin-top: 8px;">
                    <select class="form-control" id="slcApprover2" style="width: 100%" disabled></select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnConfirmKirimApproval">Kirim</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDeleteDataBatch" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Data Kegiatan (Batch)</h4>
            </div>
            <div class="modal-body">
                <span id="deleteDataBatchCount" style="font-weight: bold;"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDeleteBatch">Hapus</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalDeleteData" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Hapus Data Kegiatan</h4>
            </div>
            <div class="modal-body">
                <span id="deleteDataMessage"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table = null, tableInfo = null;
    $(function() {
        table = $('#tblLkhPekerjaListData').DataTable({
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
            searchDelay: 500,
            drawCallback: function(x) {
                tableInfo = this.api().page.info();
                $('#checkbox-all').iCheck('uncheck');
                initCheckbox();
            },
            createdRow: function(row, data, index) {
                $('td', row).eq(5).addClass('fade-transition');
                switch(data[7]) {
                    case 'Request Approval':
                    case 'Unapproved':
                        $('td', row).eq(5).css({'background-color': '#ffb74d', 'color': 'black'});
                        break;
                    case 'Approved':
                        $('td', row).eq(5).css({'background-color': '#4CAF50', 'color': 'white'});
                        break;
                    case 'Rejected':
                        $('td', row).eq(5).css({'background-color': '#FF5252', 'color': 'white'});
                        break;
                    default:
                        $('td', row).eq(5).css({'background-color': '#64b5f6', 'color': 'white'});
                        break;
                }
            },
            columnDefs: [
                {"targets": [0], "searchable": false, "orderable": false, "visible": false},
                {"targets": [1], "searchable": false, "orderable": false, "visible": true},
                {"targets": [2], "searchable": false, "orderable": false, "visible": true},
                {"targets": [3], "searchable": true,  "orderable": true,  "visible": true},
                {"targets": [4], "searchable": true,  "orderable": true, "visible": true},
                {"targets": [5], "searchable": true,  "orderable": true,  "visible": true},
                {"targets": [6], "searchable": true,  "orderable": true,  "visible": true}
            ],
            order: [
                [3, "asc"]
            ],
            ajax: {
                url : "<?= base_url('LkhPekerjaBatch/TargetWaktu/getList'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    type: '<?= $type ?>',
                    periode: $('#currentLkhPekerjaData1').val(),
                    pekerja: $('#currentLkhPekerjaData2').val()
                }
            }
        });
    });

    function reloadDataTables() {
        if(table) $('#tblLkhPekerjaListData').DataTable().ajax.reload(null, false);
    }

    function openKirimApprovalModal() {
        if(!table) return;
        var valid = false, dataCount = 0;
        for(var i = 0; i <= tableInfo.recordsDisplay; i++) {
            if($("#checkbox-row-" + i).prop("checked")) { valid = true; dataCount++; }
        }
        if(valid) {
            $('#approvalDataCount').text('Memilih ' + dataCount + ' data dari total ' + tableInfo.recordsDisplay + ' data LKH Pekerja.');
            $('#modalKirimApproval').modal('show');
            $('#btnConfirmKirimApproval').off('click').click(function() {
                if($('#slcApprover1').val() && $('#slcApprover2').val()) {
                    kirimApproval();
                } else {
                    $.toaster('Mohon lengkapi opsi approver', '', 'danger');
                }
            });
        } else  {
            $.toaster('Tidak ada data yang dipilih', '', 'danger');
        }
    }

    function kirimApproval() {
        var employee_code = '', periode = '', approver1 = $('#slcApprover1').val(), approver2 = $('#slcApprover2').val();
        $('#btnConfirmKirimApproval').attr('disabled', true);
        for(var i = 0; i <= tableInfo.recordsDisplay; i++) {
            if($("#checkbox-row-" + i).prop("checked") == true && $('#employee-record-pekerjaan-row-' + i).text() != '-' && $('#employee-record-kondite-row-' + i).text() != '-') {
                employee_code += $('#employee-code-row-' + i).val() + ', ';
                periode += getFormattedPeriode($('#periode-row-' + i).val()) + ', ';
            }
        }
        if(employee_code && periode && approver1 && approver2) {
            $.ajax({
                url: '<?= base_url("LkhPekerjaBatch/TargetWaktu/kirimApproval"); ?>',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {
                    'periode': periode,
                    'pekerja': employee_code,
                    'approver1': approver1,
                    'approver2': approver2
                },
                success: function(response) {
                    $('#btnConfirmKirimApproval').attr('disabled', false);
                    if(response.success) {
                        for(var i = 0; i <= tableInfo.recordsDisplay; i++) {
                            if($('#checkbox-row-' + i).prop('checked')) {
                                $('#checkbox-row-' + i).iCheck('uncheck');
                                $('#checkbox-row-' + i).iCheck('disable');
                                $('#employee-status-row-' + i).text('Request Approval');
                                $('#employee-status-row-' + i).parent().css('background-color', '#ffb74d');
                                $('#employee-delete-row-' + i).attr('disabled', true);
                                $('#employee-delete-row-' + i).removeAttr('onclick');
                            }
                        }
                        $('#checkbox-all').iCheck('uncheck');
                        $.toaster(response.message, '', 'success');
                        $('#modalKirimApproval').modal('hide');
                    } else {
                        $.toaster(response.message, '', 'danger');
                    }
                },
                error: function(response) {
                    console.log('Terjadi kesalahan saat mengirim data [status: ' + response.status + ']');
                    $('#btnConfirmKirimApproval').attr('disabled', false);
                    $.toaster('Terjadi kesalahan saat mengirim data', '', 'danger');
                }
            });
        } else {
            $.toaster('Tidak ada data yang dipilih', '', 'danger');
        }
    }

    function openDeleteDataBatchModal() {
        if(!table) return;
        var valid = false, dataCount = 0;
        for(var i = 0; i <= tableInfo.recordsDisplay; i++) {
            if($("#checkbox-row-" + i).prop("checked")) {
                valid = true;
                dataCount++;
            }
        }
        if(valid) {
            $('#deleteDataBatchCount').text('Anda yakin ingin menghapus ' + dataCount + ' data dari total ' + tableInfo.recordsDisplay + ' data kegiatan LKH Pekerja ?');
            $('#modalDeleteDataBatch').modal('show');
            $('#btnConfirmDeleteBatch').off('click').click(function() {
                deleteDataKegiatanBatch();
            });
        } else {
            $.toaster('Tidak ada data yang dipilih', '', 'danger');
        }
    }

    function deleteDataKegiatanBatch() {
        var employee_code = '', periode = '';
        $('#btnConfirmDeleteBatch').attr('disabled', true);
        for(var i = 0; i <= tableInfo.recordsDisplay; i++) {
            if($("#checkbox-row-" + i).prop("checked") == true && $('#employee-record-pekerjaan-row-' + i).text() != '-' && $('#employee-record-kondite-row-' + i).text() != '-') {
                employee_code += $('#employee-code-row-' + i).val() + ', ';
                periode += $('#periode-row-' + i).val() + ', ';
            }
        }
        if(employee_code && periode) {
            $.ajax({
                url: '<?= base_url("LkhPekerjaBatch/TargetWaktu/deleteDataKegiatanBatch"); ?>',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {
                    'periode': periode,
                    'pekerja': employee_code
                },
                success: function(response) {
                    $('#btnConfirmDeleteBatch').attr('disabled', false);
                    if(response.success) {
                        $('#checkbox-all').iCheck('uncheck');
                        for(var i = 0; i <= tableInfo.recordsDisplay; i++) if($('#checkbox-row-' + i).prop('checked')) $('#checkbox-row-' + i).iCheck('uncheck');
                        $.toaster(response.message, '', 'success');
                        $('#modalDeleteDataBatch').modal('hide');
                    } else {
                        $.toaster(response.message, '', 'danger');
                    }
                },
                error: function(response) {
                    console.log('Terjadi kesalahan saat menghapus data [status: ' + response.status + ']');
                    $('#btnConfirmDeleteBatch').attr('disabled', false);
                    $.toaster('Terjadi kesalahan saat menghapus data', '', 'danger');
                }
            });
        } else {
            $.toaster('Tidak ada data yang dipilih', '', 'danger');
        }
    }

    function openDeleteDataModal(row, id) {
        if(table && row && id) {
            $('#deleteDataMessage').html('Anda yakin ingin menghapus data kegiatan LKH pekerja <b>' + $('#employee-name-row-'+row).text() + '</b> ?');
            $('#modalDeleteData').modal('show');
            $('#btnConfirmDelete').off('click').click(function() {
                deleteDataKegiatan(row, id);
            });
        }
    }

    function deleteDataKegiatan(row, id) {
        $('#btnConfirmDelete').attr('disabled', true);
        if(row && id) {
            $.ajax({
                url: '<?= base_url("LkhPekerjaBatch/TargetWaktu/deleteDataKegiatan"); ?>',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {
                    'periode': $('#periode-row-' + row).val(),
                    'pekerja': id
                },
                success: function(response) {
                    $('#btnConfirmDelete').attr('disabled', false);
                    if(response.success) {
                        $.toaster(response.message, '', 'success');
                        $('#modalDeleteData').modal('hide');
                    } else {
                        $.toaster(response.message, '', 'danger');
                    }
                },
                error: function(response) {
                    console.log('Terjadi kesalahan saat menghapus data [status: ' + response.status + ']');
                    $('#btnDeleteData').attr('disabled', false);
                    $.toaster('Terjadi kesalahan saat menghapus data', '', 'danger');
                }
            });
        }
    }

    function getFormattedPeriode(periode) {
        var result = '';
        if(periode) {
            periode = periode.split('/');
            return periode[1] + '-' + periode[0] + '-01';
        }
        return result;
    }
</script>