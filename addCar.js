document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('addCarForm');
    if (!form) return;

    form.addEventListener('submit', event => {
        const requiredInputs = form.querySelectorAll('input[required]');
        let ok = true;

        requiredInputs.forEach(input => {
            if (!input.value.trim()) ok = false;
        });

        if (!ok) {
            event.preventDefault();
            alert('Please complete all required car information.');
        }
    });
});
