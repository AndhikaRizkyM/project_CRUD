<?php
include "config/koneksi.php";


$select = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id DESC");
$rowsProduct = mysqli_fetch_all($select, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {

  $id = $_GET['delete'];

  // ambil data product dulu
  $selectProduct = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id'");

  $product = mysqli_fetch_assoc($selectProduct);

  // cek apakah gambar ada
  if (!empty($product['product_image'])) {

    $imagePath = "assets/uploads/" . $product['product_image'];

    // cek file exists lalu hapus
    if (file_exists($imagePath)) {

      unlink($imagePath);
    }
  }

  // hapus data dari database
  $delete = mysqli_query($koneksi, "DELETE FROM products WHERE id='$id'");

  if ($delete) {

    header("location:?page=product");
    exit();
  }
}
?>

<div class="card">
  <h2 class="card-header mb-3 mt-2 fw-bold">
    Product Management
  </h2>
  <div class="card-body">
    <div class="mb-3 me-3" align='right'>
      <a href="?page=create-product" class="btn btn-primary">Create New Product</a>
    </div>
    <div class="table-responsive">
      <?php /*
      if (isset($_GET['status']) && $_GET['status'] == 'success') {
        $status = "Data has been successfully added!";
        $location = "?page=menu";
        echo statusSuccess($status, $location);
      } */
      ?>
      <table class="table table-bordered mt-2">
        <thead>
          <tr>
            <th>No.</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Category Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Unit</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rowsProduct as $index => $p) {
          ?>
            <tr>
              <td>
                <?php echo $index + 1
                ?>
              </td>
              <td><img src="assets/uploads/<?= $p['product_image'] ?>" width="100">
              </td>
              <td><?php echo $p['product_name']
                  ?></td>
              <td><?php echo $p['category_name']
                  ?></td>
              <td><?php echo $p['quantity']
                  ?></td>
              <td>Rp. <?php echo number_format($p['price'], 2, ',', '.')
                      ?></td>
              <td><?php echo $p['unit']
                  ?></td>
              <td><?php echo getStatus($p['is_active'])
                  ?></td>
              <td class="">
                <a href=" ?page=create-product&edit=<?= $p['id']
                                                    ?>" class="btn btn-success">Edit</a>
                <form action="?page=product&delete=<?= $p['id']
                                                    ?>" method="post" class="d-inline">
                  <button class="btn btn-danger"
                    onclick="return confirm('Are you sure want delete this menu?')">Delete</button>
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