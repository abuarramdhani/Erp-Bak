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
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('SaveLocation/InputSubAssy');?>">
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
                <br>
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            Input New Component Data
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="saveinputassy" method="post">
                                        <div class="row">
                                            <div class="col-lg-8 col-lg-push-2">
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        ID Organization
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select-2" id="IdOrganization" name="txtOrg" onchange="getSubInvent()" required="">
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
                                                        Sub Inventory
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select-2" disabled="" id="SlcSubInventori" name="SlcSubInventori2">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Kode Assembly
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control jsAssembly" id="SlcKodeAssy" name="SlcKodeAssy2" onchange="GetDescAssy('<?php echo base_url(); ?>')">
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
                                                        <input class="form-control" id="txtNameAssy" name="txtNameAssy2" placeholder="Nama Assembly" readonly="">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Tipe Assembly
                                                    </label>
                                                    <div class="col-md-8">
                                                        <input class="form-control" id="txtTypeAssy" name="txtTypeAssy2" placeholder="Input Tipe Assembly" readonly="" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-md-4 control-label">
                                                        Locator
                                                    </label>
                                                    <div class="col-md-8">
                                                        <select class="form-control select-2" data-placeholder="Pilih Locator" disabled="" id="SlcLocator" name="txtLocator2">
                                                            <option value="">
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="box box-default box-solid">
                                                    <div class="box-header with-border">
                                                        <div class="pull-left">
                                                            Lines
                                                        </div>
                                                        <div class="pull-right">
                                                            <button class="btn btn-primary fa fa-plus min" onclick="add_row('table_input')" type="button">
                                                            </button>
                                                            <button class="btn btn-primary fa fa-minus" onclick="delete_row('table_input')" type="button">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <table class="table table-bordered table-striped" id="table_input">
                                                                    <tr class="text-center" style="font-weight: bold;">
                                                                        <td>
                                                                            Kode Komponen
                                                                        </td>
                                                                        <td>
                                                                            Nama Komponen
                                                                        </td>
                                                                        <td>
                                                                            Alamat Simpan
                                                                        </td>
                                                                        <td style="width: 200px;">
                                                                            LPPB/MO/KIB
                                                                        </td>
                                                                        <td style="width: 200px;">
                                                                            PICKLIST
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="tr_clone">
                                                                        <td>
                                                                            <select class="form-control jsItem select_input" id="SlcItem2" name="SlcItem2[]" onchange="GetName('<?php echo base_url(); ?>',event,this)" style="width: 100%;">
                                                                                <option value="">
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control nama_input" id="txtDesc2" name="txtDesc2[]" placeholder="Nama Komponen" readonly="" type="text">
                                                                            </input>
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control" name="txtAlamat2[]" type="text"/>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select-2" id="txtLmk" name="txtLmk[]" required="">
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
                                                                            <!-- <input class="lmk_check" hidden="" name="txtLmk2[]" type="text" value="0">
                                                                                <input class="ceklmk" id="txtLmk2[]" name="txtLmk2[]" onchange="lmkcheck(event,this)" type="checkbox" value="1"/>
                                                                            </input> -->
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control select-2" id="txtPicklist" name="txtPicklist[]" required="">
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
                                                                            <!-- <input class="pick_check" hidden="" name="txtPicklist2[]" type="text" value="0">
                                                                                <input class="cekpicklist" id="txtPicklist2[]" name="txtPicklist2[]" onchange="pickcheck(event,this)" type="checkbox" value="1"/>
                                                                            </input> -->
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="text-align: right;">
                                            <button class="btn btn-success glyphicon glyphicon-check " id="save_input" type="submit">
                                                SAVE
                                            </button>
                                            <button class="btn btn-primary glyphicon" id="clear" onclick="window.location.reload()" type="button">
                                                CLEAR
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div align="center">
                                <?php echo $message; ?>
                            </div>
                        </div>
                    </div>
                </br>
            </div>
        </div>
    </div>
</section>