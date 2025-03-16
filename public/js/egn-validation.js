/**
 * Check if a string contains only numbers.
 *
 * @param {string} str The string to check
 * @return {boolean} True if string contains only numbers
 */
function is_num_only(str) {
    return /^\d+$/.test(str);
}

/**
 * Perform basic EGN validation.
 *
 * @param {string} egn EGN to validate
 * @return {boolean} True if basic validation passes
 */
function basicEgnValidation(egn) {
    // Extract date components from EGN
    let year = parseInt(egn.substring(0, 2));
    let month = parseInt(egn.substring(2, 4));
    let day = parseInt(egn.substring(4, 2));

    // Adjust year and month based on month value
    if (month > 40) {
        // Person born after 2000
        year = 2000 + year;
        month = month - 40;
    } else if (month > 20) {
        // Person born between 1800 and 1899
        year = 1800 + year;
        month = month - 20;
    } else {
        // Person born between 1900 and 1999
        year = 1900 + year;
    }

    // Validate date
    const date = new Date(year, month - 1, day);
    return date.getFullYear() === year &&
           date.getMonth() === month - 1 &&
           date.getDate() === day;
}

/**
 * Check if an EGN is valid.
 *
 * @param {string} egn EGN to validate
 * @return {boolean} True if EGN is valid
 */
function isValidEGN(egn) {
    if (!is_num_only(egn)) return false;
    if (egn.length != 10) return false;
    if (!basicEgnValidation(egn)) return false;
    var egnarr = egn.split("");
    if (egnarr[0] == 1 && egnarr[1] == 0) return true;
    var t = [2, 4, 8, 5, 10, 9, 7, 3, 6];
    var sum = 0;
    for (var i = 0; i < 9; ++i) {
        if (egnarr[i] != 0)
            sum += (egnarr[i] * t[i]);
    }
    var last = sum % 11;
    if (10 == last) last = 0;
    return egnarr[9] == last;
}

// Add validation to EGN fields when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const egnInputs = document.querySelectorAll('input[name="egn"]');

    egnInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            const egn = this.value.trim();

            if (egn && !isValidEGN(egn)) {
                this.classList.add('is-invalid');

                // Create or update error message
                let errorDiv = this.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv = document.createElement('div');
                    errorDiv.classList.add('invalid-feedback');
                    this.parentNode.insertBefore(errorDiv, this.nextSibling);
                }

                errorDiv.textContent = 'Невалидно ЕГН. Моля, въведете валидно ЕГН.';
            } else {
                this.classList.remove('is-invalid');

                // Remove error message if it exists
                const errorDiv = this.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv.textContent = '';
                }
            }
        });
    });
});
