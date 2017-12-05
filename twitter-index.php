<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
  <style>
  body{
    font-family: 'Roboto';
    font-size: 16px;
    }
  h1{
    margin-bottom: 36px;
    margin-top: 36px;
    font-family: 'Lora';
  }
  h2{
    font-size: 1.2em;
  }
  a{
  color: #285A7C;
  }
  a:hover{
    text-decoration: none;
  }
  .tweet-box{
    padding: 30px;
    padding-left: 40px;
    width: 100%;
    margin-bottom: 2%;
    border-radius: 1px;
    background-color: #f1f1f1;
  }
  .avitar{
    float: left;
    padding-right: 20px;
  }

  </style>

<?php
  ini_set('display_errors', 1);
  require_once('TwitterAPIExchange.php');


  $url = 'https://api.twitter.com/1.1/search/tweets.json';
  $getfield = '?q=storm&?q=#puertorico';
  $requestMethod = 'GET';
  $twitter = new TwitterAPIExchange($settings);
  $tweetData = json_decode($twitter->setGetfield($getfield)
               ->buildOauth($url, $requestMethod)
               ->performRequest(),$assoc=TRUE);

  foreach($tweetData['statuses'] as $index => $items){
    $userArray = $items['user'];

    echo '<div class="row"><div class="col-12 tweet-box">';
    echo '<a target="_blank" href="https://twitter.com/' . $userArray['screen_name'] . '"><img class="avitar" src="' . $userArray['profile_image_url'] . '"></a>';
    echo '<a target="_blank" href="https://twitter.com/' . $userArray['screen_name'] . '"><h2>' . utf8_decode($userArray['name']) . "</h2></a><br/>";
    echo '<p class="tweet">' . utf8_decode($items['text']) . "</p><br/>";
    echo '</div></div>';
  }
  ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>/*
  jQuery Tweet Linkify (https://github.com/terenceponce/jquery.tweet-linkify)
  Written by Terence Ponce (http://terenceponce.github.com/)
  This is a small jQuery plugin that transforms @mention texts into hyperlinks
  pointing to the actual Twitter profile, #hashtag texts into actual hashtag searches
  as well as hyperlink texts into actual hyperlinks.
  The hyperlink text transforming was based off of jLinker.js by Michalis Tzikas and Vasilis Lolos.
  The use-case of this plugin is very specific, so using this plugin means that you're probably
  calling the Twitter API through Javascript just like me.
*/
(function($){
  $.fn.tweetLinkify = function(options) {
    $(this).each(function() {
      var tweet = TweetLinkify($(this).text(), options)
      $(this).html(tweet);
    })
  }


  window.TweetLinkify = function(tweet, options) {
    var defaultAttributes = {
      excludeHyperlinks: false,
      excludeMentions: false,
      excludeHashtags: false,
      hyperlinkTarget: '_blank',
      mentionTarget: '_blank',
      mentionIntent: false,
      hashtagTarget: '_blank',
      hyperlinkClass: '',
      mentionClass: '',
      hashtagClass: '',
      hyperlinkRel: '',
      mentionRel: '',
      hashtagRel: ''
    };

    var options = $.extend(defaultAttributes, options);

    var hyperlinkTarget = (options.hyperlinkTarget != '') ? 'target="_' + options.hyperlinkTarget + '"' : '';
    var mentionTarget = (options.mentionTarget != '') ? 'target="_' + options.mentionTarget + '"' : '';
    var hashtagTarget = (options.hashtagTarget != '') ? 'target="_' + options.hashtagTarget + '"' : '';
    var hyperlinkClass = (options.hyperlinkClass != '') ? 'class="' + options.hyperlinkClass + '"' : '';
    var mentionClass = (options.mentionClass != '') ? 'class="' + options.mentionClass + '"' : '';
    var hashtagClass = (options.hashtagClass != '') ? 'class="' + options.hashtagClass + '"' : '';
    var hyperlinkRel = (options.hyperlinkRel != '') ? 'rel="' + options.hyperlinkRel + '"' : '';
    var mentionRel = (options.mentionRel != '') ? 'rel="' + options.mentionRel + '"' : '';
    var hashtagRel = (options.hashtagRel != '') ? 'rel="' + options.hashtagRel + '"' : '';

    if (options.excludeHyperlinks != true) {
      tweet = tweet.replace(/(https\:\/\/|http:\/\/)([www\.]?)([^\s|<]+)/gi, '<a href="$1$2$3" ' + hyperlinkTarget + ' ' + hyperlinkClass + ' ' + hyperlinkRel + '>$1$2$3</a>');
      tweet = tweet.replace(/([^https\:\/\/]|[^http:\/\/]|^)(www)\.([^\s|<]+)/gi, '$1<a href="http://$2.$3" ' + hyperlinkTarget + ' ' + hyperlinkClass + ' ' + hyperlinkRel + '>$2.$3</a>');
      tweet = tweet.replace(/<([^a]|^\/a])([^<>]+)>/g, "&lt;$1$2&gt;").replace(/&lt;\/a&gt;/g, "</a>").replace(/<(.)>/g, "&lt;$1&gt;").replace(/\n/g, '<br />');
    }

    if (options.excludeMentions != true) {
      if (options.mentionIntent == false) {
        tweet = tweet.replace(/(@)(\w+)/g, '<a href="http://twitter.com/$2" ' + mentionTarget + ' ' + mentionClass + ' ' + mentionRel + '>$1$2</a>');
      } else {
        tweet = tweet.replace(/(@)(\w+)/g, '<a href="http://twitter.com/intent/user?screen_name=$2">$1$2</a>');
      }
    }

    if (options.excludeHashtags != true) {
      tweet = tweet.replace(/(#)(\w+)/g, '<a href="https://twitter.com/search/?src=hash&q=%23$2" ' + hashtagTarget + ' ' + hashtagClass + ' ' + hashtagRel + '>$1$2</a>');
    }

    return tweet;
  }

})(jQuery);
</script>
<script>
$('p.tweet').tweetLinkify();
</script>

</body>
