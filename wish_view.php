<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo "
                                <div class='callout callout-danger text-center'>
                                  <p>" . $_SESSION['error'] . "</p> 
                                </div>
                              ";
                                unset($_SESSION['error']);
                            }

                            if (isset($_SESSION['success'])) {
                                echo "
                                    <div class='callout callout-success text-center'>
                                      <p>" . $_SESSION['success'] . "</p> 
                                    </div>
                                  ";
                                unset($_SESSION['success']);
                            }
                            ?>
                            <h1 class="page-header">My Wishlist</h1>
                            <?php
                            $conn = $pdo->open();

                            try {
                                $inc = 3;
                                $stmt = $conn->prepare("SELECT *,wishlist.id as wish_id, products.name AS prodname, category.name AS catname FROM wishlist LEFT JOIN products ON products.id=wishlist.product_id LEFT JOIN category ON category.id=products.category_id WHERE user_id=:user_id");
                                $stmt->execute(['user_id' => $user['id']]);
                                foreach ($stmt as $row) {
                                    $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                    $inc = ($inc == 3) ? 1 : $inc + 1;
                                    if ($inc == 1)
                                        echo "<div class='row'>";
                                    echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=" . $row['slug'] . "'>" . $row['name'] . "</a></h5>
		       								</div>
		       								<div class='box-footer'>
		       									<b>&#8377; " . number_format($row['price'], 2) . "</b><a class='pull-right' href='wish_delete.php?id=" . $row['wish_id'] . "'><i class='fa fa-trash'></i></a>
		       								</div>
	       								</div>
	       							</div>
	       						";
                                    if ($inc == 3)
                                        echo "</div>";
                                }
                                if ($inc == 1)
                                    echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
                                if ($inc == 2)
                                    echo "<div class='col-sm-4'></div></div>";
                            } catch (PDOException $e) {
                                echo "There is some problem in connection: " . $e->getMessage();
                            }

                            $pdo->close();
                            ?> 
                        </div>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>