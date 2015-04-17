<?php 

function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}


function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}

$twlink = "LindseySnell";
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$oauth_access_token = "3016137195-cryFJCoax6LEZFTJihrJibgnVYNTw9BzOh4YgcK";
$oauth_access_token_secret = "NqiKWpczD0VXYjCBAxS3AeaMWAEdxHQGAcXVbX7lAuBeL";
$consumer_key = "jujsC5ixoKvMhm7JY3gS8mpZz";
$consumer_secret = "padChlaU0zSxTVG5anKXZz13QXP53B18US9Z8I96JZ2BXiCzI7";
$oauth = array(
  'screen_name' => $twlink,
  'count' => '50',
  'exclude_replies' => 'true',
  'include_rts' => 'false',
  'oauth_consumer_key' => $consumer_key,
  'oauth_nonce' => '1b5e70fbf5e70d0d6cc003f482dcba1e',
  'oauth_signature_method' => 'HMAC-SHA1',
  'oauth_token' => $oauth_access_token,
  'oauth_timestamp' => time(),
  'oauth_version' => '1.0'
);

$base_info = buildBaseString($url, 'GET', $oauth);
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// Make Requests
$header = array(buildAuthorizationHeader($oauth), 'Expect:');
$options = array(
  CURLOPT_HTTPHEADER => $header,
  //CURLOPT_POSTFIELDS => $postfields,
  CURLOPT_HEADER => false,
  CURLOPT_URL => $url. '?screen_name='.$twlink.'&count=50&exclude_replies=true&include_rts=false',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false
);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);
$twitter_data = json_decode($json);

?>

<div class="content pure-u-1 pure-u-md-1-1">

<?php
foreach($twitter_data as $data){
  echo '<div class="tweet_container">';
  if(isset($data->entities)){
      $img_url = $data->entities;
      if(isset($img_url->media)){
          $img_url = $img_url->media;
          if(isset($img_url[0]->media_url))
            $img_url = $img_url[0]->media_url;
              echo "<img src='".$img_url."'>";
        };
  };

  //prepare date
  $text = $data->text;
  $date = $data->created_at;
  $date = strtotime($date);
  $date = date('M d', $date);
  if(isset($data->entities)){
    $entities = $data->entities;
    
    if(isset($entities->urls)){
      $urls = $entities->urls; 
      foreach($urls as $url){
        $single_url = $url->url;
        $expanded_urls = $url->expanded_url;
        $display_urls = $url->display_url;
        $replacement = '<a href="'.$single_url.'" title="'.$expanded_urls.'">'.$display_urls.'</a>';
        $text = $data->text;
        $text = str_replace($single_url, $replacement, $text);
      }
    } 
    if(isset($entities->hashtags)){
        $hashtags = $entities->hashtags;
      foreach($hashtags as $hashtag){
        $hashtag = $hashtag->text;
        $hashtag_search = '#'.$hashtag;
        $link_hash = '<a href="https://twitter.com/hashtag/'.$hashtag.'?/src=hash" title="'.$hashtag_search.'">'.$hashtag_search.'</a>';
        $text = str_replace($hashtag_search, $link_hash, $text);
      }
    }
    if(isset($entities->user_mentions)){
        $usermentions = $entities->user_mentions;
      foreach($usermentions as $usermention){
        $usermention = $usermention->screen_name;
        $usermention_search = '@'.$usermention;
        $usermention_hash = '<a href="https://twitter.com/'.$usermention.'" title="'.$usermention_search.'">'.$usermention_search.'</a>';
        $text = str_replace($usermention_search, $usermention_hash, $text);
      }
    }
  }
  echo "<p><i class='fa fa-twitter'></i> ".$date."</p>";
  echo "<p>".$text."</p>";
  echo "</div>";
}?>




</div><!--close container-->
