<div class="center">
  <h1>Soon</h1>

</div>
<script>
  function restore(id) {
    const conf = confirm('Yakin untuk restore surat ini ?')
    if (!conf) return

    $.ajax({
      url: '<?= base_url('MasterPekerja/Surat/Recycle/Restore') ?>',
      method: 'POST',
      data: {
        id: id,
        surat: 'workExp',
      },
      success() {
        // window.location.reload()
      }
    })
  }
</script>