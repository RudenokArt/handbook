<script src="https://cdn.jsdelivr.net/npm/vue@3.0.2/dist/vue.global.prod.js"></script>
Вставить переменные в шаблон:
<img v-bind:src="`<?php echo $photo_galery_url;?>${item.image_url}`" alt="">