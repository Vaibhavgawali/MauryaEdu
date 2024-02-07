$(document).ready(function () {
  var page_number = parseInt($("#page_num").val());

  var logged_in_student_id = $("#logged_in_student_id").val();
  // alert(logged_in_student_id);

  var current_url = window.location.href;
  current_url = current_url.split("/");
  var last_segment = current_url.pop() || current_url.pop();
  // alert(last_segment);

  if (
    last_segment == "courses-list" ||
    last_segment == "student-portal" ||
    last_segment == "lms-testing"
  ) {
    getAllCourses();
  }

  //to get all courses
  function getAllCourses() {
    var data = {
      page_num: $("#page_num").val(),
      limit: 4,
    };
    var courseData = "";

    var ajax_url =
      logged_in_student_id > 0
        ? "student/course/get-course-list"
        : "course/get-course-list";

    $.ajax({
      type: "post",
      // url:base_url+"course/get-course-list",
      url: base_url + ajax_url,
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        // console.log(res);

        if (res.status == true) {
          console.log(res.courseData);
          if (res.courseData.length > 0) {
            for (let i = 0; i < res.courseData.length; i++) {
              var add_to_cart_btn = "";
              var course_details_url = "";
              var start_date = "";
              var end_date = "";
              var is_course_expired = "";

              if (!res.courseData[i].is_already_bought) {
                var is_allow_purchase_after_expire = "";
                var course_expired = false;

                is_allow_purchase_after_expire =
                  res.courseData[i].is_allow_purchase_after_expire;
                course_expired = res.courseData[i].is_course_expired;

                add_to_cart_btn =
                  `<div class="text-center border-top">            	
			                                                <a href="javascript:void(0)" id='` +
                  res.courseData[i].course_master_id +
                  `' course_sell_price ='` +
                  res.courseData[i].course_sell_price +
                  `'  class="btn btn-primary btn-sm mt-4 mb-4 add_to_cart"><i class="fa fa-shopping-cart"></i> Add to cart</a>
			                                            </div>`;

                //---- if course is expired & not allow to purchase
                if (course_expired && is_allow_purchase_after_expire == "0") {
                  add_to_cart_btn =
                    `<div class="text-center border-top">            	
			                                                <a href="javascript:void(0)" id='` +
                    res.courseData[i].course_master_id +
                    `' course_sell_price ='` +
                    res.courseData[i].course_sell_price +
                    `'  class="btn btn-default btn-sm mt-4 mb-4"><i class="fa fa-times-circle"></i> Not Allow To Purchase</a>
			                                            </div>`;
                }

                course_details_url =
                  base_url +
                  "student/course-details/" +
                  res.courseData[i].course_master_id;
              } else {
                add_to_cart_btn =
                  `<div class="text-center border-top">            	
			                                                <a href="javascript:void(0)" id='` +
                  res.courseData[i].course_master_id +
                  `' course_sell_price ='` +
                  res.courseData[i].course_sell_price +
                  `'  class="btn btn-success btn-sm mt-4 mb-4"><i class="fa fa-thumbs-up"></i> Already Purchased</a>
			                                            </div>`;

                course_details_url =
                  base_url +
                  "student/enrolled-course-details/" +
                  res.courseData[i].course_master_id;
              }

              if (
                res.courseData[i].course_start_date != "" &&
                res.courseData[i].course_start_date != null &&
                res.courseData[i].course_start_date != "0000-00-00"
              ) {
                start_date = res.courseData[i].course_start_date;
                const start_dateArray = start_date.split("-");
                start_date =
                  start_dateArray[2] +
                  "-" +
                  start_dateArray[1] +
                  "-" +
                  start_dateArray[0];
              } else {
                start_date = "-";
              }

              if (
                res.courseData[i].course_end_date != "" &&
                res.courseData[i].course_end_date != null &&
                res.courseData[i].course_end_date != "0000-00-00"
              ) {
                end_date = res.courseData[i].course_end_date;
                const end_dateArray = end_date.split("-");
                end_date =
                  end_dateArray[2] +
                  "-" +
                  end_dateArray[1] +
                  "-" +
                  end_dateArray[0];
              } else {
                end_date = "-";
              }

              if (res.courseData[i].is_course_expired) {
                is_course_expired = `<div class="text-center">            	
			                                                <span class="text-info"><b>Course is expired...</b></span>
			                                            </div>`;
              }

              courseData +=
                `<div class="col-lg-3 col-md-offset-3 hovernow">
	            								<a href = "` +
                course_details_url +
                `">
			                                        <div class="card item-card">
			                                            <div class="card-body pb-0">
			                                                <div class="text-center">` +
                `<img src="` +
                base_url +
                `uploads/course/` +
                res.courseData[i].course_master_id +
                `/course-image/` +
                res.courseData[i].course_image +
                `` +
                `" alt="` +
                res.courseData[i].course_name +
                `" class="img-fluid">
			                                                </div>

			                                                <div class="text-center my-5">
																<p><b>` +
                res.courseData[i].course_category_name +
                `</b><br>
																<h5 style="color:red!important;"><b class="course_title text-danger">` +
                res.courseData[i].course_name +
                `</b></h5>
																Duration: ` +
                res.courseData[i].course_duration_number_of_days +
                ` Days</p>
			                                                </div>

			                                                <div class="text-center my-5">
																<p>Start Date: ` +
                start_date +
                `</p>
																<p>End Date: ` +
                end_date +
                `</p>
			                                                </div>

			                                                <div class="text-center my-5">
																<p>` +
                is_course_expired +
                `</p>
			                                                </div>
			                                                
			                                                <div class="cardbody">
			                                                    
			                                                    <div class="cardtitle">
																	<span class="font-weight-bold">Actual Price <small style="font-size: 65%;"> (Inc. GST)</small></span>
																	<a  class="font-weight-bold">Offer Price <small style="font-size: 65%;"> (Inc. GST)</small></a>
																</div>
																<div class="cardprice">
																	<span class="type--strikethrough"><i class="fa fa-rupee"></i> ` +
                res.courseData[i].course_actual_price +
                `</span>
																	<span><i class="fa fa-rupee"></i> ` +
                res.courseData[i].course_sell_price +
                `</span>
																</div>                                     
			                                                </div>
			                                            </div>` +
                add_to_cart_btn +
                `</div>
			                                    </a>
			                                </div>`;
            }
          }
          // console.log(courseData)
          $("#course-grid").append(courseData);
          if (res.remaining_course <= 0) {
            $("#load-more-btn").hide();
          }
        } else {
          console.log("treasdad");
          // $("#register_status").html("<div class='alert alert-secondary text-center' style='padding: 3px; margin-bottom: 3px;margin-left: 5px;margin-right: 5px;'><i class='fa fa-times-circle'></i> "+res.message+"</div>");
          // return false;
        }
      },
    });
  }

  //on load more click btn get more courses
  $(document).on("click", "#load-more-btn", function () {
    page_number = parseInt($("#page_num").val());
    page_number = page_number + 1;
    $("#page_num").val(page_number);
    getAllCourses();
  });

  //add to cart
  $(document).on("click", ".add_to_cart", function () {
    var logged_in_student_id = $("#logged_in_student_id").val();

    if (logged_in_student_id > 0) {
      var product_id = $(this).attr("id");
      var course_sell_price = $(this).attr("course_sell_price");

      var data = {
        product_id: product_id,
        course_sell_price: course_sell_price,
      };

      $.ajax({
        type: "post",
        url: base_url + "student/add-to-cart",
        dataType: "json",
        data: data,
        cache: false,
        success: function (res) {
          // console.log(res);
          if (res.status == true) {
            // console.log(res.message);
            // console.log(res.cart_details.length);
            generateNotification("success", res.message);
            $("#cart_count").html(res.cart_details.length);
            $("#cart_item_msg").html(
              res.cart_details.length + " product(s) added in the cart"
            );
          } else {
            // console.log(res.message);
            // console.log(res.cart_details.length);
            generateNotification("error", res.message);
            $("#cart_count").html(res.cart_details.length);
            $("#cart_item_msg").html(
              res.cart_details.length + " product(s) added in the cart"
            );
          }
        },
      });
    } else {
      generateNotification("error", "You need to login first ");
      setTimeout(function () {
        window.location.href = base_url + "student/login";
      }, 3000);
      // setTimeout(function() { window.location.href="https://play.google.com/store/apps/details?id=com.rahuldhanawade.chemcaliba&pli=1"; }, 3000);
    }
  });

  //remove from cart
  $(document).on("click", ".remove_cart", function () {
    var product_id = $(this).attr("product_id");
    var data = {
      product_id: product_id,
    };

    $.confirm({
      title: "Remove item from cart!",
      content: "Are you sure you want to remove this product from cart ?",
      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "student/remove-from-cart",
            dataType: "json",
            data: data,
            cache: false,
            success: function (res) {
              $("#loader-spin").hide();
              // console.log(res);
              if (res.status == true) {
                generateNotification(
                  "success",
                  "Product removed from the cart. Please wait... "
                );
                setTimeout(function () {
                  window.location.href = base_url + "student/view-cart";
                }, 2000);
              }
            },
          });
        },
        cancel: function () {
          $(this).hide();
        },
      },
    });
  });

  //checkout cart
  $(document).on("click", ".checkout_cart", function () {
    var data = {
      logged_in_student_id: logged_in_student_id,
    };

    $.confirm({
      title: "Checkout!",
      content: "Are you sure you want to checkout ?",
      buttons: {
        confirm: function () {
          $("#loader-spin").show();
          $.ajax({
            type: "post",
            url: base_url + "student/checkout",
            dataType: "json",
            data: data,
            cache: false,
            success: function (res) {
              $("#loader-spin").hide();
              // console.log(res);
              if (res.status == true) {
                generateNotification("success", res.message);
                setTimeout(function () {
                  window.location.href = base_url + "student/courses-list";
                }, 2000);
              } else {
                generateNotification("error", res.message);
                setTimeout(function () {
                  window.location.href = base_url + "student/view-cart";
                }, 2000);
              }
            },
          });
        },
        cancel: function () {
          $(this).hide();
        },
      },
    });
  });

  //apply coupon
  $(document).on("click", "#apply_coupon", function () {
    var coupon_code = $("#coupon_code").val();
    var data = {
      coupon_code: coupon_code,
    };

    if (coupon_code == "") {
      generateNotification("error", "Please enter coupon code");
      return false;
    } else {
      $.ajax({
        type: "post",
        url: base_url + "student/apply-coupon",
        dataType: "json",
        data: data,
        cache: false,
        success: function (res) {
          console.log(res);
          if (res.status == true) {
            generateNotification(
              "success",
              "Coupon applied successfully. Please wait... "
            );
            setTimeout(function () {
              window.location.href = base_url + "student/view-cart";
            }, 2000);
          } else {
            generateNotification("error", res.message);
            return false;
          }
        },
      });
    }
  });
});
