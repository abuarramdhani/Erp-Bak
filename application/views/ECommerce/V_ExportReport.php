<style type="text/css">
#filter tr td {
    padding: 5px
}
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1><b>EXPORT PELANGGAN</b></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                Export Excel dari tokoquick.id
                            </div>
                            <div class="box-body">
                                <form id="filter-date" style="margin-left:40px" method="post" action="<?php echo base_url('ECommerce/ExportPelanggan/getItemByDate'); ?>">
                                    <table id="filter">
                                        <tr>
                                            <td>
                                                <span class="align-middle"><label>Periode Tanggal Receipt</label></span>
                                            </td>
                                            <td>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input size="30" type="text" class="form-control" name="dateBegin" id="dateBegin" placeholder="From">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="align-middle">s/d</span>
                                            </td>
                                            <td>
                                                <div class="input-group date" data-provide="datepicker">
                                                    <input size="30" type="text" class="form-control" name="dateEnd" id="dateEnd" placeholder="To">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="submit" id="btn-search-export2" class="btn btn-primary" value="Search" />
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="col-lg-12">
                                        <button class="btn btn-md btn-success pull-right" style="margin-right:20px;" type="submit" disabled><i class="glyphicon glyphicon-export"></i>EXPORT</button>

                                    </div>
                                </form>
                                <div class="col-lg-12">
                                    <hr size="30">
                                </div>
                                <br>
                                <div class="col-lg-12" style="margin-top:30px">
                                    <form method="post" action="<?php echo base_url('ECommerce/ExportPelanggan/tableExport/'); ?>">
                                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:10px;">
                                            <label class="col-md-3 pull-right" style="margin-bottom:0px;">&emsp;&emsp;Name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:</label>
                                            <select class="form-control" id="user_id" name="user_id" disabled>
                                                <option></option>
                                                <?php foreach ($NamaUser as $Nama) {?>
                                                <option value="<?= $Nama['display_name']; ?>">
                                                    <?= $Nama['display_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <button id="btn-name" type="button" class="btn btn-md btn-success pull-right enable" style="margin-left:10px;">Enable</button>
                                            <aside style="width:10px;"></aside>
                                        </div>
                                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:10px;margin-top:10px">
                                            <label class="col-md-3 pull-right" style="margin-bottom:0px;">&emsp;&emsp;Item Category&emsp;&emsp;&emsp;&emsp;&nbsp;:</label>
                                            <select class="form-control" id="cat_name" name="cat_name" disabled>
                                                <option></option>
                                                <?php foreach ($ItemCat as $Nama) {?>
                                                <option value="<?= $Nama['name']; ?>">
                                                    <?= $Nama['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <button id="btn-cat" type="button" class="btn btn-md btn-success pull-right enable" style="margin-left:10px;">Enable</button>

                                            <aside style="width:10px;"></aside>
                                        </div>
                                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:10px;margin-top:10px">
                                            <label class="col-md-3 pull-right" style="margin-bottom:0px;">&emsp;&emsp;Item Name&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</label>
                                            <select class="form-control" id="item_name" name="item_name" disabled>
                                                <option></option>
                                                <?php foreach ($ItemName as $NamaItem) {?>
                                                <option value="<?= $NamaItem['order_item_name']; ?>">
                                                    <?= $NamaItem['order_item_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <button id="btn-item" type="button" class="btn btn-md btn-success pull-right enable" style="margin-left:10px;">Enable</button>

                                            <aside style="width:10px;"></aside>
                                        </div>
                                        <br>

                                        <a href="<?php echo base_url('ECommerce/ExportPelanggan/exportexcelAll'); ?>" target="_blank" id="btn-export-all" class="btn btn-md btn-success pull-right" type="button" style="margin-right:20px;"><i class="glyphicon glyphicon-export"></i>&emsp;Export All</a>
                                        <!-- <a id="btn-search-export-all" class="btn btn-md btn-primary pull-right" type="button" style="margin-right:10px;">Search All</a> -->
                                        <button formaction="<?php echo base_url('ECommerce/ExportPelanggan/exportexcel'); ?>" target="_blank" id="btn-export" class="btn btn-md btn-success pull-right" type="submit" style="margin-right:10px;" disabled><i class="glyphicon glyphicon-export"></i>&emsp;Export</button>
                                        <input type="submit" id="btn-search-export" class="btn btn-primary pull-right" style="margin-right:10px;" value="Search" disabled />
                                    </form>
                                    <br>
                                    <br>
                                    <div id="divdataTableExport" class="col-lg-12" style="margin-top:20px">
                                        <table id="dataTableExport" class="table table-striped table-bordered table-hover text-center rowTable">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Nomor Order</th>
                                                    <th class="text-center" width="150px">Nama Pelanggan</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Registration Date</th>
                                                    <th class="text-center">No.Telp</th>
                                                    <th class="text-center" width="300px">Alamat</th>
                                                    <th class="text-center" width="100px">Kecamatan</th>
                                                    <!-- <th class="text-center" width="150px">Shipping Name</th> -->
                                                    <!-- <th class="text-center" width="200px">Shipping Address</th> -->
                                                    <th class="text-center" width="120px">Kota/Kabupaten</th>
                                                    <th class="text-center">Provinsi</th>
                                                    <th class="text-center">Kode Pos</th>
                                                    <th class="text-center">Order Item Code</th>
                                                    <th class="text-center" width="150px">Order Item Name</th>
                                                    <th class="text-center" width="200px">Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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