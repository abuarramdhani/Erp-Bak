			</div>
		</div>
		
	   <!-- FOOTER -->
		<footer class="main-footer" style="margin:0;">
        <div class="pull-right hidden-xs">
			<strong>Copyright &copy; Quick 2015.</strong> All rights reserved.
        </div>
		<b>Version</b> 1.0.0
		</footer>
		<!--END FOOTER -->
     
	
	
	<!-- Slimscroll -->
    <script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
	<!-- FastClick -->
    <script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js');?>" type="text/javascript"></script>
	<!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/theme/js/app.min.js');?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
    <script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/buttons.html5.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/buttons.print.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/dataTables.buttons.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/jszip.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/pdfmake.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/vfs_fonts.js');?>"></script>

	<script src="<?php echo base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.js')?>"></script>

	<!--<script src="<?php echo base_url('assets/plugins/jquery-autocomplete/jquery.autocomplete.min.js');?>"></script>-->
	<!-- Fine Uploader JS file -->
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/fine-uploader/jquery.fine-uploader.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/fine-uploader/fine-uploader.min.js');?>"></script>

	<!-- Custom Javascript -->
    <script src="<?php echo base_url('assets/js/custom.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customFA.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customCM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customAP.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customAR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customCR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPM.js');?>" type="text/javascript"></script>

	<script src="<?php echo base_url('assets/js/customPR.js');?>" type="text/javascript"></script>

	<script src="<?php echo base_url('assets/js/customTIMS.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/jquery-maskmoney.js');?>" type="text/javascript"></script>
    <script type="text/javascript">
		var baseurl = "<?php echo base_url(); ?>";
		if(counter_row <= 0){
			var counter_row = 0;
		}
	</script>
    <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable({
			  "bSort" : false
			});
			
			$('#dataTables-customer').dataTable({
				"bSort" : false,
				"searching": false,
				"bLengthChange": false
			});
         });
    </script>
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
	<script language=Javascript>
			function noInput(evt)
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode != 13){
				return false;
			 }else{
				 return true;
			 }
			 
			
		  }
		  
		  
		  //-->
	</script>
	<!-- PAGE LEVEL SCRIPTS FOR FORM-->
	
	<script src="<?php echo base_url('assets/plugins/jquery.number.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/uniform/jquery.uniform.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/chosen/chosen.jquery.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/colorpicker/js/bootstrap-colorpicker.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/tagsinput/jquery.tagsinput.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/validVal/js/jquery.validVal.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dropzone/dropzone.min.js');?>"></script>
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
    
	<script src="<?php echo base_url('assets/js/formsInit.js');?>"></script>
	<script src="<?php echo base_url('assets/js/ajaxSearch.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/HtmlFunction.js')?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/ChainArea.js');?>"></script>
	<!--
	<script src="<?php echo base_url('assets/js/formValidation.js')?>" type="text/javascript"></script>
	-->
    <script>
       $(function () { formInit(); });
		
		function callModal(link){
			$('#myModal').modal({
				show: true,
				remote: link
			});
		}
		
		
	</script>
	<?php
	if (empty($alert)) {
		$alert = '';
	};
	echo $alert; ?>
     <!--END MAIN WRAPPER -->
</body>
     <!-- END BODY -->
</html>