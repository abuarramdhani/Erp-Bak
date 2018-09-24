<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="col-md-4">
                        Penerimaan Awal
                    </h1>
                </div>
            </div>
            <div class="box box-primary box-solid" style="margin-top: 10px">
                <div class="box-header with-border">
                    <div class="col-md-8" style="padding: 0px">
                        <h4 style="margin-top: 8px; margin-bottom: 8px">
                            Data Header
                        </h4>
                    </div>
                    <div class="col-md-4 form-inline" style="padding-right: 0px">
                        <div class="input-group" style="margin-right: 10px">
                            <input class="form-control" id="in_po" name="in_po" placeholder="Nomor PO"/>
                        </div>
                        <button class="btn btn-default" id="b_procces" name="b_procces">
                            PROSES
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div>
                        <div class="col-md-12">
                            <div class="col-md-9" style="padding: 0px">
                                <label>Subinventory : </label>
                                <span name="subinv" id="subinv"></span>
                            </div>
                            <div class="col-md-2" style="padding: 0px">
                                
                            </div>
                        </div>
                    </div>
                     <div>
                        <div class="col-md-6">
                            <div class="col-md-9" style="padding: 0px">
                                <input class="form-control" id="in_sj" placeholder="Surat Jalan" required="" type="text"/>
                            </div>
                            <div class="col-md-2" style="padding: 0px; margin-left: 20px">
                                <button class="btn btn-default" id="b_generate" name="b_generate">
                                    GENERATE
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control selectVendor" id="sel_vendor" name="sel_vendor" required="">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding: 0px;margin-top: 30px">
                        <div class="col-md-6">
                            <div>Tanggal Terima</div>
                            <div class="input-group" >
                                <input class="datetime form-control time-form" data-date-format="yyyy-mm-dd hh:ii:ss" id="in_dateRcv" name="in_dateRcv" placeholder="Tanggal Terima">
                                    <div class="input-group-addon" style="padding-left: 10px;padding-right: 10px">
                                        <span class="glyphicon glyphicon-th">
                                        </span>
                                    </div>
                                </input>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>Tanggal Shipment</div>
                            <div class="input-group date" data-provide="datepicker">
                                <input class="form-control" id="in_dateShip" name="in_dateShip" placeholder="Tanggal Shipment">
                                    <div class="input-group-addon" style="padding-left: 10px;padding-right: 10px">
                                        <span class="glyphicon glyphicon-th">
                                        </span>
                                    </div>
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-primary box-solid" style="margin-top: 20px">
                <div class="box-header with-border">
                    <div class="col-md-1" style="padding: 0px">
                        <h4 style="margin-top: 8px; margin-bottom: 8px">
                            Data Line
                        </h4>
                    </div>
                    <div class="col-md-11" style="padding: 0px">
                        <div class="col-md-6">
                            <select class="form-control selectItem" id="sel_item" name="sel_item">
                                <option>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" id="in_qty" name="in_qty" placeholder="Quantity" type="number"/>
                        </div>
                        <div class="col-md-1" style="padding: 0px">
                            <button class="btn btn-default btn-block" id="b_add" name="b_add" type="submit">
                                ADD
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div id="loading" style="display: none;text-align: center;width:100%;margin-top: 0px;margin-bottom: 20px">
                        <img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading11.gif' ?>"/>
                    </div>
                    <div class="col-md-12" style="padding: 2px">
                        <div class="col-md-3">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        ITEM
                                    </b>
                                </h5>
                            </center>
                        </div>
                        <div class="col-md-1">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        PO
                                    </b>
                                </h3>
                            </center>
                        </div>
                         <div class="col-md-1">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        RECEIPT
                                    </b>
                                </h3>
                            </center>
                        </div>
                         <div class="col-md-2">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        NOT DELIVERED 
                                    </b>
                                </h3>
                            </center>
                        </div>
                        <div class="col-md-2">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        KETERANGAN
                                    </b>
                                </h5>
                            </center>
                        </div>
                        <div class="col-md-1">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        CHECK
                                    </b>
                                </h5>
                            </center>
                        </div>
                        <div class="col-md-2">
                            <center>
                                <h5 style="margin: 0px">
                                    <b>
                                        INPUT
                                    </b>
                                </h5>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-12" id="div_root" name="div_root" style="padding: 0px">
                       
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 30px">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary col-md-12" id="b_save" name="b_save" type="submit">
                            SAVE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
