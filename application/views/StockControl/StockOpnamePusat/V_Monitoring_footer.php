						</div>
						<div class="clear"></div>
					</fieldset>
				</div>
			</div>
		</div>
		<!-- SCRIPT -->
		<?php echo $this->session->flashdata('alert'); ?>
		<script type="text/javascript">
			var baseurl = "<?php echo base_url() ?>";
		</script>
		
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
		<script src="<?php echo base_url('assets/js/customSC.js');?>" type="text/javascript"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/theme/js/app.min.js')?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/slider.js')?>"></script>
		<script language=Javascript>
				function isNumberKey(evt)
			  {
				 var charCode = (evt.which) ? evt.which : event.keyCode
				 if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;

				 return true;
			  }
			  //-->
		</script>
		<script type="text/javascript">
			function SaveSO(masterID,planID,input){
				$("#loadingImage").html('<img src="<?php echo base_url() ?>assets/img/gif/loading3.gif" style="width: 33px"/>');
				var soData = input.value;
				$.ajax({
					type: "POST",
					url:baseurl+"StockControl/stock-control-new/saveTransaction",
					data:{qtySO : soData, master_id : masterID, plan_id : planID},
					success:function(result)
					{
						$(input).parent().html(result);
						$("#loadingImage").html('');
					},
					error:function()
					{
						$("#loadingImage").html('');
						alert('Something Error');
					}
				});
			}

			function SaveSO_Pusat(master_data_id,input){
				$("#loadingImage").html('<img src="<?php echo base_url() ?>assets/img/gif/loading3.gif" style="width: 33px"/>');
				var soData = input.value;
				$.ajax({
					type: "POST",
					url:baseurl+"StockControl/stock-opname-pusat/SaveSO",
					data:{qtySO : soData, master_id : master_data_id},
					success:function(result)
					{
						$(input).parent().html(result);
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