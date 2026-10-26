// элемент после клика отображает или скрывает другой элемент, а сам элемент меняет свой текст.
function hide_show_element_by_click(clicked_element, target_element, text_variants) {
  hide_show_element(target_element.is(":hidden"), clicked_element, target_element, text_variants)
}

// элемент при условии show_target отображает target_element, а clicked_element меняет свой текст и наоборот.
function hide_show_element_loading(has_related_announcement, clicked_element, target_element, text_variants) {
  hide_show_element(has_related_announcement, clicked_element, target_element, text_variants)
}

function hide_show_element(should_element_show, clicked_element, target_element, text_variants) {
  if (should_element_show) {
    target_element.show();
    clicked_element.text(text_variants[1]);
  } else {
    target_element.hide();
    clicked_element.text(text_variants[0]);
  }
}
