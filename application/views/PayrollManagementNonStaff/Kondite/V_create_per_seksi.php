<section class="content">
    <div class="inner" >
        <div class="row">
            <form method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/Kondite/doCreate/seksi');?>" class="form-horizontal">
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
                                    <h3 class="box-title">Input Insentif Kondite Per Seksi</h3>
                                </div>
                                <div class="box-body">
                                    <div class="panel-body">
                                        <div class="row">
											<div class="form-group">
                                                <label class="control-label col-lg-2">Seksi</label>
                                                <div class="col-lg-6">
                                                    <select id="cmbKodesie" name="cmbKodesie" class="select cmbKodesie" data-placeholder="Pilih Salah Satu" style="width: 100%" required>
                                                    </select>
                                                </div>
                                                <div class="col-lg-1" id="cmbKodesie-loading">
                                            
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-2">Tanggal</label>
                                                <div class="col-lg-6">
                                                    <div class="input-group">
                                                        <input type="text" id="txtTanggal" name="txtTanggalHeader" class="form-control date-picker-pr-non-staf" placeholder="Tanggal" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th width="30%" class="text-center">No Induk</th>
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
                                                            <td colspan="8" class="text-center"><h4>Please select Section Code first</h4></td>
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