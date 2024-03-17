$(document).ready(function () {
  var page_number = parseInt($("#page_num").val());
  var logged_in_student_id = $("#logged_in_student_id").val();

  getEnrolledCourses();

  //to get all courses
  function getEnrolledCourses() {
    var data = {
      page_num: page_number,
      limit: 4,
    };
    var courseData = "";

    $.ajax({
      type: "post",
      url: base_url + "student/get-enrolled-course-list",
      dataType: "json",
      data: data,
      cache: false,
      success: function (res) {
        $("#loader-spin").hide();

        // console.log(res);

        if (res.status == true) {
          //console.log(res.courseData.length);
          const courseCard = res.courseData.map((Elem)=>
          {
            console.log(Elem)
            return `<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <div class="card">

                <div class="card-body">
                    <div class="img-div">
                        <img src="${base_url}uploads/course/${Elem.course_master_id}/course-image/${Elem.course_image}" class="img-fluid" alt="${base_url}/uploads/course/${Elem.course_master_id}/course-image/${Elem.course_image}">
                        
                    </div>
                    <div class="card-title">
                        <div class="badge badge-primary text-left">${Elem.course_category_name}</div>
                    </div>
                    <div>
                        <h4 class="card-title">${Elem.course_name.length > 30 ? Elem.course_name.substring(0,30)+"...":Elem.course_name}</h4>
                    </div>
                    <p class="card-text">Duration : <span class="">${Elem.course_duration_number_of_days} Days</span></p>
                    <div class="border"></div>
                    <div class="d-flex justify-content-between align-items-center my-1 ">

                        <div>
                            <a href="${base_url}/student/enrolled-course-details/${Elem.course_master_id} "class="btn btn-gradient-danger btn-sm ">View Details <i class="mdi mdi-arrow-right"></i></a>
                        </div>
                        <div class="d-flex flex-md-column gap-3 gap-md-0 flex-xl-row gap-xl-3 mt-3">
                            <p class="fw-lighter  text-decoration-line-through mt-1">₹ ${Math.floor(Elem.course_actual_price)}</p>
                            <p class="fw-bold fs-5 text-success">₹${Math.floor(Elem.course_sell_price)}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>`
          })
          // console.log(courseData)
          $("#course-grid").append(courseCard);
          if (res.remaining_course <= 0) {
            $("#load-more-btn").hide();
          }
        } else {
          if (res.remaining_course == 0) {
            $("#course-grid").html(
              "<h5 class='page-title mx-3 text-primary'>You have not enrolled for any course yet.</h5>"
            );
            $("#load-more-btn").hide();
          }
        }
      },
    });
  }

  //on load more click btn get more courses
  $(document).on("click", "#load-more-btn", function () {
    page_number = parseInt($("#page_num").val());
    page_number = page_number + 1;
    getEnrolledCourses();
  });
});
