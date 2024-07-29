var milliseconds = 3000;
setTimeout(function () {
    document.getElementById('alert').remove();
}, milliseconds);

//password eye
//document.addEventListener('DOMContentLoaded', function () {
//    // Initialize tooltips
//    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
//    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//        return new bootstrap.Tooltip(tooltipTriggerEl);
//    });
//
//    function togglePasswordVisibility(toggleButtonId, passwordInputId) {
//        const toggleButton = document.querySelector(toggleButtonId);
//        const passwordInput = document.querySelector(passwordInputId);
//
//        toggleButton.addEventListener('click', function () {
//            // Toggle the type attribute
//            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
//            passwordInput.setAttribute('type', type);
//
//            // Toggle the icon
//            // this.classList.toggle('fa-eye-slash');
//            // Toggle the image source
//            const newSrc = type === 'password' ? openEyeSrc : closedEyeSrc;
//            toggleButton.setAttribute('src', newSrc);
//
//            // Update tooltip title
//            const title = type === 'password' ? 'Show Password' : 'Hide Password';
//            this.setAttribute('data-bs-original-title', title);
//
//            // Manually show or hide tooltip
//            const tooltipInstance = bootstrap.Tooltip.getInstance(toggleButton);
//            tooltipInstance.hide();
//            tooltipInstance.show();
//        });
//    }
//
//    togglePasswordVisibility('#togglePassword', '#password');
//    togglePasswordVisibility('#con_togglePassword', '#con_password');
//    togglePasswordVisibility('#new_togglePassword', '#new_password');
//});
document.addEventListener('DOMContentLoaded', function () {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    function togglePasswordVisibility(toggleButtonId, passwordInputId) {
        const toggleButton = document.querySelector(toggleButtonId);
        const passwordInput = document.querySelector(passwordInputId);

        const openEyeSrc = toggleButton.getAttribute('data-open-eye');
        const closedEyeSrc = toggleButton.getAttribute('data-closed-eye');

        toggleButton.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the image source
            const newSrc = type === 'password' ? closedEyeSrc : openEyeSrc;
            toggleButton.setAttribute('src', newSrc);

            // Update tooltip title
            const title = type === 'password' ? 'Show Password' : 'Hide Password';
            this.setAttribute('data-bs-original-title', title);

            // Manually show or hide tooltip
            const tooltipInstance = bootstrap.Tooltip.getInstance(toggleButton);
            tooltipInstance.hide();
            tooltipInstance.show();
        });
    }

    togglePasswordVisibility('#togglePassword', '#password');
    togglePasswordVisibility('#con_togglePassword', '#con_password');
    togglePasswordVisibility('#new_togglePassword', '#new_password');
});