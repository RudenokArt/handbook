 Текстовый редактор для сайта
 <!-- https://cdn.ckeditor.com/  --> 
 <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
 <textarea id="editor" name="editor1"></textarea>
 <button>save</button>
 <script>
  CKEDITOR.replace('editor1', {height: 500});
  $('button').click(function() {
    var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
    console.log(text);
  });
</script>

<script>
// ===== AJAX =====
  function ajaxGetData (text,file) {
   var req = new XMLHttpRequest();
   req.open('POST','php-get-data.php');
   req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   req.send('text='+text+'&file='+file);
   req.onreadystatechange=function (){
    if (req.readyState == 4 && req.status == 200) {
     console.log(req.responseText);
   }
 };
}

// ===== FormData ===== 
var formdata = new FormData();
formdata.set('product_id', 'V01PAK');
formdata.set('preferred_day', 0);
formdata.set('visual_min_age', 0);
formdata.set('service_ParcelOutletRouting', 'yes');
formdata.set('ident_date_of_birth', '');
formdata.set('ident_min_age', 0);
formdata.set('security', '150a8800fe');
formdata.set('reference_id', '9');
formdata.set('action', 'woocommerce_gzd_create_shipment_label_submit');
console.log(Array.from(formdata));

// ===== FETCH POST + ЗАГРУЗКА ФАЙЛОВ =====

async function newCommentAdd (e) {
  var formdata = new FormData(e.target);
  var comment = await fetch(this.ajaxUrl, {
    method: 'POST',
    body: formdata,
  }).then(function(response){
    return response.text();
  }).then(function (text) {
    return (text);
  });
  console.log(comment);
};
</script>

===== Плавный скролл страницы =====
<style>
  html {
    scroll-behavior: smooth;
  }
</style>
<script>
  window.scrollTo(pageYOffset, 0);
</script>

===== Прокрутка скролла в блоке =====

<script>
 var node = document.querySelector('#vetliva_live_chat_tape');
 node.scrollTop = node.scrollHeight;
</script>

===== УВЕДОМЛЕНИЯ В БРАУЗЕРЕ =====
<script>
  console.log(Notification.permission);
  Notification.requestPermission().then(function (permission) {
    console.log(permission);
  });
  var body = 'text';
  setTimeout(function () {
    var test = new Notification('title',{body});
  }, 2000);
</script>


===== DRAG & DROP =====
<div class="container">
 <a href="" class="row">item # 1</a>
 <a href="" class="row">item # 2</a>
 <a href="" class="row">item # 3</a>
</div>
<script>
  var drag, undrag;
  $('.row').bind('dragover', function(){
    drag = this;
    console.log(drag.children[0].innerHTML);
  });
  $('.row').bind('dragend', function () {
    undrag = this;
    console.log('end'+'~'+undrag.children[0].innerHTML);
    $(drag).before(undrag);
  });
</script>