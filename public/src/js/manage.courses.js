if (document.getElementById("course_code")) {
    document
        .getElementById("course_code")
        .addEventListener("change", function () {
            const batch = document.getElementById("batch");
            document
                .getElementById("course_id")
                .setAttribute("value", this.value + "-" + batch.value);
        });
}

if (document.getElementById("batch")) {
    document.getElementById("batch").addEventListener("change", function () {
        const course_code = document.getElementById("course_code");
        document
            .getElementById("course_id")
            .setAttribute("value", course_code.value + "-" + this.value);
    });
    window.addEventListener("load", function () {
        const batch = document.getElementById("batch");
        const course_code = document.getElementById("course_code");
        document
            .getElementById("course_id")
            .setAttribute("value", course_code.value + "-" + batch.value);
    });
}
