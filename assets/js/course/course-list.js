$(document).ready(function () {
  var page_number = parseInt($("#page_num").val());

  var logged_in_student_id = $("#logged_in_student_id").val();

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
          const courseCard = res.courseData.map((Elem) => {
            console.log(Elem);
            return `<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center  w-100 ">
                    <div class=" mb-3" style="height: 200px;width:250px;">
                        <img style="height:100%;width:100%" class="" src="${base_url}uploads/course/${
              Elem.course_master_id
            }/course-image/${
              Elem.course_image
            }" class="img-fluid" alt="${base_url}/uploads/course/${
              Elem.course_master_id
            }/course-image/${Elem.course_image}">
                    </div>
                    </div>
                    <div class="card-title">
                        <div class="badge badge-primary text-left">${
                          Elem.course_category_name
                        }</div>
                    </div>
                    <div>
                        <h4 class="card-title">${
                          Elem.course_name.length > 30
                            ? Elem.course_name.substring(0, 30) + "..."
                            : Elem.course_name
                        }</h4>
                    </div>
                    <p class="card-text">Duration : <span class="">${
                      Elem.course_duration_number_of_days
                    } Days</span></p>
                    <div class="border"></div>
                    <div class="d-flex justify-content-between align-items-center my-1 ">

                        <div>
                            <a href="${base_url}/student/course-details/${
              Elem.course_master_id
            } "class="btn btn-gradient-danger btn-sm ">View Details <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                        <div class="d-flex flex-md-column gap-3 gap-md-0 flex-xl-row gap-xl-3 mt-3">
                            <p class="fw-lighter  text-decoration-line-through mt-1">₹ ${Math.floor(
                              Elem.course_actual_price
                            )}</p>
                            <p class="fw-bold fs-5 text-success">₹${Math.floor(
                              Elem.course_sell_price
                            )}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
          });

          // console.log(courseData)
          $("#course-grid").append(courseCard);
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
    console.log("Logged in student id: " + logged_in_student_id);

    if (logged_in_student_id > 0) {
      var product_id = $(this).attr("id");
      var course_sell_price = $(this).attr("course_sell_price");

      var data = {
        product_id: product_id,
        course_sell_price: course_sell_price,
      };
      console.log(data);

      $.ajax({
        type: "post",
        url: base_url + "student/add-to-cart",
        dataType: "json",
        data: data,
        cache: false,
        success: function (res) {
          console.log(res);
          if (res.status == true) {
            // console.log(res.message);
            // console.log(res.cart_details.length);
            generateNotification("success", res.message);
            $("#cart_count").html(res.cart_details.length);
            $("#cart_item_msg").html(
              res.cart_details.length + " product(s) added in the cart"
            );
          } else {
            console.log(res.message);
            // console.log(res.cart_details.length);
            generateNotification("error", res.message);
            $("#cart_count").html(res.cart_details.length);
            $("#cart_item_msg").html(
              res.cart_details.length + " product(s) added in the cart"
            );
          }
        },
        error: function (error) {
          console.log(error);
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
