<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Template</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      /* font-family: "Courier New", Courier, monospace; */
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #e8e8e8;
    }

    #app {
      max-width: 512px;
      margin: 0 auto;
      position: relative;
    }

    header {
      display: block;
      padding: 2em 1em;
      color: white;
      background-color: #d31b1b;
      text-align: center;
      z-index: 9;
    }

    main {
      margin-top: -1em;
      padding: 1em;
      background-color: white;
    }

    footer {
      padding: 1em;
      color: white;
      background-color: #092a47;
    }

    h1 {
      margin: 0;
      padding: 0;
    }

    table.table {
      border-collapse: collapse;
    }

    table.table-bordered td,
    table.table-bordered th {
      padding: 0.25em 0.5em;
      border: 1px solid black;
    }

    .card {
      padding: 1em;
      /* box-shadow: 5px 5px 5px 5px #e8e8e8; */
      background-color: cornsilk;
      border: 1px solid orange;
    }

    .mt-1 {
      margin-top: 0.25em;
    }

    .mt-4 {
      margin-top: 4em;
    }

    .mb-4 {
      margin-bottom: 1em;
    }

    a {
      color: #42a9ff;
      text-decoration: none;
    }

    a:visited {
      color: #1a78c7;
    }

    .center {
      text-align: center;
    }
  </style>
</head>

<body>
  <div id="app">
    <header>
      <h1>Akun Baru Telah Dibuat</h1>
    </header>
    <main>
      <span style="float: right"><?= date('d F Y') ?><small style="color: gray;"><?= date('H:i:s') ?></small></span>
      <p>Hai <?= $receiverName ?></p>
      <p>Telah dibuat akun untuk <b><?= $createdFor ?></b></p>
      <div class="card">
        <small>Pembuat: </small>
        <p class="mt-1"><?= $creator ?></p>
        <small>Aplikasi: </small>
        <p class="mt-1"><?= $applicationName ?></p>
      </div>
      <?php foreach ($accountContent as $account) : ?>
        <h2><?= $account['title'] ?></h2>
        <table class="table">
          <tr>
            <td>Username</td>
            <td>:</td>
            <td><a href="<?= $account['accountLink'] ?>"><?= $account['username'] ?></a></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td><?= $account['email'] ?></td>
          </tr>
          <tr>
            <td>Password</td>
            <td>:</td>
            <td><?= $account['password'] ?></td>
          </tr>
        </table>
      <?php endforeach ?>
      <div class="mt-4">
        <hr />
        <h3 class="center">Terimakasih</h3>
      </div>
    </main>
    <footer>
      <p>
        <small>Notifikasi ini digenerate melalui web <a href="http://erp.quick.com/">erp.quick.com</a></small>
      </p>
      <small>Bila terdapat kesalahan mohon untuk menghubungi programmer ICT - Tim Human Resource</small>
    </footer>
  </div>
</body>

</html>