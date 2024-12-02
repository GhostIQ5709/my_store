</div>
<script src="/my_store/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // const themeToggleBtn = document.getElementById('theme-toggle');
    // let isDarkMode = false;

    // themeToggleBtn.addEventListener('click', () => {
    //     if (isDarkMode) {
    //         document.body.classList.remove('bg-dark', 'text-light');
    //         document.body.classList.add('bg-light', 'text-dark');
    //         themeToggleBtn.textContent = 'Toggle Dark Mode';
    //     } else {
    //         document.body.classList.remove('bg-light', 'text-dark');
    //         document.body.classList.add('bg-dark', 'text-light');
    //         themeToggleBtn.textContent = 'Toggle Light Mode';
    //     }
    //     isDarkMode = !isDarkMode;
    // })
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggleCheckbox = document.getElementById('theme-toggle');

        themeToggleCheckbox.addEventListener('change', () => {
            const bodyClassList = document.body.classList;
            const textElements =
                document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, li, .card, .modal-content');

            if (themeToggleCheckbox.checked) {
                bodyClassList.remove('bg-light', 'text-dark');
                bodyClassList.add('bg-dark', 'text-light');
                textElements.forEach(element => {
                    element.classList.remove('bg-light', 'text-dark');
                    element.classList.add('bg-dark', 'text-light');
                });
            } else {
                bodyClassList.remove('bg-dark', 'text-light');
                bodyClassList.add('bg-light', 'text-dark');
                textElements.forEach(element => {
                    element.classList.remove('bg-dark', 'text-light');
                    element.classList.add('bg-light', 'text-dark');
                });
            }
        });
    });
</script>

</body>

</html>
