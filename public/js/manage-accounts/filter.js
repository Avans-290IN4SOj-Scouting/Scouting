document.getElementById('search').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        this.form.submit();
    }
});

document.getElementById('filter').addEventListener('change', function () {
    this.form.submit();
});
