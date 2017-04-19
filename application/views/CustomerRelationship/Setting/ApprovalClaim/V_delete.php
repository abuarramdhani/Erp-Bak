<?php $no = 1; foreach ($approval as $ac) { ?>
<div class="modal fade" id="delete<?php echo $ac['claim_approval_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-bordered table-hover text-left">
              <thead>
                <tr class="bg-primary">
                  <th width="5%"><center>No</center></th>
                  <th width="35%"><center>Employee Name</center></th>
                  <th width="30%"><center>Branch</center></th>
                  <th width="20%"><center>Status</center></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td align="center">
                    <?php echo $no++; ?>
                  </td>
                  <td><?php echo $ac['employee_name']; ?></td>
                  <td><?php echo $ac['location_name']; ?></td>
                  <td><?php echo $ac['status']; ?></td>
                </tr>
              </tbody>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="<?php echo base_url('CustomerRelationship/Setting/ApprovalClaim/Delete/'.$ac['claim_approval_id']); ?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>
<?php } ?>