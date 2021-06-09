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
                                <div class="col-lg-12" style="margin-top:0px">
                                    <form action="<?php echo base_url('ECommerce/ExportPelanggan/exportexcel');?>" method="post">
                                        <table id="filter">
                                            <tr>
                                                <td style="padding-left:0px;padding-right:10px;">
                                                    <span class="align-middle"><label style=>&emsp;&emsp;Periode Tanggal Order&emsp;&emsp;:&emsp;&emsp;&nbsp;</label></span>
                                                </td>
                                                <td>
                                                    <input size="30" type="text" class="form-control" name="dateBegin" id="dateBegin" placeholder="From" autocomplete="off">
                                                </td>
                                                <td>
                                                    <span class="align-middle">s/d</span>
                                                </td>
                                                <td>
                                                    <input size="30" type="text" class="form-control" name="dateEnd" id="dateEnd" placeholder="To" autocomplete="off">
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:10px;">
                                            <label class="col-md-3" style="margin-bottom:0px;padding-right:0px;">&emsp;Name &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:</label>
                                            <select class="form-control" id="CustId" name="CustId">
                                                <option></option>
                                                <?php foreach ($NamaUser as $Nama) {?>
                                                <option value="<?= $Nama['cust_id']; ?>">
                                                    <?= $Nama['display_name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <aside style="width:10px;"></aside>
                                        </div>
                                        <div style="display:flex;align-items:center;justify-content:space-between;width:100%;padding-right:10px;margin-top:10px">
                                            <label class="col-md-3" style="margin-bottom:0px;padding-right:0px;">&emsp;Item Category &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;:</label>
                                            <select class="form-control" id="TermId" name="TermId">
                                                <option></option>
                                                <?php foreach ($ItemCat as $Nama) {?>
                                                <option value="<?= $Nama['term_id']; ?>">
                                                    <?= $Nama['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <aside style="width:10px;"></aside>
                                        </div>
                                        <br>
                                        <button id="btn-export" class="btn btn-md btn-success glyphicon glyphicon-export pull-right" style="margin-right:18px;">&emsp;Export</button>
                                    </form>
                                    <button class="btn btn-primary pull-right" id="btn-search" style="margin-right:18px;"></i>Search</button>
                                    <a href="<?php echo base_url('ECommerce/ExportPelanggan/exportexcelAll'); ?>" target="_blank" id="btn-export-all" class="btn btn-md btn-success" type="button" style="margin-left:20px;"><i class="glyphicon glyphicon-export"></i>&emsp;Export All</a>
                                    <div id="divdataTableExport" class="col-lg-12" style="margin-top:20px">
                                        <table id="dataTableExport" class="table table-striped table-bordered table-hover text-center rowTable">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th class="text-center">No</th>
                                                    <th class="text-center" width="100px">Nomor Order</th>
                                                    <th class="text-center">Tgl Pemesanan</th>
                                                    <th class="text-center">Status Order</th>
                                                    <th class="text-center" width="150px">Nama Pelanggan</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">Customer Category</th>
                                                    <th class="text-center">Registration Date</th>
                                                    <th class="text-center" width="150px">No.Telp</th>
                                                    <th class="text-center" width="300px">Alamat</th>
                                                    <th class="text-center" width="100px">Kecamatan</th>
                                                    <th class="text-center" width="120px">Kota/Kabupaten</th>
                                                    <th class="text-center">Provinsi</th>
                                                    <th class="text-center" width="80px">Kode Pos</th>
                                                    <th class="text-center">Order Item Code</th>
                                                    <th class="text-center" width="150px">Order Item Name</th>
                                                    <th class="text-center" width="200px">Category</th>
                                                    <th class="text-center" width="100px">Harga Per Pcs</th>
                                                    <th class="text-center">Qty Beli</th>
                                                    <th class="text-center" width="100px">Berat Per Item</th>
                                                    <th class="text-center">Ekspedisi Pengiriman</th>
                                                    <th class="text-center" width="100px">Biaya Kirim</th>
                                                    <th class="text-center">Metode Pembayaran</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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