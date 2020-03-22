<?php $rss = simplexml_load_file('https://rss.itmedia.co.jp/rss/2.0/news_bursts.xml'); ?>
<h2 class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="1s">IT TOPIC</h2>
<article class="wow fadeInUp it_topik_news" data-wow-duration="2s" data-wow-delay="1s">
<?php
$count = 0;
foreach($rss->channel->item as $item){
	$count++;
	$title = $item->title;
	$date = date("Y年 n月 j日", strtotime($item->pubDate));
	$link = $item->link;
    $description = mb_strimwidth (strip_tags($item->description), 0 , 110, "", "utf-8");
?>
	<section class="it_topik_news_item">
		<a href="<?php echo $link; ?>" target="_blank">
		<span class="date"><?php echo $date; ?></span>
		<span class="title"><?php echo $title; ?></span></a><br/>
		<span class="text"><?php echo $description; ?></span>
	</section>

	<?php
		if ($count === 12) {
			break;
		}
	?>
<?php } ?>
</article>

<?php
$rss = simplexml_load_file('https://www.gizmodo.jp/index.xml');
//var_dump($rss->channel);
?>
<h2 class="wow fadeInUp" data-wow-duration="2s" data-wow-delay="1s">GADGET TOPIC</h2>
<article class="wow fadeInUp it_topik_news" data-wow-duration="2s" data-wow-delay="1s">
<?php
$count = 0;
foreach($rss->channel->item as $item){
	$count++;
	$img = (string)$item->enclosure->attributes()->url;
	$title = $item->title;
	$date = date("Y年 n月 j日", strtotime($item->pubDate));
	$link = $item->link;
    $description = mb_strimwidth (strip_tags($item->description), 0 , 110, "", "utf-8");
?>
	<section class="it_topik_news_item">
		<img src="<?php echo $img; ?>">
		<a href="<?php echo $link; ?>" target="_blank">
		<span class="date"><?php echo $date; ?></span>
		<span class="title"><?php echo $title; ?></span></a><br/>
		<span class="text"><?php echo $description; ?></span>
	</section>

	<?php
		if ($count === 12) {
			break;
		}
	?>
<?php } ?>
</article>

<?php // echo $rss->channel->item[0]->enclosure->attributes()->url[0]; ?>