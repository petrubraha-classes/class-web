<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>lab10-news</title>
  <meta name="description" content="a kind of a web scrapper using rss">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="xciting.css">
</head>

<body>
  <header>
    <h2> ay lmao news </h2>
  </header>
  <main>

    <?php
    $news = array(
      "dst" => "https://distrowatch.com/news/dw.xml",
      "cnn" => "http://rss.cnn.com/rss/money_technology.rss",
      "yho" => "https://www.yahoo.com/news/rss"
    );

    for ($i = 0; $i < 3; $i++) {
      $dom = new DomDocument();
      $dom->load($sources[$i]);

      $items = $dom->getElementsByTagName("item");

      for ($j = 0; $j < 3 && $j < $items->length; $j++) {
        $item = $items->item($j);
        $title = $item->getElementsByTagName("title")->item(0)->nodeValue;
        $link = $item->getElementsByTagName("link")->item(0)->nodeValue;

        echo "<p>$title</p>";
        echo "<p><a href='$link'>$link</a></p><br>";
      }
    }
    ?>

  </main>
</body>

</html>