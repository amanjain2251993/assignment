$(document).ready(function () {

    var updateOutput = function () {
        $('#nestable-output').val(JSON.stringify($('#nestable').nestable('serialize')));
    };

    $('#nestable').nestable().on('change', updateOutput);

    updateOutput();

    $("#add-item").submit(function (e) {
        e.preventDefault();
        id = Date.now();
        var label = $("#name").val();
        var code = $("#code").val();
        var description = $("#description").val();
		$('.error').hide(); 
		if((label == "")){
		 $('#name').after('<span class="error"> Please enter your Name </span>');
		 return;
		}
		if((code == "")){
		 $('#code').after('<span class="error"> Please enter Code </span>');
		 return;
		}
		if((description == "")){
		 $('#description').after('<span class="error"> Please enter Description </span>');
		 return;
		}
		 
        
        var item =
            '<li class="dd-item dd3-item" data-id="' + id + '" data-label="' + label + '" data-code="' + code + '" data-description="' + description + '">' +
            '<div class="dd-handle dd3-handle" > Drag</div>' +
            '<div class="dd3-content"><span>' + label + '</span>' +
            '<div class="item-edit">Edit</div>' +
            '</div>' +
            '<div class="item-settings d-none">' +
            '<p><label for="">Name<br><input type="text" name="update_name" value="' + label + '"></label></p>' +
            '<p><label for="">Code<br><input type="text" name="update_code" value="' + code + '"></label></p>' +
            '<p><label for="">Description<br><input type="text" name="update_description" value="' + description + '"></label></p>' +
            '<p><a class="item-delete" href="javascript:;">Remove</a> |' +
            '<a class="item-close" href="javascript:;">Close</a></p>' +
            '</div>' +
            '</li>';

        $("#nestable > .dd-list").append(item);
        $("#nestable").find('.dd-empty').remove();
        $("#add-item > [name='name']").val('');
        $("#add-item > [name='code']").val('');
        $("#add-item > [name='description']").val('');
        updateOutput();
    });

    $("body").delegate(".item-delete", "click", function (e) {
        $(this).closest(".dd-item").remove();
        updateOutput();
    });


    $("body").delegate(".item-edit, .item-close", "click", function (e) {
        var item_setting = $(this).closest(".dd-item").find(".item-settings");
        if (item_setting.hasClass("d-none")) {
            item_setting.removeClass("d-none");
        } else {
            item_setting.addClass("d-none");
        }
    });

    $("body").delegate("input[name='udate_label']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("label", $(this).val());
        $(this).closest(".dd-item").find(".dd3-content span").text($(this).val());
    });

    $("body").delegate("input[name='update_code']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("code", $(this).val());
    });
	  $("body").delegate("input[name='update_description']", "change paste keyup", function (e) {
        $(this).closest(".dd-item").data("description", $(this).val());
    });

});