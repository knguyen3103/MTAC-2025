document.addEventListener("DOMContentLoaded", () => {
    console.log("Custom JS Loaded!");

    // Toggle submenu logic (nếu chưa có)
    document.querySelectorAll(".group-title").forEach(el => {
        el.addEventListener("click", () => {
            const target = document.getElementById(el.dataset.target);
            target?.classList.toggle("active");
            el.classList.toggle("open");
        });
    });
});
