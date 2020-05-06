<style>
.flex {
  display: flex;
}

.flex.center {
  align-items: center;
  justify-content: center;
}

button {
  border-radius: 5px;
  text-decoration: none;
  padding: 10 20;
  background-color: #236fce;
  color: white;
  border: 0;
}

button:hover {
  background-color: #1857a7;
}
</style>

<section class="flex center" style="height: 100vh;">
  <div class="" style="text-align: center;">
    <h1>Ooops Blanko tidak ditemukan</h1>
    <h3>Pastikan url valid</h3>
    <p>
      <button id="back" class="btn btn-primary">Kembali</button>
    </p>
  </div>
</section>
<script>
document.querySelector('#back').addEventListener('click', () => window.close())
</script>