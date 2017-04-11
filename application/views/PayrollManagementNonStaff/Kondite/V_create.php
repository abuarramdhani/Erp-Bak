<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/doCreate/pekerja');?>" class="form-horizontal">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-lg-11">
                                <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                            </div>
                            <div class="col-lg-1 ">
                                <div class="text-right hidden-md hidden-sm hidden-xs">
                                    <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/');?>">
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
                                <div class="box-header with-border">
                                    <h3 class="box-title">Input Insentif Kondite Per Pekerja</h3>
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label class="control-label col-lg-2">No Induk</label>
                                                <div class="col-lg-6">
                                                    <select id="cmbNoindHeader" name="cmbNoindHeader" class="select cmbNoindHeader" data-placeholder="Pilih Salah Satu" style="width: 100%" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-2">Periode</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="txtTanggal1" name="txtTanggal1" class="form-control date-picker-pr-non-staf" placeholder="Periode 1" required>
                                                        <span class="input-group-addon">S/D</span>
                                                        <input type="text" id="txtTanggal2" name="txtTanggal2" class="form-control date-picker-pr-non-staf" placeholder="Periode 2" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" id="btnCetakForm" class="btn btn-primary btn-block">Cetak Form</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="30%" class="text-center">Tanggal</th>
                                                            <th width="7%" class="text-center">MK</th>
                                                            <th width="7%" class="text-center">BKI</th>
                                                            <th width="7%" class="text-center">BKP</th>
                                                            <th width="7%" class="text-center">TKP</th>
                                                            <th width="7%" class="text-center">KB</th>
                                                            <th width="7%" class="text-center">KK</th>
                                                            <th width="7%" class="text-center">KS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="FormWrapper">
                                                        <tr>
                                                            <td colspan="8" class="text-center"><h4>Please select both start date and end date and then click the button</h4></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="panel-footer">
                                        <div class="row text-right">
                                            <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
                                            &nbsp;&nbsp;
                                            <button type="submit" class="btn btn-primary btn-lg btn-rect">Save Data</button>
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