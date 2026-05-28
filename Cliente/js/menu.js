document.addEventListener("DOMContentLoaded", () => {

    const toggleBtn = document.querySelector(".menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".sidebar-overlay");

    function isMobile() {
        return window.innerWidth <= 1100;
    }

    function openMobileSidebar() {
        sidebar.classList.add("active");
        overlay.classList.add("active");
    }

    function closeMobileSidebar() {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
    }

    function toggleDesktopSidebar() {
        sidebar.classList.toggle("collapsed");
    }

    if (toggleBtn) {

        toggleBtn.addEventListener("click", () => {

            // MOBILE
            if (isMobile()) {

                if (sidebar.classList.contains("active")) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }

            }
            // DESKTOP
            else {

                toggleDesktopSidebar();

            }

        });

    }

    if (overlay) {
        overlay.addEventListener("click", closeMobileSidebar);
    }

});