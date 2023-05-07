<!-- BOOTSTRAP ПАГИНАЦИЯ -->

<?php 
$pages_qty = 10;
$current_page = 1;
if ($_GET['page_N']) {
  $current_page = $_GET['page_N'];
}
?>
<div class="row justify-content-center">
  <div class="col-lg-4 col-md-6 col-sm-12 col-12">
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="page_N=1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for($i=1; $i <= $pages_qty ; $i++): ?>
          <?php if ($i >= $current_page-2 and $i <= $current_page+2): ?>
            <li class="page-item">
              <a class="page-link <?php if ($current_page == $i): ?>
              text-danger
              <?php endif ?>" href="?page_N=<?php echo $i;?>">
              <?php echo $i ?>
            </a>
          </li>
        <?php endif ?>
      <?php endfor; ?>
      <li class="page-item">
        <a class="page-link" href="?page_N=<?php echo $i-1;?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
</div>

<!-- ЗАГРУЗКА ФАЙЛА -->
<div class="row pt-5">
  <div class="col-lg-3 col-md-6 col-sm-12 col-12">
    <div class="text-info h5">Логотип:</div>
    <img src="<?php echo $theme_url.'/ug_ideal-libs/dompdf/img/ug-ideal.png?='.time(); ?>" width="200" alt="">
  </div>
  <div class="h5 text-info">Заменить:</div>
  <form action="" enctype="multipart/form-data" method="post" id="company_logo-form">
    <input type="file" name="logotip" id="company_logo">
  </form>
  <div>(загружать изображение в формате .png на прозрачном фоне)</div>
</div>
<script>
  $('#company_logo').change(function () {
    $('#company_logo-form')[0].submit();
  });
</script>
<?php
if (isset($_FILES['logotip'])) {
  $ext = explode('.', $_FILES['logotip']['name']);
  $ext = array_pop($ext);
  if ($ext == 'png') {
    move_uploaded_file($_FILES['logotip']['tmp_name'], $theme_path.'/ug_ideal-libs/dompdf/img/ug-ideal.png');
    echo 'Логотип изменен';
  } else {
    echo 'Неверный формат файла';
  }
}

// ВЫБОР ИНТЕРВАЛА ДАТ
function date_interval () {
  if (isset($_POST['filter'])) {
    if ($_POST['date_filter']=='month') {
      $interval = [
        strtotime(date('Y-m-01')),
        strtotime(date('Y-m-t')), 
      ];
    }
    if ($_POST['date_filter']=='prev_month') {
      $interval = [
        strtotime(date('Y-m-01', strtotime('-1 month'))),
        strtotime(date('Y-m-t', strtotime('-1 month'))),
      ];
    }
    if ($_POST['date_filter']=='week') {
      $interval = [strtotime('last monday'), strtotime('next monday')];
    }
    if ($_POST['date_filter']=='prev_week') {
      $interval = [strtotime('last monday -1 week'), strtotime('next monday -1 week')];
    }
    if ($_POST['date_filter']=='interval') {
      $interval = [strtotime($_POST['date_for']), strtotime($_POST['date_to'])];
    }
  }
  return $interval;
}

?>

<!-- Простой календарь на PHP -->
<a href="?year=<?php echo prevMon()['year'];?>&mon=<?php echo prevMon()['mon'];?>">
  previous
</a>
<a href="?year=<?php echo nextMonth()['year'];?>&mon=<?php echo nextMonth()['mon'];?>">
  next
</a>
<pre><?php print_r(getCurrentMonth()) ?></pre>
<?php 
function nextMonth () {
  $year = getCurrentMonth()[0]['year'];
  $mon = getCurrentMonth()[0]['mon'] + 1;
  if ($mon>12) {
    $mon = 1;
    $year = $year + 1;
  }
  return ['mon'=>$mon, 'year'=>$year];
}
function prevMon () {
  $year = getCurrentMonth()[0]['year'];
  $mon = getCurrentMonth()[0]['mon'] - 1;
  if ($mon < 1) {
    $mon = 12;
    $year = $year - 1;
  }
  return ['mon'=>$mon, 'year'=>$year];
}
function getCurrentMonth() {
  $current_date = getdate();
  $mon = $current_date['mon'];
  if (isset($_GET['mon'])) {
    $mon = $_GET['mon'];
  }
  $year = $current_date['year'];
  if (isset($_GET['year'])) {
    $year = $_GET['year'];
  }
  $last_day_month = getdate(strtotime(date($year.'-'.$mon.'-'.cal_days_in_month(CAL_GREGORIAN, $mon, $year))));
  $arr = [];
  for ($i=1; $i <= $last_day_month['mday']; $i++) { 
    array_push($arr, getdate(strtotime(date($year.'-'.$mon.'-'.$i))));
  }
  return $arr;
}
?>