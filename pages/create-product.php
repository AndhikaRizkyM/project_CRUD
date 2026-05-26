<?php
include "config/koneksi.php";
include "inc/js.php";

$catProduct = mysqli_query($koneksi, 'SELECT * FROM categories ORDER BY id ASC');
$rowCatProduct = mysqli_fetch_all($catProduct, MYSQLI_ASSOC);

if (isset($_POST['create'])) {
  $categoryId = htmlspecialchars($_POST['category_id']);
  $productName = htmlspecialchars($_POST['product_name']);
  $qty = htmlspecialchars($_POST['quantity']);
  $price = htmlspecialchars($_POST['price']);
  $unit = htmlspecialchars($_POST['unit']);
  $description = $_POST['description'];
  $isActive = $_POST['status'];

  $productImage = time() . '_' . $_FILES['product_image']['name'];
  $tmpName = $_FILES['product_image']['tmp_name'];
  move_uploaded_file($tmpName, "assets/uploads/" . $productImage);

  $insertProduct = mysqli_query($koneksi, "INSERT INTO products (category_id, product_name, product_image, quantity, price, unit, description, is_active) VALUES ('$categoryId', '$productName', '$productImage', '$qty','$price','$unit','$description','$isActive')");

  if ($insertProduct) {
    header('location:?page=product');
    exit();
  }
}



if (isset($_GET['edit'])) {
  $id = $_GET['edit'] ?? 0;
  $selectProduct = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$id' ");
  $rEdit = mysqli_fetch_assoc($selectProduct);
  if (isset($_POST['edit'])) {

    $categoryId = htmlspecialchars($_POST['category_id']);
    $productName = htmlspecialchars($_POST['product_name']);
    $qty = htmlspecialchars($_POST['quantity']);
    $price = htmlspecialchars($_POST['price']);
    $unit = htmlspecialchars($_POST['unit']);
    $description = $_POST['description'];
    $isActive = $_POST['status'];

    // gunakan gambar lama sebagai default
    $productImage = $rEdit['product_image'];

    // jika upload gambar baru
    if ($_FILES['product_image']['name'] != '') {

      // hapus gambar lama
      if (!empty($rEdit['product_image']) && file_exists("assets/uploads/" . $rEdit['product_image'])) {

        unlink("assets/uploads/" . $rEdit['product_image']);
      }

      // upload gambar baru
      $productImage = time() . '_' . $_FILES['product_image']['name'];

      $tmpName = $_FILES['product_image']['tmp_name'];

      move_uploaded_file($tmpName, "assets/uploads/" . $productImage);
    }

    // update database
    $update = mysqli_query($koneksi, "
        UPDATE products SET
            category_id='$categoryId',
            product_name='$productName',
            product_image='$productImage',
            quantity='$qty',
            price='$price',
            unit='$unit',
            description='$description',
            is_active='$isActive'
        WHERE id='$id'
    ");

    if ($update) {
      header('location:?page=product');
      exit();
    }
  }
}


?>


<div class="card">
  <h2 class="card-header fw-bold mt-2 mb-3"><?= isset($_GET['edit']) ? 'Edit' : 'Create'
                                            ?> Product</h2>
  <!-- <div class="card-header mt-2 text-primary">
  </div> -->
  <div class="card-body">
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="formFile" class="form-label">Input Product Image</label>
        <div class="mb-3">
          <img src="assets/uploads/<?= isset($_GET['edit']) ? $rEdit['product_image'] : ''; ?>" width="100">
        </div>
        <input class="form-control" type="file" id="formFile" name="product_image">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Product Name *</label>
        <input type="text" name="product_name" class="form-control" placeholder="Add Your Name" required value="<?= isset($_GET['edit']) ? $rEdit['product_name'] : ''
                                                                                                                ?>">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Category Name *</label>
        <select type="text" name="category_id" class="form-select" required value="<?= isset($_GET['edit']) ? $rEdit['category_name'] : ''
                                                                                    ?>">
          <option value="">Select Category Product</option>
          <?php foreach ($rowCatProduct as $key => $cp) {
          ?>
            <option value="<?= $cp['id'] ?>"><?= $cp['category_name'] ?>
            </option>
          <?php } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Quantity *</label>
        <input type="number" name="quantity" class="form-control" placeholder="Add Product Quantity" value="<?= isset($_GET['edit']) ? $rEdit['quantity'] : ''
                                                                                                            ?>">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Price *</label>
        <input type="number" name="price" class="form-control" placeholder="Add Product Price" value="<?= isset($_GET['edit']) ? $rEdit['price'] : ''
                                                                                                      ?>">
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Unit *</label>
        <input type="tezt" name="unit" class="form-control" placeholder="Add Product Unit" value="<?= isset($_GET['edit']) ? $rEdit['unit'] : ''
                                                                                                  ?>">
      </div>
      <div class="mb-3">
        <label for="" class="form-label mb-2">Status *</label><br>
        <div class="btn-group" role="group" aria-label="radio toggle button status">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="status" id="radioDefault1" value="1" checked
              <?= isset($_GET['edit']) && $cp['id'] == $rEdit['is_active'] ? 'checked' : '' ?>></input>
            <label class="form-check-label" for="radioDefault1">
              Active
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="radioDefault2" value="0" <?= isset($_GET['edit']) ? ($rEdit['is_active'] == 0 ? 'checked' : '') : ''
                                                                                                    ?>>
            <label class="form-check-label" for="radioDefault2">
              Inactive
            </label>
          </div>
        </div>


      </div>
      <div class="row mb-4">
        <div class="mb-3">
          <label for="" class="form-label">Description *</label>
          <textarea name="description" id="default-editor" class="form-control" placeholder="Add Your Description"
            cols="30" rows="5" value="<?= isset($_GET['edit']) ? $rEdit['description'] : ''
                                      ?>"></textarea>
        </div>
        <?php // if ($id): 
        ?>
        <div class="mt-2 ms-3 text-secondary">
          <p>*Leave blank if you dont want to change description</p>
          <?php // endif 
          ?>
          <div class="text-end mt-4 me-4">
            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'create' ?>"
              class="btn btn-primary me-2"><?php echo isset($_GET['edit']) ? 'Edit' : 'Create' ?> Product</button>
            <a href="?page=product" class="btn btn-danger">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>