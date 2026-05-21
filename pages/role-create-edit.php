<!-- tadi kita breakdown if, nanti cek if lama di file lama-->

<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
  $name = htmlspecialchars($_POST['name']);
  $status = htmlspecialchars($_POST['status']);
  $desc = $_POST['description'];

  // memasukkan data ke dalam table users
  mysqli_query($koneksi, "INSERT INTO roles (name,is_active,description) VALUES ('$name','$status','$desc')");
  header('location:?page=role&status=success');
}

// membuat parameter status untuk alert status
$status = $_GET['status'] ?? '';


// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$id = $_GET['edit'] ?? '';
$selectRole = mysqli_query($koneksi, "SELECT * FROM roles WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectRole);

if (isset($_POST['edit'])) {
  $name = htmlspecialchars($_POST['name']);
  $status = htmlspecialchars($_POST['status']);
  $desc = $_POST['description'];

  // print_r($status);
  // die();

  mysqli_query($koneksi, "UPDATE roles SET name='$name', is_active='$status', description='$desc' WHERE id='$id'");
  header('location:?page=role');
}


?>
<!-- <h2 class="ms-3 fw-bold">User</h2> -->

<div class="card">
  <h2 class="card-header fw-bold mt-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</h2>
  <!-- <div class="card-header mt-2 text-primary">
  </div> -->
  <div class="card-body">
    <form action="" method="post">
      <div class="row mt-2">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Name *</label>
          <input type="text" name="name" class="form-control" placeholder="Add Your Name" required
            value="<?php echo isset($_GET['edit']) ? $rEdit['name'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table mb-2">Status *</label><br>
          <div class="btn-group" role="group" aria-label="radio toggle button status">
            <div class="form-check me-3">
              <input class="form-check-input" type="radio" name="status" id="radioDefault1" value="1"
                <?php echo isset($_GET['edit']) ? ($rEdit['is_active'] == 1 ? 'checked' : '') : 'checked' ?>>
              <label class="form-check-label" for="radioDefault1">
                Active
              </label>
            </div><br>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="radioDefault2" value="0" checked
                <?php echo isset($_GET['edit']) ? ($rEdit['is_active'] == 0 ? 'checked' : '') : '' ?>>
              <label class="form-check-label" for="radioDefault2">
                Inactive
              </label>
            </div>
          </div>


        </div>
      </div>
      <div class="row mb-4">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table">Description *</label>
          <textarea name="description" id="" class="form-control" placeholder="Add Your Description"
            value="<?php echo isset($_GET['edit']) ? $rEdit['description'] : '' ?>"></textarea>
        </div>
        <?php if ($id): ?>
          <div class="mt-2 ms-3 text-secondary">
            <p>*Leave blank if you dont want to change the password</p>
          </div>
        <?php endif ?>
        <div class="text-end mt-4">
          <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>"
            class="btn btn-primary me-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Role</button>
          <a href="?page=role" class="btn btn-danger">Cancel</a>
        </div>
    </form>
  </div>
</div>