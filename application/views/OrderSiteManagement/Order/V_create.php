<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('OrderSiteManagement/Order');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('OrderSiteManagement');?>">
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
                                <div class="box-header with-border">Create Order</div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">

											<div class="form-group">
                                                <label for="osm-tglorder" class="control-label col-lg-4">Tgl Order</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="Masukkan Tanggal Order" name="osm-tglorder" class="form-control sm_datepicker" data-date-format="yyyy-mm-dd" id="osm-tglorder" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="osm-jenisorder" class="control-label col-lg-4">Jenis Order</label>
                                                <div class="col-lg-4">
                                                    <select id="osm-jenisorder" name="osm-jenisorder" class="form-control select2" data-placeholder="Pilih Jenis Order" required>
                                                        <option value=""></option>
                                                        <option value="Perbaikan Kursi">Perbaikan Kursi</option>
                                                        <option value="Cleaning Service">Cleaning Service</option>
                                                        <option value="Lain-Lain">Lain-Lain</option>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="osm-seksiorder" class="control-label col-lg-4">Seksi Order</label>
                                                <div class="col-lg-4">
                                                    <select id="osm-seksiorder" name="osm-seksiorder" class="form-control sm-selectseksi" required>
                                                    </select>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="osm-duedate" class="control-label col-lg-4">Due Date</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="Masukkan Due Date" name="osm-duedate" class="form-control sm_datepicker" data-date-format="yyyy-mm-dd" id="osm-duedate" required/>
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="osm-tglterima" class="control-label col-lg-4">Tgl Terima</label>
                                                <div class="col-lg-4">
                                                    <input type="text" maxlength="10" placeholder="Masukkan Tanggal Terima" name="osm-tglterima" class="sm_datepicker form-control" data-date-format="yyyy-mm-dd" id="osm-tglterima" />
                                                </div>
                                            </div>

											<div class="form-group">
                                                <label for="osm-remarks" class="control-label col-lg-4">Remarks</label>
                                                <div class="col-lg-4">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="osm-remarks" id="osm-remarks" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="nav-tabs-custom">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading">Lines Of Order Detail</div>
                                                                <div class="panel-body">
                                                                    <table id="table_smorderdetail" class="table table-striped table-bordered table-hover" style="font-size:12px;">
                                                                        <thead>
                                                                            <tr class="bg-primary">
                                                                                <th style="text-align:center; width:5%">No</th>
                                                                                <th style="text-align:center; width:5%">Action</th>
                                                                                <th style="text-align:center; width:10%">Jumlah</th>
                                                                                <th style="text-align:center; width:10%">Satuan</th>
                                                                                <th style="text-align:center; width:35%">Keterangan</th>
                                                                                <th style="text-align:center; width:35%">Lampiran</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="osm-orderlinesdetail">
                                                                            <tr row-id="1">
                                                                                <td style="text-align:center;">1</td>
                                                                                <td align="center">
                                                                                    <a class="del-row btn btn-xs btn-danger fa fa-times" data-toggle="tooltip" data-placement="bottom" title="Delete Data" data-id="" onclick="delSpesifikRow(this)"></a>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="number" placeholder="Jumlah" name="osm-jumlahorder[]" id="osm-jumlahorder" class="form-control"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" placeholder="Satuan" name="osm-satuanorder[]" id="osm-satuanorder" class="form-control"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" placeholder="Masukkan Keterangan" name="osm-ketorder[]" id="osm-ketorder" class="form-control"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <div class="col-lg-12">
                                                                                        <input type="text" placeholder="Masukkan Lampiran" name="osm-lampiran[]" id="osm-lampiran" class="form-control"/>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <a class="add-row btn btn-sm btn-success" onclick="AddRowOrderSM()"><i class="fa fa-plus"></i> Add New</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <button type="submit" class="btn btn-danger btn-lg btn-rect hidden" id="osm-cetakorder">Cetak Data</button>
                                            &nbsp;&nbsp;
                                            <button class="btn btn-success btn-lg btn-rect" id="osm-saveorder" disabled>Save Data</button>
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