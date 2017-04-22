<?
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package WordPress
 */

header('Content-Type: text/xml; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

?>

<rss version="2.0"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:wfw="http://wellformedweb.org/CommentAPI/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:atom="http://www.w3.org/2005/Atom"
  <? do_action('rss2_ns'); ?>
>

<channel>
  <title><? bloginfo_rss('name'); wp_title_rss(); ?></title>
  <atom:link href="<? self_link(); ?>" rel="self" type="application/rss+xml" />
  <link><? bloginfo_rss('url') ?></link>
  <description><? bloginfo_rss("description") ?></description>
  <pubDate><? echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></pubDate>
  <language><? echo get_option('rss_language'); ?></language>
  <? do_action('rss2_head'); ?>
  <? while( have_posts()) : the_post(); ?>
  <item>
    <title><? the_title_rss() ?></title>
    <link><? the_permalink_rss() ?></link>
    <comments><? comments_link(); ?></comments>
    <pubDate><? echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
    <dc:creator><? the_author() ?></dc:creator>
    <? the_category_rss() ?>

    <guid isPermaLink="false"><? the_guid(); ?></guid>
    <?
      $content = get_the_content();
      if(!in_category("hidden")) {
        if(in_category("words")) {
    ?>

    <description><![CDATA[<?=$content?>]]></description>
    <content:encoded><![CDATA[<?=$content?>]]></content:encoded>

    <?
        } else {
          $content = explode("\n", $content);
          $image = trim($content[0]);
    ?>

    <description><![CDATA[<?=$content[1]?>]]></description>
    <content:encoded><![CDATA[<img src="http://quis.cc/images/thumb.php?img=<?=$image?>.jpg" /><br /> <?=$content[1]?>]]></content:encoded>

    <?
        }
      }
    ?>

    <wfw:commentRss><? echo get_post_comments_feed_link(); ?></wfw:commentRss>
<? rss_enclosure(); ?>
  <? do_action('rss2_item'); ?>
  </item>
  <? endwhile; ?>
</channel>
</rss>
