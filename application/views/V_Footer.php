</div>
		</div>
		<footer class="main-footer" style="margin:0;">
			<div class="pull-right hidden-xs">
				Page rendered in <strong>{elapsed_time}</strong> seconds.
				<strong>Copyright &copy; Quick 2015<?php if(date('Y')>2015) { echo '-'.date('Y'); } ?>.</strong> All rights reserved.
			</div>
			<b>Version</b> 1.0.0
		</footer>
		<!--END FOOTER -->
     
	<script type="text/javascript">
	const baseurl = "<?php echo base_url(); ?>";
	</script>
	<!-- Slimscroll -->
    <script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
	<!-- FastClick -->
    <script src="<?php echo base_url('assets/plugins/fastclick/fastclick.min.js');?>" type="text/javascript"></script>
	<!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/theme/js/app.min.js');?>" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS FOR DATATABLES-->
    <?php
     	if(!(isset($newDataTable)))
     	{
    ?>
    
	<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/buttons.html5.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/buttons.print.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/dataTables.buttons.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/jszip.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/pdfmake.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/extensions/vfs_fonts.js');?>"></script>
	<?php
	 	}
	 	else
	 	{
	?>
	<script src="<?php echo base_url('assets/plugins/dataTables-punyamilton/datatables.min.js');?>"></script>
	<?php
	 	}
    ?>

	<script src="<?php echo base_url('assets/plugins/canvasjs/canvasjs.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/chartjs/Chart.js');?>"></script>
	<!-- PAGE LEVEL SCRIPTS FOR TEXT AREA-->
	<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>

	<!-- InputMask -->
	<script src="<?php echo base_url('assets/plugins/input-mask/3.x');?>/dist/jquery.inputmask.bundle.js"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/3.x');?>/dist/inputmask/phone-codes/phone.js"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/3.x');?>/dist/inputmask/phone-codes/phone-be.js"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/3.x');?>/dist/inputmask/phone-codes/phone-ru.js"></script>
	<script src="<?php echo base_url('assets/plugins/input-mask/3.x');?>/dist/inputmask/bindings/inputmask.binding.js"></script>

	<!-- MULTISELECT -->
	<script src="<?php echo base_url('assets/plugins/multiselect/js/bootstrap-multiselect.js');?>"></script>

	<script src="<?php echo base_url('assets/plugins/touchspin/jquery.bootstrap-touchspin.min.js')?>"></script>

	<!--<script src="<?php echo base_url('assets/plugins/jquery-autocomplete/jquery.autocomplete.min.js');?>"></script>-->
	<!-- Fine Uploader JS file -->
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/fine-uploader/jquery.fine-uploader.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/fine-uploader/fine-uploader.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/chartjs/Chart.bundle.min.js');?>"></script>

	<!-- Redactor -->
	<script src="<?php echo base_url('assets/plugins/redactor/js/redactor.min.js');?>"></script>
	<!-- <script src="<?php echo base_url('assets/plugins/redactor/plugins/fontcolor.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/redactor/plugins/fontfamily.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/redactor/plugins/fontsize.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/redactor/plugins/imagemanager.min.js');?>"></script> -->
	<script src="<?php echo base_url('assets/plugins/mdtimepicker/mdtimepicker.js');?>"></script>

	<!-- html2canvas -->
	<script src="<?php echo base_url('assets/plugins/html2canvas/html2canvas.min.js') ?>" type="text/javascript"></script>	

	<!-- Highchart.js charts -->
	<script src="<?php echo base_url('assets/plugins/highchart/highcharts.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/highchart/exporting.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/highchart/offline-exporting.js');?>"></script>

	
	<!-- Custom Javascript -->
    <script src="<?php echo base_url('assets/js/custom.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customFA.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customCM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customAP.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customAPD.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customAR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customCR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMO.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMK.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPRS.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customKL.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customTIMS.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customDC.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPL.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/customDC.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/customTR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/formValidation.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customWM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customSL.js');?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/jquery-maskmoney.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customGA.js');?>" type="text/javascript"></script>
	<!--	<script src="<?php echo base_url('assets/js/customLKH.js');?>" type="text/javascript"></script>-->
	<script src="<?php echo base_url('assets/js/customOC.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customOJT.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customDS.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPP.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customICT.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customWR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMP.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMPK.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPPO.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPC.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPOB.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMC.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customSM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customPKEL.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customECM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customLKKK.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customWH.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customWMS.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMI.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customUM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customHLCM.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMA.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customSI.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customIMO.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMO.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customERC.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customBI.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customMA.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customTI.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customTF.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customPPH.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customSPL.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customWHS.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customBK.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customKMK.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customPD.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customMPO.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customSMM.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customME.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customOR.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customMOA.js');?>" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/customET.js');?>" type="text/javascript"></script>
	 
 	
