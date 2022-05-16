let alertDiv = $('#alert')

function alertToggle() {
    alertDiv.toggleClass('d-block d-none')
}

function hideAlert() {
    setTimeout(alertToggle, 2500)
}

if (alertDiv.hasClass('d-block')) {
    hideAlert()
}
alertDiv.on('showAlert', function () {
    alertToggle()
    hideAlert()
})
