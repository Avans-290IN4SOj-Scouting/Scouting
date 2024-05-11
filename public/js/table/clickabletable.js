// To use this
// <tr href="{{ route('your.route.here'}}" class="clickable">

document.querySelectorAll('.clickable').forEach(row => {
    row.addEventListener('click', function() {
        window.location.href = this.getAttribute('href');
    });
});
