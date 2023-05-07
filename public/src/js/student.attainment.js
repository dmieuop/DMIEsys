function cshowbtn(course_code) {
  const btn = document.getElementById("searchbtn");
  btn.style.display = "block";
  const link = 'course-report/' + course_code
  btn.setAttribute('href', link);
}

document.getElementById("student_id").addEventListener("change", function() {
  const btn = document.getElementById("searchbtn");
  const link = 'student-report/' + this.value
  btn.setAttribute('href', link);
});
