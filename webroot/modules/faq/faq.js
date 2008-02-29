if (Drupal.jsEnabled) {
  $(document).ready(function () {
    // hide/show answer to question
    $('dd.faq_answer').hide();
    $("dt.faq_question").click(function() {
      $(this).next("dd.faq_answer").toggle();
						return false;
    });


    // hide/show q/a for a category
    $('div.faq_qa_hide').hide();
    $(".faq_qa_header").click(function() {
      $(this).next("div.faq_qa_hide").toggle();
						return false;
    });



    // handle faq_category_settings_form
    faq_display_handler();
    questions_top_handler();
    categories_handler();
    $("input[@name=display]").bind("click", faq_display_handler);
    $("input[@name=category_display]").bind("click", categories_handler);
    $("input[@name=hide_sub_categories]").bind("click", sub_cats_handler);


  });
}


function faq_display_handler(event) {
  if ($("input[@name=display]:checked").val() == "questions_inline"
    || $("input[@name=display]:checked").val() == "questions_top") {
    $("input[@name=use_teaser]").removeAttr("disabled");
    $("input[@name=more_link]").removeAttr("disabled");
    $("input[@name=back_to_top]").removeAttr("disabled");
  }
  else {
    $("input[@name=use_teaser]").attr("disabled", "disabled");
    $("input[@name=more_link]").attr("disabled", "disabled");
    $("input[@name=back_to_top]").attr("disabled", "disabled");
  }
  if ($("input[@name=display]:checked").val() == "new_page"
    || $("input[@name=display]:checked").val() == "questions_top") {
				$("select[@name=question_listing]").removeAttr("disabled");
		}
		else {
				$("select[@name=question_listing]").attr("disabled", "disabled");
		}
}

function questions_top_handler(event) {
  $("input[@name=faq_display]").val() == "questions_top" ?
    $("input[@name=group_questions_top]").removeAttr("disabled"):
    $("input[@name=group_questions_top]").attr("disabled", "disabled");

  $("input[@name=faq_display]").val() == "questions_top" ?
    $("input[@name=answer_category_name]").removeAttr("disabled"):
    $("input[@name=answer_category_name]").attr("disabled", "disabled");
}

function categories_handler(event) {
  if ($("input[@name=faq_display]").val() == "questions_top") {
    $("input[@name=category_display]:checked").val() == "categories_inline" ?
      $("input[@name=group_questions_top]").removeAttr("disabled"):
      $("input[@name=group_questions_top]").attr("disabled", "disabled");
    $("input[@name=category_display]:checked").val() == "new_page" ?
      $("input[@name=answer_category_name]").attr("disabled", "disabled"):
      $("input[@name=answer_category_name]").removeAttr("disabled");
  }
  else {
    $("input[@name=group_questions_top]").attr("disabled", "disabled");
  }

  $("input[@name=category_display]:checked").val() == "categories_inline" ?
    $("input[@name=hide_sub_categories]").attr("disabled", "disabled"):
    $("input[@name=hide_sub_categories]").removeAttr("disabled");
  $("input[@name=category_display]:checked").val() == "categories_inline" ?
    $("input[@name=show_cat_sub_cats]").attr("disabled", "disabled"):
    $("input[@name=show_cat_sub_cats]").removeAttr("disabled");
		$("input[@name=category_display]:checked").val() == "new_page" ?
				$("select[@name=category_listing]").removeAttr("disabled"):
				$("select[@name=category_listing]").attr("disabled", "disabled");

		sub_cats_handler();
}

function sub_cats_handler(event) {
  if ($("input[@name=hide_sub_categories]:checked").val() == 1) {
    $("input[@name=show_cat_sub_cats]").attr("disabled", "disabled");
		}
		else if ($("input[@name=category_display]:checked").val() != "categories_inline") {
    $("input[@name=show_cat_sub_cats]").removeAttr("disabled");
		}
}


function faq_has_options(obj) {
		if (obj != null && obj.options != null) {
				return true;
		}
		return false;
}

function faq_swap_options(obj, i, j) {
		var o = obj.options;
		var i_selected = o[i].selected;
		var j_selected = o[j].selected;
		var temp = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
		var temp2= new Option(o[j].text, o[j].value, o[j].defaultSelected, o[j].selected);
		o[i] = temp2;
		o[j] = temp;
		o[i].selected = j_selected;
		o[j].selected = i_selected;
}

function faq_move_selected_item_up() {
		var obj = document.getElementById("edit-order-no-cats");
		if (!faq_has_options(obj)) {
				return;
		}
		for (i = 0; i < obj.options.length; i++) {
				if (obj.options[i].selected) {
						if (i != 0 && !obj.options[i-1].selected) {
								faq_swap_options(obj, i, i-1);obj.options[i-1].selected = true;
						}
				}
		}
}

function faq_move_selected_item_down() {
		var obj = document.getElementById("edit-order-no-cats");
		if (!faq_has_options(obj)) {
				return;
		}
		for (i = obj.options.length-1; i >= 0; i--) {
				if (obj.options[i].selected) {
						if (i != (obj.options.length-1) && ! obj.options[i+1].selected) {
								faq_swap_options(obj, i, i+1);
								obj.options[i+1].selected = true;
						}
				}
		}
}

function faq_update_order() {
		var obj = document.getElementById("edit-order-no-cats");
		var ids = new Array();
		for (var i = 0; i < obj.length; i++) {
				ids[i] = obj.options[i].value;
		}
		var new_order = new String(ids.join(","));
		var form = document.getElementById('faq-weight-settings-form');
		form.faq_node_order.value = new_order;
}

function faq_order_by_date(order) {
		var obj = document.getElementById("edit-order-no-cats");
		if (!faq_has_options(obj)) {
				return;
		}

		var form = document.getElementById('faq-weight-settings-form');
		var date_order = form.faq_node_date_order.value;

		var newIds = date_order.split(",");
		if (order == "ASC") {
				newIds.reverse();
				date_order = new String(newIds.join(","));
		}
		form.faq_node_order.value = date_order;

		var opt_text = new Array();
		var opts = obj.options;

		for (var i = 0; i < opts.length; i++) {
				var id = opts[i].value;
				opt_text[id] = opts[i].text;
		}
		for (var i = 0; i < newIds.length; i++) {
				var id = newIds[i];
				var opt = new Option(opt_text[id], id);
				obj.options[i] = opt;
		}

}


