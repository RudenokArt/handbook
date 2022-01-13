<style>
  .preloader_wrapper {
  position: absolute;
  width: 120%;
  height: 120%;
  display: flex;
  background: white;
  top: -10%;
  left: -10%;
}
.preloader_inner {
  color: grey;
  font-size: 36px;
  margin: auto;
}
</style>

<div class="preloader_wrapper" id="preloader_wrapper">
  <div class="preloader_inner">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
  </div>
</div>

<script>
  setTimeout(function () {
    $('.preloader_wrapper').fadeOut();
  }, 1000);
</script>
