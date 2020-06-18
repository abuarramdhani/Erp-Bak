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
                                    Order Sharpening
                                 </b>
                             </h1>
                         </div>
                     </div>
                     <div class="col-lg-1 ">
                        <div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="">
                                <i aria-hidden="true" class="fa fa-refresh fa-2x">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                           <b>Input Order</b>
                       </div>
                       <div class="box-body">
                            <div class="row">
                                <div class="col-md-11" style="padding-top: 5px">
                                    <input type="hidden" id="no_order" name="no_order" value="<?php echo $regen ?>">
                                    <input type="hidden" id="reff_number" name="reff_number" value="<?php echo $reffBuilder ?>">
                                    <div class="row text-right">
                                        <label style="font-size: 15px"><?php echo date("l, d F Y") ?></label>
                                    </div>
                                    <br>
                                    <div class="alert-warning" id="alert-message" style="margin-bottom: 5px"></div>
                                    <form action="#" method="post" id="form">
                                    <div class="row">
                                        <div class="col-md-4 " style="text-align: right;">
                                            <label>Kode Barang</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select name="item_sharp" id="item_sharp" class="form-control select4" style="width: 400px;padding-left: 10px" onchange="getDeskripsi(this)" data-placeholder="Pilih Item">
                                                    <option></option>
                                                    <?php foreach ($item as $a) { ?>
                                                    <option><?php echo $a['SEGMENT1']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <small id="item_error" class="form-text text-danger" style="display: none;">Item belum terpilih</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>Deskripsi Barang</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="desc_sharp" id="desc_sharp" class="form-control" style="width: 400px;padding-left: 10px" placeholder="Deskripsi Otomatis" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>Quantity</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="number" min="0" name="qty_sharp" id="qty_sharp" class="form-control" style="width: 400px" placeholder="Total Qty">
                                                <small id="qty_error" class="form-text text-danger" style="display: none;">Tentukan jumlah terlebih dahulu</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>Sub Inventory</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                              <select id="subinv" name="subinv" class="form-control select2" style="width: 400px" data-placeholder="Pilih Sub Inventory">
                                                <!-- <option value="" disabled="" selected="">Pilih Sub Inventory</option> -->
                                                <option></option>
                                                <option>TR-DM</option>
                                                <option>TR-TKS</option>
                                              </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4" style="text-align: right;">
                                            <label>Locator</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                               <select id="locator" name="locator" class="form-control select2" style="width:400px" data-placeholder="Pilih locator" >
                                                            <option></option>
                                                            <!-- <?php foreach ($locator as $loc) { ?>
                                                            <option name="locator" value="<?php echo $loc['INVENTORY_LOCATION_ID'] ?>"><?php echo $loc['SEGMENT1'] ?></option>
                                                            <?php } ?> -->
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                <!--
                                    <div class="row">
                                        <div class="col-md-5 " style="text-align: right;">
                                            <label>Tanggal Order</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="dateOrder" id="tgl_order_sharp" class="form-control datepicker" style="width: 200px; padding-left: 12px" placeholder="Pilih Tanggal Order">
                                            </div>
                                        </div>
                                    </div>
                                -->
                                    <!--
                                    <div class="row">
                                        <div class="col-md-5 " style="text-align: right;">
                                            <label>Tanggal Selesai</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="text" name="dateFinish" id="tgl_selesai_sharp" class="form-control datepicker" style="width: 200px; padding-left: 12px" placeholder="Pilih Tanggal Selesai">
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                </div>
                                </div>
                        </div>
                        <!-- <div class="panel panel-body"> -->
                        <div class="panel-body">
                        <div class="col-md-6 text-right">
                            <button id="btnreset" class="btn btn-danger"><i class="fa fa-refresh"></i><b> reset</b></button>
                            <!-- <input type="button" id="btnreset" class="btn btn-danger" value="reset" /> -->
                        </div>
                        </form>
                        <div class="col-md-2">
                            <a href="javascript:void(0);" id="addResponsbility" onclick="addRowOrderSharpening()" class="btn btn-primary" title="Insert data"><i class="fa fa-plus"></i><b> insert</b></a>
                        </div>
                        
                        </div>
                        <form name="Orderform" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" action="<?php echo base_url('OrderSharpening/Order/Insert'); ?>" method="post">
                            <div class="panel-body">
                            <input type="hidden" name="dateOrder" value="<?php echo date("d F Y") ?>">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover text-center" style="table-layout: fixed;" name="tblUserResponsbility" id="tblUserResponsbility">
                                <thead>
                                    <tr class="bg-primary">
                                        <th >Sub Inventory</th>
                                        <th >Locator</th>
                                        <th >Kode Barang</th>
                                        <th >Deskripsi Barang</th>
                                        <th width="10%">QTY</th>
                                        <th width="10%">Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyUserResponsibility">

                                </tbody>
                                </table>
                            </div>
                            </div>

                            <div class="panel-footer">
                                <div class="row text-right" style="padding-right: 10px">
                                    <button type="submit" title="Generate to Pdf" class="btn btn-success"><b>Generate</b></button>
                                </div>
                            </div>

                        </form>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<script type="text/javascript">
    var subinv = document.getElementById("subinv");
    subinv.onchange = function(e) {
      subinv.disabled = (subinv.value !== "");
    };

    var locator = document.getElementById("locator");
    locator.onchange = function(e) {
      locator.disabled = (locator.value !== "");
    };

    // var tbodyUserResponsibility = document.getElementById("tbodyUserResponsibility");
    // tbodyUserResponsibility.onchange = function(e) {
    //   locator.disabled = (tbodyUserResponsibility.value !== "");
    // }; 
    $(document).ready(function(){
    $("#btnreset").click(function(){
         $("#subinv").removeAttr("disabled");
         $("#locator").removeAttr("disabled");
    /* Single line Reset function executes on click of Reset Button */
    $("#form")[0].reset();
    });
});

</script>
