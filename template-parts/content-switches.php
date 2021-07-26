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
				<input type="checkbox" id="tufte" onclick="saveCheckbox(document.getElementById('tufte'));">
				<span class="slider round"></span>
			</label>
		 </p>
		 
				<p>Dyslexia Font
			<label class="switch">
				<input type="checkbox" id="accessible" onclick="saveCheckbox(document.getElementById('accessible'));">
				<span class="slider round"></span>
			</label>
		 </p>
				<p>Dark Mode
			<label class="switch">
				<input type="checkbox" id="darkmode" onclick="saveCheckbox(document.getElementById('darkmode'));">
				<span class="slider round"></span>
			</label>
		 </p>
		 <div>
			 <a id="myLink" href="#" onclick="resetStorage();">Reset Settings</a>
			 </div>
		 	</div>
			 
			<?php echo '</div>';

