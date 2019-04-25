<?php 
		$succ =  $this->session->flashdata('kosong');

		if ($succ != null) {
			echo '<section class="notif  alert fade in" style="background-color: #fff; min-height: 30px;
				    padding: 15px;
				    margin-right: 15px;
				    margin-left: 15px;
				    padding-left: 15px;
				    padding-right: 15px;
				    color: orangered;
				    border: 1px solid orangered;
				    border-top: 2px solid orangered;
				    border-bottom: 2px solid orangered;
				    margin-top: 15px;">
				    <center>
				    <table>
				    	<tr>
				    		<td><b>'.$succ.' </b></td>
				    	</tr>
				    </table>
					</center>
				</section>';
		}
?>
<section class="content">
	<div class="inner">
		<div class="box box-info">
			<div class="box-header with-border">
				<h2><b><center>SORTIR DATA MIN MAX</center></b></h2>
			</div>
			<div class="box-body">
			<center><form method="post" action="<?php echo base_url('SettingMinMax/EditbyRoute')?>">
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>ORGANIZATION</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<select class="form-control" name="org" id="org" style="width: 400px" />
								<option></option>
								<option value="ODM">ODM</option>
								<option value="OPM">OPM</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2 col-md-offset-2" style="text-align: right;">
							<label>ROUTING CLASS</label>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<select class="form-control" name="routing_class" id="routing_class" style="width: 400px" />
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<center><button class="btn btn-success btn-lg" type="submit"><span class="fa fa-search"></span> Tampil</button></center>
				</div>
			</form></center>
			</div>
				
		</div>
	</div>
</section>