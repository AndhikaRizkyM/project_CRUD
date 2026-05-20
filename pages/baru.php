<?php
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
    $confirm = $_POST['password_confirm'];
    $passHas = md5($pass);

    if ($pass == '') {
      $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email' WHERE id='$id'");
    } else {
      $updateUser = mysqli_query($koneksi, "UPDATE users SET name='$name', email='$email', password='$passHas' WHERE id='$id'");
    }

    if ($updateUser) {
      header('location:?page=user');
      exit();
    }
  }
}

?>

<div class="card">
  <div class="card-header ">
    <div class="card-body">
      <h2 class="card-title"><?= isset($_GET['idEdit']) ? "Edit" : "Tambah"  ?> User</h2>
    </div>
    <div class="card-body">
      <form action="" method="post">
        <div class="row">
          <div class=" col-6">
            <label for="" class="form-label">Nama</label>
            <input type="text" name="name" value="<?= isset($_GET['idEdit']) ? $rEdit['name'] : '' ?>"
              class="form-control" required>
          </div>
          <div class="col-6">
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" value="<?= isset($_GET['idEdit']) ? $rEdit['email'] : '' ?>"
              class="form-control" required>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-6">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-6">
            <label for="" class="form-label">Password Confirm</label>
            <input type="password" name="password_confirm" class="form-control">
          </div>
        </div>
        <div class="text-end mt-2 ">
          <button type="submit" class="btn btn-primary"
            name="<?= isset($_GET['idEdit']) ? 'edit' : 'simpan' ?>"><?= isset($_GET['idEdit']) ? 'Edit' : 'Simpan' ?></button>
          <a href="?page=user" class="btn btn-secondary">Batal</a>
        </div>

      </form>
    </div>
  </div>
</div>
</div>