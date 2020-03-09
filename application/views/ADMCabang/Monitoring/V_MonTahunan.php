<style type="text/css">
	#cover-spin {
    position:fixed;
    width:100%;
    height: 100%;
    left:0;right:0;top:0;bottom:0;
    z-index:9999;
    display: none;
    vertical-align: middle;
     background: url(<?php echo base_url('assets/img/gif/loadingquick.gif'); ?>) 
              50% 50% no-repeat rgba(0,0,0,0.7);
}


#rowT{
	color: white;
	background: #667db6;  /* fallback for old browsers */
	background: -webkit-linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6);  /* Chrome 10-25, Safari 5.1-6 */
	background: linear-gradient(to right, #667db6, #0082c8, #0082c8, #667db6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
	}

#grafik:hover{
	cursor: pointer;
}	

canvas{
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
		#chartjs-tooltip {
			opacity: 1;
			position: absolute;
			background: rgba(0, 0, 0, .7);
			color: white;
			border-radius: 3px;
			-webkit-transition: all .1s ease;
			transition: all .1s ease;
			pointer-events: none;
			-webkit-transform: translate(-50%, 0);
			transform: translate(-50%, 0);
		}

		.chartjs-tooltip-key {
			display: inline-block;
			width: 10px;
			height: 10px;
			margin-right: 10px;
		}
</style>
<div id="cover-spin">
</div>
<section id="content">
	<div class="inner" style="background: url("<?php echo base_url('assets/img/3.jpg');?>");background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="panel panel-primary panelPrimer">
					  <div class="panel-heading">
					  <div class="panel-title">
					  	<b class="pull-left"><?= $Title ?></b>

					  	<button class="pull-right btn btn-info btn-intro">
					  		<i class="fa fa-info-circle"></i>
					  		&nbsp;Panduan
					  	</button>

					  	<button style="margin-right: 5px;" class="pull-right btn btn-warning btn-video" onclick="window.open('<?=base_url('') ?>assets/video/presensi_harian/montahunan.webm')">
					  		<i class="fa fa-video-camera"></i>
					  		&nbsp;Video Panduan
					  	</button>
					  </div>
					  <div class="clearfix"></div>
					  </div>
					 <div class="panel-body">

						<form>
						  <div class="row" id="rowPeriode">
	                                  <div class="form-group col-sm-2">
	                                    <label>Periode</label>
	                                    </div>
	                                    <div class="form-group col-sm-5">
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                                                <input required oninvalid="return alert('Empty!')" id="daterangepicker" class="form-control datepicker" autocomplete="off" type="text" name="periode" style="width:100%" placeholder="Masukkan Tahun" value="" required/>
	                                        </div>
	                                  </div>
	                                  </div>

	                                  <!-- <div class="form-group col-sm-3">
	                                    <label>Periode Akhir</label>
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                                                <input id="daterangepicker" class="form-control datepicker" autocomplete="off" type="text" name="periodeAkhir" style="width:100%" placeholder="Masukkan Periode Akhir" value="" required/>
	                                        </div>
	                                  </div> -->

	                               <div class="row" id="rowCheckBox">
		                           <div class="form-group col-sm-2">
							  		<label class="form-check-label" for="defaultCheck1">
										All
									</label>
							  		</div>
	                           	<div class="form-group col-sm-4">
	                                  	<div class="form-check">
										  <input class="form-check-input i-checks" type="checkbox" value="">
										  <label>( Rekap hanya berdasarkan periode )</label>
										</div>
	                                  </div>
	                           </div>

	                           <div class="row" id="rowStatusHubker">
		                           <div class="form-group col-sm-2">								  		
	                                    <label class="control-label" >Status Hubungan Kerja</label>
								  		</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                      			<div class="input-group-addon">
														<i class="glyphicon glyphicon-briefcase"></i>
													</div>
	                                                <select id="vm-status" data-placeholder="Pilih Salah Satu!" class="form-control select2 customInput" style="width:100%" name ="statusKerja[]"  multiple="multiple">
														<option value=""><option>
															<!-- <option value="All">ALL</option> -->
															<?php foreach ($status as $status_item){
																?>
																<option value="<?php echo $status_item['fs_noind'];?>"><?php echo $status_item['fs_noind'].' - '.$status_item['fs_ket'];?></option>
																<?php } ?>
															</select>
	                                        </div>
	                                  </div>
	                           </div>

	                            <div class="row" id="rowUnit">
		                            <div class="form-group col-sm-2">								  		
		                                    <label class="control-label" >Unit</label>
									  	</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                            <div class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i>
														</div>
	                                                <select id="vm-unit" data-placeholder="Pilih Unit" class="form-control select2 customInput" style="width:100%" name ="unit" >
														<option value=""><option>
															<!-- <option value="All">ALL</option> -->
															<?php foreach ($unit as $status_item){
																?>
																<option value="<?php echo $status_item['kodesie'];?>"><?php echo $status_item['kodesie'].' - '.$status_item['unit'];?></option>
																<?php } ?>
															</select>
	                                        </div>
	                                  </div>
	                           </div>

	                           <div class="row" id="rowSeksi">
	                           <div class="form-group col-sm-2">								  		
		                                    <label class="control-label">Seksi</label>
									  	</div>
	                                  <div class="form-group col-sm-8">
	                                      <div class="input-group">
	                                            <div class="input-group-addon">
															<i class="glyphicon glyphicon-user"></i>
														</div>
	                                                <select id="vm-seksi" disabled data-placeholder="Pilih Seksi" class="form-control select2" style="width:100%" name="seksi">
														<option value=""><option>
													</select>
	                                        </div>
	                                  </div>
	                           </div>

	                           <div class="row">
	                           <div class="form-group col-sm-2"></div>
	                                  <div class="form-group col-sm-8">
	                                     <button class="btn btn-success btn-submit"><i class="fa fa-send"></i>&nbsp;&nbsp;Proses</button>
	                                  </div>
	                           </div>
	                    </form>
					  </div>
					</div>

					<div class="panel panel-primary panelGrafik" style="display: none">
					 <div class="panel-body">
					 <div id="wadah-grafik"  style="position:relative;right: 0;height: 500px !important;">
					 	
					 </div>
					 </div>
					</div>

					<div class="panel panel-primary panelTabel" style="display: none;">
						<div class="panel-heading">
							<div class="panel-title">Tabel Grafik</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive" align="center">
								<table style="width: 60%;" class="table table-bordered table-hovered table-striped" id="tblTahunan">
									<thead>
										<tr id="rowT">
											<th class="text-center">No</th>
											<th>Seksi</th>
											<th class="text-center" id="tahunProses"></th>
											<th>Grafik</th>
										</tr>
									</thead>
									<tbody id="tbodyTahunan">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>


			</section>
			<hr />
		</div>
		
