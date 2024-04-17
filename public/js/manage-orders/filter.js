document.querySelectorAll('#date-filter').forEach(function(element) {
    element.addEventListener('change', function () {
        this.form.submit();
    });
});
