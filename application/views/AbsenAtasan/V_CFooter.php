			</div>
			</div>
			<footer class="main-footer" style="margin:0;">
				<div class="pull-right hidden-xs">
					<span>Page rendered in <strong>{elapsed_time}</strong> seconds.</span>
					<strong>Copyright &copy; Quick 2015-<?= date('Y') ?>.</strong> All rights reserved.
				</div>
				<span><b>Version</b> 1.0.0</span>
			</footer>
			<script>
				const baseurl = "<?= base_url() ?>";
			</script>
			<script src="<?= base_url('assets/plugins/datatables-latest/datatables.min.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table2excel/jquery.table2excel.min.js'); ?>"></script>
			<script src="<?= base_url('assets/plugins/sweetAlert/sweetalert.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/table2csv.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/tableHTMLExport.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/jspdf.min.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/jspdf.plugin.autotable.min.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/tableExport.js') ?>"></script>
			<script src="<?= base_url('assets/plugins/table-to-CSV/FileSaver.min.js') ?>"></script>