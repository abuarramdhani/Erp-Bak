						</div>
						<div class="clear"></div>
					</fieldset>
				</div>
			</div>
		</div>
		<!-- SCRIPT -->
		
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

			data_kekurangan();
			function data_kekurangan(){
				var table = $('#monitoring-kekurangan').DataTable({
					responsive: true,
					
					scrollCollapse: true,
					"lengthChange": false,
					"dom": 'tp',
					"info": false,
					"paging": false,
					"ordering": false,
					language: {
						search: "_INPUT_",
					},
					/*
					"columnDefs": [
			            { "visible": false, "targets": 1 },
			            { "visible": false, "targets": 2 },
			        ],
			        "drawCallback": function ( settings ) {
			            var api = this.api();
			            var rows = api.rows( {page:'current'} ).nodes();
			            var last=null;
			 
			            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
			                if ( last !== group ) {
			                    $(rows).eq( i ).before(
			                        '<tr><td colspan="<?php echo ($col*4)+4; ?>" align="left" style="background-color: #cecece">'+group+'</td></tr>'
			                    );
			 
			                    last = group;
			                }
			            } );

			            api.column(2, {page:'current'} ).data().each( function ( group, i ) {
			                if ( last !== group ) {
			                    $(rows).eq( i ).before(
			                        '<tr class="group"><td colspan="<?php echo ($col*4)+4; ?>">&emsp;&emsp;'+group+'</td></tr>'
			                    );

			                    last = group;
			                }
			            } );
			        }*/
			        
				});
			};

			$('#periode1').daterangepicker({
				"singleDatePicker": true,
				"timePicker": false,
				"timePicker24Hour": true,
				"showDropdowns": false,
				locale: {
					format: 'YYYY-MM-DD'
				},
			})

			getMinDate1($("#periode1").val());
			function getMinDate1(min_date){
				$('#periode2').daterangepicker({
					"singleDatePicker": true,
					"timePicker": false,
					"timePicker24Hour": true,
					"showDropdowns": false,
					locale: {
						format: 'YYYY-MM-DD'
					},
					"minDate":min_date
				})
			}

			$("#periode1").change(function(){
				var date_from = $(this).val();
				getMinDate1(date_from);
			})

			$("#periode1, #periode2").change(function(){
				$("#loadingImage").html('<img src="'+baseurl+'assets/img/gif/loading3.gif" style="width: 33px"/>');
				$("#periode1, #periode2").prop('disabled',false);
				var form = $('#filter_periode');
				var data = $('#filter_periode').serialize();
				$("#periode1, #periode2").prop('disabled',true);
				$.ajax({
					type: "POST",
					url:baseurl+"StockControl/stock-control-new/getDataKekurangan",
					data:data,
					success:function(result)
					{
						$("#table_div").html(result);
						data_kekurangan();
						$("#loadingImage").html('');
						$("#periode1, #periode2").prop('disabled',false);
					},
					error:function()
					{
						$("#loadingImage").html('');
						$("#periode1, #periode2").prop('disabled',false);			
						alert('Something Error');
					}
				});
			});

			setTimeout(function () {
				window.location.reload();
			},(900000));
		</script>
	</body>
</html>