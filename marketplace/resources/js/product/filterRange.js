let limit = document.getElementById('range');
let min = document.getElementById('range').min;
let span = document.getElementById('rangeInt');
if (limit.value !== min) {
    limit.setAttribute('name', 'priceLimit')
    span.textContent = limit.value;
}
limit.addEventListener('change', function (e) {
    span.textContent = e.target.value;
    limit.setAttribute('name', 'priceLimit');
})
