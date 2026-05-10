const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const emailCodeInput = document.getElementById('email_code');
const phoneCodeInput = document.getElementById('phone_code');

const emailStatus = document.getElementById('emailCodeStatus');
const phoneStatus = document.getElementById('phoneCodeStatus');

const emailVerifiedInput = document.getElementById('email_verified');
const phoneVerifiedInput = document.getElementById('phone_verified');

const setMessage = (el, message, ok) => {
    if (!el) return;
    el.textContent = message;
    el.style.display = 'block';
    el.style.color = ok ? '#1b7f3a' : '#c62828';
};

const postForm = async (url, data) => {
    const body = new URLSearchParams(data);

    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: body.toString()
    });

    return response.json();
};

const resetEmailCheck = () => {
    emailVerifiedInput.value = '0';
    setMessage(emailStatus, 'Email changed. Please verify again.', false);
};

const resetPhoneCheck = () => {
    phoneVerifiedInput.value = '0';
    setMessage(phoneStatus, 'Phone number changed. Please verify again.', false);
};

document.getElementById('sendEmailCodeBtn')?.addEventListener('click', async () => {
    const email = emailInput.value.trim();

    try {
        const data = await postForm('send_email_code.php', { email });

        if (data.success) {
            emailVerifiedInput.value = '0';
            setMessage(emailStatus, 'Email code sent. Please check the demo code.', true);
            alert('Email demo code: ' + data.demo_code);
        } else {
            setMessage(emailStatus, data.message, false);
        }
    } catch (error) {
        setMessage(emailStatus, 'Unable to send email code. Please try again.', false);
    }
});

document.getElementById('sendPhoneCodeBtn')?.addEventListener('click', async () => {
    const phone = phoneInput.value.trim();

    try {
        const data = await postForm('send_phone_code.php', { phone });

        if (data.success) {
            phoneVerifiedInput.value = '0';
            setMessage(phoneStatus, 'Phone code sent. Please check the demo code.', true);
            alert('Phone demo code: ' + data.demo_code);
        } else {
            setMessage(phoneStatus, data.message, false);
        }
    } catch (error) {
        setMessage(phoneStatus, 'Unable to send phone code. Please try again.', false);
    }
});

document.getElementById('verifyEmailCodeBtn')?.addEventListener('click', async () => {
    const email = emailInput.value.trim();
    const code = emailCodeInput.value.trim();

    try {
        const data = await postForm('verify_code.php', {
            type: 'email',
            target: email,
            code: code
        });

        if (data.success) {
            emailVerifiedInput.value = '1';
            setMessage(emailStatus, 'Email verified.', true);
        } else {
            emailVerifiedInput.value = '0';
            setMessage(emailStatus, data.message, false);
        }
    } catch (error) {
        setMessage(emailStatus, 'Unable to verify email code.', false);
    }
});

document.getElementById('verifyPhoneCodeBtn')?.addEventListener('click', async () => {
    const phone = phoneInput.value.trim();
    const code = phoneCodeInput.value.trim();

    try {
        const data = await postForm('verify_code.php', {
            type: 'phone',
            target: phone,
            code: code
        });

        if (data.success) {
            phoneVerifiedInput.value = '1';
            setMessage(phoneStatus, 'Phone number verified.', true);
        } else {
            phoneVerifiedInput.value = '0';
            setMessage(phoneStatus, data.message, false);
        }
    } catch (error) {
        setMessage(phoneStatus, 'Unable to verify phone code.', false);
    }
});

emailInput?.addEventListener('input', resetEmailCheck);
phoneInput?.addEventListener('input', resetPhoneCheck);

// This runs after the normal form validation file.
document.getElementById('registerForm')?.addEventListener('submit', (event) => {
    if (event.defaultPrevented) return;

    if (emailVerifiedInput.value !== '1' || phoneVerifiedInput.value !== '1') {
        event.preventDefault();
        alert('Please verify both email and phone number before registration.');
    }
});
