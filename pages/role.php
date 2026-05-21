<?php
include "config/koneksi.php";
// include "config/function.php";

// mysqli_fetch ini berfungsi sebagai pemanggilan data
$query = mysqli_query($koneksi, "SELECT * from roles ORDER BY id ASC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $delete = mysqli_query($koneksi, "DELETE FROM roles WHERE id='$id'");
  header("location:?page=role");
  exit();
}

// $status = 1;
// $statusTampil = ($status == 1) ? 'Active' : 'Inactive';

?>

<div class="card">
  <h2 class="card-header mb-3 mt-2 fw-bold">
    Role Management
  </h2>
  <div class="card-body">
    <div class="mb-3 me-3" align='right'>
      <a href="?page=role-create-edit" class="btn btn-primary">Create New Role</a>
    </div>
    <div class="table-responsive">
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Data has been successfully added!";
        $location = "?page=role";
        echo statusSuccess($status, $location);
      }
      ?>
      <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Status</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rows as $index => $r) {
          ?>
          <tr>
            <td>
              <?php echo $index + 1 ?>
            </td>
            <td><?php echo $r['name'] ?></td>
            <td><?php echo getStatus($r['is_active'])  ?></td>
            <td><?php echo $r['description'] ?></td>
            <td class="">
              <a href="?page=role-create-edit&edit=<?php echo $r['id'] ?>" class="btn btn-success">Edit</a>
              <form action="?page=role&delete=<?php echo $r['id'] ?>" method="post" class="d-inline">
                <button class="btn btn-danger"
                  onclick="return confirm('Are you sure want delete this data?')">Delete</button>
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