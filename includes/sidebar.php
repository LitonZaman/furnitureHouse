<div class="row">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Most Viewed Today</b></h3>
        </div>
        <div class="box-body">
            <ul id="trending">
                <?php
                $now = date('Y-m-d');
                $conn = $pdo->open();

                $stmt = $conn->prepare("SELECT * FROM products WHERE date_view=:now ORDER BY counter DESC LIMIT 10");
                $stmt->execute(['now' => $now]);
                foreach ($stmt as $row) {
                    echo "<li><a href='product.php?product=" . $row['slug'] . "'>" . $row['name'] . "</a></li>";
                }

                $pdo->close();
                ?>
                <ul>
                    </div>
                    </div>
                    </div>

                    <div class="row">
                        <div class='box box-solid'>
                            <div class='box-header with-border'>
                                <h3 class='box-title'><b>Follow us on Social Media</b></h3>
                            </div>
                            <div class='box-body'>
                                <a class="btn btn-social-icon" href="https://www.facebook.com/Furniture-House-102784475249848/"><img src="images/facebook.png" alt="alt"/></a>
                                <a class="btn btn-social-icon"href="https://www.instagram.com/furni_turehouse786/"><img src="images/instagram.png" alt="alt"/></a>
                                <a class="btn btn-social-icon"href="https://twitter.com/FurnitureHouse9"><img src="images/twitter.png" alt="alt"/></a>
                                <a class="btn btn-social-icon"href="https://myaccount.google.com/u/2/profile?pli=1"><img src="images/google-plus.png" alt="alt"/></a>
                            </div>
                        </div>
                    </div>
