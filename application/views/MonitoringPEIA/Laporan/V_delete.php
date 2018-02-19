<!-- Modal -->
<?php $no = 1; foreach ($credit as $cl) { ?>
<div class="modal fade" id="delete<?php echo $cl['LINE_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CONFIRM DELETE CREDIT LIMIT NUMBER <?php echo $cl['LINE_ID']; ?></h4>
      </div>
      <div class="modal-body">
        <table id="creditLimit" class="table table-striped table-bordered table-responsive table-hover">
          <thead style="background:#22aadd; color:#FFFFFF;">
            <th style="text-align:center">NO</th>
            <th style="text-align:center">BRANCH</th>
            <th style="text-align:center">CUSTOMER NAME</th>
            <th style="text-align:center">ACCOUNT NUMBER</th>
            <th style="text-align:center">OVERALL CREDIT LIMIT</th>
            <th style="text-align:center">EXPIRED DATE</th>
          </thead>
          <tbody>
            <tr>
              <td style="text-align:center"><?php echo $no++; ?></td>
              <td style="text-align:center"><?php echo $cl['NAME']; ?></td>
              <td style="text-align:center"><?php echo $cl['PARTY_NAME']; ?></td>
              <td style="text-align:center"><?php echo $cl['ACCOUNT_NUMBER']; ?></td>
              <td style="text-align:center"><?php echo $cl['OVERALL_CREDIT_LIMIT']; ?></td>
              <td style="text-align:center"><?php echo $cl['EXPIRED_DATE']; ?></td>
            </tr>
          </tbody>
        </table>
        <p>Press the <u><b>DELETE</b></u> button to continue deleting this data.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
        <a class="btn btn-danger" href="<?php echo base_url(); ?>AccountReceivables/CreditLimit/Delete/<?php echo $cl['LINE_ID']; ?>">DELETE</a>
      </div>
    </div>
  </div>
</div>
<?php } ?>