<?php include 'includes/session.php'; ?>
<?php
if (!isset($_SESSION['user']) || !isset($_POST['checkout'])) {
    header('location: index.php');
}
?>
<?php
include 'includes/header.php';
$conn = $pdo->open();
?>
<body class="hold-transition skin-green layout-top-nav">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <form class = "form-horizontal" id="form" method = "POST" action = "sales.php" enctype = "multipart/form-data">
                            <div class="col-sm-5">
                                <h3 class="page-header">Checkout - Address and Payment Option</h3>
                                <div class = "form-group">
                                    <label for = "firstname" class = "col-sm-3 control-label">Firstname</label>

                                    <div class = "col-sm-9">
                                        <input type = "text" class = "form-control" required=""  id = "firstname" name = "firstname" value = "<?php echo $user['firstname']; ?>">
                                        <input type = "hidden" name = "total" value = "<?php echo $_POST['total'] ?>">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <label for = "lastname" class = "col-sm-3 control-label">Lastname</label>

                                    <div class = "col-sm-9">
                                        <input type = "text" class = "form-control" required=""  id = "lastname" name = "lastname" value = "<?php echo $user['lastname']; ?>">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <label for = "contact" class = "col-sm-3 control-label">Contact Info</label>

                                    <div class = "col-sm-9">
                                        <input type = "text" class = "form-control" required=""  id = "contact" name = "contact" value = "<?php echo $user['contact_info']; ?>">
                                    </div>
                                </div>
                                <div class = "form-group">
                                    <label for = "address" class = "col-sm-3 control-label">Address</label>

                                    <div class = "col-sm-9">
                                        <textarea class = "form-control" required=""  id = "address" name = "address"><?php echo $user['address'];
        ?></textarea>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <h3 class="page-header">&nbsp;</h3>
                                <div class = "form-group">
                                    <label for = "address" class = "col-sm-3 control-label">Payment Option</label>

                                    <div class = "col-sm-9">
                                        <input type="radio" required="" name="option" value="cod"> Cash On Delivery<br/>
                                        <input type="radio" required="" name="option" value="paytm"> Paytm
                                    </div>
                                </div>
                                <button type="submit" name="pay" class="btn btn-primary btn-block btn-flat pull-right" name="signup"><i class="fa fa-check"></i> Proceed to pay</button>
                            </div>
                        </form>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/profile_modal.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script type="text/javascript">
        $('input[type=radio]').change(function () {
            if (this.value == 'cod') {
                $('#form').attr('action', 'sales.php');
            } else if (this.value == 'paytm') {
                $('#form').attr("action", 'pgRedirect.php');
            }
        });
    </script>
