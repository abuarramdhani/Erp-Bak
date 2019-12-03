<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('RekapLppb/Perbaikan/');?>">
                                    <i class="icon-wrench icon-2x">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"><b>Perbaikan</b></div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-2">
                                        <input id="no_recipt" name="no_recipt" class="form-control pull-right " placeholder="No Recipt" >
                                    </div>
                                    <div class="col-md-2">
                                        <input id="no_po" name="no_po" class="form-control pull-right " placeholder="No Po" >
                                    </div>
                                    <div class="col-md-2">
                                        <input id="item" name="item" class="form-control pull-right " placeholder="Item" >
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                        <select id="id_org" name="id_org" class="form-control select2" data-placeholder="Pilih IO">
                                        <option></option>
                                            </select>
                                        <span class="input-group-btn">
                                            <button type="button" onclick="schPerbaikan(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="panel-body">
                                        <div class="table-responsive"  id="tb_LPPB">
                                        
                                        </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
