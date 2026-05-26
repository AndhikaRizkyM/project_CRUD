<?php
include "config/koneksi.php";

// ambil semua category
$categoryQuery = mysqli_query($koneksi, "
    SELECT * FROM categories
    ORDER BY category_name ASC
");

$categories = mysqli_fetch_all($categoryQuery, MYSQLI_ASSOC);
?>

<div class="row">

    <!-- LEFT SIDE -->
    <div class="col-lg-8 p-4">

        <!-- NAV CATEGORY -->
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($categories as $index => $category) : ?>
                <li class="nav-item">
                    <button class="nav-link <?= $index == 0 ? 'active' : '' ?>" data-bs-toggle="tab"
                        data-bs-target="#tab-<?= $category['id'] ?>">
                        <?= $category['category_name'] ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- SEARCH GLOBAL (ONLY 1) -->
        <div class="mt-3 mb-3 sticky-top bg-white p-2 shadow-sm" style="z-index: 10;">
            <input type="text" id="globalSearch" class="form-control" placeholder="Search product...">
        </div>

        <!-- TAB CONTENT -->
        <div class="tab-content mt-3">

            <?php foreach ($categories as $index => $category) : ?>

                <?php
                $categoryId = $category['id'];

                $productQuery = mysqli_query($koneksi, "
                    SELECT * FROM products
                    WHERE category_id = '$categoryId'
                    AND is_active = 1
                    ORDER BY id DESC
                ");

                $products = mysqli_fetch_all($productQuery, MYSQLI_ASSOC);
                ?>

                <div class="tab-pane fade <?= $index == 0 ? 'show active' : '' ?>" id="tab-<?= $category['id'] ?>">

                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-semibold">
                            <span class="fs-5"><?= count($products) ?></span> Products
                        </div>
                    </div>

                    <div class="row g-3">

                        <?php foreach ($products as $product) : ?>

                            <div class="col-md-4">

                                <div class="card product-card h-100 shadow-sm">

                                    <div class="p-3 text-center">

                                        <h6 class="mb-1">
                                            <?= $product['product_name'] ?>
                                        </h6>

                                        <small class="text-muted">
                                            <?= $category['category_name'] ?>
                                        </small>

                                        <div class="mt-2">
                                            <img src="assets/uploads/<?= $product['product_image'] ?>" class="img-fluid"
                                                style="max-height:150px; object-fit:cover;">
                                        </div>

                                    </div>

                                    <div class="px-3 pb-3 text-center">

                                        <h6 class="fw-bold">
                                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                                        </h6>

                                        <p class="text-muted">
                                            Ready Stock <?= $product['quantity'] ?> pcs
                                        </p>

                                    </div>

                                    <div class="px-3 pb-3 d-flex justify-content-center gap-2">

                                        <!-- DETAIL -->
                                        <button type="button" class="btn btn-success btn-sm btn-detail-book" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop" data-title="<?= $product['product_name'] ?>"
                                            data-category="<?= $category['category_name'] ?>"
                                            data-price="<?= number_format($product['price'], 0, ',', '.') ?>"
                                            data-stock="<?= $product['quantity'] ?>"
                                            data-description="<?= htmlspecialchars($product['description']) ?>"
                                            data-image="assets/uploads/<?= $product['product_image'] ?>">
                                            Detail
                                        </button>

                                        <!-- ADD CART -->
                                        <button type="button" class="btn btn-primary btn-sm btn-add-cart" data-id="<?= $product['id'] ?>"
                                            data-title="<?= $product['product_name'] ?>" data-price="<?= $product['price'] ?>"
                                            data-image="assets/uploads/<?= $product['product_image'] ?>">
                                            Add
                                        </button>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

    <!-- RIGHT SIDE CART -->
    <div class="col-lg-4 p-4">

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active">Order Details</button>
            </li>
        </ul>

        <div class="card p-3 mt-3 shadow-sm">

            <div id="order-items" style="max-height:350px; overflow-y:auto;">
                <div class="text-center text-muted py-4" id="empty-cart">
                    Cart masih kosong
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <small>Subtotal</small>
                <small id="subtotal">Rp 0</small>
            </div>

            <div class="d-flex justify-content-between">
                <small>Tax</small>
                <small id="tax">Rp 0</small>
            </div>

            <div class="d-flex justify-content-between">
                <small>Discount</small>
                <small id="discount">Rp 0</small>
            </div>

            <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                <small>Total</small>
                <small id="total-bill">Rp 0</small>
            </div>

            <div class="mt-3">
                <button class="btn btn-success w-100">Payment</button>
            </div>

        </div>

    </div>

</div>

<!-- ================= CART JS ================= -->
<script>
    let cart = {};

    // render cart
    function renderCart() {

        let container = document.getElementById('order-items');
        let empty = document.getElementById('empty-cart');

        container.innerHTML = '';

        let subtotal = 0;
        let items = Object.values(cart);

        if (items.length === 0) {
            container.appendChild(empty);
            updateSummary(0);
            return;
        }

        items.forEach(item => {

            subtotal += item.price * item.qty;

            let html = `
        <div class="card p-2 mb-2 shadow-sm">

            <div class="d-flex justify-content-between">

                <div class="d-flex gap-2">

                    <img src="${item.image}" width="45" height="45" class="rounded">

                    <div>
                        <div class="fw-semibold">${item.title}</div>
                        <small>Rp ${item.price.toLocaleString('id-ID')}</small>
                    </div>

                </div>

                <button onclick="removeItem(${item.id})"
    class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
    style="width:30px; height:30px;">
    ✕
</button>

            </div>

            <div class="d-flex align-items-center gap-1">

    <button onclick="decreaseQty(${item.id})"
        class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
        style="width:28px; height:28px; font-weight:bold;">
        −
    </button>

    <span class="fw-semibold px-2">
        ${item.qty}
    </span>

    <button onclick="increaseQty(${item.id})"
        class="btn btn-outline-success btn-sm rounded-circle d-flex align-items-center justify-content-center"
        style="width:28px; height:28px; font-weight:bold;">
        +
    </button>

</div>

        </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
        });

        updateSummary(subtotal);
    }

    // update total
    function updateSummary(subtotal) {

        let tax = subtotal * 0.1;
        let discount = 0;
        let total = subtotal + tax - discount;

        document.getElementById('subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('tax').innerText = 'Rp ' + tax.toLocaleString('id-ID');
        document.getElementById('discount').innerText = 'Rp ' + discount.toLocaleString('id-ID');
        document.getElementById('total-bill').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    // ADD CART
    document.querySelectorAll('.btn-add-cart').forEach(btn => {

        btn.addEventListener('click', function() {

            let id = this.dataset.id;

            if (cart[id]) {
                cart[id].qty++;
            } else {
                cart[id] = {
                    id: id,
                    title: this.dataset.title,
                    price: parseInt(this.dataset.price),
                    image: this.dataset.image,
                    qty: 1
                };
            }

            renderCart();
        });

    });

    // qty control
    function increaseQty(id) {
        cart[id].qty++;
        renderCart();
    }

    function decreaseQty(id) {
        cart[id].qty--;
        if (cart[id].qty <= 0) delete cart[id];
        renderCart();
    }

    function removeItem(id) {
        delete cart[id];
        renderCart();
    }
</script>

<!-- ================= SEARCH ================= -->
<script>
    document.getElementById('globalSearch').addEventListener('keyup', function() {

        let keyword = this.value.toLowerCase();
        let activeTab = document.querySelector('.tab-pane.active');
        let cards = activeTab.querySelectorAll('.product-card');

        cards.forEach(card => {

            let title = card.querySelector('h6').innerText.toLowerCase();

            card.parentElement.style.display =
                title.includes(keyword) ? '' : 'none';

        });

    });
</script>