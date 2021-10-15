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

	
</div>
