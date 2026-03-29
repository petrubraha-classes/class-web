<?php

define('FEED', 'https://feed.infoq.com/');
define('XPATH', '/rss/channel/item');

try {
  $dom = new DomDocument();
  $dom->load(FEED);
  $xpath = new DOMXpath($dom);

  foreach ($xpath->query(XPATH) as $news) {
    // get the tutle of each news: the value of the <title> element
    echo '<p>Noutate: <em>' .
      $news->getElementsByTagname('title')->item(0)->nodeValue . '</p>';
    echo '<p>Calea nodului: <code>' .
      $news->getElementsByTagname('title')->item(0)->getNodePath() .
      '</code></p>';

    $xpath->evaluate("count(" . XPATH . ")") . '</p>';
  }
} catch (RuntimeException $e) {
  echo $e->getMessage();
}
