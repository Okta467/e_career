<!DOCTYPE html>
<html lang="en">

<head>
  <?php session_start() ?>
  <?php include 'config/connection.php' ?>
  <?php include 'config/config.php' ?>
  <?php include 'login_head.php' ?>
  <?php include 'helpers/isAccessAllowedHelper.php' ?>
  <?php include 'helpers/isAlreadyLoginHelper.php' ?>

  <?php isset($_SESSION['hak_akses']) ? isAlreadyLoggedIn($_SESSION['hak_akses']) : '' ?>

  <meta name="author" content="" />
  <meta name="Description" content="Halaman Buat Akun Perusahaan">
  <title>Buat Akun Perusahaan - <?= SITE_NAME ?></title>
</head>

<body class="bg-primary">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container-xl px-4">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center">
                  <h3 class="fw-light my-4">Buat Akun Perusahaan</h3>
                </div>
                <div class="card-body">
                  <form action="perusahaan_registration_save.php" method="POST" id="perusahaan_registration_form">
                    
                    <div class="mb-3">
                      <label class="small mb-1" for="xnama_perusahaan">Nama Perusahaan <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control" id="xnama_perusahaan" type="text" name="xnama_perusahaan" placeholder="Enter nama perusahaan" required>
                    </div>
                
                    <div class="mb-3">
                      <label class="small mb-1" for="xid_jenis_perusahaan">Jenis Perusahaan <span class="text-danger fw-bold">*</span></label>
                      <select name="xid_jenis_perusahaan" class="form-control select2" id="xid_jenis_perusahaan" required>
                        <option value="">-- Pilih --</option>
                        <?php $query_jenis_perusahaan = mysqli_query($connection, "SELECT * FROM tbl_jenis_perusahaan ORDER BY nama_jenis ASC") ?>
                        <?php while ($jenis_perusahaan = mysqli_fetch_assoc($query_jenis_perusahaan)): ?>
                
                          <option value="<?= $jenis_perusahaan['id'] ?>"><?= $jenis_perusahaan['nama_jenis'] ?></option>
                
                        <?php endwhile ?>
                      </select>
                    </div>
                    
                    <div class="mb-3">
                      <label class="small mb-1" for="xusername">Username <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control" id="xusername" type="text" name="xusername" placeholder="Enter username" autocomplete="username" required>
                    </div>

                    
                    <div class="row gx-3">
                    
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="small mb-1" for="xpassword">Password <span class="text-danger fw-bold">*</span></label>
                          <div class="input-group input-group-joined mb-1">
                            <input class="form-control mb-1" id="xpassword" type="password" name="xpassword" placeholder="Enter password" autocomplete="new-password" required>
                            <button class="input-group-text" id="xpassword_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                          </div>
                          <small class="text-danger fade-in-up d-none" id="xpassword_help">Password tidak sama!</small>
                        </div>
                      </div>
                    
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="small mb-1" for="xpassword_confirm">Confirm Password <span class="text-danger fw-bold">*</span></label>
                          <div class="input-group input-group-joined mb-1">
                            <input class="form-control mb-1" id="xpassword_confirm" type="password" name="xpassword_confirm" placeholder="Confirm password" autocomplete="new-password" required>
                            <button class="input-group-text" id="xpassword_confirm_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                          </div>
                          <small class="text-danger fade-in-up d-none" id="xpassword_confirm_help">Password tidak sama!</small>
                        </div>
                      </div>
                    
                    </div>
                
                    <div class="mb-3">
                      <label class="small mb-1" for="xalamat_perusahaan">Alamat <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control" id="xalamat_perusahaan" type="text" name="xalamat_perusahaan" placeholder="Enter alamat" required>
                    </div>

                    <button type="submit" name="xsubmit" class="btn btn-primary btn-block" id="toggle_swal_submit">Buat Akun</button>

                  </form>
                </div>
                <div class="card-footer text-center">
                  <div class="small">Sudah punya akun? <a href="index.php">Login</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <div id="layoutAuthentication_footer">
      <footer class="footer-admin mt-auto footer-dark">
        <div class="container-xl px-4">
          <div class="row">
            <div class="col-md-6 small">Copyright &copy; <?= SITE_NAME_SHORT . ' ' . date('Y') ?></div>
            <div class="col-md-6 text-md-end small">
              <a href="#!">Privacy Policy</a>
              &middot;
              <a href="#!">Terms &amp; Conditions</a>
            </div>
          </div>
        </div>
      </footer>
    </div>

  </div>

  <?php include_once 'login_script.php' ?>
  <?php include_once 'helpers/sweetalert2_notify.php' ?>

  <script>
    let password = document.getElementById('xpassword');
    let passwordConfirm = document.getElementById('xpassword_confirm');

    let passwordToggle = document.getElementById('xpassword_toggle');
    let passwordConfirmToggle = document.getElementById('xpassword_confirm_toggle');

    let passwordHelp = document.getElementById('xpassword_help');
    let passwordConfirmHelp = document.getElementById('xpassword_confirm_help');

    passwordConfirm.addEventListener('keyup', function() {
      initIsPasswordSame(password, passwordConfirm, passwordHelp, passwordConfirmHelp);
    });
    
    passwordConfirmToggle.addEventListener('click', function() {
      initTogglePassword(passwordConfirm);
    });
    
    passwordToggle.addEventListener('click', function() {
      initTogglePassword(password);
    });


    $(document).ready(function() {
      const jenisPerusahaanSelect = $('#xid_jenis_perusahaan');
      
      initSelect2(jenisPerusahaanSelect, {
        width: '100%',
        dropdownParent: "form"
      });
        
      
      const formSubmitBtn = $('#toggle_swal_submit');
      const eventName = 'click';
      const formElement = $('#perusahaan_registration_form');
      const submitElement = $('<input />')
        .attr('type', 'hidden')
        .attr('name', 'xsubmit')
        .attr('value', 'Buat Akun');

      toggleSwalSubmit(formSubmitBtn, eventName, formElement, submitElement);
    });
  </script>

</body>

</html>