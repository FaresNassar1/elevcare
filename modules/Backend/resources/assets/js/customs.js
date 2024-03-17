function addStyleSubmenu(e) {
    var t = e.find(".juzaweb__menuLeft__navigation"),
        n = e.offset().top,
        i = $(window).scrollTop(),
        o = n - i - 30,
        e = n + t.height() + 1,
        n = 60 + e - $('.juzaweb__layout').height(),
        i = $(window).height() + i - 50;

    if ((n = o < (n = i < e - n ? e - i : n) ? o : n) > 1 && n > 40) {
        t.css("margin-top", "-" + n + "px");
    } else {
        t.css("margin-top", "");
    }
}

$(document).ready(function () {
    let bodyElement = $('body');

    $(".appointment_form").closest("form").find(".btn-group").hide();

    bodyElement.on('change', '.show_on_front-change', function () {
        let showOnFront = $(this).val();

        if (showOnFront == 'posts') {
            $('.select-show_on_front').prop('disabled', true);
        }

        if (showOnFront == 'page') {
            $('.select-show_on_front').prop('disabled', false);
        }
    });

    bodyElement.on('click', '.cancel-button', function () {
        window.location = "";
    });

    bodyElement.on('change', '.generate-slug', function () {
        let title = $(this).val();

        ajaxRequest(juzaweb.adminUrl + '/load-data/generateSlug', {
            title: title
        }, {
            method: 'GET',
            callback: function (response) {
                $('input[name=slug]').val(response.slug).trigger('change');
            }
        });
    });

    bodyElement.on('click', '.slug-edit', function () {
        let slugInput = $(this).closest('.input-group').find('input:first');
        slugInput.prop('readonly', !slugInput.prop('readonly'));
    });

    bodyElement.on('click', '.close-message', function () {
        let id = $(this).data('id');
        ajaxRequest(juzaweb.adminUrl + '/remove-message', {
            id: id,
        }, {
            method: 'POST',
            callback: function (response) {

            }
        });
    });

    $(".juzaweb__menuLeft__submenu").on("mouseover", function () {
        if (!$(this).hasClass('juzaweb__menuLeft__submenu--toggled')) {
            addStyleSubmenu($(this));
        }
    }
    );

    //Customer Scripts
    $(document).on("click", ".expand-more", function (e) {
        e.preventDefault();
        $(this).closest("td").find(".short-text").toggleClass("expand");
    });

    $('.lang-switch').on('change', function () {
        // Get selected value
        var selectedValue = $(this).val();
        if ($(".related_ids").length) {
            var go_to_id = $(".related_ids#" + selectedValue).val();
            var currentUrl = window.location.href;
            if (typeof go_to_id != "undefined") {
                var newUrl = currentUrl.replace(/(\d+)\/edit/, go_to_id + '/edit');
                window.location.href = newUrl;
            }

        }
    });

    //Hide not related lang taxonomies
    var formLang = $(".lang-switch").val();
    $(".taxonomy-categories li[data-lang!='" + formLang + "']").remove();

    if ($(".box-custom-seo").length) {
        $("input[name=title], textarea[name=content]").on('change', function () {
            updateSeoForm();
        });
        if (tinyMCE.activeEditor) {
            tinyMCE.activeEditor.on('change', function () {
                updateSeoForm();
            });
        }
        function updateSeoForm() {
            let title = $('input[name=title]').val();
            let editor = tinyMCE.get('content-editor');
            if (editor) {
                var description = tinyMCE.get('content-editor').getContent();
            }else{
                var description = "";
            }

            var strippedContent = $('<div>').html(description).text();
            strippedContent = strippedContent.substring(0, 160);
            $(".box-custom-seo #meta_title").val(title);
            $("#meta_og_title").val(title);
            $("#meta_twitter_title").val(title);
            $(".review-description").text(strippedContent);
            $(".box-custom-seo #meta_description").text(strippedContent);
        }
    }
    $(".slug-edit").click(function (e) {
        alert("Caution! Modifying the slug of a page will have an impact on any associated subpages and posts.")
    });

    $(document).on('click', '.multi-files .add-image-images', function () {
        let prefix = juzaweb.adminPrefix + '/file-manager';
        let item = $(this).closest('.form-images');
        let inputName = item.find('.input-name').val();
        juzawebFileManager({
            type: 'file&lang=' + formLang,
            prefix: prefix,
            multichoose: true,
        }, function (files) {
            let temp = document.getElementById('form-images-template').innerHTML;
            let str = "";

            $.each(files, function (index, item) {
                item.icon = "";
                if (!isImage(item.url)) {
                    item.icon = "fa fa-file";
                }
                str += replace_template(temp, {
                    name: inputName,
                    url: item.url,
                    icon: item.icon,
                    path: item.path
                });
            });

            item.find('.images-list .image-item:last').before(str);
        });
    });
    //Change post status,show schedule datepicker
    $('select[name="status"]').on('change', function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'publish') {
            $('#status_scheduled').show();
        } else {
            $('#status_scheduled').hide();
        }
    });
    //Page Preview before publish
    $(document).on("click", "#preview-post", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        let formData = new FormData(form[0]);
        formData.append("status", "preview");
        formData.append("content", tinyMCE.activeEditor.getContent());

        let btnsubmit = form.find("button[type=submit]");
        let currentText = btnsubmit.html();
        let currentIcon = btnsubmit.find('i').attr('class');

        btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
        btnsubmit.prop("disabled", true);

        if (btnsubmit.data('loading-text')) {
            btnsubmit.html('<i class="fa fa-spinner fa-spin"></i> ' + btnsubmit.data('loading-text'));
        }

        sendcustomRequestAjax(
            form,
            formData,
            btnsubmit,
            currentText,
            currentIcon
        );
    });

});


var previewID = 0;
function sendcustomRequestAjax(form, data, btnsubmit, currentText, currentIcon) {
    let notify = form.data('notify') || false;
    var url = form.attr('action');
    var segments = url.split("/");
    if (/^\d+$/.test(segments[segments.length - 1])) {
        segments.pop(); // Remove the last segment if it's a number
    }
    var form_action = segments.join("/");
    var $method = "POST";
    data.delete("_method");
    if (previewID != 0) {
        form_action = form_action + "/" + previewID;
        data.append("_method", "PUT");
    }
    $.ajax({
        type: $method,
        url: form_action,
        dataType: 'json',
        data: data,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (response) {
        btnsubmit.find('i').attr('class', currentIcon);
        btnsubmit.prop("disabled", false);

        if (btnsubmit.data('loading-text')) {
            btnsubmit.html(currentText);
        }

        if (response.status === false) {
            return false;
        }
        previewID = response.data.id;

        window.open(response.data.path, '_blank');
        return false;
    }).fail(function (response) {
        btnsubmit.find('i').attr('class', currentIcon);
        btnsubmit.prop("disabled", false);

        if (btnsubmit.data('loading-text')) {
            btnsubmit.html(currentText);
        }

        if (notify) {
            show_notify(response);
        } else {
            show_message(response);
        }
        return false;
    });
}
