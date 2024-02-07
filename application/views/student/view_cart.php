<?php
$page = $this->uri->segment(1);
//print_r_custom($login_detail,1);
?>
<div class="page-header">
    <h4 class="page-title">Cart</h4>
    <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item active" aria-current="page">Cart</li> -->
    </ol>
</div>

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <!-- Cart -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">Shopping Cart</span>
            </div>
            <div class="card-body hero-feature">
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover tbl-cart text-nowrap">
                        <thead>
                            <tr>
                                <th class="hidden-xs text-center font-weight-bold">Image</th>
                                <th class="font-weight-bold">Product Name</th>
                                <th class="font-weight-bold">Unit Price (<i class="fa fa-inr" aria-hidden="true"></i>)
                                </th>
                                <th class="font-weight-bold"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // print_r_custom($cart_details);
                            
                            $total_cart_price = 0;
                            if (isset($cart_details) && count($cart_details) > 0) {
                                for ($i = 0; $i < count($cart_details); $i++) {
                                    $total_cart_price = $total_cart_price + $cart_details[$i]['price_after_discount'];
                                    ?>
                                    <tr>
                                        <td class="hidden-xs text-center">
                                            <a href="javascript:void(0)">
                                                <img src="<?php echo base_url() . "uploads/course/" . $cart_details[$i]['product_id'] . "/course-image/" . $cart_details[$i]['course_image']; ?>"
                                                    alt="Metal Watch" title="" width="100" height="auto">
                                            </a>
                                        </td>
                                        <td><a href="javascript:void(0)">
                                                <?php echo $cart_details[$i]['product_name']; ?>
                                            </a></td>
                                        <td>
                                            <?php echo $cart_details[$i]['course_sell_price']; ?>
                                        </td>

                                        <!-- <td><?php //echo $cart_details[$i]['course_sell_price'] ; ?></td>                                       -->
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="remove_cart btn btn-sm btn-primary"
                                                product_id=<?php echo $cart_details[$i]['product_id']; ?>>
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>


                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr>
                                    <?php
                                    $start_date = $cart_details[0]['course_start_date'] != '' ? date('d-m-Y', strtotime($cart_details[0]['course_start_date'])) : '-';
                                    ?>
                                    <td colspan="2" class="text-center"><b>Course Start Date: </b>
                                        <?php echo $start_date; ?>
                                    </td>

                                    <?php
                                    $end_date = $cart_details[0]['course_end_date'] != '' ? date('d-m-Y', strtotime($cart_details[0]['course_end_date'])) : '-';
                                    ?>
                                    <td colspan="2" class="text-center"><b>Course End Date: </b>
                                        <?php
                                        echo $end_date;
                                        if ($cart_details[0]['is_course_expired']) {
                                            echo "<small class='text-primary'> [Course is already expired]</small>";
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="text-center font-weight-bold">Course Duration</td>
                                    <td class="">
                                        <?php
                                        echo $cart_details[0]['course_duration_number_of_days'] . " days";

                                        if ($cart_details[0]['is_course_expired']) {
                                            echo "<small class='text-success'><b> You can purchase this course.<b></small>";
                                        }
                                        ?>
                                    </td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <?php
                                    $course_duration_number_of_days = $cart_details[0]['course_duration_number_of_days'];
                                    $course_end_date = $cart_details[0]['course_end_date'];
                                    $is_allow_purchase_after_expire = $cart_details[0]['is_allow_purchase_after_expire'];

                                    $enrollment_expiry_date = '';

                                    if (($course_end_date == NULL || $course_end_date == '0000-00-00') && $is_allow_purchase_after_expire == '1') {
                                        $enrollment_expiry_date = date('Y-m-d', strtotime("+" . $course_duration_number_of_days . " days"));
                                    } else {
                                        if ($course_end_date > date('Y-m-d')) {
                                            $enrollment_expiry_date = date('Y-m-d', strtotime($course_end_date . ""));
                                        } else
                                            if (($course_end_date < date('Y-m-d')) && $is_allow_purchase_after_expire == '1') {
                                                $enrollment_expiry_date = date('Y-m-d', strtotime("+" . $course_duration_number_of_days . " days"));
                                            }
                                    }
                                    ?>
                                    <td colspan="2" class="text-center font-weight-bold">Enrollment Expiry Date <small
                                            class="text-primary">[After purchase]</small></td>
                                    <td class="text-primary">
                                        <?php echo date('d-m-Y', strtotime($enrollment_expiry_date)); ?>
                                    </td>
                                    <td></td>
                                </tr>



                                <tr id='discount_tr'>
                                    <td colspan="2" class="text-center font-weight-bold">Discount Amount</td>
                                    <?php
                                    $discount_value = $cart_details[0]['discount_value'] != '' ? $cart_details[0]['discount_value'] : 0;
                                    ?>
                                    <td class="total" id="discount_value">
                                        <?php echo $discount_value; ?>
                                    </td>
                                    <td class="total font-weight-bold" id="discount_type"></td>
                                </tr>

                                <tr>
                                    <td colspan="2" class="text-center font-weight-bold">Total</td>
                                    <td class="total font-weight-bold" id="total_cart_price">
                                        <?php echo number_format($total_cart_price, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4" class="total font-weight-bold text-center">Cart is empty !!</td>
                                </tr>
                                <?php
                            }

                            ?>

                            <?php
                            $description = "ChemCaliba Course";
                            $txnid = date("YmdHis");
                            $key_id = RAZOR_KEY_ID;
                            $currency_code = $currency_code;
                            $total = ($total_cart_price * 100); // 100 = 1 indian rupees
                            $amount = $total_cart_price;
                            $merchant_order_id = "ChemCaliba-" . date("YmdHis");
                            $card_holder_name = $studentInfo['full_name'];
                            $email = $studentInfo['emailid'];
                            $phone = $studentInfo['contact'];
                            $name = COMPANY_NAME;
                            ?>

                        </tbody>
                    </table>
                </div>

                <form name="razorpay-form" id="razorpay-form" action="<?php echo $callback_url; ?>" method="POST">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                    <input type="hidden" name="merchant_order_id" id="merchant_order_id"
                        value="<?php echo $merchant_order_id; ?>" />
                    <input type="hidden" name="merchant_trans_id" id="merchant_trans_id"
                        value="<?php echo $txnid; ?>" />
                    <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id"
                        value="<?php echo $description; ?>" />
                    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>" />
                    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>" />
                    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id"
                        value="<?php echo $card_holder_name; ?>" />
                    <input type="hidden" name="card_holder_email_id" id="card_holder_email_id"
                        value="<?php echo $email; ?>" />
                    <input type="hidden" name="card_holder_phone_id" id="card_holder_phone_id"
                        value="<?php echo $phone; ?>" />
                    <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>" />
                    <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>" />

                    <input type="hidden" name="discount_coupon_master_id" id="discount_coupon_master_id"
                        value="<?php echo isset($cart_details[0]['discount_coupon_master_id']) ? $cart_details[0]['discount_coupon_master_id'] : ''; ?>" />
                    <input type="hidden" name="course_actual_price" id="course_actual_price"
                        value="<?php echo isset($cart_details[0]['course_sell_price']) ? $cart_details[0]['course_sell_price'] : ''; ?>" />
                    <input type="hidden" name="price_after_discount" id="price_after_discount"
                        value="<?php echo isset($cart_details[0]['price_after_discount']) ? $cart_details[0]['price_after_discount'] : ''; ?>" />
                    <input type="hidden" name="discount_type" id="discount_type"
                        value="<?php echo isset($cart_details[0]['discount_type']) ? $cart_details[0]['discount_type'] : ''; ?>" />
                    <input type="hidden" name="disount_percent" id="disount_percent"
                        value="<?php echo isset($cart_details[0]['disount_percent']) ? $cart_details[0]['disount_percent'] : ''; ?>" />
                    <input type="hidden" name="discount_value" id="discount_value"
                        value="<?php echo isset($cart_details[0]['discount_value']) ? $cart_details[0]['discount_value'] : ''; ?>" />

                    <!-- <input type="hidden" name="enrollment_expiry_date" id="enrollment_expiry_date" value="<?php echo $enrollment_expiry_date; ?>"/> -->

                </form>

                <div class="float-left mt-2">
                    <?php
                    if (isset($cart_details) && count($cart_details) > 0) {
                        if (isset($cart_details[$i]['is_discount_applied']) && $cart_details[0]['is_discount_applied']) {
                            ?>
                            <div class="alert alert-icon alert-success">
                                <?php
                                $coupon_str = '';
                                if ($cart_details[0]['discount_type'] == 'PERCENTAGE') {
                                    $coupon_str .= "You have got <strong>" . $cart_details[0]['disount_percent'] . " % </strong> discount.";
                                } else {
                                    $coupon_str .= "You have got <strong> FLAT " . $cart_details[0]['discount_value'] . " </strong> discount.";
                                }
                                echo "Hurray!!  <strong>" . $cart_details[0]['discount_coupon_code'] . "</strong> coupon is applied. " . $coupon_str;
                                ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="row" id="coupon_div">
                                <div class="col-8">
                                    <input class="productcart form-control" type="text" id="coupon_code"
                                        placeholder="Enter Coupon Code">
                                </div>
                                <div class="col-4">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-md" id="apply_coupon">Apply</a>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class=" float-right">
                    <?php
                    if (isset($cart_details) && count($cart_details) == 0) {
                        ?>
                        <a href="<?php echo base_url('student/courses-list'); ?>" class="btn btn-info mt-2"><i
                                class="fa fa-arrow-circle-left"></i> Continue Shopping</a>
                        <?php
                    }
                    ?>

                    <?php
                    if (isset($cart_details) && count($cart_details) > 0) {
                        ?>
                        <!-- <a href="javascript:void(0)" class="btn btn-success mt-2 checkout_cart">Checkout <i class="fa fa-arrow-circle-right"></i></a> -->
                        <button id="pay-btn" type="submit" onclick="razorpaySubmit(this);" class="btn btn-primary mt-2">
                        <i class="fa fa-arrow-circle-right"></i> Pay Now</button>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <!-- End Cart -->
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        key: "<?php echo $key_id; ?>",
        amount: "<?php echo $total; ?>",
        name: "<?php echo $name; ?>",
        description: "Order # <?php echo $merchant_order_id; ?>",
        image: "<?php echo base_url('assets/images/logo.png'); ?>",
        netbanking: true,
        currency: "<?php echo $currency_code; ?>", // INR
        prefill: {
            name: "<?php echo $card_holder_name; ?>",
            email: "<?php echo $email; ?>",
            contact: "<?php echo $phone; ?>"
        },
        notes: {
            soolegal_order_id: "<?php echo $merchant_order_id; ?>",
        },
        handler: function (transaction) {
            document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
            document.getElementById('razorpay-form').submit();
        },
        "modal": {
            "ondismiss": function () {
                location.reload()
            }
        }
    };

    var razorpay_pay_btn, instance;
    function razorpaySubmit(el) {
        if (typeof Razorpay == 'undefined') {
            setTimeout(razorpaySubmit, 200);
            if (!razorpay_pay_btn && el) {
                razorpay_pay_btn = el;
                el.disabled = true;
                el.value = 'Please wait...';
            }
        } else {
            if (!instance) {
                instance = new Razorpay(options);
                if (razorpay_pay_btn) {
                    razorpay_pay_btn.disabled = false;
                    razorpay_pay_btn.value = "Pay Now";
                }
            }
            instance.open();
        }
    }  
</script>