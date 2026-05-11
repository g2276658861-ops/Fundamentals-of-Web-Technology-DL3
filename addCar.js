// Basic browser check before the form is submitted to PHP.
function initAddCarForm() {
    const form = document.getElementById('addCarForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let ok = true;
        const requiredInputs = form.querySelectorAll('input[required]');

        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                ok = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = 'lightgray';
            }
        });

        const year = Number(document.getElementById('carYear').value);
        const price = Number(document.getElementById('carPrice').value);

        if (year < 1990 || year > 2026 || price <= 0) {
            ok = false;
        }

        if (!ok) {
            e.preventDefault();
            alert('Please complete the car information correctly.');
            return;
        }

        const successText = document.getElementById('carSuccess');
        if (successText) successText.style.display = 'block';
    });
}

document.addEventListener('DOMContentLoaded', initAddCarForm);
