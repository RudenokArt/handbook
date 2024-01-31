
// Серилизация формы
$.post('phpfile.php', $('#loginForm').serialize(), function (data) {
  console.log(data);
});

// Делегирование событий
$('body').delegate('#timeline_activity_add_form', 'submit', function (e) {
  e.preventDefault();
  console.log('submit');
});


// Событие загрузки html
$(document).ready(function () {
    /* body... */
});