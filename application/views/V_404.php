<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 | Page Not Found</title>
  <link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.ico') ?>">
  <style>
    html {
      font-family: Arial, Helvetica, sans-serif;
    }

    section {
      height: 100vh;
    }

    .d-flex {
      display: flex;
    }

    .justify-center {
      justify-content: center;
    }

    .align-center {
      align-items: center;
    }

    .hero_image {
      width: 300px;
    }

    .h-100 {
      height: 100%;
    }

    a,
    a:visited {
      text-decoration: none;
      color: #ff3006;
    }

    a:hover,
    a:focus {
      color: #bf2606;
    }

    .text-center {
      text-align: center;
    }

    h1 {
      font-size: 4rem;
    }
  </style>
</head>

<body>
  <section>
    <div class="d-flex justify-center align-center h-100">
      <div class="content-wrapper text-center">
        <img class="hero_image" src="<?= base_url('/assets/img/id_card.png') ?>" alt="Hero">
        <h4 style="margin-bottom: 0;">Maaf, halaman tidak ditemukan</h4>
        <h4 style="margin-top: 5px;"><a href="<?= @$_SERVER['HTTP_REFERER'] ?: base_url('/') ?>">kembali</a></h4>
      </div>
    </div>
  </section>
</body>

</html>