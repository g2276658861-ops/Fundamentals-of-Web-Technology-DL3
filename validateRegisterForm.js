import { regexRules } from './regexRules.js';

const showError = (id, show) => {
    const el = document.getElementById(id);
    if (el) el.style.display = show ? 'block' : 'none';
};

function validateRegisterForm() {
    const form = document.getElementById('registerForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let isValid = true;

        const fields = [
            ['name', 'nameError', regexRules.name],
            ['address', 'addressError', regexRules.address],
            ['phone', 'phoneError', regexRules.phone],
            ['email', 'emailError', regexRules.email],
            ['username', 'usernameError', regexRules.username],
            ['password', 'passwordError', regexRules.password]
        ];

        fields.forEach(([inputId, errorId, rule]) => {
            const input = document.getElementById(inputId);
            const ok = input && rule.test(input.value.trim());
            showError(errorId, !ok);
            if (!ok) isValid = false;
        });

        const password = document.getElementById('password')?.value.trim() || '';
        const confirmPassword = document.getElementById('confirm_password')?.value.trim() || '';
        const passwordsMatch = password !== '' && password === confirmPassword;
        showError('confirmPasswordError', !passwordsMatch);
        if (!passwordsMatch) isValid = false;

        if (!isValid) {
            e.preventDefault();
            showError('registerSuccess', false);
            return;
        }

        // Do not save to localStorage now. PHP will insert the seller into MySQL.
        showError('registerSuccess', true);
    });
}

validateRegisterForm();
