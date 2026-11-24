// AgriTwin — scripts du Front Office (menu mobile, confirmations, filtres)
(function () {
    var toggle = document.querySelector('.nav-toggle');
    var menu = document.getElementById('menu');
    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            var open = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
    // Confirmation avant les actions destructrices : <form data-confirm="Message">
    document.querySelectorAll('form[data-confirm]').forEach(function (f) {
        f.addEventListener('submit', function (e) {
            if (!window.confirm(f.getAttribute('data-confirm'))) { e.preventDefault(); }
        });
    });
    // Filtres auto-envoyés quand on change une liste déroulante
    document.querySelectorAll('select[data-autosubmit]').forEach(function (s) {
        s.addEventListener('change', function () { s.form.submit(); });
    });
})();
