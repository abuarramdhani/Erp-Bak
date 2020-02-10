<style type="text/css">
	#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    z-index:9999;
    display: none;
    background: url(<?php echo base_url('assets/img/gif/loading11.gif'); ?>) 
              50% 50% no-repeat rgba(0,0,0,0.7);
}
</style>
<div id="cover-spin">
</div>
<section id="content">
	<div class="inner" style="background: url("<?php echo base_url('assets/img/3.jpg');?>");background-size: cover;" >

			<!-- Content Header (Page header) -->
			<section class="content-header">
					<div class="panel panel-primary">
					  <div class="panel-heading"><?= $Title ?></div>
					 <div class="panel-body">

						<form>
						  <div class="row">
	                                  <div class="form-group col-sm-3">
	                                    <label>Periode Awal</label>
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                                                <input required oninvalid="return alert('Empty!')" id="daterangepicker" class="form-control datepicker" autocomplete="off" type="text" name="periodeAwal" style="width:100%" placeholder="Masukkan Periode Awal" value="" required/>
	                                        </div>
	                                  </div>

	                                  <div class="form-group col-sm-3">
	                                    <label>Periode Akhir</label>
	                                      <div class="input-group">
	                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                                                <input id="daterangepicker" class="form-control datepicker" autocomplete="off" type="text" name="periodeAkhir" style="width:100%" placeholder="Masukkan Periode Akhir" value="" required/>
	                                        </div>
	                                  </div>

	                                  <div class="form-group col-sm-2">
	                                    <label>&nbsp;</label>	
	                                      <div class="input-group">
	                                            <button class="btn btn-success btn-submit"><i class="fa fa-send"></i>&nbsp;&nbsp;Proses</button>
	                                        </div>
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


			</section>
			<hr />
		</div>
		
</section>

<script type="text/javascript">
	$(document).ready(function(){
		$('.datepicker').datepicker({
		    autoclose: true,
            format: " yyyy",
            viewMode: "years",
            minViewMode: "years"
           });

		$('.btn-submit').on('click',function(e){
			e.preventDefault();
			if($('.panelGrafik').css('display') != 'none'){
				$('.panelGrafik').fadeOut()
			}			
			let periodeAwal = $('input[name="periodeAwal"]').val();
			let periodeAkhir = $('input[name="periodeAkhir"]').val();
			if(!periodeAwal || !periodeAkhir){
				alert('Empty!');
			}else if(periodeAwal > periodeAkhir){
				alert('Range tidak valid!');
			}else{
				$('#cover-spin').fadeIn();
				$.ajax({
					url: '<?php echo base_url(''); ?>AdmCabang/Monitoring/getMonTahunan',
					type: 'POST',
					data: {periodeAwal: periodeAwal,periodeAkhir: periodeAkhir},
					dataType: 'json',
					success: function(res){
						console.log(res);
						setTimeout(function(){
						$(".panelGrafik").show();
						$('#cover-spin').fadeOut();
						document.getElementById("wadah-grafik").innerHTML = '&nbsp;';
						document.getElementById("wadah-grafik").innerHTML = '<canvas id="grafik"></canvas>';
						var ctx = document.getElementById('grafik').getContext('2d');
						var myChart = new Chart(ctx, {
						    type: 'bar',
						    data: {
						        labels: res.periode,
						        datasets: [{
						            label: '# Data Presensi',
						            data: res.dataPerPeriode,
						            backgroundColor: [
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)',
						                'rgba(255, 99, 132, 0.2)',
						                'rgba(54, 162, 235, 0.2)',
						                'rgba(255, 206, 86, 0.2)',
						                'rgba(75, 192, 192, 0.2)',
						                'rgba(153, 102, 255, 0.2)',
						                'rgba(255, 159, 64, 0.2)'
						            ],
						            borderColor: [
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)',
						                'rgba(255, 99, 132, 1)',
						                'rgba(54, 162, 235, 1)',
						                'rgba(255, 206, 86, 1)',
						                'rgba(75, 192, 192, 1)',
						                'rgba(153, 102, 255, 1)',
						                'rgba(255, 159, 64, 1)'
						            ],
						            borderWidth: 1
						        }]
						    },
						    options: {
						    	 tooltips: {
					                enabled: true,
					                mode: 'nearest',
					                callbacks: {
					                    label: function(tooltipItems, data) {
					                       var multistringText = [tooltipItems.yLabel];
					                           multistringText.push(res.data[tooltipItems.index].toFixed(1) + '%');
					                        return multistringText;
					                    },
					                     title: function(tooltipItems, data) { 
					                     	console.log(tooltipItems);
								          return 'Data tahun '+tooltipItems[0].xLabel;
								        }
					                }
					            },
						        scales: {
						           yAxes: [
									    {
									      ticks: {
									        min: 0,
									        max: res.dataTotal,// Your absolute max value
									        callback: function (value) {
									          return (value / res.dataTotal * 100).toFixed(1) + '%'; // convert it to percentage
									        },
									      },
									      scaleLabel: {
									        display: true,
									        labelString: 'Percentage',
									      },
									    },
									  ],
						        },
						        responsive: true,
           						maintainAspectRatio: false,
						    },
						    
						});	//end chart
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
		})
	})
</script>