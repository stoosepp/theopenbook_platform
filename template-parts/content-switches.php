<?php
/**
 * Template part for displaying switches to change display optoins
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * 
 */?>
	
 <div class="toggles">
				<p>Book Theme
			<label class="switch">
				<input type="checkbox" id="tufte" onclick="saveCheckbox(this);" />
				<span class="slider round"></span>
			</label>
		 </p>
		 
				<p>Dyslexic Font<a style="color:#ccc;" href="https://opendyslexic.org/" target="_blank"><i class="fa fa-info-circle"></i></a>
			<label class="switch">
				<input type="checkbox" id="opendyslexic" onclick="saveCheckbox(this);" />
				<span class="slider round"></span>
			</label>
		 </p>
		 <div>
			 
			 </div>
		 	</div>
			 <!-- BACKGROUND COLOR SELECTOR -->
			 <div id="colorScheme">
				<label class="container">
					<input type="radio" checked="checked" name="radio" id="whiteCheck" onclick="changeColorScheme(this);" value="white" />
					<span class="checkmark white"></span>
				</label>
				<label class="container">
					<input type="radio" name="radio" id="sepiaCheck" onclick="changeColorScheme(this);" value="sepia" />
					<span class="checkmark sepia"></span>
				</label>
				<label class="container">
					<input type="radio" name="radio" id="darkmodeCheck" onclick="changeColorScheme(this);" value="darkmode" />
					<span class="checkmark dark"></span>
				</label>	
			</div>	 
			<a id="resetLink" href="#" onclick="resetStorage();">Reset Completed Chapters</a>

<?php
/*
 	$bookRoot = getRootForPage($post);
	 $root = get_post($bookRoot);  
	 if ($post != $bookRoot){
		$feedbackOn = get_post_meta( $root->ID, 'acceptFeedback', true ); 
		if($feedbackOn == true)
		{
			$voteData = getVoteData($post->ID);
			consolePrint('Up: '.$voteData[0].' Down: '.$voteData[1]);
			$totalCount = $voteData[0] + $voteData[1];
			$percentage = $voteData[0]/$totalCount;
			 ?>
			 <div class="post-votes">
				 <div class="submit-vote">
				<p>Is this chapter helping you learn?</p>			
				<!-- <input style="display:none;" type="checkbox" id="votedon<?php echo $post->ID ?>" onclick="saveCheckbox(this)"> -->
				<a href="<?php echo home_url( $wp->request ) ?>?voteUp=true&value=<?php echo get_the_id() ?>"><i class="far fa-thumbs-up"></i></a>
				<a href="<?php echo home_url( $wp->request ) ?>?voteDown=true&value=<?php echo get_the_id() ?>"><i class="far fa-thumbs-down"></i></a>
			 </div>
			<div class="did-vote hidden">
				<p>Thank you for providing feedback</p>
			 </div>
				<p id="vote-results"><?php echo round($percentage,2)*100 ?>% of <?php echo $totalCount ?> voters found this helpful.</p>
			</div><?php
		} 
	 }
	 */
	?>
</div>
