</main>
<!-- /.content-wrapper -->

<!-- Footer -->
<footer class="app-footer">
    <div class="float-end d-none d-sm-inline">
        <b>Versión</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2025 <a href="#">Sistema de Inventario</a>.</strong> Todos los derechos reservados.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery (requerido por DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>

<!-- Popper.js (requerido por Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"></script>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- AdminLTE App -->
<script src="<?= BASE_URL ?>assets/dist/js/adminlte.min.js"></script>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Dark Mode Toggle Script -->
<script>
    $(document).ready(function () {
        const body = $('body');
        const darkModeToggle = $('#darkModeToggle');
        const darkModeIcon = $('#darkModeIcon');

        // Verificar preferencia guardada
        const isDarkMode = localStorage.getItem('darkMode') === 'true';

        // Aplicar tema guardado al cargar
        if (isDarkMode) {
            enableDarkMode();
        }

        // Toggle al hacer clic
        darkModeToggle.on('click', function (e) {
            e.preventDefault();

            if (body.attr('data-bs-theme') === 'dark') {
                disableDarkMode();
            } else {
                enableDarkMode();
            }
        });

        function enableDarkMode() {
            body.attr('data-bs-theme', 'dark');
            darkModeIcon.removeClass('bi-moon-fill').addClass('bi-sun-fill');
            localStorage.setItem('darkMode', 'true');
        }

        function disableDarkMode() {
            body.attr('data-bs-theme', 'light');
            darkModeIcon.removeClass('bi-sun-fill').addClass('bi-moon-fill');
            localStorage.setItem('darkMode', 'false');
        }
    });
</script>

<!-- Scripts personalizados de cada página -->
<?php if (isset($pageScripts)): ?>
    <?= $pageScripts ?>
<?php endif; ?>

<!-- OverlayScrollbars Configuration -->
<script>
    const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
    const Default = {
        scrollbarTheme: "os-theme-light",
        scrollbarAutoHide: "leave",
        scrollbarClickScroll: true,
    };

    document.addEventListener("DOMContentLoaded", function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined") {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: Default.scrollbarTheme,
                    autoHide: Default.scrollbarAutoHide,
                    clickScroll: Default.scrollbarClickScroll,
                },
            });
        }
    });
</script>
</body>

</html>