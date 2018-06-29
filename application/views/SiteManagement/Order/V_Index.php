<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SiteManagement');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
          
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <form action="" method="post" enctype="multipart/formdata">
                                   <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                            <input class="form-control sm_tglmonitoring"  data-date-format="d M Y" autocomplete="off" type="text" name="sm_order" style="width: 170px" placeholder="Masukkan Periode" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select class="form-control sm-selectseksi" name="order_seksi" id="order_seksi" style="width:240px">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <select class="form-control sm_select2" name="sm_order" id="sm_order" style="width: 170px">
                                                <option value=""></option>
                                                <option value="Perbaikan Kursi">Perbaikan Kursi</option>
                                                <option value="Cleaning Servis">Cleaning Servis</option>
                                                <option value="Lain-Lain">Lain-Lain</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-success pull-right">Search</button>
                                        </div>
                                    </div>
                               </form>
                            </div>
                            <div class="box-body">
                                <div>
                                    <table class="table table-striped table-bordered table-hover text-left sm_datatable" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center; width:30px">No</th>
                                                <th>No Order</th>
                                                <th>Tanggal Order</th>
                                                <th>Jenis Order</th>
                                                <th>Seksi Pemberi Order</th>
                                                <th>Keterangan Order</th>
                                                <th>Due Date</th>
                                                <th>Tanggal Terima GA</th>
                                                <th>Remarks</th>
                                                <th style="text-align:center; min-width:80px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td align="center"><input type="checkbox" name=""></td>
                                                <td align="center"><a style="margin-right:4px" href="" data-toggle="tooltip" data-placement="bottom" title="Simpan Data" class="fa fa-save fa-2x" id="SaveDataSM"></a></td>
                                            </tr>
                                        </tbody>                                      
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
