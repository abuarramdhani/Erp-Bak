	<aside class="main-sidebar">
		<section class="sidebar">
		    <div class="user-panel">
				<div class="pull-left image">
					<img src="<?php echo base_url('assets/img/avatar5.png') ?>" class="img-circle" alt="User Image">
				</div>
				
				<div class="pull-left info">
					<p>Admin</p>
					<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
				</div>
			</div>

			<form action="#" method="get" class="sidebar-form">
				<div class="input-group">
					<input type="text" name="q" class="form-control" placeholder="Search...">
					<span class="input-group-btn">
						<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
					</span>
				</div>
			</form>

			<ul class="sidebar-menu">
				<li class="header">
					HEADER
				</li>
				<li>
					<a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-home"></i><span>Dashboard</span></a>
				</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-wrench"></i><span>Setting</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url('setting/pricelist') ?>">Pricelist Index</a></li>
						<li><a href="<?php echo base_url('setting/salesomset') ?>">Sales Omset</a></li>
						<li><a href="<?php echo base_url('setting/salestarget') ?>">Sales Target</a></li>
					</ul>
				</li>
			</ul>
		</section>

	</aside>