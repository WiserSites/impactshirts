<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
Template Name: Trust Pilot
*/

get_header();

	echo '<h2>See what our customers have to say about us</h2>';

  // Get the JSON feed and gzunpack
  $file = url_get_contents("https://s.trustpilot.com/tpelements/7840372/f.json");
  
  // JSON decode the string
  $json = json_decode($file);
   
  $settings['review_amount'] = 100;
  $settings['review_max_length'] = 500;
  if(isset($json->ReviewCount->Total)){
  $reviews = $json->ReviewCount->Total;
  }
  if(isset($reviews)){
  $reviews = floor($reviews / 100)*100;
  }
?>
<!--<a class="footer" href="<?php // echo $json->ReviewPageUrl; ?>" target="_blank">-->
    <a class="footer" href="<?php echo (isset($json->ReviewPageUrl)) ? $json->ReviewPageUrl : "";?>" target="_blank">
	<div class="tp-box-header">
		<div class="trustpilotBigStars floatLeft">
			<!--<span class="text20 centre"><?php // echo $json->TrustScore->Human; ?></span>-->
                        <span class="text20 centre"><?php echo (isset($json->TrustScore->Human)) ? $json->TrustScore->Human : ""; ?></span>
		</div>
		<div class="floatRight">
			<!--<span class="text24"><strong><?php // echo number_format($reviews); ?>+</strong><br><span class="text16">customer reviews</span></span>-->
			<span class="text24"><strong><?php echo (isset($reviews)) ?  number_format($reviews) : ""; ?>+</strong><br><span class="text16">customer reviews</span></span>
		 </div>
		 <div class="clearfix"></div>
	</div>
</a>
  <div class="tp-box<?php if(isset($_GET,$_GET['horizontal'])){?> horizontal<?php } ?>" id="tp-iframe-widget">
	
	<section class="reviews">
	     <?php for($i = 1; $i <= $settings['review_amount']; $i++) : ?>
      <?php if(isset($json->Reviews[$i])) : $review = $json->Reviews[$i]; ?>
      <article>
        <img src="<?php echo $review->TrustScore->StarsImageUrls->small; ?>" alt="review stars"/>
        <time datetime="<?php echo date('c',$review->Created->UnixTime); ?>"><?php echo $review->Created->HumanDate; ?></time>
        <h3><?php echo $review->Title; ?></h3>
        <p class="desc"><?php echo substr($review->Content, 0, $settings['review_max_length']); ?></p>
        <img src="<?php echo $review->User->ImageUrls->i24; ?>" alt="<?php echo $review->User->Name; ?>" class="user-img" />
        <p class="author">
          <?php echo $review->User->Name; ?><br />
          <?php echo $review->User->City; ?>
        </p>
      </article>
    <?php endif; endfor; ?>
    </section>
</div>
<div class="tp-box-footer">
<!--<a class="footer" href="<?php // echo $json->ReviewPageUrl; ?>" target="_blank">Leave your own review!</a>-->
    <a class="footer" href="<?php echo (isset($json->ReviewPageUrl)) ?  $json->ReviewPageUrl : ""; ?>" target="_blank">Leave your own review!</a>
</div> 

<?php

get_footer();

?>