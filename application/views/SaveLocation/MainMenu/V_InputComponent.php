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
                                        <?php echo $title;?>
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/InputComponent');?>">
                                    <i aria-hidden="true" class="fa fa-2x fa-pencil">
                                    </i>
                                    <span>
                                        <br/>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        Save Location Monitoring
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo site_url('saveinput')?>" method="post">
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                ID Organization
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select-2" id="txtOrgId" name="txtOrg" onchange="getSubInvent()" required="">
                                                    <option disabled="" selected="" value="">
                                                        -- Choose One --
                                                    </option>
                                                    <option value="102">
                                                        ODM
                                                    </option>
                                                    <option value="101">
                                                        OPM
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                SubInventory
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori" onchange="getKodeKomp()" required="">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Kode Komponen
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select-2" disabled="" id="SlcItem" name="SlcItem" onchange="getKodeAssem()" required="">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Nama Komponen
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" id="txtDesc" name="txtDesc" placeholder="Nama Komponen" readonly="" type="text">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Locator
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select-2" data-placeholder="Pilih Locator" disabled="" id="SlcLocator" name="txtLocator" style="width: 100%">
                                                    <option value="">
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Alamat Simpan
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" id="txtAlamat" name="txtAlamat" placeholder="Input Alamat Simpan" type="text">
                                                </input>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Kode Assembly
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy" onchange="GetDescAssy('<?php echo base_url(); ?>')" style="width: 100%">
                                                    <option value="">
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Nama Assembly
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" id="txtNameAssy" name="txtNameAssy" placeholder="Nama Assembly" readonly="" style="width: 100%">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Type Assembly
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" id="txtTypeAssy" name="txtTypeAssy" placeholder="Input Tipe Assembly" readonly="" type="text">
                                                </input>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                LPPB/MO/KIB
                                            </label>
                                            <div class="col-md-8">
                                                <select name="txtLmk" class="form-control select-2" id="txtLmk">
                                                    <option value="" selected="">-- Choose One --</option>
                                                    <option value="1">YES</option>
                                                    <option value="0">NO</option>
                                                </select>
                                                <!-- <input id="txtLmk" name="txtLmk" type="checkbox" value="1">
                                                </input> -->
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                PICKLIST
                                            </label>
                                            <div class="col-md-8">
                                                <select id="txtPicklist" name="txtPicklist" class="form-control select-2">
                                                    <option value="" selected="">-- Choose One --</option>
                                                    <option value="1">YES</option>
                                                    <option value="0">NO</option>
                                                </select>
                                                <!-- <input id="txtPicklist" name="txtPicklist" type="checkbox" value="1">
                                                </input> -->
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="col-md-12">
    <div class="form-group">
        <div class="col-md-12" style="text-align: right; margin-top: 10px">
            <button class="btn btn-success glyphicon glyphicon-check ">
                SAVE
            </button>
            <button class="btn btn-primary" id="clear" onclick="window.location.reload()">
                CLEAR
            </button>
        </div>
    </div>
</div>
<div align="center">
    <?php echo $message; ?>
</div>
