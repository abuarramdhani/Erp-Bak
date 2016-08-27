						</div>
						<div class="clear"></div>
					</fieldset>
				</div>
			</div>
		</div>
		<!-- SCRIPT -->
		<script src="<?php echo base_url('assets/plugins/jquery-2.1.4.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/jQueryUI/jquery-ui.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/bootstrap/3.3.6/js/bootstrap.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/theme/js/app.min.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
		<script src="<?php echo base_url('assets/js/custom.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/js/jquery-maskmoney.js');?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/plugins/uniform/jquery.uniform.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/tagsinput/jquery.tagsinput.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validVal/js/jquery.validVal.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/daterangepicker-master/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/datepicker/js/bootstrap-datepicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/daterangepicker-master/daterangepicker.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/timepicker/js/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/switch/static/js/bootstrap-switch.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/autosize/jquery.autosize.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jasny/js/bootstrap-inputmask.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery-validation-1.11.1/dist/jquery.validate.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validator/bootstrapValidator.min.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/validator/bootstrapValidator.js');?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery.mask.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/theme/js/app.min.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/slider.js')?>"></script>
		<script type="text/javascript">
			var baseurl = "<?php echo base_url() ?>";
		</script>
		<script type="text/javascript">
			function SaveSO(masterID,planID,data){
				$("#loadingImage").html('<img src="<?php echo base_url() ?>assets/img/gif/loading3.gif" style="width: 33px"/>');
				var soData = data.value;
				$.ajax({
					type: "POST",
					url:baseurl+"StockControl/stock-control-new/saveTransaction",
					data:{qtySO : soData, master_id : masterID, plan_id : planID},
					success:function(result)
					{
						var form = $('#filter-form');
						var data = $('#filter-form').serialize();
						$.ajax({
							type: "POST",
							url:baseurl+"StockControl/stock-control-new/getData",
							data:data,
							success:function(result)
							{
								$("#table-full").html(result);
								$('#production_monitoring').DataTable({
									responsive: true,
									"scrollX": true,
									"scrollY": "330px",
									scrollCollapse: true,
									"lengthChange": false,
									"dom": 't',
									"paging": false,
									"info": false,
									language: {
										search: "_INPUT_",
									},
								});
								$("#loadingImage").html('');
							},
							error:function()
							{
								$("#loadingImage").html('');
								alert('Something Error');
							}
						});
						$("#loadingImage").html('');
					},
					error:function()
					{
						$("#loadingImage").html('');
						alert('Something Error');
					}
				});
			} 
		</script>
	</body>
</html>