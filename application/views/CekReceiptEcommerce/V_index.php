<section class="content-header">
    <h3> Cek Receipt E-Commerce </h3>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table class="table table-fit table-bordered table-responsive tblMainMenuCRE" width="100%">
                        <thead>
                            <tr class="bg-primary">
                                <th class="text-center" style="vertical-align: middle;">No. </th>
                                <th class="text-center" style="vertical-align: middle;">Cust. Num</th>
                                <th class="text-center" style="vertical-align: middle;">Cust. Name</th>
                                <th class="text-center" style="vertical-align: middle;">Receipt Number</th>
                                <th class="text-center" style="vertical-align: middle;">Receipt Date</th>
                                <th class="text-center" style="vertical-align: middle;">Amount</th>
                                <th class="text-center" style="vertical-align: middle;">Status</th>
                                <th class="text-center" style="vertical-align: middle;">Applied Amount</th>
                                <th class="text-center" style="vertical-align: middle;">Unapplied Amount</th>
                                <th class="text-center" style="vertical-align: middle;">Receipt Method</th>
                                <th class="text-center" style="vertical-align: middle;">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 0;
                            foreach ($receipt as $key => $rcpt) {
                                $no++;
                            ?>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $no?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['CUSTOMER_NUMBER']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['NAMA_CUSTOMER']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['RECEIPT_NUMBER']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['RECEIPT_DATE']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['AMOUNT']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['STATUS']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['APPLIED_AMOUNT']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['UNAPPLIED_AMOUNT']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['RECEIPT_METHOD']?></td>
                                <td class="text-center" style="vertical-align: middle;"><?php echo $rcpt['COMMENTS']?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.tblMainMenuCRE').DataTable({
                'scrollX': true
            });
        })
    </script>
</section>