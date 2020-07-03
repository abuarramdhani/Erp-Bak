<style type="text/css">
	.image-cropper {
    width: 100px;
    height: 100px;
    position: relative;
    overflow: hidden;
    border-radius: 50%;
}

img {
    display: inline;
    margin: 0 auto;
    width: 100px;
    height: auto;
}

#li_setting{
	<?= $set == '1' ? 'display: none;' : '' ?>
}
</style>

<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b id="titleSrcFPD">Setting User</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class=" btn btn-default btn-md btnHoPg" style="border-radius: 50% !important">
										<b class="fa fa-user fa-2x "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>User Profile</b></button>
							</div>
							<div class="box-body" style="min-height: 350px; " >

<!-- from here -->
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <div style="width: 100%; text-align: center;">

              <div class="image-cropper" style="display: inline-block">
			    <?php
				$path_photo  		=	base_url('assets/img/foto').'/';
				$file 			= 	$path_photo.$user['no_induk'].'.'.'JPG';
				$file_headers 	= 	@get_headers($file);
				if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
					$file 			= 	$path_photo.$this->session->user.'.'.'JPG';
					$file_headers 	= 	@get_headers($file);
					if(!$file_headers || substr($file_headers[0], strpos($file_headers[0], 'Not Found'), 9) == 'Not Found'){
						$ekstensi 	= 	'Not Found';
					}else{
						$ekstensi 	= 	'JPG';
					}
				}else{
					$ekstensi 	= 	"jpg";
				}

				if($ekstensi=='jpg' || $ekstensi=='JPG'){
					echo '<img src="'.$path_photo.$user['no_induk'].'.'.$ekstensi.'" class="rounded" alt="User Image" title="'.$user['name'].' - '.$user['no_induk'].'">';
				}else{
					echo '<img src="'.base_url('assets/theme/img/user.png').'" class="rounded" alt="User Image" />';
				}
              	?>
				</div>
              </div>

              <h3 class="profile-username text-center"><?php echo $user['name'];?></h3>

              <p class="text-muted text-center"><?php echo $user['no_induk'];?></p>

              <ul class="list-group list-group-unbordered">
                <!-- <li class="list-group-item">
                  <b>Status</b> <a class="pull-right"> Auditee</a>
                </li> -->
                <li class="list-group-item">
                  <b>Status Auditor</b> <a class="pull-right"><?= $user['status_auditor'] ?></a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block btn-update-user-ia"><i class="fa fa-edit"> </i><b> Update </b></a>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?= $set == '1' ? 'active' : '' ?>" id="li_profile"><a href="#profile" data-toggle="tab">Profile</a></li>
              <li class="<?= $set == '2' ? 'active' : '' ?>" id="li_setting"><a href="#settings" data-toggle="tab">Setting</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?= $set == '1' ? 'active' : '' ?>" id="profile">
                <form class="form-horizontal">
                 <strong><i class="fa fa-phone margin-r-5"></i> VOIP</strong>

	              <p class="text-muted">
	                <?= $user['no_voip'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-mobile-phone margin-r-5"></i> My Group</strong>

	              <p class="text-muted">
	                <?= $user['no_mygroup'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-envelope margin-r-5"></i> Email Internal</strong>

	              <p class="text-muted">
	                <?= $user['email'] ?>
	              </p>

	              <hr>
	              <strong><i class="fa fa-user margin-r-5"></i> Initial</strong>

	              <p class="text-muted">
	                <?= $user['initial'] ?>
	              </p>

	              <hr>
                </form>
              </div>
              <div class="tab-pane <?= $set == '2' ? 'active' : '' ?>" id="settings">
              	<form method="post" action="<?= base_url('InternalAudit/SettingAccount/User/UpdateUser') ?>">
              	<input type="hidden" name="user_id" value="<?= $user['user_id'] ?>" >
              	<div class="form-group">
	                <label>VOIP:</label>
	                <div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-phone"></i>
	                  </div>
	                  <input type="text" class="form-control" placeholder="Input VOIP Number.." name="no_voip" value="<?= $user['no_voip'] ?>" >
	                </div>
	              </div>
	              <div class="form-group">
	                <label>MyGroup Number:</label>
	                <div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-mobile-phone"></i>
	                  </div>
	                  <input type="text" class="form-control" placeholder="Input MyGroup Number.." name="no_mygroup" value="<?= $user['no_mygroup'] ?>" >
	                </div>
	              </div>
	              <div class="form-group">
	                <label>Email Internal:</label>
	                <div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-envelope"></i>
	                  </div>
	                  <input type="text" class="form-control" placeholder="Input Email Internal.." name="email" value="<?= $user['email'] ?>" >
	                </div>
	              </div>
	              <div class="form-group">
	                <label>Initial :</label>
	                <div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-user"></i>
	                  </div>
	                  <input type="text" class="form-control" placeholder="Input Initial.." name="initial" value="<?= $user['initial'] ?>" >
	                </div>
	              </div>
	              <div class="form-group">
	                <label>Status Auditor :</label>
	                <div class="input-group">
	                  <div class="input-group-addon">
	                    <i class="fa fa-user"></i>
	                  </div>
	                  <select class="slc2" name="status_auditor">
	                  		<option></option>
	                  		<option value="1" <?= $user['status_auditor_id'] == '1' ? 'selected' : '' ?> >Kasie</option>
	                  		<option value="2" <?= $user['status_auditor_id'] == '2' ? 'selected' : '' ?>>Admin</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
                      <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
              	</form>
              </div>

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>
