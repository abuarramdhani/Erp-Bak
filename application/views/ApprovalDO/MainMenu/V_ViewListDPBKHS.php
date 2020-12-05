<style>    
    label {
        font-weight: normal !important;
    }
    .label {
        font-size: 90% !important;
        display: inline-block;
        width: 100px;
        padding: 5px;
    }
    .mailbox-attachments li {
        width: 225px !important;
    }    
    .mr-20px {
        margin-right: 20px;
    }
    .swal-font-small {
        font-size: 1.5rem !important;
    }
</style>

<section class="content-header">
    <h1><?= $UserMenu[0]['user_group_menu_name'] ?> </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List Daftar Penerimaan Barang KHS</h3>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                        <div class="panel panel-body">
                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                <label for="slcADOSearchBy" class="col-sm-2 control-label">Cari Berdasarkan</label>
                                <div class="input-group col-sm-6">
                                    <span class="input-group-addon"><i style="width:15px;" class="fa fa-search"></i></span>
                                    <select id="slcADOSearchBy" class="form-control select2" style="width: 35%;" disabled>
                                        <option selected disabled>Creation Date</option>
                                    </select>
                                    <input id="txtADOSearchByCreationDate" type="text" class="form-control pull-right" style="width: 65%;">
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <p class="bold">List DPB KHS</p>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 text-center divADOLoadingTable">
                                    <label class="control-label">
                                        <p><img src="<?= base_url('assets/img/gif/loading5.gif') ?>" style="width:30px"> Sedang Memproses ...</p> 
                                    </label>
                                </div>
                                <table class="table table-bordered table-hover table-striped tblADOList" style="display: none; width: 100%">
                                    <thead>
                                        <tr class="bg-primary" height="50px">
                                            <th class="text-center">No</th>
                                            <th class="text-center text-nowrap">No PR</th>
                                            <th class="text-center text-nowrap">Creation Date</th>
                                            <th class="text-center text-nowrap">Jns. Kend.</th>
                                            <th class="text-center text-nowrap">No. Kend.</th>
                                            <th class="text-center text-nowrap">Nama Supir</th>
                                            <th class="text-center text-nowrap">Kontak Sopir</th>
                                            <th class="text-center text-nowrap">Vendor Exp.</th>
                                            <th class="text-center text-nowrap">Est. Datang</th>
                                            <th class="text-center text-nowrap">Tgl Kirim</th>
                                            <th class="text-center no-orderable">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($DPBKHSList as $key => $val) : ?>
                                            <tr>
                                                <td class="text-right"><?= $key+1 ?></td>
                                                <td class="text-right"><?= $val['NO_PR'] ?></td>
                                                <td class="text-right"><?= $val['CREATION_DATE'] ?></td>
                                                <td class="text-left"><?= $val['JENIS_KENDARAAN'] ?></td>
                                                <td class="text-left"><?= $val['NO_KENDARAAN'] ?></td>
                                                <td class="text-left"><?= $val['NAMA_SUPIR'] ?></td>
                                                <td class="text-left"><?= $val['KONTAK_SOPIR'] ?></td>
                                                <td class="text-left"><?= $val['VENDOR_EKSPEDISI'] ?></td>
                                                <td class="text-left"><?php if(isset($val['ESTIMASI_DATANG'])) echo date("d-m-Y H:i:s",strtotime($val['ESTIMASI_DATANG'])) ?></td>
                                                <td class="text-left"><?php if(isset($val['TGL_KIRIM'])) echo date("d-M-Y",strtotime($val['TGL_KIRIM'])) ?></td>
                                                <td class="text-center">
                                                    <form action="<?= base_url('ApprovalDO/View/detailKHS') ?>" method="post" target="_blank">
                                                        <input type="hidden" name="data-pr" value="<?= $val['NO_PR'] ?>">
                                                        <button type="submit" title="Detail" class="btn btn-default">
                                                            <i class="fa fa-book"></i>&nbsp; Detail
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                
                </div>
            </div>
        </div>
    </div>
</section>
