// Загрука разметки
$( selector ).load( url, data, complete );

// Серилизация формы
$.post('phpfile.php', $('#loginForm').serialize(), function (data) {
  console.log(data);
});

// Делегирование событий
$('body').delegate('#timeline_activity_add_form', 'submit', function (e) {
  e.preventDefault();
  console.log('submit');
});

// Ближайший родитель
$(this).closest('form').trigger('submit');


// Событие загрузки html
$(document).ready(function () {
    /* body... */
});


// Создание элемента
var plusButton = $('<a>', {
  class: 'main-buttons-item-sublink crm-menu-plus-btn',
  href: '/crm/quote/edit/0/?deal_id=' + dealId,
  title: "Neues Angebot",
  onclick: "BX.onCustomEvent(window, 'CrmCreateQuoteFromDeal'); return false;",
  html: 'test',
});
$(this).append(plusButton);