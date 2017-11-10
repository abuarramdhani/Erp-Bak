<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
			</div>
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b>Permintaan Dana Kasir</b></h1>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Parameter Pencarian
							</div>
							<div class="box-body">
								<fieldset class="row2" style="background:#F8F8F8 ;">
			                    	<div class="box-body">
				                     	<table width="100%">
				                     		<tr>
				                     			<td class="col-lg-2">
				                     				<label for="exampleInputPassword1">Tanggal Saldo Kas</label>
				                     			</td>
				                     			<td class="col-lg-3 pull-left">
				                     				<div class="input-group">
													<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
													<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
														<input id="tanggal_awal" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="tanggal_awal" riquaite placeholder=" Date" autocomplete="off" autoclose="true">
													</div>
													</div>
				                     			</td>
				                     		</tr>
				                     	</table>
									</div>
							 	</fieldset>
							 	<div class="box-footer">
							 		<a class="btn btn-primary btn-sm" id="btnBalanceDate"><b>Submit</b></a>
				            	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Hasil Pencarian
							</div>
							<div class="box-body">
								<form method="post" action="<?php echo base_url('AccountPayables/PermintaanDana/create') ?>" id="formDemand">
									<input type="hidden" value="<?php echo date("Y-m-d H:i:s")?>" name="hdnDate" />
									<input type="hidden" value="<?php echo $this->session->user; ?>" name="hdnUser" />
									<input type="hidden" name="hdnBalanceDate" id="hdnBalanceDate" />
									<fieldset class="row2" style="background:#F8F8F8 ;">
										<div class="box-body">
											<div class="row">
												<div class="col-lg-12">
													<h3 class="text-center"><strong>PERMINTAAN DANA KASIR</strong></h3>
												</div>
											</div>
											<br />
											<div class="row">
												<div class="col-lg-4">
													<table>
														<tr>
															<td>KEPADA</td>
															<td>&nbsp;:&nbsp;</td>
															<td>KEUANGAN</td>
														</tr>
														<tr>
															<td>DARI</td>
															<td>&nbsp;:&nbsp;</td>
															<td>KASIR</td>
														</tr>
													</table>
												</div>
												<div class="col-lg-5 col-lg-offset-3">
													<div class="col-lg-6">
														<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
														<div class="date" data-date="" data-date-format="dd-M-yyyy" data-link-field="dtp_input2" data-link-format="dd-M-yyyy">
															<input id="tanggal_akhir" onkeypress="return hanyaAngka(event, false)" class="form-control datepicker" value="<?php echo date('d-m-y'); ?>"  data-date-format="dd-M-yyyy" type="text" name="txtNeedByDate" riquaite placeholder=" Date" autocomplete="off">
														</div>
														</div>
													</div>
												</div>
											</div>
											<br />
											<div class="row">
												<div class="table-responsive">
													<table width="100%">
														<tr>
															<td class="col-lg-7">PLAFON HARIAN OPERASIONAL</td>
															<td class="col-lg-5">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">Rp</span>
																		<input type="text" class="form-control input-sm" placeholder="amount" aria-describedby="basic-addon1" name="txtCashLimit" id="txtCashLimit" value="50000000">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="col-lg-7">SALDO KAS ORACLE <span id="BalanceDate"></span></td>
															<td class="col-lg-5">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">Rp</span>
																		<input type="text" class="form-control input-sm" placeholder="amount" aria-describedby="basic-addon1" name="txtCashBalance" id="txtCashBalance" value="0">
																	</div>
																</div>
															</td>
														</tr>
														<tr>
															<td class="col-lg-7"><span id="saldoType"></span> DANA</td>
															<td class="col-lg-5">
																<div class="col-lg-6">
																	<div class="input-group">
																		<span class="input-group-addon" id="basic-addon1">Rp</span>
																		<input type="text" class="form-control input-sm" placeholder="amount" aria-describedby="basic-addon1" name="txtLackAmount" id="txtLackAmount" value="0">
																		<input type="hidden" class="form-control input-sm" placeholder="amount" aria-describedby="basic-addon1" name="txtLackAmountHidden" id="txtLackAmountHidden" value="0">
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</div>
											</div>
											<br />
											<b>RENCANA PENGELUARAN TAMBAHAN</b>
											<div class="row">
												<div class="table-responsive">
													<table id="tblDemandForFunds" width="100%">
														<thead>
															<tr>
																<th class="col-lg-7">RENCANA PENGELUARAN</th>
																<th class="col-lg-5"><div class="col-lg-12">ESTIMASI BIAYA</div></th>
															</tr>
														</thead>
														<tbody>
															<tr class="clone">
																<td class="col-lg-7">
																	<input type="text" class="form-control input-sm" data-id="1" name="txtExpenseDescription[]" id="txtExpenseDescription">
																</td>
																<td class="col-lg-5">
																	<div class="col-lg-6">
																		<div class="input-group">
			  																<span class="input-group-addon" id="basic-addon1">Rp</span>
			  																<input type="text" class="form-control input-sm expAmount" data-id="1" placeholder="amount" aria-describedby="basic-addon1" name="txtExpenseAmount[]" id="txtExpenseAmount" value="0">
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<p><a class="btn btn-xs btn-success add-fund-row" data-id="1"><i class="fa fa-plus"></i></a> <a class="btn btn-xs btn-danger del-fund-row" data-id="1"><i class="fa fa-minus"></i></a></p>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
													<div class="col-lg-7">TOTAL RENCANA PENGELUARAN</div>
													<div class="col-lg-5">
														<div class="col-lg-6">
															<div class="input-group">
																<span class="input-group-addon" id="basic-addon1">Rp</span>
																<input type="text" class="form-control input-sm" data-id="1" placeholder="amount" aria-describedby="basic-addon1" name="txtExpenseTotal" id="txtExpenseTotal" value="0">
															</div>
														</div>
													</div>
												</div>
											</div>
											<br />
											<div class="row">
												<div class="col-lg-7">JUMLAH DANA YANG DIMINTA</div>
												<div class="col-lg-5">
													<div class="col-lg-6">
														<div class="input-group">
															<span class="input-group-addon" id="basic-addon1">Rp</span>
															<input type="text" class="form-control input-sm" data-id="1" placeholder="amount" aria-describedby="basic-addon1" name="txtTotalDemand" id="txtTotalDemand" value="0">
														</div>
													</div>
												</div>
											</div>
											<br />
										</div>
									</fieldset>
									<div class="box-footer">
										<button type="submit" class="btn btn-success btn-sm" id="btnBalanceReport">Create Report</button>
					            	</div>
					            </form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

