<style>
    /* .modal-body {
        background-color: #eeeeee;
        font-family: 'Open Sans', serif
    } */

    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.10rem
    }

    .card-header:first-child {
        border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1)
    }

    .track {
        position: relative;
        background-color: #ddd;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        height: 7px;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #FF5722
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #ee5435;
        color: #fff
    }

    .track .step.deactive:before {
        background: #030303;
    }

    .track .step.deactive .icon {
        background: #030303;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    .track .text {
        display: block;
        margin-top: 7px
    }

    .btn-warning {
        color: #ffffff;
        background-color: #ee5435;
        border-color: #ee5435;
        border-radius: 1px
    }

    .btn-warning:hover {
        color: #ffffff;
        background-color: #ff2b00;
        border-color: #ff2b00;
        border-radius: 1px
    }
    
</style>
<?php 
    $statusmodalsql = "SELECT * FROM `orders` WHERE `userId`= $userId";
    $statusmodalresult = mysqli_query($conn, $statusmodalsql);
    while($statusmodalrow = mysqli_fetch_assoc($statusmodalresult)){
        $orderid = $statusmodalrow['orderId'];
        $status = $statusmodalrow['orderStatus'];
        if ($status == 0) 
            $tstatus = "Order Placed.";
        elseif ($status == 1) 
            $tstatus = "Order Confirmed.";
        elseif ($status == 2)
            $tstatus = "Preparing your Order.";
        elseif ($status == 3)
            $tstatus = "Your order is on the way!";
        elseif ($status == 4) 
            $tstatus = "Order Delivered.";
        elseif ($status == 5) 
            $tstatus = "Order Denied.";
        else
            $tstatus = "Order Cancelled.";

        if($status >= 1 && $status <= 4) {
            $deliveryDetailSql = "SELECT * FROM `deliverydetails` WHERE `orderId`= $orderid";
            $deliveryDetailResult = mysqli_query($conn, $deliveryDetailSql);
            $deliveryDetailRow = mysqli_fetch_assoc($deliveryDetailResult);
            $trackId = $deliveryDetailRow['id'];
            $deliveryBoyName = $deliveryDetailRow['deliveryBoyName'];
            $deliveryBoyPhoneNo = $deliveryDetailRow['deliveryBoyPhoneNo'];
            $deliveryTime = $deliveryDetailRow['deliveryTime'];
            if($status == 4)
                $deliveryTime = 'xx';
        }
        else {
            $trackId = 'xxxxx';
            $deliveryBoyName = '';
            $deliveryBoyPhoneNo = '';
            $deliveryTime = 'xx';
        }

?>
<!-- Modal -->
<div class="modal fade" id="orderStatus<?php echo $orderid; ?>" tabindex="-1" role="dialog" aria-labelledby="orderStatus<?php echo $orderid; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderStatus<?php echo $orderid; ?>">Order Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="printThis">
                <div class="container" style="padding-right: 0px;padding-left: 0px;">
                    <article class="card">
                        <div class="card-body">
                            <h6><strong>Order ID:</strong> #<?php echo $orderid; ?></h6>
                            <article class="card">
                                <div class="card-body row">
                                    <div class="col"> <strong>Estimated Delivery time:</strong> <br><?php echo $deliveryTime; ?> minute </div>
                                    <div class="col"> <strong>Shipping By:</strong> <br> <?php echo $deliveryBoyName; ?> | <i class="fa fa-phone"></i> <?php echo $deliveryBoyPhoneNo; ?> </div>
                                    <div class="col"> <strong>Status:</strong> <br> <?php echo $tstatus; ?> </div>
                                    <div class="col"> <strong>Tracking #:</strong> <br> <?php echo $trackId; ?> </div>
                                </div>
                            </article>
                            <div class="track">
                            <?php
                                if($status == 0){
                                      echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                            <div class="step"> <span class="icon"> <i class="fa fa-times"></i> </span> <span class="text">Order Confirmed</span> </div>
                                            <div class="step"> <span class="icon"> <i class="fa fa-times"></i> </span> <span class="text"> Preparing your Order</span> </div>
                                            <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                            <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Order Delivered</span> </div>';
                                }
                                elseif($status == 1){
                                    echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-times"></i> </span> <span class="text"> Preparing your Order</span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Order Delivered</span> </div>';
                                }
                                elseif($status == 2){
                                    echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Preparing your Order</span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Order Delivered</span> </div>';
                                }
                                elseif($status == 3){
                                    echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Preparing your Order</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                          <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Order Delivered</span> </div>';
                                }
                                elseif($status == 4){
                                    echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Confirmed</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> Preparing your Order</span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> On the way </span> </div>
                                          <div class="step active"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Order Delivered</span> </div>';
                                } 
                                elseif($status == 5){
                                    echo '<div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">Order Placed</span> </div>
                                          <div class="step deactive"> <span class="icon"> <i class="fa fa-times"></i> </span> <span class="text">Order Denied.</span> </div>';
                                }
                                else {
                                    echo '<div class="step deactive"> <span class="icon"> <i class="fa fa-times"></i> </span> <span class="text">Order Cancelled.</span> </div>';
                                }
                            ?>
                            </div>
                            <a href="contact.php" class="btn btn-warning" data-abc="true">Help <i class="fa fa-chevron-right"></i></a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>

<?php 
    $itemModalSql = "SELECT * FROM `orders`";
    $itemModalResult = mysqli_query($conn, $itemModalSql);
    while($itemModalRow = mysqli_fetch_assoc($itemModalResult)){
        $orderid = $itemModalRow['orderId'];
        $userid = $itemModalRow['userId'];
        $orderStatus = $itemModalRow['orderStatus'];
    
?>

<!-- Modal -->
<div class="modal fade" id="orderStatus<?php echo $orderid; ?>" tabindex="-1" role="dialog" aria-labelledby="orderStatus<?php echo $orderid; ?>" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(111 202 203);">
        <h5 class="modal-title" id="orderStatus<?php echo $orderid; ?>">Order Status and Delivery Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="partials/_orderManage.php" method="post" style="border-bottom: 2px solid #dee2e6;">
            <div class="text-left my-2">    
                <b><label for="name">Order Status</label></b>
                <div class="row mx-2">
                <input class="form-control col-md-3" id="status" name="status" value="<?php echo $orderStatus; ?>" type="number" min="0" max="6" required>    
                <button type="button" class="btn btn-secondary ml-1" data-container="body" data-toggle="popover" title="User Types" data-placement="bottom" data-html="true" data-content="0=Order Placed.<br> 1=Order Confirmed.<br> 2=Preparing your Order.<br> 3=Your order is on the way!<br> 4=Order Delivered.<br> 5=Order Denied.<br> 6=Order Cancelled.">
                    <i class="fas fa-info"></i>
                </button>
                </div>
            </div>
            <input type="hidden" id="orderId" name="orderId" value="<?php echo $orderid; ?>">
            <button type="submit" class="btn btn-success mb-2" name="updateStatus">Update</button>
        </form>
        <?php 
            $deliveryDetailSql = "SELECT * FROM `deliverydetails` WHERE `orderId`= $orderid";
            $deliveryDetailResult = mysqli_query($conn, $deliveryDetailSql);
            if ($deliveryDetailRow = mysqli_fetch_assoc($deliveryDetailResult)) {
                $orderid = $deliveryDetailRow['orderId'];
                $deliveryBoyName = $deliveryDetailRow['deliveryBoyName'];
                $deliveryBoyPhoneNo = $deliveryDetailRow['deliveryBoyPhoneNo'];
                $deliveryTime = $deliveryDetailRow['deliveryTime'];
            } else {
                // Set default values or handle the case where no record is found
                $orderid = "";
                $deliveryBoyName = "Not Assigned";
                $deliveryBoyPhoneNo = "N/A";
                $deliveryTime = "N/A";
            }
            if($orderStatus>0 && $orderStatus<5) { 
        ?>
            <form action="partials/_orderManage.php" method="post">
                <div class="text-left my-2">
                    <b><label for="name">Delivery Boy Name</label></b>
                    <input class="form-control" id="name" name="name" value="<?php echo $deliveryBoyName; ?>" type="text" required>
                </div>
                <div class="text-left my-2 row">
                    <div class="form-group col-md-6">
                        <b><label for="phone">Phone No</label></b>
                        <input class="form-control" id="phone" name="phone" value="<?php echo $deliveryBoyPhoneNo; ?>" type="tel" required pattern="[0-9]{10}">
                    </div>
                    <div class="form-group col-md-6">
                        <b><label for="catId">Estimate Time(minute)</label></b>
                        <input class="form-control" id="time" name="time" value="<?php echo $deliveryTime; ?>" type="number" min="1" max="120" required>
                    </div>
                </div>
                <input type="hidden" id="trackId" name="trackId" value="<?php echo $trackId; ?>">
                <input type="hidden" id="orderId" name="orderId" value="<?php echo $orderid; ?>">
                <button type="submit" class="btn btn-success" name="updateDeliveryDetails">Update</button>
            </form>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php
    }
?>

<style>
    .popover {
        top: -77px !important;
    }
</style>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>