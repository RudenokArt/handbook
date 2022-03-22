 Текстовый редактор для сайта
 <!-- https://cdn.ckeditor.com/  --> 
 <textarea id="editor1" name="editor1"></textarea>
 <button>save</button>
 <script>
  CKEDITOR.replace( 'editor1' );
  $('button').click(function() {
    var text = document.getElementsByTagName("iframe")[0].contentDocument.getElementsByTagName("body")[0].innerHTML;
    console.log(text);
  });
</script>