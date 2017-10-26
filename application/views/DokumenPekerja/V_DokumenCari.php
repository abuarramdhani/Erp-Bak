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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('DocumentStandarization/AllDoc');?>">
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
                            </div>
                            <div class="box-body">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <center>
                                                <div class="form-group">
                                                    <select id="cmbPencarianDokumenBerdasarkan" name="cmbPencarianDokumenBerdasarkan" class="select2" data-placeholder="Cari WI/COP berdasarkan" required="" autofocus="" style="width: 100%">
                                                        <option value=""></option>
                                                        <option value="all">Semua Dokumen</option>
                                                        <option value="BP">Business Process</option>
                                                        <option value="CD">Context Diagram</option>
                                                        <option value="SOP">Standard Operating Procedure</option>
                                                        <option value="WI">Work Instruction</option>
                                                        <option value="COP">Code of Practice</option>
                                                    </select>
                                                </div>
                                            </center>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="txtKataKunciPencarianDokumen" id="txtKataKunciPencarianDokumen" class="col-lg-3 form-control" style="text-transform: uppercase" placeholder="Kata Kunci" required=""/>
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-success">Cari</button>
                                                    </span>
                                                </div>                                                  
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="datatable table table-striped table-bordered table-hover text-left" id="dataTables-Pekerja-cariDokumen" style="font-size:12px;">
                                        <thead>
                                            <th>No</th>
                                            <th>Business Process</th>
                                            <th>Context Diagram</th>
                                            <th>Standard Operating Procedure</th>
                                            <th>Work Instruction / Code of Practice</th>
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