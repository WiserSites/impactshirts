<?php if( !defined( 'ABSPATH' ) ) {	exit; };

/*****************************************************************
*                                                                *
*          THE ASSET CLASS: GETTING THE STATS                    *
*                                                                *
******************************************************************/

	// Function to contact foreign servers
	class shareCount {
		private $url,$timeout;
		function __construct($url,$timeout=10) {
			$this->url=rawurlencode($url);
			$this->timeout=$timeout;
		}
		
		// Gather the Twitter Stats
		function get_tweets() { 
			$json_string = $this->file_get_contents_curl('http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url);
			$json = json_decode($json_string, true);
			return isset($json['count'])?intval($json['count']):0;
		}
		
		// Gather the LinkedIn Stats
		function get_linkedin() { 
			$json_string = $this->file_get_contents_curl("http://www.linkedin.com/countserv/count/share?url=$this->url&format=json");
			$json = json_decode($json_string, true);
			return isset($json['count'])?intval($json['count']):0;
		}
		
		// Gather the Facebook Stats
		function get_fb() {
			$json_string = $this->file_get_contents_curl('http://api.facebook.com/restserver.php?method=links.getStats&format=json&urls='.$this->url);
			$json = json_decode($json_string, true);
			return isset($json[0]['total_count'])?intval($json[0]['total_count']):0;
		}
		
		// Gather the Plus Ones
		function get_plusones()  {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"'.rawurldecode($this->url).'","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
			$curl_results = curl_exec ($curl);
			curl_close ($curl);
			$json = json_decode($curl_results, true);
			return isset($json[0]['result']['metadata']['globalCounts']['count'])?intval( $json[0]['result']['metadata']['globalCounts']['count'] ):0;
		}
		
		// Gather the Pinterest Stats
		function get_pinterest() {
			$return_data = $this->file_get_contents_curl('http://api.pinterest.com/v1/urls/count.json?url='.$this->url);
			$json_string = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $return_data);
			$json = json_decode($json_string, true);
			return isset($json['count'])?intval($json['count']):0;
		}
		private function file_get_contents_curl($url){
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
			$cont = curl_exec($ch);
			if(curl_error($ch))
			{
				die(curl_error($ch));
			}
				return $cont;
			}
		}
		function request_data( $url ) {
	
			$response = null;
		
			// First, we try to use wp_remote_get
			$response = wp_remote_get( $url );
			if( is_wp_error( $response ) ) {
		
				// If that doesn't work, then we'll try file_get_contents
				$response = file_get_contents( $url );
				if( false == $response ) {
		
					// And if that doesn't work, then we'll try curl
					$response = $this->curl( $url );
					if( null == $response ) {
						$response = 0;
					} // end if/else
		
				} // end if
		
			} // end if
		
			// If the response is an array, it's coming from wp_remote_get,
			// so we just want to capture to the body index for json_decode.
			if( is_array( $response ) ) {
				$response = $response['body'];
			} // end if/else
		
			return $response;
		
		}
		
/*****************************************************************
*                                                                *
*          Create a function to round results                    *
*                                                                *
******************************************************************/
	function kilomega( $val ) {
		if( $val < 1000 ): 
			return number_format($val);
		else: 
			$val = $val/1000; 
			return number_format($val).'K';
		 endif;
	}
	
