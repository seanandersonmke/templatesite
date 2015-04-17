   <?php
    $q = $the_film;
    $apikey = 'w96gmegw6ezzwcuf64cgkcyw';
    // construct the query with apikey and query
    $endpoint = 'http://api.rottentomatoes.com/api/public/v1.0/movies/'.$q.'.json?apikey=' . $apikey;
    // setup curl to make a call to the endpoint
    $session = curl_init($endpoint);
    // indicates that we want the response back
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    // exec curl and get the data back
    $data = curl_exec($session);
    // close curl session once finished retrieveing data
    curl_close($session);
    // decode json
    $search_results = json_decode($data);
    $posters = $search_results->posters;
    //print_r($search_results);
    if ($search_results === NULL) die('Error parsing json');
    // the data
    //print_r($search_results);
    //$ratings = $search_results->ratings;
   // print_r($search_results);
    ?><?php
    $date = date_create();
    $timestamp = gmdate("Y-m-d\TH:i:s\Z");
//echo date_format($date, 'U = Y-m-d H:i:s') . "\n";

//date_timestamp_set($date, 1171502725);
//$timestamp = date_format($date, "Y-m-d\TH:i:sO");
//$timestamp = urlencode($timestamp);
//echo $timestamp;
$amazon = "http://webservices.amazon.com/onca/xml?AWSAccessKeyId=AKIAIF26BR5VJ3FYEOXA&AssociateTag=9459-0301-3827&Condition=All&Keywords=Eastern%20Promises&Operation=ItemSearch&ResponseGroup=Images%2CItemAttributes%2COffers%2CReviews&SearchIndex=All&Service=AWSECommerceService&Timestamp=2015-04-01T03%3A33%3A05.000Z&Version=2011-08-01&Signature=ZnoJWQ3YJkGcBYAnCc8P1H8N6UIKINXYZOx4V3yLqjY%3D";
$a_session = curl_init($amazon);
curl_setopt($a_session, CURLOPT_RETURNTRANSFER, true);
    // exec curl and get the data back
    $a_data = curl_exec($a_session);
    // close curl session once finished retrieveing data
    curl_close($a_session);
    // decode json
    $xml=simplexml_load_string($a_data);
    $a_search_results = json_decode($a_data);
  ?>    

<div class="container">
    <h3><?=$search_results->title?></h3>
    <h6>Year Released - <?=$search_results->year?></h6>
    <img src="<?=$posters->detailed;?>" alt="poster image">
    <span>Genres - </span>
    <?php foreach ($search_results->genres as $key) {
        echo "<span>".$key." | </span>";  
    };?>
            <?php
           //print_r($data);
            foreach ($page_data as $row){?>
                <h1 class="content-subhead"></h1>
                <!-- A single blog post -->
                <section class="post">
                    <header class="post-header">
                        <h2 class="post-title"><?=$row['heading']?></h2>
                    </header>
                    <div class="post-description">
                        <p><?=$row['article']?></p>
                    </div>
                </section>
            <?php }?>
        </div>