$(document).on('click', '.add-fund-row', function(){
	var id = $(this).attr('data-id');
  	var countLines = $('#tblDemandForFunds tbody tr').length;
  	var clone = $('#tblDemandForFunds tbody tr.clone:last').clone().find('input, select, textarea').val('').end();

  	clone.find('input, a').each(function() {
    	if($(this).attr('data-id') == undefined) {
      	// alert('data-id is undefined');
    	} else {
      		$(this).attr({
        		'data-id': $(this).attr('data-id').slice(0, -1) + (countLines+1),
      		});
    	}
  	});
  	$('#tblDemandForFunds tbody').append(clone);
});

$(document).on('click', '.del-fund-row', function () {
  	var id = $(this).attr('data-id');
  	var amount = $('.expAmount[data-id="'+id+'"]').val();
  	var subtotal = $('#txtExpenseTotal').val();
  	var total = $('#txtTotalDemand').val();
  	var lack = parseInt($('#txtLackAmountHidden').val());
  	var countLines = $('#tblDemandForFunds tbody tr').length;
  	
  	if(countLines == 1) {
  		alert('maaf, baris tidak dapat dihapus');
  	} else {
  		$(this).closest('tr').fadeTo(400, 0, function () { 
    		$(this).remove();
	  	});
	  	$('#txtExpenseTotal').val(subtotal - amount);

	  	if(lack <= 0) {
	  		if(subtotal-amount > Math.abs(lack)) {
				$('#txtTotalDemand').val(Math.abs(total - amount));	
	  		} else {
	  			$('#txtTotalDemand').val(0);
	  		}
	  	} else {
			$('#txtTotalDemand').val(Math.abs(total - amount));
	  	}
  	}

  	return false;
});

$(document).on('keyup', '#txtExpenseAmount', function (){
    var total = 0;
    var lack = parseInt($('#txtLackAmountHidden').val());

    $('.expAmount').each(function() {
        total += parseInt($(this).val(),10);
	});
	$('#txtExpenseTotal').val(total);
	if(lack <= 0) {
		if(total > Math.abs(lack)) {
			$('#txtTotalDemand').val(Math.abs(total + lack));
		} else {
			$('#txtTotalDemand').val(0);
		}
	} else {
		$('#txtTotalDemand').val(Math.abs(total + lack));
	}
});

$(document).on('click', '#btnBalanceDate', function(){
	var date = $('#tanggal_awal').val();
	var plafon = $('#txtCashLimit').val();

	var mydate = new Date(date);
	var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][mydate.getMonth()];
	var str = mydate.getDate() + ' ' + month + ' ' + mydate.getFullYear();

	$('#hdnBalanceDate').val(date);
	$('#BalanceDate').text(str);

  	$.ajax({
	    type: 'POST',
	    url: baseurl+'AccountPayables/PermintaanDana/saldo/',
	    data: {date : date},
	    dataType: 'json',
	    success: function (data) {
	    	$('#txtCashBalance').val(data);
	    	$('#txtLackAmount').val(Math.abs(plafon-data));
	    	$('#txtLackAmountHidden').val(plafon-data);
	    	if(plafon-data <= 0) {
	    		$('#txtTotalDemand').val(0);
	    		$('#saldoType').text('KELEBIHAN');
	    	} else {
	    		$('#txtTotalDemand').val(Math.abs(plafon-data));
	    		$('#saldoType').text('KEKURANGAN');
	    	}
	    },
  	});
})

</script>