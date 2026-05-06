import { regexRules } from './regexRules.js';

function showError(id, show) {
    const element = document.getElementById(id);
    if (element) element.style.display = show ? 'block' : 'none';
}

const form = document.getElementById('registerForm');
if (form) {
    form.addEventListener('submit', function (event) {
        let ok = true;
        const checks = [
            ['name', 'nameError', regexRules.name],
            ['address', 'addressError', regexRules.address],
            ['phone', 'phoneError', regexRules.phone],
            ['email', 'emailError', regexRules.email],
            ['username', 'usernameError', regexRules.username],
            ['password', 'passwordError', regexRules.password]
        ];

        checks.forEach(([inputId, errorId, rule]) => {
            const value = document.getElementById(inputId).value.trim();
            const valid = rule.test(value);
            showError(errorId, !valid);
            if (!valid) ok = false;
        });

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        showError('confirmPasswordError', password !== confirmPassword);
        if (password !== confirmPassword) ok = false;

        if (!ok) event.preventDefault();
    });
}