</section>

<!-- Modal -->
<div id="detailGrafikModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 90%;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail</h4>
      </div>
      <div class="modal-body">
        <table id="tblDtl" class="table table-striped table-bordered table-hovered">
        	<thead>
        		<tr id="rowT">
        			<th>Tanggal</th>
        			<th>No. Induk</th>
        			<th>Nama</th>
        			<th>Seksi</th>
        			<th>Keterangan</th>
        		</tr>
        	</thead>
        	<tbody id="bodyTab">
        		
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		var introguide = introJs();

		introguide.setOptions({
		    steps: [
		        {
		          element: '.panelPrimer',
		          intro: 'Monitoring Presensi Tahunan merupakan sebuah aplikasi yang digunakan untuk melakukan monitoring data presensi pekerja per tahun.',
		          position: 'bottom'
		        },
		        {
		          element: '#rowPeriode',
		          intro: 'Pertama, Anda Wajib Memilih Tahun / Periode ! ',
		          position: 'bottom'
		        },
		        {
		          element: '#rowCheckBox',
		          intro: '(Opsional) Jika Ingin Memfilter Data Berdasarkan Status Hubungan Kerja, Unit, dan Seksi Anda Bisa Meng-uncheck Checkbox ini.',
		          position: 'bottom'
		        },
		        {
		          element: '#rowStatusHubker',
		          intro: '(Opsional) Pilih Status Hubungan Kerja yang Ingin Anda Filter.',
		          position: 'bottom'
		        },
		        {
		          element: '#rowUnit',
		          intro: '(Opsional) Pilih Unit Kerja yang Ingin Anda Filter.',
		          position: 'bottom'
		        },
		        {
		          element: '#rowSeksi',
		          intro: '(Opsional) Pilih Seksi yang Ingin Anda Filter.',
		          position: 'bottom'
		        },
		        {
		          element: '.btn-submit',
		          intro: 'Tekan Button Proses untuk Mulai Memproses Data.',
		          position: 'bottom'
		        }
		    ],
		    skipLabel: 'Lewati',
		    nextLabel: 'Berikutnya',
		    prevLabel: 'Kembali',
		    doneLabel: 'Selesai',
		    hideNext: true
		});

		$(".btn-intro").on('click',function(e){
			introguide.start();
		})

		$('.datepicker').datepicker({
		    autoclose: true,
            format: " yyyy",
            minViewMode: "years"
           });

		$('.i-checks').iCheck('check')
		$('.customInput').prop('disabled',true)

		$(document).on('ifChecked', '.i-checks' ,function(event){
			$('.i-checks').iCheck('check')
			$('.customInput').prop('disabled',true)
			$("#vm-status").select2('val','')
			$("#vm-unit	").select2().val('').trigger('change')
			$("#vm-seksi").select2().val('').trigger('change')
			$("#vm-unit").val('')
			$("#vm-seksi").val('')
			$("#vm-seksi").prop('disabled',true)
		});
		$(document).on('ifUnchecked', '.i-checks' ,function(event){
			$('.i-checks').iCheck('uncheck')
			$('.customInput').prop('disabled',false)
		});

		$("#vm-unit").on('change',function(e){
			let val = $(this).val();
			let keyKodesie = val.split(' - ')[0];
			$("#vm-seksi").select2().val('').trigger('change')
			if(val != ""){
				$("#vm-seksi").prop('disabled',false)
			}else{
				$("#vm-seksi").prop('disabled',true)
			}

			$('#vm-seksi').select2({
			allowClear: true,
			searching: true,
			ajax: {
				url: '<?php echo base_url(''); ?>AdmCabang/Monitoring/getSeksiByUnit',
			dataType: 'json',
			type: 'GET',
			delay: 500,
			data: function (params){
				return {
					kodesie: keyKodesie
				}
			},
			processResults: function(data) {
				return {
					results: $.map(data, function(obj){
						// return {id: obj.employee_name, text: obj.employee_name};
						return {id: obj.kodesie+" - "+obj.seksi, text: obj.kodesie+" - "+obj.seksi};
					})
				};
			}
			}
		})

		})


		function arrChartData(arrTanggal,data){
			let arr = [];

			Object.keys(data).forEach((key)=>{
					arr.push({
							 	label: key,
							 	fill:false,
					            data: data[key],
					            backgroundColor: [
					                'rgba(255, 99, 132, 0.2)'
					            ],
					            borderColor: [
					                'RGBA(0,0,0,1)'
					            ],
					            borderWidth: 3,
					            pointBackgroundColor: [
					                'RGBA(0,0,0,1)'
					            ],
					            pointBorderColor: [
					                'RGBA(0,0,0,1)'
					            ],
					            pointBorderWidth: 3,
					            pointRadius: 5
						})
			})

			return arr;
		}

		$(".modal").on("hidden.bs.modal", function(){
		    $('#tblDtl').dataTable().fnDestroy();		
		});

		$('#tblTahunan').on('click','.btn-grafik',function(e){
			e.preventDefault();
			if($('.panelGrafik').css('display') != 'none'){
				$('.panelGrafik').fadeOut()
				$(".panelTabel").fadeOut()
				$('#tblTahunan').dataTable().fnDestroy();	
			}	
			let kodesie = $(this).attr('data-id');
			let periode = $('input[name="periode"]').val();
			let statusKerja = $('#vm-status').val()
			let unitKerja = $('#vm-unit').val()
			let seksiKerja = $('#vm-seksi').val()

			$('#cover-spin').fadeIn();
				getDataTahunan(periode,'','',kodesie)

		})

		$('.btn-submit').on('click',function(e){
			e.preventDefault();
			if($('.panelGrafik').css('display') != 'none'){
				$('.panelGrafik').fadeOut()
				$(".panelTabel").fadeOut()
				$('#tblTahunan').dataTable().fnDestroy();	
			}

			let periodeAwal = $('input[name="periode"]').val();
			// let periodeAkhir = $('input[name="periodeAkhir"]').val();
			let statusKerja = $('#vm-status').val()
			let unitKerja = $('#vm-unit').val()
			let seksiKerja = $('#vm-seksi').val()
			if(!periodeAwal){
				$("input#daterangepicker").focus()
				Swal.fire('Oops!','Periode Wajib diisi!','warning')
			}else{
				getDataTahunan(periodeAwal,statusKerja,unitKerja,seksiKerja)
			}	
		})

		function getDataTahunan(periodeAwal,statusKerja,unitKerja,seksiKerja){
			$('#cover-spin').fadeIn();
			$.ajax({
					url: '<?php echo base_url(''); ?>AdmCabang/Monitoring/getMonTahunan',
					type: 'POST',
					data: {periode: periodeAwal,statusKerja: statusKerja,unitKerja: unitKerja,seksiKerja:seksiKerja},
					dataType: 'json',
					success: function(res){
						setTimeout(function(){
						$(".panelTabel").fadeIn();
						$(".panelGrafik").fadeIn();
						$('#cover-spin').fadeOut();
						chartShow(res,periodeAwal)
						},2000)
						
					},
					error: function(res){
						$('#cover-spin').hide();
						Swal.fire({
							type: 'error',
							title: 'Request Error'
						})
					}
				})
		}

		
		function chartShow(res,periodeAwal){
						var isiTabel = "";
						var no = 0;
						var persentase = 0;
						var bgcolor = "";
						for(var j = 0;j < res.dataTabelPerTahun.length;j++){
							no++;
							if(res.dataTabelPerTahun[j].total_absen != "0"){
								persentase = ((res.dataTabelPerTahun[j].total_bekerja / res.dataTabelPerTahun[j].total_absen) * 100 ).toFixed(2);
							}else{
								persentase = "0";
							}

							if( j == 0){
								bgcolor = "rgba(255, 99, 132, 0.7)";
							}else if (j == 1) {
								bgcolor = "rgba(54, 162, 235, 0.7)";
							}else if (j == 2) {
								bgcolor = "rgba(168, 50, 98, 0.7)";
							}else if (j == 3) {
								bgcolor = "rgba(75, 192, 192, 0.7)";
							}else if (j == 4) {
								bgcolor = "rgba(153, 102, 255, 0.7)";
							}else if (j == 5) {
								bgcolor = "rgba(255, 159, 64, 0.7)";
							}else if (j == 6) {
								bgcolor = "rgba(101,101,80,0.7)";
							}else if (j == 7) {
								bgcolor = "rgba(101,196,0,0.7)";
							}else if (j == 8) {
								bgcolor = "rgba(231,196,0,0.7)";
							}else if (j == 9) {
								bgcolor = "rgba(101,101,148,0.7)";
							}else{
								bgcolor = "rgba(101,101,0,0.7)";
							}
							isiTabel += "<tr>" +
										"<td class='text-center' style='background-color:"+bgcolor+"'>"+ no +"</td>" +
										"<td>"+ res.dataTabelPerTahun[j].seksi +"</td>" +
										"<td class='text-center'>"+ persentase + " %" +"</td>" +
										"<td class='text-center'><button data-id='"+res.dataTabelPerTahun[j].kodesie+"' class='btn btn-info btn-grafik'><i class='fa fa-line-chart'></i>&nbsp;Grafik</button></td>" +
										"</tr>";

						}

						$("th#tahunProses").text("Tahun " + periodeAwal);
						$("#tbodyTahunan").html(isiTabel);

						document.getElementById("wadah-grafik").innerHTML = '&nbsp;';
						document.getElementById("wadah-grafik").innerHTML = '<canvas id="grafik"></canvas>';
						// $("#grafik").after('<div id="chartjs-tooltip" class="center"></div>');
						// $("#chartjs-tooltip").html("<table></table>");
						var ctx = document.getElementById('grafik').getContext('2d');
						var myChart = new Chart(ctx, {
						    type: 'line',
						    data: {
						        labels: res.periodeBulan,
						        datasets: arrChartData(periodeAwal,res.data)
						    },
						    options: {
						    	elements: {
							        line: {
							            tension: 0
							        }
							    },
						    	legend: {
							        display: true,
							        position: 'bottom'
							    },
						    	 tooltips: {
					                enabled: true,
					                mode: 'nearest',
					                // custom: customTooltips
					                callbacks: {
					                    label: function(tooltipItems, data) {
					                       var label = data.datasets[tooltipItems.datasetIndex].label || '';
					                       var multistringText = [tooltipItems.yLabel];
					                       if(label != "TARGET"){                       
					                       	   multistringText[0] = multistringText[0].toFixed(2) + '%';
					                       	   multistringText.push('Seksi '+ res.seksiPerTanggal[tooltipItems.index][tooltipItems.datasetIndex])
					                       	   multistringText.push(res.dataTotalPerTahun[tooltipItems.index][tooltipItems.datasetIndex].sum + ' Bekerja / dari Total '+res.dataTotalTahunan[tooltipItems.index][tooltipItems.datasetIndex].sum + ' Presensi')
					                       }else{
					                       	multistringText[0] = "Target : "+multistringText[0].toFixed(2) + '%';
					                       }

					                        return multistringText;
					                    }
					                }
					            }
					            ,
						        scales: {
						           yAxes: [
									    {
									      ticks: {
									      	fontColor: "#000", 
									        min: 0,
									        max: Math.max.apply(Math, res.kabehData),// Your absolute max value
									        callback: function (value,index,values) {
									          return (value.toFixed(2)) + '%';
									        },
									      },
									      scaleLabel: {
									        display: true,
									        labelString: 'Percentage',
									      },
									    },
									  ]
									  ,
									  xAxes: [{
									  	ticks:{
									  		fontColor: "#000",
									  	}
									  }]
						        },
						        responsive: true,
           						maintainAspectRatio: false,
           						onClick: function(c,i) {
           							var element = this.getElementAtEvent(c);
           							var index = element[0]['_index'];
           							var dtSetIndex = element[0]['_datasetIndex'];
								    var dtClick = element[0]['_chart'].config.data;

								    var periode = dtClick.labels[index];
								    var kodesie = res.kodesieArr[index][dtSetIndex];

								    $('#cover-spin').fadeIn();
								    $.ajax({
								    	url: '<?php echo base_url(''); ?>AdmCabang/Monitoring/getDetailPekerjaBulanan',
								    	type: 'GET',
								    	dataType: 'json',
								    	data: {periode:periode,kodesie:kodesie},
								    	success: res => {
								    		setTimeout(() => {
								    			$('#cover-spin').fadeOut();
								    			$('#detailGrafikModal').modal('show');

								    			var i;
							                    var no = 0;
							                    var html = "";
							                    for(i=0;i < res.length ; i++){
							                    	var chgTanggal = new Date(res[i].tanggal)
							                    	var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
"Juli", "Agustus", "September", "Oktober", "November", "Desember"][chgTanggal.getMonth()];
							                        no++;
							                        html = html + '<tr>'
							                        			+ '<td>' + chgTanggal.getDate() + " " + month + " " + chgTanggal.getFullYear()  + '</td>'
							                                    + '<td>' + res[i].noind  + '</td>'
							                                    + '<td>' + res[i].nama  + '</td>'
							                                    + '<td>' + res[i].seksi  + '</td>'
							                                    + '<td>' + res[i].keterangan  + '</td>'
							                                    + '</tr>';
							                    }
							                    $("#bodyTab").html(html);
							                    $("#tblDtl").DataTable();
								    	},2000)
								    		
								    	},
								    	error: (res)=>{
								    		$('#cover-spin').fadeOut();
								    	}
								    })
								}
						    }
						    
						});	//end chart

						myChart.data.datasets.map((data,index)=>{
							if(index == 0){ 
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(255, 99, 132, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(255, 99, 132, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(255, 99, 132, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(255, 99, 132, 0.7)';
								}
							}else if(index == 1){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(54, 162, 235, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(54, 162, 235, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(54, 162, 235, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(54, 162, 235, 0.7)';
								}
							}else if(index == 2){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(168, 50, 98, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(168, 50, 98, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(168, 50, 98, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(168, 50, 98, 0.7)';
								}
							}else if(index == 3){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(75, 192, 192, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(75, 192, 192, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(75, 192, 192, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(75, 192, 192, 0.7)';
								}
							}else if(index == 4){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(153, 102, 255, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(153, 102, 255, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(153, 102, 255, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(153, 102, 255, 0.7)';
								}
							}else if(index == 5){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(255, 159, 64, 0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(255, 159, 64, 0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(255, 159, 64, 0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(255, 159, 64, 0.7)';
								}
							}else if(index == 6){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(101,101,80,0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(101,101,80,0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(101,101,80,0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(101,101,80,0.7)';
								}
							}else if(index == 7){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(101,196,0,0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(101,196,0,0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(101,196,0,0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(101,196,0,0.7)';
								}
							}else if(index == 8){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(231,196,0,0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(231,196,0,0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(231,196,0,0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(231,196,0,0.7)';
								}
							}else if(index == 9){
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(101,101,148,0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(101,101,148,0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(101,101,148,0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(101,101,148,0.7)';
								}
							}
							else{
								for(var j = 0;j < myChart.data.datasets.length;j++){
									myChart.data.datasets[index].backgroundColor = 'rgba(101,101,0,0.7)';
									myChart.data.datasets[index].borderColor = 'rgba(101,101,0,0.7)';
									myChart.data.datasets[index].pointBackgroundColor = 'rgba(101,101,0,0.7)';
									myChart.data.datasets[index].pointBorderColor = 'rgba(101,101,0,0.7)';
								}
							}


						})
						myChart.update();
		}
	})
</script>