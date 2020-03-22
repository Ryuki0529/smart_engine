        <!--    ログインモーダル -->
        <div class="gray_scale" id="login_modal_visable">
            <article class="login_modal">
                <form method="post" action="login.php">
                    <h2>ログインフォーム</h2>
                    <div class="form-group">
                        <input type="email" class="form-control" id="autofocus" name="email" placeholder="メールアドレス" required />
                        <input type="password" class="form-control" name="password" placeholder="パスワード" required />
                    </div>
                    <center><button type="submit" class="btn-submit" name="login">ログインする</button>
                    <button type="button" class="close">❌閉じる</button></center>
                    <center><p><a href="register.php">会員登録はこちら</a></p></center>
                </form>
            </article>
        </div>
        <!--    ログインモーダルここまで -->
        <!--  メール送信用モーダル  -->
        <div class="gray_scale" id="gray_scale_send_mail_modal">
            <div class="send_mail_modal">
                <h2>メール送信</h2>
                <p>タイトル：<span id="send_mail_contenttitle"></span></p>
                <p>翻訳テキスト：<span id="send_mail_contenttranslete"></span></p>
                <p><span id="send_mail_contentdescription"></span></p>
                <center><button type="button" id="send_mail_content" class="btn-submit" name="login">送信</button>
                <button type="button" class="close">❌閉じる</button></center>
            </div>
        </div>
        <!--  メール送信用モーダルここまで  -->
        <!--  ストックモーダル  -->
        <div class="gray_scale" id="gray_scale_add_stock_modal">
            <div class="add_stock_modal">
                <h2>コンテンツのストック</h2>
                <form method="post" id="add_stock_form">
                    <div style="margin-top:15px; margin-bottom:20px;">
                        <label for="add_stock_contentTitle">タイトル（確認用）</label>
                        <input readonly type="text" name="contentTitle" id="add_stock_contentTitle">
                        <input readonly type="hidden" name="contentUrl" id="add_stock_contentUrl">
                        <label id="add_movie_preview" for="add_stock_description">ディスクリプション（確認用）</label>
                        <textarea readonly name="description" id="add_stock_description"></textarea>
                        <label for="add_stock_translateText">タイトル翻訳テキスト（確認用）</label>
                        <input readonly type="text" name="translateText" id="add_stock_translateText">
                        <div style="width:49.5%; margin:0px auto; float:left; box-sizing: border-box;">
                            <label for="contentType">コンテンツ種別</label>
                            <select name="contentType" id="contentType">
                                <option id="contentType_text" value="text">テキストコンテンツ</option>
                                <option id="contentType_movie" value="movie">動画コンテンツ</select>
                            </select>
                        </div>
                        <div style="width:49.5%; margin:0px auto; float:left; box-sizing: border-box;">
                            <label for="remove_date_input"><input style="width:auto; display: inline;" type="checkbox" id="remove_date_condition">&nbsp;ストック期限</label>
                            <input id="remove_date_input" type="date" name="remove_date" min="<?php echo date('Y-m-d'); ?>" disabled>
                        </div>
                        <label style="clear:both;" for="stock_coment">メモ</label>
                        <textarea name="addComent" id="stock_coment"></textarea>
                        <label for="stock_tage">タグ</label>
                        <input type="text" name="addTag" id="stock_tage">
                    </div>
                    <center><button type="button" id="add_stock_content" class="btn-submit" name="stock">ストック</button>
                    <button type="button" class="close">❌閉じる</button></center>
                </form>
            </div>
        </div>
        <!--  ストックモーダルここまで  -->
        <!--  モバイルメニュー  -->
        <div class="gray_scale" id="mobile_menu_modal_swich">
            <nav class="mobile_menu_modal">
                <h2>メニュー</h2>
                <?php if ($GLOBALS['login'] == true): ?>
                <p>こんにちは。<?php echo $username.$emai; ?>さん！</p>
                <a class="mypage_link" href="mypage.php?stock">マイページ</a>
                <a class="logout" href="logout.php?logout">ログアウト</a>
                <?php else: ?>
                <br/><button type="button" id="login_modal_show_mobile">ログイン</button>
                <center><br/>or<br/><a href="register.php">会員登録</a></center><br/>
                <?php endif; ?>
                <button type="button" id="mobile_menu_close">❌閉じる</button>
            </nav>
        </div>
        <!--  モバイルメニューここまで  -->
        <div class="container">
            <a href="https://smart-engine.yrp.xyz/"><h1>SMART ENGINE</h1></a>
            <div class="header_menu">
                <?php if ($GLOBALS['login'] == true): ?>
                <p>こんにちは。<?php echo $username.$emai; ?>さん！</p>
                <a class="mypage_link" href="mypage.php?stock">マイページ</a>
                <a class="logout" href="logout.php?logout">ログアウト</a>
                <?php else: ?>
                <button type="button" id="login_modal_show">ログイン</button>
                &nbsp;or&nbsp;<a href="register.php">会員登録</a>
                <?php endif; ?>
            </div>
            <div class="mobile_menu"><button type="button" id="mobile_menu_btn_done"><i class="fas fa-bars"></i><font size="1px">メニュー</font></button></div>
            <span class="float_clear"></span>
        </div>