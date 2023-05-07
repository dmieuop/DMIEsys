document.getElementById("batch").addEventListener("change", function () {
    const student_batch = document.getElementById("student_batch");
    student_batch.textContent = this.value;
    const student_id = document.getElementById("student_id");
    document.getElementById("id").setAttribute('value', this.value + student_id.value);
});

document.getElementById("student_id").addEventListener("change", function () {
    const batch = document.getElementById("batch");
    document.getElementById("id").setAttribute('value', batch.value + this.value);
});

window.addEventListener("load", function () {
    const batch = document.getElementById("batch");
    const student_batch = document.getElementById("student_batch");
    student_batch.textContent = batch.value;
    const student_id = document.getElementById("student_id");
    document.getElementById("id").setAttribute('value', batch.value + student_id.value);
});
