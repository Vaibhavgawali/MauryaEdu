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
          if (res.courseData.length > 0) {
            for (let i = 0; i < res.courseData.length; i++) {
              courseData +=
                `<div class="col-lg-3 col-md-offset-3 hovernow">
													<a href = "` +
                base_url +
                `student/enrolled-course-details/` +
                res.courseData[i].course_master_id +
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
																	<b class="course_title">` +
                res.courseData[i].course_name +
                `</b><br><br>
																	Enrolled On: ` +
                res.courseData[i].course_enrollment_date +
                `<br>
																	Duration: ` +
                res.courseData[i].no_of_days +
                ` days<br>
																	Valid Upto: ` +
                res.courseData[i].course_validity +
                `</p>
																</div>
																															
															</div>
															<div class="text-center border-top">            	
																<a href="` +
                base_url +
                `student/enrolled-course-details/` +
                res.courseData[i].course_master_id +
                `" id='` +
                res.courseData[i].course_master_id +
                `' course_sell_price ='` +
                res.courseData[i].course_sell_price +
                `'  class="btn btn-primary btn-sm mt-4 mb-4"><i class="fa fa-eye"></i> View In Detail </a>
															</div>
														</div>
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
