<style type="text/css">
    #filter tr td {
        padding: 5px
    }

    .text-left span {
        font-size: 36px
    }
</style>
<form action="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/saveActionAkuntansi') ?>" method="POST">
    <section class="content">
        <div class="inner">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-left ">
                                <span><b>Unprocessed Invoice</b></span>
                                <input type="hidden" name="batch_num" value="<?php echo $batch_num ?>">
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box box-primary box-solid">
                                <div class="box-body">
                                    <!-- <div style="overflow: auto;"> -->
                                    <table id="unprocessTabel" class="table table-striped table-bordered table-hover table-responsive text-center" style="width:100%">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-center">No</th>
                                                <th class="text-center">Invoice ID</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Vendor Name</th>
                                                <th class="text-center">Invoice Number</th>
                                                <th class="text-center">Receipt Number</th>
                                                <th class="text-center" style="width:18%">Action</th>
                                                <th class="text-center">Invoice Date</th>
                                                <th class="text-center">PPN</th>
                                                <th class="text-center">Tax Invoice Number</th>
                                                <th class="text-center">Invoice Amount</th>
                                                <th class="text-center">Po Amount</th>
                                                <th class="text-center">PO Number</th>
                                                <th class="text-center">Purchasing Submit Date</th>
                                                <th class="text-center">Alasan</th>
                                                <th class="text-center">PIC</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbodyUnproses">
                                            <?php $no = 1;
                                            foreach ($unprocess as $u) { ?>
                                                <tr>
                                                    <td><?php echo $no ?></td>
                                                    <td><?php echo $u['INVOICE_ID'] ?></td>
                                                    <td>
                                                        <?php if ($u['LAST_PURCHASING_INVOICE_STATUS'] == 1) {
                                                            echo 'Belum Approved';
                                                        }
                                                        if ($u['LAST_PURCHASING_INVOICE_STATUS'] == 2) {
                                                            echo 'Approved';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $u['VENDOR_NAME'] ?></td>
                                                    <td><strong><?php echo $u['INVOICE_NUMBER'] ?></strong></td>
                                                    <td><?php echo $u['RECEIPT_NUM'] ?></td>
                                                    <td data-id="<?= $u['INVOICE_ID'] ?>" batch_number="<?= $u['BATCH_NUMBER'] ?>" class="ganti_<?= $u['INVOICE_ID'] ?>">
                                                        <a title="Detail..." href="<?php echo base_url('AccountPayables/MonitoringInvoice/Unprocess/DetailUnprocess/' . $u['BATCH_NUMBER'] . '/' . $u['INVOICE_ID']); ?>" class="btn btn-info btn-sm"><i class="fa fa-file-text-o"></i>
                                                        </a>
                                                        <?php if ($u['LAST_FINANCE_INVOICE_STATUS'] == 1) { ?>
                                                            <a title="Terima" type="submit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-primary btn-sm" value="2" name="proses"><i class="glyphicon glyphicon-ok"></i></a>
                                                        <?php } else { ?>
                                                            <span data-id="<?= $u['INVOICE_ID'] ?>" class="btn btn-success" value="2" name="success">Success</span>
                                                        <?php } ?>
                                                        <a title="Tolak" type="sumbit" data-id="<?= $u['INVOICE_ID'] ?>" onclick="prosesInvMI(this)" class="btn btn-danger btn-sm" value="3" name="proses"> <i class="glyphicon glyphicon-remove"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-primary btn-sm btnReceiptMIA" value="<?php echo $u['INVOICE_NUMBER'] ?>" title="receipt"><i class="fa fa-sticky-note"></i></button>
                                                        <button type="button" class="btn btn-info btn-sm" onclick="window.open('http://produksi.quick.com/cetak-lpba-qrcode-prod/?akun=AA%20AKUN%20TSR%2010&org=124&rcpt1=<?php echo $u['RECEIPT_NUM'] ?>&rcpt2=<?php echo $u['RECEIPT_NUM'] ?>&noind=<?= $noind ?>')" value="<?php echo $u['RECEIPT_NUM'] ?>" title="load pdf"><i class="fa fa-file-pdf-o"></i></button>
                                                    </td>
                                                    <td data-order="<?php echo date('Y-m-d', strtotime($u['INVOICE_DATE'])) ?>">
                                                        <?php echo date('d-M-Y', strtotime($u['INVOICE_DATE'])) ?></td>
                                                    <td><?php echo $u['PPN'] ?></td>
                                                    <td><?php echo $u['TAX_INVOICE_NUMBER'] ?></td>
                                                    <td class="inv_amount">
                                                        <?php if ($u['INVOICE_AMOUNT'] == NULL) {
                                                            echo 'Rp.' . ' ,-';
                                                        } else {
                                                            echo 'Rp. ' . number_format($u['INVOICE_AMOUNT'], 0, '.', '.') . ',00-';
                                                        }; ?>
                                                    </td>
                                                    <td class="po_amount">
                                                        <?php if ($u['PO_AMOUNT'] == NULL) {
                                                            echo 'Rp.' . ' ,-';
                                                        } else {
                                                            echo 'Rp. ' . number_format(round($u['PO_AMOUNT']), 0, '.', '.') . ',00-';
                                                        }; ?>
                                                    </td>
                                                    <td><?php echo $u['PO_NUMBER'] ?></td>
                                                    <input type="hidden" value="<?php echo $u['PO_NUMBER'] ?>" id="Po_NumInvAkt">
                                                    <td><?php echo $u['LAST_STATUS_PURCHASING_DATE'] ?></td>
                                                    <td class="kasihInputInvoice">

                                                        <input type="hidden" name="id_reason[]" value="<?php echo $u['INVOICE_ID'] ?>">
                                                    </td>
                                                    <td><?php echo $u['SOURCE'] ?></td>
                                                </tr>
                                            <?php $no++;
                                            } ?>
                                        </tbody>
                                    </table>
                                    <div class="col-md-2 pull-right">
                                        <button type="submit" class="btn btn-primary pull-right" style="margin-top: 10px">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<div class="modal fade mdlInvoiceBermasalah" id="mdlInvoiceBermasalah" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:800px;" role="document">
        <div class="modal-content">
            <div class="modal-header" style="width: 100%;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="width: 100%;">
                <div class="modal-tabel">
                </div>

                <div class="modal-footer">
                    <div class="col-md-2 pull-left">
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>