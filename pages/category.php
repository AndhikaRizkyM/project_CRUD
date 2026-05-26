<?php
include "config/koneksi.php";

$selectCategory = mysqli_query($koneksi, "SELECT * from categories ORDER BY id ASC");
$rows = mysqli_fetch_all($selectCategory, MYSQLI_ASSOC);

if (isset($_GET['idDelete'])) {
  $id = $_GET['idDelete'];
  $delete = mysqli_query($koneksi, "DELETE FROM categories WHERE id='$id'");
  header("location:?page=category");
  exit();
}
?>
<div class="card">
  <h2 class="card-header mb-3 mt-2 fw-bold">
    Category Management
  </h2>
  <div class="card-body">
    <div class="mb-4 d-flex justify-content-end">
      <a href="?page=create-category" class="btn btn-primary">Create Category</a>
    </div>
    <div class="table-responsive">
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Data has been successfully added!";
        echo statusSuccess($status, $location);
      }
      ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No.</th>
            <th>Category Name</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rows as $index => $c) {
          ?>
            <tr>
              <td><?php echo $index + 1 ?></td>
              <td><?php echo $c['category_name'] ?></td>
              <td><?php echo getStatus($c['is_active'])  ?></td>
              <td><a href="?page=create-category&idEdit=<?php echo $c['id'] ?>" class="btn btn-success">Edit</a>
                <form action="?page=category&idDelete=<?php echo $c['id'] ?>" method="post" class="d-inline">
                  <button class="btn btn-danger"
                    onclick="return confirm('Are you sure want delete this category?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>