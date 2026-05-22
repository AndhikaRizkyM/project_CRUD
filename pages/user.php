<?php
include "config/koneksi.php";
// include "config/function.php";

// mysqli_fetch ini berfungsi sebagai pemanggilan data
$selectUser = mysqli_query($koneksi, "SELECT users.id, users.name, users.email from users ORDER BY id ASC");
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);

if (isset($_GET['idDelete'])) {
  $id = $_GET['idDelete'];
  $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
  header("location:?page=user");
  exit();
}
?>

<div class="card">
  <h2 class="card-header mb-3 mt-2 fw-bold">
    Users Management
  </h2>
  <div class="card-body">
    <div class="mb-3 me-3" align='right'>
      <a href="?page=user-create-edit" class="btn btn-primary">Create New User</a>
    </div>
    <div class="table-responsive">
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Data has been successfully added!";
        $location = "?page=user";
        echo statusSuccess($status, $location);
      }
      ?>
      <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
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
              <td><?php echo $r['email'] ?></td>
              <td class="-2">
                <a href="?page=user-create-edit&idEdit=<?php echo $r['id'] ?>" class="btn btn-success">Edit</a>
                <form action="?page=user&idDelete=<?php echo $r['id'] ?>" method="post" class="d-inline">
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