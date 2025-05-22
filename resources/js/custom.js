document.addEventListener("DOMContentLoaded", function () {
    console.log("📁 Sidebar JS loaded!");

    // Hàm toggle mở/đóng submenu
    function toggleSubmenu(title, submenu) {
        title.classList.toggle("open");
        submenu.classList.toggle("active");

        if (submenu.classList.contains("active")) {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
        } else {
            submenu.style.maxHeight = null;
        }
    }

    // Duyệt qua tất cả các group-title có submenu
    const titles = document.querySelectorAll(".group-title");
    titles.forEach(function (title) {
        const targetId = title.dataset.target;
        const submenu = document.getElementById(targetId);
        if (!submenu) return;

        // Gắn sự kiện click để toggle
        title.addEventListener("click", function () {
            toggleSubmenu(title, submenu);
        });

        // Nếu bên trong có item đang active thì tự mở
        if (submenu.querySelector(".active")) {
            toggleSubmenu(title, submenu);
        }
    });
});

