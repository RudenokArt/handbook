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

===== AJAX =====
<script>
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

</script>

===== CANVAS =====

<script>
  var example = document.getElementById('example');
  example.width = 800;
  example.height = 600;
  draw = example.getContext('2d');
  draw.rect(100,100,100,100);
  draw.fillStyle = 'red';
  draw.fill();
  setTimeout(function () {
    draw.fillStyle = 'blue';
    draw.fill();
  }, 1000);
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