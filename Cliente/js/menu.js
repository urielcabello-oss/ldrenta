document.addEventListener("DOMContentLoaded", () => {

    const toggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".sidebar-overlay");
    const closeBtn = document.querySelector(".sidebar-close");

    function openSidebar() {
        sidebar.classList.add("active");
        overlay.classList.add("active");
    }

    function closeSidebar() {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
    }

    // BOTÓN NARANJA (FUNCIONA EN TODO)
    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {

            // si está abierto lo cierra
            if (sidebar.classList.contains("active")) {
                closeSidebar();
            } else {
                openSidebar();
            }

        });
    }

    if (overlay) overlay.addEventListener("click", closeSidebar);
    if (closeBtn) closeBtn.addEventListener("click", closeSidebar);

});