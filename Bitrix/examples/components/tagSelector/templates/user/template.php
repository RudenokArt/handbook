<!-- Виджет TagSelector -->
<div class="tagSelector-input-wrapper">
  <input
  type="text"
  name="<?php echo $arParams['INPUT_NAME']; ?>"
  <?php if ($arParams['REQUIRED']): ?>
    required
  <?php endif ?>
  class="tagSelector-input"
  autocomplete="off">
</div>


<div id="tagSelector<?php echo $arResult['id']; ?>"></div>

<script>
 BX.ready(function(){
  var usersList = JSON.parse('<?php echo json_encode($arResult['usersList']); ?>');
  var tagSelector = new BX.UI.EntitySelector.TagSelector({
    dialogOptions: {
      items: usersList,
      tabs: [
        { id: 'users', title: 'users' }
        ],
      showAvatars: false,
      dropdownMode: true,
    },
    multiple: false,
    events: {
      onAfterTagAdd: (event) => {
        inputSetValue();
      },
      onAfterTagRemove: (event) => {
        inputSetValue();
      },
    },
  });

  tagSelector.renderTo(document.getElementById('tagSelector<?php echo $arResult['id']; ?>'));

  <?php if ($arParams['SELECTED'] and is_int((int)$arParams['SELECTED'])): ?>
    usersList.forEach( function(element, index) {
      if (element.id == <?php echo $arParams['SELECTED'] ?>) {
        tagSelector.addTag(element);
      }
    });
  <?php endif ?>

  function inputSetValue () {
    var tags = tagSelector.getTags();
    if (tags[0] && tags[0].id) {
      $('input[name="<?php echo $arParams['INPUT_NAME']; ?>"]').prop('value', tags[0].id);
    } else {
      $('input[name="<?php echo $arParams['INPUT_NAME']; ?>"]').prop('value', '');
    }
  };

});
</script>

