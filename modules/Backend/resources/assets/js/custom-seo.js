$(document).ready(function () {

    $("body").on('click', '.custom-seo', function () {
        let item = $(this);
        let title = $('input[name=title]').val();
        let description = tinyMCE.get('content-editor').getContent();

        // let description = tinyMCE.activeEditor.getContent();
        if ($("#meta_title").val() && $("#meta_description").val()) {
            item.hide('slow');
            $(".box-custom-seo").show('slow');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: juzaweb.adminUrl + '/ajax/seo-content',
            dataType: 'json',
            data: {
                'title': title,
                'description': description,
            }
        }).done(function (data) {

            if (data.status === false) {
                show_message(data);
                return false;
            }

            if (!$("#meta_title").val()) {
                $("#meta_title").val(data.title);
            }

            if (!$("#meta_description").val()) {
                $("#meta_description").val(data.description);
            }

            if (!$("#meta_title").val()) {
                $(".review-title").text(data.title);
            }

            if (!$("#meta_description").val()) {
                $(".review-description").text(data.description);
            }

            item.hide('slow');
            $(".box-custom-seo").show('slow');
            return false;
        }).fail(function (data) {
            show_message(data);
            return false;
        });
    });

    $(document).on('change',
        'input[name="meta_og_title"], textarea[name="meta_og_description"], input[name="meta_og_url"]',
        function () {
            var newValue = $(this).val();
            var targetClass = $(this).attr('name');
            if ($('.' + targetClass).length > 0) {
                $('.' + targetClass).text(newValue);
            }
        });


    $("input[name=title], textarea[name=content]").on('change', function () {
        let title = $('input[name=title]').val();
        let editor = tinyMCE.get('content-editor');
        if (editor) {
            var description = tinyMCE.get('content-editor').getContent();
        } else {
            var description = "";
        }
        $.ajax({
            type: 'POST',
            url: juzaweb.adminUrl + '/ajax/seo-content',
            dataType: 'json',
            data: {
                'title': title,
                'description': description,
            }
        }).done(function (data) {

            if (data.status === false) {
                show_message(data);
                return false;
            }

            if (!$("#meta_title").val()) {
                $(".review-title").text(data.title);
            }



            if (!$("#meta_description").val()) {
                $(".review-description").text(data.description);
            }

            return false;
        }).fail(function (data) {
            show_message(data);
            return false;
        });
    });

    $('form').on('change', 'input[name=slug]', function () {
        let slug = $(this).val();
        $(".review-url span").text(slug);
    });

    $("#meta_title, #meta_description, #meta_url").on('change', function () {
        let title = $('#meta_title').val();
        let description = $('#meta_description').val();

        $.ajax({
            type: 'POST',
            url: juzaweb.adminUrl + '/ajax/seo-content',
            dataType: 'json',
            data: {
                'title': title,
                'description': description
            }
        }).done(function (data) {

            if (data.status === false) {
                show_message(data.message);
                return false;
            }

            $(".review-title").text(data.title);
            $(".review-description").text(data.description);
            //$(".review-url span").text(data.slug);
            //if (!$("#meta_url").val()) $("#meta_url").val(data.slug);
            return false;
        }).fail(function (data) {
            show_message(data);
            return false;
        });
    });

    $(document).on('change', '#meta_description', function () {
        var meta_og_description = $('#meta_og_description');
        meta_og_description.val($(this).val());

    });

    $("input[name=title]").on('change', function () {
        let title = $('input[name=title]').val();
        let editor = tinyMCE.get('content-editor');
        if (editor) {
            var description = tinyMCE.get('content-editor').getContent();
        } else {
            var description = "";
        } $.ajax({
            type: 'POST',
            url: juzaweb.adminUrl + '/ajax/seo-content',
            dataType: 'json',
            data: {
                'title': title,
                'description': description,
            }
        }).done(function (data) {
            $("#meta_og_description").val(data.description);
            $(".meta_og_description").text(data.description);
            $(".meta_og_title").text(data.title);
            $("#meta_twitter_description").val(data.description);
            return false;
        }).fail(function (data) {
            show_message(data);
            return false;
        });
    });

    var showRobotsRadio = document.querySelectorAll('input[name="meta_showRobots"]');
    var robotsOptionsDiv = document.getElementById('robotsOptions');

    showRobotsRadio.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (this.value === 'yes') {
                robotsOptionsDiv.style.display = 'block';
            } else {
                robotsOptionsDiv.style.display = 'none';
            }
        });
    });

    $('input[name="thumbnail"]').on('change', function () {
        var newValue = $(this).val(); // Get the new value
        $('input[name="meta_og_image"]').val(newValue);
    });
});
