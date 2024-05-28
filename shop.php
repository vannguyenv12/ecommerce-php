<?php
require "./include/header.php";
require "./include/topbar.php";
require "./include/navbar.php";
?>

<?php
$TOTAL_ITEMS_PER_PAGE = 6;


$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $TOTAL_ITEMS_PER_PAGE;

$allProducts = $db->customQuery("SELECT * FROM products", []);
$totalItems = count($allProducts);

$totalPages = ceil($totalItems / $TOTAL_ITEMS_PER_PAGE);

$products = $db->customQuery("SELECT * FROM products LIMIT $start, $TOTAL_ITEMS_PER_PAGE", []);

$queryResult = "SELECT * FROM products";
$queryLimit = " LIMIT $start, $TOTAL_ITEMS_PER_PAGE";


if (!empty($_GET['price_range']) && !empty($_GET['price_range'][0])) {
    $priceRanges = $_GET['price_range'];
    $whereClause = '';

    foreach ($priceRanges as $range) {
        list($min, $max) = explode('_', $range);
        $whereClause .= "(offer_price >= $min AND offer_price <= $max) OR ";
    }

    $whereClause = rtrim($whereClause, 'OR ');

    $queryResult .= " WHERE $whereClause" . $queryLimit;
    $query = "SELECT * FROM products WHERE $whereClause";

    $products = $db->customQuery($queryResult, []);
    $productsNotLimited = $db->customQuery($query, []);

    $totalItems = count($productsNotLimited);

    $totalPages = ceil($totalItems / $TOTAL_ITEMS_PER_PAGE);
}

if (!empty($_GET['category'])) {

    $query = "SELECT * FROM products WHERE category_id = ?";
    $queryResult .= " WHERE category_id = ?" . $queryLimit;

    $products = $db->customQuery($queryResult, [$_GET['category']]);
    $productsNotLimited = $db->customQuery($query, [$_GET['category']]);


    $totalItems = count($productsNotLimited);

    $totalPages = ceil($totalItems / $TOTAL_ITEMS_PER_PAGE);
}

if (!empty($_GET['q'])) {
    $query = "SELECT * FROM products WHERE name LIKE CONCAT('%', ?, '%')";
    $queryResult .= " WHERE name LIKE CONCAT('%', ?, '%')" . $queryLimit;

    $products = $db->customQuery($queryResult, [$_GET['q']]);
    $productsNotLimited = $db->customQuery($query, [$_GET['q']]);

    $totalItems = count($productsNotLimited);

    $totalPages = ceil($totalItems / $TOTAL_ITEMS_PER_PAGE);
}


?>



<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop List</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form method="GET" action="">
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" checked id="price-all" name="price_range[]" value="0_99999">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-1" name="price_range[]" value="0_100">
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-2" name="price_range[]" value="100_200">
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-3" name="price_range[]" value="200_300">
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="radio" class="custom-control-input" id="price-4" name="price_range[]" value="300_400">
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="radio" class="custom-control-input" id="price-5" name="price_range[]" value="400_99999">
                        <label class="custom-control-label" for="price-5">$400 - MAX</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                    <input type="hidden" name="page" value="1" />
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <!-- Price End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if (count($products) <= 0) echo '<p class="text-center">Not found any products</p>';
                else
                    foreach ($products as $product) {
                ?>

                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" style="height: 300px !important;" src="./uploads/<?= $product->thumb_image ?>" alt="product">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="detail.php?productId=<?= $product->id ?>"><?= $product->name ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <?php
                                    if (isset($product->offer_price)) {
                                    ?>
                                        <h5>$<?= $product->offer_price ?></h5>
                                        <h6 class="text-muted ml-2"><del>$<?= $product->price ?></del></h6>
                                    <?php
                                    } else {
                                    ?>
                                        <h5>$<?= $product->price ?></h5>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php

                    }
                ?>

                <!-- <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="img/product-1.jpg" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?> "><a class="page-link" href="./shop.php?page=<?= $page - 1; ?>&q=<?= $_GET['q'] ?? '' ?>&price_range[]=<?= $_GET['price_range'][0] ?? '' ?>&category=<?= $_GET['category'] ?? '' ?>"">Previous</span></a></li>
                            <?php


                            for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                                <li class=" page-item <?= $page == $i ? 'active' : '' ?> ">
                                    <a class=" page-link" href="./shop.php?page=<?= $i; ?>&q=<?= $_GET['q'] ?? '' ?>&price_range[]=<?= $_GET['price_range'][0] ?? '' ?>&category=<?= $_GET['category'] ?? '' ?>">
                                    <?= $i; ?>
                                </a>
                            </li>

                        <?php
                            }

                        ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?> "><a class="page-link" href="./shop.php?page=<?= $page + 1; ?>&q=<?= $_GET['q'] ?? '' ?>&price_range[]=<?= $_GET['price_range'][0] ?? '' ?>&category=<?= $_GET['category'] ?? '' ?>">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->


<?php require "./include/footer.php" ?>