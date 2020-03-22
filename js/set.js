$(function(){
    $('#slide').vegas({
        slides: [
        { src: '../img/slide1.jpg' },
        { src: '../img/slide2.jpg' },
        { src: '../img/slide3.jpg' },
        { src: '../img/slide4.jpg' },
        { src: '../img/slide5.jpg' },
        { src: '../img/slide6.jpg' }
        ],
        transition: 'blur2',
        transitionDuration: 2000,
        shuffle: true,
        delay: 7000
    });

    // モバイルメニューの表示・非表示
    $('#mobile_menu_btn_done').click(function() {
        $('#mobile_menu_modal_swich').fadeIn(500);
        $('.mobile_menu_modal').slideDown(500);
    });

    $('#mobile_menu_close').click(function() {
        $('#mobile_menu_modal_swich').fadeOut(500);
        $('.mobile_menu_modal').slideUp(500);
    });

    // ログインモーダルの表示・非表示
    $('.close').click(function() {
        $('.gray_scale').fadeOut(1000);
    });

    $('#login_modal_show').click(function() {
        $('#login_modal_visable').fadeIn(1000);
        $('#autofocus').focus();
    });

    $('#login_modal_show_mobile').click(function() {
        $('#mobile_menu_modal_swich').fadeOut(500);
        $('.mobile_menu_modal').slideUp(500);
        $('#login_modal_visable').fadeIn(1000);
        $('#autofocus').focus();
    });

    // メール送信モーダルの表示・非表示・各種設定
    $('.send_mail_btn_web').click(function() {
        var title = $(this).parents('.google_custom_item').find('.webpage_title').html();
        var translate = $(this).parents('.google_custom_item').find('.webpage_trans').text();
        if (translate == "") {
            translate = "---";
        }
        var description = $(this).parents('.google_custom_item').find('.webpage_description').text();
        console.log(title);
        console.log(translate);
        console.log(description);

        $('#gray_scale_send_mail_modal').fadeIn(1000);
        $('#send_mail_contenttitle').html(title);
        $('#send_mail_contenttranslete').text(translate);
        $('#send_mail_contentdescription').text(description);
        $('#send_mail_content').focus();
    });

    $('.send_mail_btn_movie').click(function() {
        var title = $(this).parents('.youtube_search_item').find('.movie_title').html();
        var translate = $(this).parents('.youtube_search_item').find('p').text();
        if (translate == "") {
            translate = "---";
        }
        var movie = $(this).parents('.youtube_search_item').find('.movie-wrap').html();
        console.log(title);
        console.log(translate);
        console.log(movie);

        $('#gray_scale_send_mail_modal').fadeIn(1000);
        $('#send_mail_contenttitle').html(title);
        $('#send_mail_contenttranslete').text(translate);
        $('#send_mail_contentdescription').html(movie);
        $('#send_mail_content').focus();
    });

    // メール送信処理
    $('#send_mail_content').click(function() {
        var title = $('#send_mail_contenttitle').html();
        var translate = $('#send_mail_contenttranslete').html();
        var description = $('#send_mail_contentdescription').html();
        $.ajax({
            url: "send_mail.php",
            type: "POST",
            data: { 'title':  title, 'translate': translate, 'description': description}
        }).done(function(data) {
            $('#gray_scale_send_mail_modal').slideUp(600);
            console.log(data);
        });
    });

    $('#rss_load').click(function() {
        $.ajax({
            url: "include/news.php",
            type: "POST",
            data: { 'title':  'post' }
        }).done(function(data) {
            $('.news').fadeOut();
            $('.news').html(data).slideDown(500);
            console.log(data);
        }).fail(function(data) {
            console.log(data);
        });
    });

    // コンテンツのストック処理
    $('.stock_text_btn').click(function() {
        let textContent = $(this).parents('.google_custom_item');
        let title = textContent.find('.webpage_title a').text();
        let url = textContent.find('.webpage_title a').attr('href');
        let translateText = textContent.find('.webpage_trans').text();
        if (translateText == "") {
            translateText = "翻訳なし。";
        }
        let description = textContent.find('.webpage_description').text();

        $('#add_stock_contentTitle').attr('value', title);
        $('#add_stock_contentUrl').attr('value', url);
        $('#add_stock_translateText').attr('value', translateText);
        $('#add_movie_preview').text('ディスクリプション（確認用）');
        $('#contentType_text').prop('selected', true);
        $('#add_stock_description').fadeIn();
        $('#add_stock_description').text(description);
        if (($('#remove_date_input').prop('disabled')) == false) {
            $('#remove_date_condition').prop('checked', false);
            $('#remove_date_input').attr('disabled', 'disabled');
        }
        $('#gray_scale_add_stock_modal').fadeIn(1000);
        $('#add_stock_contentTitle').focus();
        console.log(translateText);
    });

    $('.stock_movie_btn').click(function() {
        let textContent = $(this).parents('.youtube_search_item');
        let title = textContent.find('.movie_title a').text();
        let url = textContent.find('.movie_title a').attr('href');
        let fream = textContent.find('.movie-wrap').html();
        let translateText = textContent.find('.movie_title_translate').text();
        if (translateText == "") {
            translateText = "翻訳なし。";
        }

        $('#add_stock_contentTitle').attr('value', title);
        $('#add_stock_contentUrl').attr('value', url);
        $('#add_stock_translateText').attr('value', translateText);
        $('#contentType_movie').prop('selected', true);
        $('#add_stock_description').fadeOut();
        $('#add_movie_preview').html(fream);
        if (($('#remove_date_input').prop('disabled')) == false) {
            $('#remove_date_condition').prop('checked', false);
            $('#remove_date_input').attr('disabled', 'disabled');
        }
        $('#gray_scale_add_stock_modal').fadeIn(1000);
        $('#add_stock_contentTitle').focus();
    });

    $('#remove_date_condition').click(function() {
        if ($('#remove_date_condition').prop('checked')) {
            $('#remove_date_input').removeAttr('disabled');
        }else {
            $('#remove_date_input').attr('disabled', 'disabled');
        }
    });

    $('#add_stock_content').click(function() {
        let formData = $('#add_stock_form').serialize();

        $.ajax({
            url: "stock.php",
            type: "POST",
            data: formData
        }).done(function(data) {
            console.log(data);
        }).fail(function(data) {
            console.log(data);
        });
        //console.log(formData);
        $('#gray_scale_add_stock_modal').slideUp(600);
    });

    //  ストックの更新ページ
    $('#update_stock_remove_date').click(function() {
        if ($('#update_stock_remove_date').prop('checked')) {
            $('#update_remove_date_visable').removeAttr('disabled');
        }else {
            $('#update_remove_date_visable').attr('disabled', 'disabled');
        }
    });

    /*Pace.on('done', function(){
        $('#pace_run').fadeOut();
    });*/
});

new WOW().init();