<!--  	<script src="<?php echo base_url('assets/js/customOSP.js');?>" type="text/javascript"></script>
 	<script src="<?php echo base_url('assets/js/customHWM.js');?>" type="text/javascript"></script> -->
	<script type="text/javascript">
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

		<!-- CUSTOM JAVASCRIPT FOR APPLICATION | DO NOT EDIT!! -->
		<script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customFA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customCM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customAP.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customAPD.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customAR.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customCR.js') ?>"></script>
		<!-- <script type="text/javascript" src="<?= base_url('assets/js/customMO.js') ?>"></script> -->
		<script type="text/javascript" src="<?= base_url('assets/js/customPM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMK.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPRS.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customKL.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customTIMS.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customDC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPL.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customDC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customTR.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customWM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSL.js') ?>"></script>
		<!-- <script type="text/javascript" src="<?= base_url('assets/js/customPR.js') ?>"></script>-->
		<script type="text/javascript" src="<?= base_url('assets/js/customGA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customGRR.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customLKH.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customOC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customOJT.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customDS.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPP.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customICT.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customWR.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMP.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMPK.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPPO.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPOB.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPKEL.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customECM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customLKKK.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customWH.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customWMS.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMI.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customUM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customHLCM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSI.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customIMO.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMO.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customERC.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customBI.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customTI.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customTF.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPPH.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSPL.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customWHS.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customBK.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customKMK.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customPD.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMPO.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSMM.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customME.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customOR.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMOA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customET.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customOSP.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customML.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customMPBG.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customSGA.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/js/customTB.js') ?>"></script>
		<!--<script type="text/javascript" src="<?= base_url('assets/js/customOSP.js') ?>"></script>-->
		<!--<script type="text/javascript" src="<?= base_url('assets/js/customHWM.js') ?>"></script>-->
		<!-- END OF CUSTOM JAVASCRIPT | DO NOT EDIT!! -->

		<script type="text/javascript">
			var id_gd;
			if(counter_row <= 0) { var counter_row = 0; }
			$(function() {
				$('#dataTables-example').dataTable({
					"bSort" : false
				});
				$('#dataTables-customer').dataTable({
					"bSort" : false,
					"searching": false,
					"bLengthChange": false,
					"bDestroy": true
				});
				$(".textarea").wysihtml5();
				$('.pp-date').datepicker({
					"autoclose": true,
					"todayHiglight": true,
					"allowClear" : true,
					"format": 'dd M yyyy'
				});
				$('[data-toggle="tooltip"]').tooltip(); 
				formInit();
				<?php
					if($this->session->flashdata('delete-menu-respond')) {
						switch($this->session->flashdata('delete-menu-respond')) {
							case 1:
								if($this->session->flashdata('delete-menu-name')) {
									echo "
										Swal.fire({
											text: 'Terjadi kesalahan saat menghapus menu ' + '".$this->session->flashdata('delete-menu-name')."',
											confirmButtonText: 'Tutup',
											type: 'error'
										});
									";
								}
								break;
							case 2:
								if($this->session->flashdata('delete-menu-name')) {
									echo "
										Swal.fire({
											text: 'Menu ' + '".$this->session->flashdata('delete-menu-name')."' + ' berhasil dihapus',
											confirmButtonText: 'Tutup',
											type: 'success'
										});
									";
								}
								break;
						}
					}
					if($this->session->flashdata('delete-menu-list-respond')) {
						switch($this->session->flashdata('delete-menu-list-respond')) {
							case 1:
								if($this->session->flashdata('delete-menu-list-name')) {
									echo "
										Swal.fire({
											text: 'Terjadi kesalahan saat menghapus menu list ' + '".$this->session->flashdata('delete-menu-list-name')."',
											confirmButtonText: 'Tutup',
											type: 'error'
										});
									";
								}
								break;
							case 2:
								if($this->session->flashdata('delete-menu-list-name')) {
									echo "
										Swal.fire({
											text: 'Menu list ' + '".$this->session->flashdata('delete-menu-list-name')."' + ' berhasil dihapus',
											confirmButtonText: 'Tutup',
											type: 'success'
										});
									";
								}
								break;
						}
					}
					if($this->session->flashdata('delete-sub-menu-respond')) {
						switch($this->session->flashdata('delete-sub-menu-respond')) {
							case 1:
								echo "
									Swal.fire({
										text: 'Terjadi kesalahan saat menghapus sub menu',
										confirmButtonText: 'Tutup',
										type: 'error'
									});
								";
								break;
							case 2:
								echo "
									Swal.fire({
										text: 'Sub menu berhasil dihapus',
										confirmButtonText: 'Tutup',
										type: 'success'
									});
								";
								break;
						}
					}
				?>
			});
			function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode;
				if(charCode > 31 && (charCode < 48 || charCode > 57)) return false;
				return true;
			}
			function noInput(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode
				if(charCode != 13) return false;
				return true;
			}
			function callModal(link) {
				$('#myModal').modal({ show: true, remote: link });
			}
		</script>
	</body>
</html>