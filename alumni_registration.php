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
  <meta name="Description" content="Halaman Buat Akun Alumni">
  <title>Buat Akun Alumni - <?= SITE_NAME ?></title>
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
                  <h3 class="fw-light my-4">Buat Akun Alumni</h3>
                </div>
                <div class="card-body">
                  <form action="alumni_registration_save.php" method="POST" id="alumni_registration_form">

                    <input type="hidden" name="xid_alumni" id="xid_alumni" required>
                    <input type="hidden" name="xid_pengguna" id="xid_pengguna" required>

                    <div class="mb-3">
                      <label class="small mb-1" for="xnisn">NISN (10 Digit) <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control mb-1 xnisn" id="xnisn" type="text" name="xnisn" minlength="10" maxlength="10" placeholder="Enter nisn" required>
                      <small class="text-danger">Perhatian: NISN digunakan untuk login sistem, catat bila perlu.</small>
                    </div>

                    <div class="mb-3">
                      <label class="small mb-1" for="xnama_alumni">Nama Alumni <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control" id="xnama_alumni" type="text" name="xnama_alumni" placeholder="Enter nama Alumni" required>
                    </div>

                    <div class="mb-3">
                      <label class="small mb-1" for="xid_kelas">Kelas <span class="text-danger fw-bold">*</span></label>
                      <select name="xid_kelas" class="form-control select2" id="xid_kelas" required>
                        <option value="">-- Pilih --</option>
                        <?php $query_kelas = mysqli_query($connection, "SELECT * FROM tbl_kelas ORDER BY nama_kelas ASC") ?>
                        <?php while ($kelas = mysqli_fetch_assoc($query_kelas)) : ?>

                          <option value="<?= $kelas['id'] ?>"><?= $kelas['nama_kelas'] ?></option>

                        <?php endwhile ?>
                      </select>
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


                    <div class="row gx-3">

                      <div class="col-md-6">
                        <div class="form-check form-check-solid mb-3">
                          <input class="form-check-input" id="xjk_l" type="radio" name="xjk" value="l" checked required>
                          <label class="form-check-label" for="xjk_l">Laki-laki</label>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-check form-check-solid mb-3">
                          <input class="form-check-input" id="xjk_p" type="radio" name="xjk" value="p" required>
                          <label class="form-check-label" for="xjk_p">Perempuan</label>
                        </div>
                      </div>

                    </div>


                    <div class="mb-3">
                      <label class="small mb-1" for="xalamat">Alamat</label>
                      <input class="form-control" id="xalamat" type="text" name="xalamat" placeholder="Enter alamat" required>
                    </div>


                    <div class="row gx-3">

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="small mb-1" for="xtmp_lahir">Tempat Lahir</label>
                          <input class="form-control" id="xtmp_lahir" type="text" name="xtmp_lahir" placeholder="Enter tempat lahir" required>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="small mb-1" for="xtgl_lahir">Tanggal Lahir</label>
                          <input class="form-control" id="xtgl_lahir" type="date" name="xtgl_lahir" required>
                        </div>
                      </div>

                    </div>


                    <div class="mb-3">
                      <label class="small mb-1" for="xno_telp">No. Telp</label>
                      <input class="form-control" id="xno_telp" type="text" name="xno_telp" min="0" maxlength="16" placeholder="Enter no telp" required>
                    </div>

                    <div class="mb-3">
                      <label class="small mb-1" for="xemail">Email <span class="text-danger fw-bold">*</span></label>
                      <input class="form-control" id="xemail" type="email" name="xemail" aria-describedby="emailHelp" placeholder="Enter email address" required>
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
      if (password.value !== passwordConfirm.value) {
        passwordHelp.classList.remove('d-none');
        passwordConfirmHelp.classList.remove('d-none');
      } else {
        passwordHelp.classList.add('d-none');
        passwordConfirmHelp.classList.add('d-none');
      }
    });

    passwordToggle.addEventListener('click', function() {
      password.getAttribute('type') === 'password' ?
        password.setAttribute('type', 'text') :
        password.setAttribute('type', 'password');
    });

    passwordConfirmToggle.addEventListener('click', function() {
      passwordConfirm.getAttribute('type') === 'password' ?
        passwordConfirm.setAttribute('type', 'text') :
        passwordConfirm.setAttribute('type', 'password');
    });


    $(document).ready(function() {
      const kelasSelect = $('#xid_kelas');
      
      initSelect2(kelasSelect, {
        width: '100%',
        dropdownParent: "form"
      });
        
      
      const formSubmitBtn = $('#toggle_swal_submit');
      const eventName = 'click';
      const formElement = $('#alumni_registration_form');
      const submitElement = $('<input />')
        .attr('type', 'hidden')
        .attr('name', 'xsubmit')
        .attr('value', 'Buat Akun');

      toggleSwalSubmit(formSubmitBtn, eventName, formElement, submitElement);
    });
  </script>

</body>

</html>