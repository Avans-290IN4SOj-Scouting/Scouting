document.getElementById('search').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        this.form.submit();
    }
});

document.getElementById('filter').addEventListener('change', function () {
    this.form.submit();
});

document.querySelectorAll('.date-filter').forEach(function(element) {
    element.addEventListener('change', function () {
        this.form.submit();
    });
});
