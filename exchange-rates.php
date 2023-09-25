<?php
try {
  $db = new PDO("mysql:host=localhost; dbname=exchange_rate; charset=utf8", 'root', '');
} catch (Exception $e) {
  echo $e->getMessage();
}

session_start();

$exchange_rates = simplexml_load_file("https://www.tcmb.gov.tr/kurlar/today.xml");
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>exchange rate</title>
<link rel="icon" type="image/x-icon" href="favicon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    .alert {
      --bs-alert-padding-x: 0.5rem;
      --bs-alert-padding-y: 0.8rem;
    }
  </style>
</head>

<body>

  <?php
  if (isset($_POST['logout'])) {
    $swal = 'swal';
    session_destroy();
    echo '<script>' . $swal . '("Çıkış yapıldı !", "İşlemleriniz kaydedildi", "success");</script>';
    header('Refresh:3; exchange-rates.php');
  }
  ?>
  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Lütfen İşlem Yapabilmek İçin Giriş Yapın</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php
          if (isset($_POST['login'])) {
            $email = $_POST['userEmail'];
            $password = $_POST['userPassword'];
            $swal = 'swal';

            if (!$email) {
              echo '<script>' . $swal . '("Lütfen kullanıcı adınızı girin !", "", "error");</script>';
            } elseif (!$password) {
              echo '<script>' . $swal . '("Lütfen şifrenizi girin !", "", "error");</script>';
            } else {
              $kullanici_sor = $db->prepare('SELECT * FROM users WHERE userEmail= ? and userPassword= ?');
              $kullanici_sor->execute([$email, md5($password)]);

              $say = $kullanici_sor->rowCount();

              if ($say == 1) {
                $_SESSION['email'] = $email;
                echo '<script>' . $swal . '("Hoşgeldiniz !", "", "success");</script>';
                header('Refresh:2; exchange-rates.php');
              } else {
                echo '<script>' . $swal . '("Lütfen bilgilerinizi kontrol edip tekrar deneyin !", "", "error");</script>';

              }
            }
          }
          ?>
          <form action="" method="post">
            <div class="form-group">
              <div class="form-floating mb-3">
                <input type="text" id="email" name="userEmail" placeholder="E-posta" class="form-control" required>
                <label for="email">Email Adresiniz</label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" id="password" name="userPassword" placeholder="Şifre" class="form-control"
                  required>
                <label for="name">Şifreniz</label>
              </div>
              <button type="submit" class="btn btn-outline-success" name="login">Giriş Yap</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <label for="">Hesabın Yok Mu ? &rarr;</label> <button class="btn btn-outline-warning"
            data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Kayıt Ol</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Kayıt Olarak İşlemlerinize Devam Edin</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php
          if (isset($_POST['register'])) {
            $name = $_POST['userName'];
            $password = $_POST['userPassword'];
            $email = $_POST['userEmail'];
            $swal = 'swal';

            if (!$name) {
              echo '<script>' . $swal . '("Lütfen kullanıcı adınızı girin !", "", "error");</script>';
            } elseif (!$password) {
              echo '<script>' . $swal . '("Lütfen şifrenizi girin !", "", "error");</script>';
            } elseif (!$email) {
              echo '<script>' . $swal . '("Lütfen e-posta adresinizi girin !", "", "error");</script>';
            } else {
              $sorgu = $db->prepare('INSERT INTO users SET userName = ?, userPassword = ?, userEmail = ?');
              $ekle = $sorgu->execute([$name, md5($password), $email]);

              if ($ekle) {

                echo '<script>' . $swal . '("Kayıt İşlemi Başarılı !", "Yönlediriliyorsunuz...", "success");</script>';
                header('Refresh:2; exchange-rates.php');

              } else {
                echo '<script>' . $swal . '("Lütfen bilgilerinizi kontrol edip tekrar deneyin !", "", "error");</script>';
              }
            }
          }
          ?>

          <form action="" method="post">
            <div class="form-group">
              <div class="form-floating mb-3">
                <input type="text" id="name" name="userName" placeholder="Kullanıcı Adınız" class="form-control"
                  required>
                <label for="name">Kullanıcı Adınız</label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" id="password" name="userPassword" placeholder="Şifre" class="form-control"
                  required>
                <label for="name">Şifreniz</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="userEmail" placeholder="name@example.com"
                  required>
                <label for="email">Email</label>
              </div>

              <button type="submit" class="btn btn-outline-success" name="register">Kayıt Ol</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <label for="">Hesabın Var Mı ? &rarr;</label><button class="btn btn-outline-warning"
            data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Giriş Yap</button>
        </div>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg text-white"
    style="position: sticky;position: -webkit-sticky;top: 0; background-color: #00028f;">
    <div class="container-fluid text-white">
      <a class="navbar-brand text-white" style="font-family: cursive;" href="#"><i><b>Exchange Rate</b></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-white" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
        </ul>
        <?php
        if (isset($_SESSION['email'])) { ?>
          <form action="" method="post" class="mx-3">
            <button type="submit" name="logout" class="btn ">
              <svg xmlns="http://www.w3.org/2000/svg" width="64" height="45" viewBox="0 0 64 64" version="1.1">
                <path
                  d="M 23.248 6.880 C 9.388 11.668, 2.355 25.385, 6.480 39.583 C 9.576 50.240, 21.090 59, 32 59 C 45.638 59, 59 45.638, 59 32 C 59 21.360, 50.247 9.620, 40.068 6.608 C 33.170 4.566, 29.788 4.620, 23.248 6.880 M 31 19.500 C 31 22.525, 31.450 25, 32 25 C 32.550 25, 33 22.525, 33 19.500 C 33 16.475, 32.550 14, 32 14 C 31.450 14, 31 16.475, 31 19.500 M 20.153 21.479 C 14.427 28, 14.729 36.964, 20.882 43.118 C 32.167 54.402, 50.527 44.283, 47.551 28.419 C 46.855 24.709, 40.702 16.965, 39.447 18.220 C 39.055 18.612, 40.122 20.513, 41.818 22.445 C 43.514 24.377, 45.193 27.513, 45.550 29.413 C 47.462 39.607, 37.478 48.293, 27.598 45.032 C 17.970 41.855, 15.128 28.926, 22.529 21.973 C 23.888 20.696, 25 19.280, 25 18.826 C 25 17.088, 23.090 18.133, 20.153 21.479"
                  stroke="none" fill="#fffcfc" fill-rule="evenodd" />
                <path d="" stroke="none" fill="#fcfcfc" fill-rule="evenodd" />
              </svg>
            </button>

          </form>
        <?php } ?>

        <button id="refreshbtn" class="btn btn-warning  fw-bold" type="submit">Verileri Güncelle</button>

      </div>
    </div>
  </nav>
  <div class="container-fluid">

    <div class="row">
      <div class="col-2" style="background-color:	#BDBDBD;">
        <form action="" method="post">
          <h4 class="text-center mt-3">Döviz Çevirici</h4>
          <hr>
          <select name="transforming" class="form-select form-select mb-3 mt-3" aria-label=".form-select-lg example">
            <option selected>Çevirilen Döviz Cinsi</option>
            <?php
            for ($i = 0; $i < count($exchange_rates->Currency); $i++) { ?>
              <option value="<?= $exchange_rates->Currency[$i]['CurrencyCode'] ?>">
                <?= $exchange_rates->Currency[$i]['CurrencyCode'] ?>
              </option>
            <?php } ?>
          </select>

          <input type="number" name="amount" placeholder="Miktar" min="0" class="form-control">

          <select name="converted" class="form-select form-select mb-3 mt-3" aria-label=".form-select-lg example">
            <option selected>Çevirilecek Döviz Cinsi</option>
            <?php
            for ($i = 0; $i < count($exchange_rates->Currency); $i++) { ?>
              <option value="<?= $exchange_rates->Currency[$i]['CurrencyCode'] ?>">
                <?= $exchange_rates->Currency[$i]['CurrencyCode'] ?>
              </option>
            <?php } ?>
          </select>
          <button type="submit" name="convert" class="btn btn-success mx-auto">Hesapla</button>
        </form>

        <?php
        if (isset($_POST['convert'])) {
          $transforming = $_POST['transforming'];
          $converted = $_POST['converted'];
          $amount = $_POST['amount'];
          $swal = 'swal';

          for ($i = 0; $i < count($exchange_rates->Currency); $i++) {

            if ($exchange_rates->Currency[$i]['CurrencyCode'] == $transforming) {
              $transformingPrice = $exchange_rates->Currency[$i]->ForexBuying;
            }
          }

          for ($i = 0; $i < count($exchange_rates->Currency); $i++) {

            if ($exchange_rates->Currency[$i]['CurrencyCode'] == $converted) {
              $convertedPrice = $exchange_rates->Currency[$i]->ForexBuying;
            }
          }

          $calcAmount = ($transformingPrice / $convertedPrice) * $amount;
          echo "<div class='alert alert-success alert-dismissible fade show mt-5'><label >İşlem Sonucu :</label><br><hr>"
            . $amount . " " . $transforming . "<br> &rarr; <br>" . substr($calcAmount, 0, 6) . " " . $converted
            . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";

          if (isset($_SESSION['email'])) {
            $user = $_SESSION['email'];
            if (!$transforming || !$converted || !$amount) {
              echo '<script>' . $swal . '("Lütfen çeviri işlemi yapmak için alanları doldurun!", "", "error");</script>';
            } else {
              $transaction = $db->prepare('INSERT INTO transactions SET transforming = ?, converted = ?, amount = ?, Date=?, calculation = ?, user = ?');
              $transac = $transaction->execute([$transforming, $converted, $amount, date("Y-m-d H:i:s"), substr($calcAmount, 0, 6), $user]);

              if ($transac) {
                //   echo '<script>' . $swal . '("Kayıt İşlemi Başarılı !", "Yönlediriliyorsunuz...", "success");</script>';
                //   header('Refresh:2; exchange-rates.php');
              } else {
                echo '<script>' . $swal . '("Bir hata oldu !", "Tekrar deneyin", "error");</script>';
              }
            }
          }
        }
        ?>
      </div>

      <div class="col-7 overflow-auto" style="background-color:	#E0E0E0;height: 680px">
        <table id="refresh" class="table table-hover table-bordered border-white overflow-auto">
          <thead>
            <tr>
              <th scope="col">Döviz Kodu</th>
              <th scope="col">Birim</th>
              <th scope="col">Döviz Cinsi</th>
              <th scope="col">Döviz Alışı</th>
              <th scope="col">Döviz Satşı</th>
              <th scope="col">Efektif Alış</th>
              <th scope="col">Efektif Satış</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            <?php
            for ($i = 0; $i < count($exchange_rates->Currency); $i++) { ?>
              <tr>
                <th scope="row">
                  <?= $exchange_rates->Currency[$i]['CurrencyCode'] ?>
                </th>
                <td>
                  <?= $exchange_rates->Currency[$i]->Unit ?>
                </td>
                <td>
                  <?= $exchange_rates->Currency[$i]->Isim ?>
                </td>
                <td>
                  <?= $exchange_rates->Currency[$i]->ForexBuying ?>
                </td>
                <td>
                  <?= $exchange_rates->Currency[$i]->ForexSelling ?>
                </td>
                <td>
                  <?= $exchange_rates->Currency[$i]->BanknoteBuying ?>
                </td>
                <td>
                  <?= $exchange_rates->Currency[$i]->BanknoteSelling ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="col-3 overflow-auto" style="background-color: #BDBDBD;height: 680px">
        <h5 class="text-center mt-3">Son Yapılan İşlemler</h5>
        <hr>
        <?php
        if (isset($_SESSION['email'])) { ?>
          <form action="" method="post">
            <div class="input-group input-group-sm mb-3 w-70">
              <input type="date" name="Date" class="form-control w-70">
              <button type="submit" name="list" class="btn btn-warning">Listele</button>
            </div>
          </form>
          <hr>
        <?php } ?>

        <?php
        $hidden = "";
        if (isset($_SESSION['email']) && isset($_POST['list'])) {
          $hidden = "hidden";
          $date = $_POST['Date'];
          $listTransaction = $db->query("SELECT * FROM transactions WHERE Date LIKE '%$date%'", PDO::FETCH_ASSOC);
          foreach ($listTransaction as $item) { ?>

            <div class="alert alert-warning" style="font-size:15px;">
              <p>
                <?= $item['amount'] ?>.
                <?= $item['transforming'] ?>
                &rarr;
                <?= $item['converted'] ?> =
                <?= $item['calculation'] ?>.
                <?= $item['converted'] ?>
              </p>
              <span class="float-end badge badge-dark bg-dark"><small class="">
                  <?= $item['Date'] ?>
                </small></span>
            </div>
          <?php }
        }

        if (isset($_SESSION['email'])) {
          $user = $_SESSION['email'];
          $lastTransaction = $db->query("SELECT * FROM transactions WHERE user LIKE '%$user%' GROUP BY Id DESC", PDO::FETCH_ASSOC);

          foreach ($lastTransaction as $value) { ?>

            <div <?= $hidden ?> class="alert alert-warning" style="font-size:15px;">
              <p>
                <?= $value['amount'] ?>.
                <?= $value['transforming'] ?>
                &rarr;
                <?= $value['converted'] ?> =
                <?= $value['calculation'] ?>.
                <?= $value['converted'] ?>
              </p>
              <span class="float-end badge badge-dark bg-dark"><small class="">
                  <?= $value['Date'] ?>
                </small></span>
            </div>

          <?php }
        }
        ?>
      </div>
    </div>
    <footer class="fw-bold d-flex justify-content-center">www.argenova.com.tr - Copyright ©
      <?php echo date('Y'); ?>. Tüm Hakları Saklıdır
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(function () {
      $("#refreshbtn").click(function () {
        $("#refresh").load(location.href + " #refresh");
      });

      <?php if (isset($_SESSION['email'])) { ?>
        $("#exampleModalToggle").modal('<?= 'hide' ?>');
      <?php } else { ?>
        $("#exampleModalToggle").modal('<?= 'show' ?>');
      <?php } ?>
    });
  </script>
</body>

</html>