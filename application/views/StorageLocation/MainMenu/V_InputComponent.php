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
                                                <select class="form-control select-2" id="IdOrganization" name="txtOrg" onchange="getSubInvent()" required="">
                                                    <option></option>
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
                                                <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori" required="">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                Kode Komponen
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control jsItem" disabled="" id="SlcItem" name="SlcItem" onchange="getKodeAssem()" required="">
                                                    <option></option>
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
                                                <select class="form-control select-2" id="SlcKodeAssy" name="SlcKodeAssy" onchange="getDescTypeAssy()" style="width: 100%" disabled>
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
                                                <select class="form-control select-2" id="txtLmk" name="txtLmk" required>
                                                    <option selected="" value="">
                                                        -- Choose One --
                                                    </option>
                                                    <option value="1">
                                                        YES
                                                    </option>
                                                    <option value="0">
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label">
                                                PICKLIST
                                            </label>
                                            <div class="col-md-8">
                                                <select class="form-control select-2" id="txtPicklist" name="txtPicklist" required="">
                                                    <option selected="" value="">
                                                        -- Choose One --
                                                    </option>
                                                    <option value="1">
                                                        YES
                                                    </option>
                                                    <option value="0">
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12" style="text-align: right; margin-top: 10px">
                                                <button class="btn btn-default btn-lg" id="clear" onclick="window.location.reload()">
                                                    CLEAR
                                                </button>
                                                <button class="btn btn-primary btn-lg">
                                                    SAVE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div align="center">
                                        <?php echo $message; ?>
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