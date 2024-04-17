function displayError(message, apiError) {
    if (apiError !== undefined) {
        message = message + ' (Error ' + apiError.status + ' - ' + apiError.error + ')'
    }

    let errorBox = document.getElementById('error');
    errorBox.classList.remove('hidden');
    errorBox.innerHTML = message;
}