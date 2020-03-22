    <div class="wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.8s">
        <div class="seach_erea_line_top"></div>
        <div class="seach_wrapper" id="slide">
            <div class="mask">
                <div class="container">
                    <div class="seach_erea">
                        <h2>Webサイトと動画を翻訳検索できます。</h2>
                        <form method="post" action="index.php"><center>
                            <div class="translate_select">
                                <input type="radio" name="translate" id="translate1" value="ja" checked>&nbsp;
                                <label for="translate1">日本語で検索</label>&emsp;
                                <?php
                                    if ($GLOBALS['login'] === false) {
                                    $read = "disabled='true'";
                                    $title_permission = "会員登録後に利用可能になります。";
                                    }else {
                                        $read = "";
                                        $title_permission = "";
                                    }
                                ?>
                                <input type="radio" name="translate" id="translate2" value="en" <?php echo $read; ?>>&nbsp;
                                <label for="translate2" title="<?php echo $title_permission; ?>">検索結果を翻訳</label>&emsp;
                                <input type="radio" name="translate" id="translate3" value="en_search" <?php echo $read; ?>>&nbsp;
                                <label for="translate3" title="<?php echo $title_permission; ?>">英語に翻訳して検索</label>
                            </div>
                            <input type="hidden" name="language[]" value="google">
                            <div class="translate_select">
                                検索フィルター：
                                <select name="site_filter" style="font-size:17px; padding:3px; text-align:center;">
                                    <option value="general" selected>標準検索</option>
                                    <option value="qiita">Qiita（キータ）</option>
                                    <option value="teratail">TeraTail</option>
                                    <option value="stackoberflow_ja">Stack Over Flow（日本）</option>
                                    <option value="stackoberflow_en">Stack Over Flow（アメリカ）</option>
                                </select>&nbsp;
                                <input type="checkbox" name="language[]" value="youtube" id="movie_lavel">&nbsp;
                                <label for="movie_lavel">同時に動画検索</label>
                            </div>
                            <div style="margin:0px auto; width:auto;">
                                <input type="test" name="str" value="<?php echo $GLOBALS['word']; ?>" placeholder="ここにキーワードを入力" id="search_text" class="seach_box">
                                <input type="submit" name="seach" value="&#xf002; 検索" class="fas seach_submit">
                            </div></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="seach_erea_line_bottom"></div>
    </div>