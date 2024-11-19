<!-- Виджет TagSelector -->
<select
name="<?php echo $arParams['INPUT_NAME']; ?>"
multiple
class="tagSelector-select"
<?php if ($arParams['REQUIRED']): ?>
  required
<?php endif ?>
autocomplete="off">
<?php foreach ($arResult['usersList'] as $key => $value): ?>
  <option value="<?php echo $value['id'] ?>">
    <?php echo $value['title']; ?>
  </option>
<?php endforeach ?>
</select>

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
    multiple: true,
    events:{
      onAfterTagAdd: (event) => {
        selectorSetValues();
      },
      onAfterTagRemove: (event) => {
        selectorSetValues();
      },
    },
  });

  tagSelector.renderTo(document.getElementById('tagSelector<?php echo $arResult['id']; ?>'));

  <?php if ($arParams['SELECTED'] and is_array($arParams['SELECTED'])): ?>
    var selectedUsersIds = JSON.parse('<?php echo json_encode($arParams['SELECTED']); ?>');
    usersList.forEach( function(element, index) {
      for (var i = 0; i < selectedUsersIds.length; i++) {
        if (selectedUsersIds[i] == element.id) {
          tagSelector.addTag(element);
        }
      }
    });
  <?php endif ?>

  function selectorSetValues () {
    var tags = tagSelector.getTags();
    var tagsIds = [];
    tags.forEach( function(element, index) {
      tagsIds.push(element.id);
    });
    $('select[name="<?php echo $arParams['INPUT_NAME']; ?>"]').find('option').each(function () {
      this.selected = false;
      for (var i = 0; i < tagsIds.length; i++) {
        if (tagsIds[i] == this.value) {
          this.selected = true;
        }
      }
    });
  };

});
</script>