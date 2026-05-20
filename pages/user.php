<?php
include "config/koneksi.php";
// include "config/function.php";

$selectUser = mysqli_query($koneksi, "SELECT * from users");
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);

if (isset($_GET['idDelete'])) {
  $id = $_GET['idDelete'] ?? 0;
  $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id");
  header("location:?page=user");
  exit();
}
?>

<div class="card">
  <div class="card-header text-center">
    <h2 class="card-title fw-bold">
      Users</h2>
  </div>
  <div class="card-body">
    <div class="mb-4">
      <a href="?page=user-create-edit" class="btn btn-primary">Create</a>
    </div>
    <div class="table-responsive">
      <?php
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Your Data has been succeed added!";
        $location = "?page=user";
        echo statusSuccess($status, $location);
      }
      ?>
      <table class="table table-bordered text-center mt-2">
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
                    onclick="return confirm('Yakin ingin menghapus data ini?')">Delete</button>
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