<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title id="title">Category</title>
    <style>
    .jumbotron {
        padding: 2rem 1rem;
    }
    #cont {
        min-height : 570px;
    }
    </style>
</head>
<body>
    <?php include 'partials/_dbconnect.php';?>
    <?php require 'partials/_nav.php' ?>

    <div class="container my-3" id="cont">
        <div class="col-lg-4 text-center bg-light my-3" style="margin:auto;border-top: 2px groove black;border-bottom: 2px groove black;">     
            <h2 class="text-center"><span id="catTitle">Items</span></h2>
        </div>
        <div class="row">
        <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `pizza` WHERE pizzaCategorieId = $id";
            $result = mysqli_query($conn, $sql);
            $noResult = true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult = false;
                $pizzaId = $row['pizzaId'];
                $pizzaName = $row['pizzaName'];
                $pizzaPriceSmall = $row['pizzaPriceSmall'];
                $pizzaPriceLarge = $row['pizzaPriceLarge'];
                $pizzaDesc = $row['pizzaDesc'];
            
                echo '<div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="card" style="width: 18rem;">
                            <img src="img/pizza-'.$pizzaId. '.jpg" class="card-img-top" alt="image for this pizza" width="249px" height="270px">
                            <div class="card-body">
                                <h5 class="card-title">' . substr($pizzaName, 0, 20). '...</h5>
                                <p class="card-text">' . substr($pizzaDesc, 0, 29). '...</p>
                                <div class="row justify-content-center">
                                    <form action="partials/_manageCart.php" method="POST">
                                        <input type="hidden" name="itemId" value="'.$pizzaId. '">
                                        <select name="size" class="form-control mb-2">
                                            <option value="small">Small - Rs. '.$pizzaPriceSmall.'</option>
                                            <option value="large">Large - Rs. '.$pizzaPriceLarge.'</option>
                                        </select>
                                        <button type="submit" name="addToCart" class="btn btn-primary">Add to Cart</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            if($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <p class="display-4">Sorry, no items available in this category.</p>
                        <p class="lead">We will update soon.</p>
                    </div>
                </div> ';
            }
        ?>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        document.getElementById("title").innerHTML = "<?php echo $catname; ?>";
        document.getElementById("catTitle").innerHTML = "<?php echo $catname; ?>";
    </script>
</body>
</html>
