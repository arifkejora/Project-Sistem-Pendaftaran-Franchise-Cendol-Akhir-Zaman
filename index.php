<DOCTYPE html="html"></DOCTYPE>
<html lang="zh-TW"></html>
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>café website</title>
  <link rel="stylesheet" href="css/normalize.css"/>
  <link rel="stylesheet" href="css/style.css"/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>
<body>
  <div class="wrapper">
    <section class="jumbotron">
      <div class="mask-dark"></div>
      <div class="container">
        <div class="logo-image" style="background-image: url(images/common/logo.png);"></div>
        <div class="btn-container"><a class="btn btn-primary btn-large" href="./franchise/register.php">Daftar Sebagai Mitra</a><a class="btn btn-secondary btn-large" href="./franchise/login.php">Sudah Terdaftar Jadi Mitra</a></div>
      </div>
    </section>
    <section class="hero bg-white" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="about-preview">
              <h3 class="title">CENAZ</h3>
              <p class="para">Tentang usaha cendol
                Melihat kondisi perekonomian saat ini yang memperlihatkan bahwa usaha minuman tidak ada matinya, dan cendol adalah minuman yang Indonesia banget maka kami mencoba membuka franchise agar semua bisa menikmati segarnya cendol akhir zaman dan cendol akhir zaman adalah cendol yang sudah ada sedari dulu, namun baru skrang kami mulai menjadikan cendol sebagai minuman kekinian yang menyegarkan.</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="image-container">
              <div class="image" style="background-image: url(images/products/Cenaz.jpg);"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="hero bg-gray" id="service">
      <div class="container">
        <div class="section-intro">
          <h2 class="title">Katalog Kami</h2>
          <p class="para">Spesial Tahun Ini</p>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="service-item">
              <div class="image-container">
                <div class="image" style="background-image: url(images/products/Paket1.jpg);"></div>
              </div>
              <div class="preview">
                <h4 class="title">Paket 1</h4>
                <h5 class="subtitle">Rp. 3.500.000</h5>
                <p class="para">Hanya dengan 3,5 juta saja kita sudah bisa punya usaha yang tidak tegerus oleh zaman, iya Cendol Akhir zaman adalah solusi untuk menambah pundi pundi rupiah, minuman yang sudah ada sedari dulu pasti laris dikalangan para pecintanya, dengan rasa dan kemasan yang kekinian cendol akhir zaman akan diterima oleh semua kalangan,  ayo bergabung skrang!!</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="service-item">
              <div class="image-container">
                <div class="image" style="background-image: url(images/products/Paket2.jpg);"></div>
              </div>
              <div class="preview">
                <h4 class="title">Paket 2</h4>
                <h5 class="subtitle">Rp. 2.500.000</h5>
                <p class="para">Dengan modal yang Hanya 2,5 juta saja kita sudah bisa punya usaha yang tidak tegerus oleh zaman, iya Cendol Akhir zaman adalah solusi untuk menambah pundi pundi rupiah, minuman yang sudah ada sedari dulu pasti laris dikalangan para pecintanya, dengan rasa dan kemasan yang kekinian cendol akhir zaman akan diterima oleh semua kalangan,  ayo bergabung skrang!!</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="hero bg-white" id="menu">
      <div class="container">
        <div class="section-intro">
          <h2 class="title">Menu</h2>
          <p class="para">Cendol Akhir Zaman</p>
        </div>
        <div class="menu-list">
          <div class="title-bar">
            <h3 class="title">Cendol</h3>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6"><a href="#!">
                    <div class="menu-item">
                      <div class="image-container">
                        <div class="image" style="background-image: url(images/products/Menu1.jpg);"></div>
                      </div>
                      <div class="preview">
                        <h5 class="title">Alpukat</h5>
                        <h6 class="subtitle">Rp. 12.000</h6>
                      </div>
                    </div></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6"><a href="#!">
                    <div class="menu-item">
                      <div class="image-container">
                        <div class="image" style="background-image: url(images/products/Menu2.jpg);"></div>
                      </div>
                      <div class="preview">
                        <h5 class="title">Nangka</h5>
                        <h6 class="subtitle">Rp. 12.000</h6>
                      </div>
                    </div></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6"><a href="#!">
                    <div class="menu-item">
                      <div class="image-container">
                        <div class="image" style="background-image: url(images/products/Menu3.jpg);"></div>
                      </div>
                      <div class="preview">
                        <h5 class="title">Durian</h5>
                        <h6 class="subtitle">Rp. 12.000</h6>
                      </div>
                    </div></a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6"><a href="#!">
                    <div class="menu-item">
                      <div class="image-container">
                        <div class="image" style="background-image: url(images/products/Menu4.jpg);"></div>
                      </div>
                      <div class="preview">
                        <h5 class="title">Coklat</h5>
                        <h6 class="subtitle">Rp. 12.000</h6>
                      </div>
                    </div></a>
            </div>
          </div>
        </div>
        
      </div>
    </section>

    
    <section class="hero bg-gray" id="contact">
      <div class="container">
        <div class="section-intro">
          <h2 class="title">Kontak</h2>
          <p class="para"></p>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <table class="contact-info">
              <tr class="title">
                <td><span>Nomor HP</span></td>
              </tr>
              <tr class="info">
                <td>+62 896-8634-4690</td>
              </tr>
              <tr class="title">
                <td><span>Lokasi</span></td>
              </tr>
              <tr class="info">
                <td>Jalan H Muchtar raya RT03/06 kel kreo kec larangan kota tangerang</td>
              </tr>
            </table>
          </div>

        </div>
      </div>
    </section>
    <footer>
      <div class="copyright">
        <p>Canaz Cendol Akhir Zaman</p>
        <p>Copyright 2024. All rights reserved. By Arta</p>
      </div>
    </footer>
  </div>
</body>
