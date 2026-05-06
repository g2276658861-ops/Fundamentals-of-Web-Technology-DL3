// First login commit: only tab switching is handled here.
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.login-tab');
    const panels = document.querySelectorAll('.login-form-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(item => item.classList.remove('active'));
            panels.forEach(panel => panel.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById(tab.dataset.target).classList.add('active');
        });
    });
});
