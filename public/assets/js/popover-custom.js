/*var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})*/

$(document).ready(function() {
  $('[data-bs-toggle="popover"]').popover({
     placement: 'top',
     trigger: 'hover'
  });
});