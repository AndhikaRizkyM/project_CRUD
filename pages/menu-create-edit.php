<!-- tadi kita breakdown if, nanti cek if lama di file lama-->

<?php
include "config/koneksi.php";

if (isset($_POST['add'])) {
  $parentId = $_POST['parent_id'] ?: 'NULL';
  $name = htmlspecialchars($_POST['name']);
  $url = htmlspecialchars($_POST['url']);
  $icon = htmlspecialchars($_POST['icon']);
  $sortOrder = htmlspecialchars($_POST['sort_order']);
  $status = htmlspecialchars($_POST['is_active']);

  // memasukkan data ke dalam table users
  mysqli_query($koneksi, "INSERT INTO menus (parent_id, name, url, icon, sort_order, is_active) VALUES ($parentId, '$name','$url', '$icon', '$sortOrder', '$status')");
  header('location:?page=menu&status=success');
}

// membuat parameter status untuk alert status
$status = $_GET['status'] ?? '';

// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : '';
$id = $_GET['edit'] ?? '';
$selectMenu = mysqli_query($koneksi, "SELECT * FROM menus WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($selectMenu);

if (isset($_POST['edit'])) {
  $name = htmlspecialchars($_POST['name']);
  $url = htmlspecialchars($_POST['url']);
  $parentId = $_POST['parent_id'] ?: 'NULL';
  $icon = htmlspecialchars($_POST['icon']);
  $sortOrder = htmlspecialchars($_POST['sort_order']);
  $status = htmlspecialchars($_POST['is_active']);

  // print_r($status);
  // die();

  mysqli_query($koneksi, "UPDATE menus SET parent_id=$parentId, name='$name', url='$url', icon='$icon', sort_order='$sortOrder', is_active='$status' WHERE id='$id'");
  header('location:?page=menu');
}

// is : adalah
$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id IS NULL");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);


?>
<!-- <h2 class="ms-3 fw-bold">User</h2> -->

<div class="card">
  <h2 class="card-header fw-bold mt-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Menu</h2>
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
          <label for="" class="form-label">Parent Name*</label>
          <select type='number' name="parent_id" id="" class="form-control">
            <option value="">Select One</option>
            <?php foreach ($rowParent as $parent): ?>
              <option value="<?= $parent['id'] ?>">
                <?= $parent['name']  ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-label">Url *</label>
          <input type="text" name="url" class="form-control" placeholder="Add Url Menu"
            value="<?php echo isset($_GET['edit']) ? $rEdit['url'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-label">Icon *</label>
          <input type="text" name="icon" class="form-control" placeholder="Add Icon" required
            value="<?php echo isset($_GET['edit']) ? $rEdit['icon'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-label">Sort Order *</label>
          <input type="number" name="sort_order" class="form-control" placeholder="Add Url Menu" required
            value="<?php echo isset($_GET['edit']) ? $rEdit['sort_order'] : '' ?>">
        </div>
        <div class="col-md-12 mb-3">
          <label for="" class="form-table mb-2">Status *</label><br>
          <div class="btn-group" role="group" aria-label="radio toggle button status">
            <div class="form-check me-3">
              <input class="form-check-input" type="radio" name="is_active" id="radioDefault1" value="1" checked
                <?php echo isset($_GET['edit']) ? ($rEdit['is_active'] == 1 ? 'checked' : '') : 'checked' ?>>
              <label class="form-check-label" for="radioDefault1">
                Active
              </label>
            </div><br>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="is_active" id="radioDefault2" value="0"
                <?php echo isset($_GET['edit']) ? ($rEdit['is_active'] == 0 ? 'checked' : '') : '' ?>>
              <label class="form-check-label" for="radioDefault2">
                Inactive
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="text-end mt-4">
        <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>"
          class="btn btn-primary me-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Menu</button>
        <a href="?page=menu" class="btn btn-danger">Cancel</a>
      </div>
    </form>
  </div>
</div>