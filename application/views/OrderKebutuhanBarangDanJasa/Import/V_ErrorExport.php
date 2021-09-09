<script src="<?php echo base_url('assets/plugins/sweetAlert/sweetalert.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        Swal.fire({
            position: "top",
            type: "error",
            title: "Data Tidak Ditemukan",
            showConfirmButton: false,
            timer: 1500,
        }).then(() => {
            window.location.href = baseurl + "OrderKebutuhanBarangDanJasa/ExportApproval";
        });
    })
</script>