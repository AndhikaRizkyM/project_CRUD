<!-- tadi kita breakdown if, nanti cek if lama di file lama-->

<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $pass = $_POST['password'];
  $confirm = $_POST['confirm_password'];
  $passHas = sha1($pass);

  // pass tidak sama
  if ($pass !== $confirm) {
    header('location:?page=user-create-edit&status=password_not_match');
    exit();
  }
  // mengecek email 
  $cekEmail = mysqli_query($koneksi, "SELECT id FROM users WHERE email = '$email'");
  if (mysqli_num_rows($cekEmail) > 0) {
    header('location:?page=user-create-edit&status=email_exists');
    exit();
  }
  // memasukkan data ke dalam table users
  mysqli_query($koneksi, "INSERT INTO users (name,email,password) VALUES ('$name','$email','$passHas')");
  header('location:?page=user&status=success');
}

// membuat parameter status untuk alert status
$status = $_GET['status'] ?? '';


// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$id = $_GET['idEdit'] ?? '';
$selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectUser);


if (isset($_POST['edit'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $pass = $_POST['password'];
  $confirm = $_POST['confirm_password'];
  $passHas = sha1($pass);

  if (empty($pass)) {
    mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$passHas' WHERE id='$id'");
    header('location:?page=user');
    exit();
  }

  if ($pass !== $confirm) {
    header('location:?page=user-create-edit&idEdit=' . $id . '$&status = password_not_match');
    exit();
  }
  mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$passHas' WHERE id='$id'");
  header('location:?page=user');
}





?>
<!-- <h2 class="ms-3 fw-bold">User</h2> -->

<div class="card">
  <h2 class="card-header fw-bold mt-2"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> User</h2>
  <!-- <div class="card-header mt-2 text-primary">
  </div> -->
  <div class="card-body">
    <?php if ($status == 'password_not_match') : ?>
      <div class="alert alert-warning alert-dismissible fade-show ps-3">
        Password do not match!
        <button type='button' class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
      </div>
    <?php endif ?>
    <?php if ($status == 'email_exists') : ?>
      <div class="alert alert-warning alert-dismissible fade-show ps-3">
        This email is already registered!
        <button type='button' class="btn-close" data-bs-dismiss='alert' aria-label="Close"></button>
      </div>
    <?php endif ?>
    <form action="" method="post">
      <div class="row mt-2">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Name *</label>
          <input type="text" name="name" class="form-control" placeholder="Add Your Name" required
            value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Email *</label>
          <input type="email" name="email" class="form-control" placeholder="Add Your Email with @" required
            value="<?php echo isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>">
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Password *</label>
          <input type="password" name="password" class="form-control" placeholder="Add Your Password"
            <?php $id ? '' : 'required' ?>>
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Confirm Password *</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Your Password"
            <?php !$id ? 'required' : '' ?>>
        </div>
        <?php if ($id): ?>
          <div class="mt-2 ms-3 text-secondary">
            <p>*Leave Password blank if you dont want to change the password</p>
          </div>
        <?php endif ?>
        <div class="text-end mt-4">
          <button type="submit" name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'add' ?>"
            class="btn btn-primary me-2"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> User</button>
          <a href="?page=user" class="btn btn-danger">Cancel</a>
        </div>
    </form>
  </div>
</div>