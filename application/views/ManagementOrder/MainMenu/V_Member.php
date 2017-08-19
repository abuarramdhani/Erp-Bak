<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>IT. PROD SQUAD</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('ManagementOrder');?>">
                                <i class="fa fa-group fa-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
 </section>
<section class="content">
	        <div class="row">
            <div class="col-md-12">
			<div class="col-md-3 divSideMenu">
					<div class="box box-primary">
						<div class="box-header with-border" style="background:#2E6DA4; color:#FFFFFF;">
							<h3 class="box-title">SQUAD IT.PRODUCTION</h3>
						</div><!-- /.box-header -->
						<div  class="box-body">
							<div class="row">
								<?php 
								$sum = 0;
								foreach($staff as $st){ 
								
								?>
									<div class="col-md-12">
										<div class="col-md-2 txtNameMember" style="float:left;"> <a href="javascript:void(0)" onclick="loadOrder('<?php echo $st['staff_id']; ?>','<?php echo $st['firstname']; ?>')"><img onMouseOver="showName('<?php echo $st['staff_id']; ?>')" onmouseout="hideName('<?php echo $st['staff_id']; ?>')" style="border:solid #49aaff;" src="<?php echo base_url('assets/img/member/'.$st['staff_id'].'.jpg') ?>" class="img-rounded" width="35px;" height="45px;" alt="User Image" /></a></div>
										<div class="col-md-6" style="text-align:left;margin-left:5%;"><a href="javascript:void(0)" style="font-size:16px;" onMouseOver="showName('<?php echo $st['staff_id']; ?>')" onmouseout="hideName('<?php echo $st['staff_id']; ?>')" id="txsMember<?php echo $st['staff_id']; ?>" onclick="loadOrder('<?php echo $st['staff_id']; ?>','<?php echo $st['firstname']; ?>')"><strong><?php echo $st['firstname']; ?></strong></a></div>
										<div class="col-md-4" style="text-align:center;" id="countJOb<?php echo $st['staff_id']; ?>"><strong style="color:#3c8dbc;"><?php 
											foreach($count as $ct){
												if($ct['user_']==$st['staff_id']){
													$sum = $sum + $ct['tot'];
													echo "<span style='color:green;'>( ".$ct['tot']." )</span>";
												}
											}
										?></strong></div>
									</div>
								<?php } ?>
							</div>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
				<div class="col-md-9">
					<div class="box box-primary">
						<div class="box-header with-border" style="background:#2E6DA4; color:#FFFFFF;">
							<div class="row">
								<div class="col-lg-8">
									<h3 class="box-title">JOB LIST ORDERNYA <span id="tgtMember" style="text-transform:uppercase;font-weight:bold;color:#f4df42;"></span></h3>
								</div>
							</div>
						</div><!-- /.box-header -->
						<br>
						<div  class="box-body">
							<table class="table table-striped table-bordered table-hover" id="tableorder-member" style="font-size:12px;width:100%;">
								<thead>
									<tr class="bg-primary">
										<th style="text-align:center;width:5%;">No</th>
										<th style="text-align:center;width:5%;">Ticket</th>
										<th style="text-align:center;width:40%;">Subject</th>
										<th style="text-align:center;width:5%;">Priority</th>
										<th style="text-align:center;width:25%;">Todo</th>
										<th style="text-align:center;width:15%;">Duedate</th>
										<?php if($this->session->userdata('prev')=='fullver_sion'){ ?>
											<th style="text-align:center;width:5%;">Sent</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
            </div>
        </div>
</section>


<!-- Modal -->
<div class="modal fade" id="modalChange" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
			<b>Mau di transfer ke siapa nih ?</b>
        </div>
        <div class="modal-body">
			<input type="hidden" class="form-control" name="txtNoTicket1" id="txtNoTicket1"></input>
			<input type="hidden" class="form-control" name="txtfrom" id="txtfrom"></input>
			<select name="txsClaim" id="txsClaim" class="form-control select2-member" style="width:100%;" onchange="changePlotting('<?php echo site_url() ?>')">
				<option value=""></option>
			</select>
        </div>
      </div>
      
    </div>
  </div>