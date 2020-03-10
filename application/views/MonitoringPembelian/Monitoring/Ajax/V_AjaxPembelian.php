<table class="table table-striped table-bordered table-hover text-left " id="tblHistoryPembelian" style="font-size:12px;">
  <thead>
    <tr class="bg-primary">
      <th width="2%"><center>No</center></th>
      <th width="2%"><center>STATUS CETAK</center></th>
      <th width="2%"><center>NO DOKUMEN</center></th>
      <th width="5%"><center>UPDATE DATE</center></th>
      <th width="5%"><center>ITEM CODE</center></th>
      <th width="30%"><center>ITEM DESCRIPTION</center></th>
      <th width="4%"><center>UOM1</center></th>
      <th width="4%"><center>UOM2</center></th>
      <th width="15%"><center>BUYER</center></th>
      <th width="2%"><center>PRE-PROCESSING LEAD TIME</center></th>
      <th width="%"><center>PREPARATION PO</center></th>
      <th width="%"><center>DELIVERY</center></th>
      <th width="2%"><center>TOTAL PROCESSING LEAD TIME</center></th>
      <th width="2%"><center>POST-PROCESSING LEAD TIME</center></th>
      <th width="2%"><center>TOTAL LEAD TIME</center></th>
      <th width="2%"><center>MOQ</center></th>
      <th width="2%"><center>FLM</center></th>
      <th width="10%"><center>NAMA APPROVER PO</center></th>
      <th width=""><center>KETERANGAN</center></th>
      <th width=""><center>RECEIVE CLOSE TOLERANCE</center></th>
      <th width=""><center>TOLERANCE</center></th>
      <th width="7%"><center>STATUS</center></th>

    </tr>
  </thead>
  <tbody>
    <?php
    $no = 0;
    foreach ($Input as $row):
      $no++;
    ?>
        <tr row-id="1">
          <td><?php echo $no ?></td>
          <td id="cetak"
          <?php if ($row['CETAK'] == '0') {
            echo 'style="color: deepskyblue;"';
          } elseif ($row['CETAK'] == '1') {
            echo 'style="color: crimson;"';
          }?>>
          <b>
            <?php if ($row['CETAK'] == '0') {
                echo 'BELUM CETAK';
              } elseif ($row['CETAK'] == '1') {
                echo 'SUDAH CETAK';
              }
              ?>
          </b>

          </td>
          <td><?php echo $row['UPDATE_ID']?></td>
          <td><?php echo $row['UPDATE_DATE']?></td>
          <td><?php echo $row['SEGMENT1']?></td>
          <td><?php echo $row['DESCRIPTION']?></td>
          <td><?php echo $row['PRIMARY_UOM_CODE']?></td>
          <td><?php echo $row['SECONDARY_UOM_CODE']?></td>
          <td><?php echo $row['FULL_NAME']?></td>
          <td><?php echo $row['PREPROCESSING_LEAD_TIME']?></td>
          <td><?php echo $row['PREPARATION_PO']?></td>
          <td><?php echo $row['DELIVERY']?></td>
          <td><?php echo $row['FULL_LEAD_TIME']?></td>
          <td><?php echo $row['POSTPROCESSING_LEAD_TIME']?></td>
          <td><?php echo $row['TOTAL_LEADTIME']?></td>
          <td><?php echo $row['MINIMUM_ORDER_QUANTITY']?></td>
          <td><?php echo $row['FIXED_LOT_MULTIPLIER']?></td>
          <td><?php echo $row['ATTRIBUTE18']?></td>
          <td><?php echo $row['KETERANGAN']?></td>
          <td><?php echo $row['RECEIVE_CLOSE_TOLERANCE']?></td>
          <td><?php echo $row['QTY_RCV_TOLERANCE']?></td>
          <td <?php if  ($row['STATUS'] == 'UNAPPROVED'){
                echo 'style="background-color: #ffc313";';
              } elseif ($row['STATUS'] == 'APPROVED') {
                  echo 'style="background-color: 	#529ecc";';
              } elseif ($row['STATUS'] == 'REJECTED') {
                  echo 'style="background-color: 	#aa1d05";';
                }
                ?>><?php echo $row['STATUS']?></td>

        </tr>
    <?php endforeach ?>
  </tbody>
</table>
<script type="text/javascript">
$(document).ready( function () {
    $('#tblHistoryPembelian').DataTable(  {
    	columnDefs: [
    		{ targets: '_all', orderable: false}
    	],
        initComplete: function () {
               	this.api().columns([19]).every( function () {
                var column = this;
                var select = $('<select style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
                    .appendTo("#filter")
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
                 	column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                	} );
            	} );
            	this.api().columns([2]).every( function () {
	                var column1 = this;
	                var select1 = $('<select id="nodok" name="nodok" class="nodok" style="background: transparent; line-height: 1; border: 0; padding: 0; border-radius: 0; width: 120%; position: relative; z-index: 10;font-size: 1em;"><option value="">--Show All--</option></select>')
	                    .appendTo("#filterid")
	                    .on( 'change', function () {
	                        var val1 = $.fn.dataTable.util.escapeRegex(
	                            $(this).val()
	                        );
	                        column1
	                            .search( val1 ? '^'+val1+'$' : '', true, false )
	                            .draw();
	                    } );
	                	column1.data().unique().sort().each( function ( d, j ) {
	                    select1.append( '<option value="'+d+'">'+d+'</option>' )
	                } );
            	} );


        }
    });

} );
</script>
