<!-- tadi kita breakdown if, nanti cek if lama di file lama-->

<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
  $name = $_POST['name'];
  // cek kategori tersebut ada atau ga
  $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name = '$name'");
  if (mysqli_num_rows($cek) > 0) {
    header('location:?page=create-category&status=category-exist');
    exit();
  }
  $query = mysqli_query($koneksi, "INSERT INTO categories (`category_name`) VALUES ('$name')");
  if ($query) {
    header('location:?page=category&status=sucess');
    exit();
  }
}

$status = $_GET['status'] ?? '';

$id = $_GET['idEdit'] ?? '';
$selectCategory = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$id' ");
$cEdit = mysqli_fetch_assoc($selectCategory);

if (isset($_POST['edit'])) {
  $name = $_POST['name'];
  $status = htmlspecialchars($_POST['is_active']);
  $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name = '$name'");
  if (mysqli_num_rows($cek) > 0) {
    header('location:?page=create-category&idEdit=' . $_GET['idEdit'] . '&status=category-exist');
    exit();
  }
  $query = mysqli_query($koneksi, "UPDATE categories SET category_name='$name', is_active='$status' WHERE id='$id'");
  if ($query) {
    header('location:?page=category&status=sucess');
    exit();
  }
}

?>
<!-- <h2 class="ms-3 fw-bold">User</h2> -->

<div class="card">
  <h2 class="card-header fw-bold mt-2"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> Category</h2>
  <!-- <div class="card-header mt-2 text-primary">
  </div> -->
  <div class="card-body">
    <?php /* if ($status == 'password_not_match') : ?>
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
    <?php endif */ ?>
    <form action="" method="post">
      <div class="row mt-2">
        <div class="col-md-12 mb-3">
          <label for="" class="form-table mb-2">Category Name *</label>
          <input type="text" name="name" class="form-control" placeholder="Add Category" required
            value="<?php echo isset($_GET['idEdit']) ? $cEdit['category_name'] : '' ?>">
        </div>
        <label for="" class="form-table mb-2">Status *</label><br>
        <div class="btn-group" role="group" aria-label="radio toggle button status">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="status" id="radioDefault1" value="1" checked
              <?php echo isset($_GET['idEdit']) ? ($cEdit['is_active'] == 1 ? 'checked' : '') : 'checked' ?>>
            <label class="form-check-label" for="radioDefault1">
              Active
            </label>
          </div><br>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="radioDefault2" value="0"
              <?php echo isset($_GET['idEdit']) ? ($cEdit['is_active'] == 0 ? 'checked' : '') : '' ?>>
            <label class="form-check-label" for="radioDefault2">
              Inactive
            </label>
          </div>
        </div>
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 'category-exist') {
          $status = "Category Name Already Exist!";
          $location = "?page=create-category";
          echo inputFailed($status);
        }
        ?>
      </div>
      <div class="text-end mt-4">
        <button type="submit" name="<?php echo isset($_GET['idEdit']) ? 'edit' : 'add' ?>"
          class="btn btn-primary me-2"><?php echo isset($_GET['idEdit']) ? 'Edit' : 'Add' ?> Category</button>
        <a href="?page=category" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>