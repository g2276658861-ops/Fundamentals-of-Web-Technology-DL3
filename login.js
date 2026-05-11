// Login tab switch and verification-code login.
// Password login still uses login_process.php.
// Phone and email login will create a PHP session after the code is checked.

function initLoginTabs() {
    const tabs = document.querySelectorAll('.login-tab');
    const panels = document.querySelectorAll('.login-form-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(item => item.classList.remove('active'));
            panels.forEach(panel => panel.classList.remove('active'));

            tab.classList.add('active');
            const target = document.getElementById(tab.dataset.target);
            if (target) target.classList.add('active');
        });
    });
}

function setMessage(element, message, isSuccess) {
    if (!element) return;
    element.textContent = message;
    element.style.color = isSuccess ? 'green' : 'red';
    element.style.display = 'block';
}

function postForm(url, data) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(data).toString()
    }).then(response => response.json());
}

function initCodeLogin(type) {
    const isPhone = type === 'phone';

    const sendBtn = document.getElementById(isPhone ? 'sendPhoneCodeBtn' : 'sendEmailCodeBtn');
    const form = document.getElementById(isPhone ? 'loginFormPhone' : 'loginFormEmail');
    const targetInput = document.getElementById(isPhone ? 'loginPhone' : 'loginEmail');
    const codeInput = document.getElementById(isPhone ? 'loginPhoneCode' : 'loginEmailCode');
    const messageBox = document.getElementById(isPhone ? 'loginPhoneCodeError' : 'loginEmailCodeError');

    if (!sendBtn || !form || !targetInput || !codeInput || !messageBox) return;

    sendBtn.addEventListener('click', () => {
        const target = targetInput.value.trim();

        if (target === '') {
            setMessage(messageBox, isPhone ? 'Please enter your phone number first.' : 'Please enter your email address first.', false);
            return;
        }

        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';

        const sendUrl = isPhone ? 'send_phone_code.php' : 'send_email_code.php';
        const postData = isPhone ? { phone: target } : { email: target };

        postForm(sendUrl, postData)
            .then(data => {
                if (data.success) {
                    let message = data.message || 'Verification code sent.';

                    // In local MAMP demo, the server returns the code directly.
                    // A real website should send it by SMS or email instead.
                    if (data.demo_code) {
                        message += ' Demo code: ' + data.demo_code;
                    }

                    setMessage(messageBox, message, true);
                } else {
                    setMessage(messageBox, data.message || 'Failed to send code.', false);
                }
            })
            .catch(() => {
                setMessage(messageBox, 'Server error when sending code.', false);
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.textContent = 'Get Code';
            });
    });

    form.addEventListener('submit', e => {
        e.preventDefault();

        const target = targetInput.value.trim();
        const code = codeInput.value.trim();

        if (target === '' || code === '') {
            setMessage(messageBox, 'Please enter both account information and verification code.', false);
            return;
        }

        setMessage(messageBox, 'Checking verification code...', true);

        postForm('login_by_code.php', {
            type: type,
            target: target,
            code: code
        })
            .then(data => {
                if (data.success) {
                    setMessage(messageBox, data.message || 'Login successful. Redirecting...', true);
                    window.location.href = data.redirect || 'add-car.php';
                } else {
                    setMessage(messageBox, data.message || 'Invalid verification code.', false);
                }
            })
            .catch(() => {
                setMessage(messageBox, 'Server error when checking code.', false);
            });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initLoginTabs();
    initCodeLogin('phone');
    initCodeLogin('email');
});
