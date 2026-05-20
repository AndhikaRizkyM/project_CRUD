<?php
include "config/koneksi.php";

if (isset($_POST['simpan'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $pass = $_POST['password'];
  $confirm = $_POST['password_confirm'];
  $passHas = sha1($pass);


  if ($pass == $confirm) {
    $cekEmail = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cekEmail) > 0) {
      header('location:?page=user-create-edit');
    }

    mysqli_query($koneksi, "INSERT INTO users (name,email,password) VALUES ('$name','$email','$passHas')");

    header('location:?page=user&status=success');
    exit();
  } else {
    header('location:?page=user-create-edit&status=error');
    exit();
  }
}

if (isset($_GET['idEdit'])) {
  $id = $_GET['idEdit'] ?? '';
  $selectUser = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id' ");
  $rEdit = mysqli_fetch_assoc($selectUser);
  if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pass = $_POST['password'];
    $confirm = $_POST['password-confirm'];
    $passHas = sha1($pass);

    if ($pass == '') {
      $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
      header('location:?page=user');
      exit();
    } else {
      if ($pass == $confirm) {
        $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$passHas' WHERE id='$id'");
        header('location:?page=user');
        exit();
      }
    }

    // if ($updateUser) {
    //   header('location:?page=user');
    //   exit();
    // }
  }
}

?>
<!-- <h2 class="ms-3 fw-bold">User</h2> -->

<div class="card">
  <div class="card-header mt-2">
    <h2 class="card-title fw-bold"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> User</h2>
  </div>
  <div class="card-body">
    <form action="" method="post">
      <div class="row mt-2">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Add Your Name" required
            value="<?php echo isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Add Your Email" required
            value="<?php echo isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>">
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Add Your Password">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Confirm Password</label>
          <input type="password" name="password-confirm" class="form-control" placeholder="Confirm Your Password">
        </div>
        <div class="text-end mt-4">
          <button type="submit" name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'add' ?>"
            class="btn btn-primary me-2"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> User</button>
          <a href="?page=user" class="btn btn-danger">Back</a>
        </div>
    </form>
  </div>
</div>