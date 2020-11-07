<form action="<?php echo base_url('Monitoring/TrackingInvoice/exportExcelTrackingInvoice') ?>" method="post">
    <section class="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-left ">
                                <h2><span style="font-family: 'Source Sans Pro',sans-serif; ">Report Tracking Invoice</span></h2>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-body">
                                    <div class="box box-primary box-solid">
                                        <div class="box-body">
                                            <div class="box-header with-border">
                                                Kriteria Pencarian
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td style="padding-left:50px"><br><label style="width:100px">Nama Vendor</label></td>
                                                            <td style="padding-left:5px">
                                                                <select id="nama_vendor" name="nama_vendor" class="form-control select2 select2-hidden-accessible" style="width:250px;">
                                                                    <option value="">PILIH</option>
                                                                    <?php foreach ($getVendorName as $name) { ?>
                                                                        <option><?php echo $name['VENDOR_NAME'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:50px"><label style="width:100px">Tanggal Awal</label></td>
                                                            <td>
                                                                <input type="text" class="form-control invoice_date" name="invoice_date_from" id="invoice_date_from" style="margin: 5px;width:250px;">
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left:50px"><label style="width:100px">Tanggal Akhir</label></td>
                                                            <td>
                                                                <input type="text" class="form-control invoice_date" name="invoice_date_to" id="invoice_date_to" style="margin: 5px;width:250px;">
                                                            </td>

                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-primary" id="btn_search_r_invoice" style="margin-top: 10px; margin-right: 10px;">Search</button>
                                                        <div class="pull-right">
                                                            <button type="reset" class="btn btn-success" id="btn_clear_invoice" style="margin-top: 10px; margin-right: 10px;">Clear</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="loading_invoice">
                                    <div style="overflow:auto;">
                                        <table style="min-width: 110%" id="tabel_search_r_tracking_invoice"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</form>