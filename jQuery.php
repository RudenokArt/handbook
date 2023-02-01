<script>
  // Серилизация формы
  $.post('phpfile.php', $('#loginForm').serialize(), function (data) {
    console.log(data);
  });
</script>