/*****************************************************************
*                                                                *
*          Collect the stats from the networks                   *
*                                                                *
******************************************************************/

	function showContestShares($all=1) {
		$postID 	= get_the_ID();
		$url 		= get_permalink( $postID );
		// $url 		= 'http://dustn.tv/find-free-images/';
		$title 		= strip_tags(get_the_title($postID));
		$title 		= str_replace('|','',$title);
		$social 	= new shareCount($url);
		$totes 		= 0;
		
		$time = time();
		$time = date('YmdH',$time);
		$lastChecked = get_post_meta($postID,'timestamp',true);
		if($lastChecked == $time):
		
			$tweets  	= get_post_meta($postID,'tweets',true);
			$shares  	= get_post_meta($postID,'shares',true);
			$plusses 	= get_post_meta($postID,'plusses',true);
			$pins    	= get_post_meta($postID,'pins',true);
			$linkShares	= get_post_meta($postID,'linkShares',true);
			$totes		= get_post_meta($postID,'totes',true);
		
		else:
		
			$tweets  	= $social->get_tweets(); 	$totes += $tweets;
			$shares  	= $social->get_fb(); 		$totes += $shares;
			$plusses 	= $social->get_plusones();	$totes += $plusses;
			$pins    	= $social->get_pinterest(); $totes += $pins;
			$linkShares	= $social->get_linkedin();	$totes += $linkShares;
		
			update_post_meta($postID,'tweets',$tweets);
			update_post_meta($postID,'shares',$shares);
			update_post_meta($postID,'plusses',$plusses);
			update_post_meta($postID,'pins',$pins);
			update_post_meta($postID,'linkShares',$linkShares);
			update_post_meta($postID,'totes',$totes);
			update_post_meta($postID,'timestamp',$time);
		
		endif;
		$count 		= 6;
		
		if($all):
			// Create the social panel
			$assets = '<div class="nc_socialPanel fullColor" data-position="'.$options['locationPost'].'" data-float="'.$floatOption.'" data-count="'.$count.'" data-floatColor="'.$options['floatBgColor'].'" data-url="'.$url.'">';
		
			// Create the Google+ Box
			$resource['googlePlus'] = '<div class="nc_tweetContainer googlePlus" data-num="18" data-wid="45" data-id="1" data-count="'.$plusses.'">';
			$resource['googlePlus'] .= '<a target="_blank" href="https://plus.google.com/share?url='.$url.'" class="nc_tweet">';
			$resource['googlePlus'] .= '<span class="iconFiller"></span>';
			$resource['googlePlus'] .= '<span class="count">'.kilomega($plusses).'</span>';
			$resource['googlePlus'] .= '</a>';
			$resource['googlePlus'] .= '</div>';
				
			// Create the Twitter Box
			$urlParam = '&url='.$url;
			$resource['Twitter'] = '<div class="nc_tweetContainer twitter" data-num="40" data-wid="70" data-id="2" data-count="0">';
			$resource['Twitter'] .= '<a href="https://twitter.com/share?original_referer=/&text='.$title.''.$urlParam.'" class="nc_tweet">';
			$resource['Twitter'] .= '<span class="iconFiller"></span>';
			$resource['Twitter'] .= '<span class="count">'.kilomega($tweets).'</span>';
			$resource['Twitter'] .= '</a>';
			$resource['Twitter'] .= '</div>';
			
			// Create the Facebook Box
			$resource['Facebook'] = '<div class="nc_tweetContainer fb" data-num="30" data-wid="55" data-id="3" data-count="0">';
			$resource['Facebook'] .= '<a target="_blank" href="http://www.facebook.com/share.php?u='.$url.'" class="nc_tweet">';
			$resource['Facebook'] .= '<span class="iconFiller"></span>';
			$resource['Facebook'] .= '<span class="count">'.kilomega($shares).'</span>'; 
			$resource['Facebook'] .= '</a>';
			$resource['Facebook'] .= '</div>';
			
			// Create the Pinterest Box
			$a = '<a href="javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());" class="nc_tweet noPop">';
			$resource['Pinterest'] = '<div class="nc_tweetContainer nc_pinterest" data-num="25" data-wid="55" data-id="4">';
			$resource['Pinterest'] .= $a;
			$resource['Pinterest'] .= '<span class="iconFiller"></span>';
			$resource['Pinterest'] .= '<span class="count">'.kilomega($pins).'</span>';
			$resource['Pinterest'] .= '</a>';
			$resource['Pinterest'] .= '</div>';
		
			// Create the Linked In Box
			$resource['LinkedIn'] .= '<div class="nc_tweetContainer linkedIn" data-num="41" data-wid="70" data-id="5" data-count="0">';
			$resource['LinkedIn'] .= '<a href="https://www.linkedin.com/cws/share?url='.$url.'" class="nc_tweet">';
			$resource['LinkedIn'] .= '<span class="iconFiller"></span>';
			$resource['LinkedIn'] .= '<span class="count">'.kilomega($linkShares).'</span>'; 
			$resource['LinkedIn'] .= '</a>';
			$resource['LinkedIn'] .= '</div>';
			
			$assets .= $resource['googlePlus'];
			$assets .= $resource['Twitter'];
			$assets .= $resource['Facebook'];
			$assets .= $resource['Pinterest'];
			$assets .= $resource['LinkedIn'];
					
			// Create the Total Shares Box
			$assets .= '<div class="nc_tweetContainer totes" data-id="6">';
			$assets .= '<span class="count">'.kilomega($totes).' Votes</span>';
			$assets .= '</div>';
			$assets .= '</div>';
		
			echo $assets;
		else:
			return kilomega($totes);
		endif;
	}

/*****************************************************************
*                                                                *
*          Collect the stats from the networks                   *
*                                                                *
******************************************************************/



?>