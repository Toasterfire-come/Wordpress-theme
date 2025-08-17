<?php /* Template Name: Accessibility */ ?>
<?php get_header(); ?>

<h2>Accessibility & WCAG Compliance</h2>
<p>We are committed to WCAG 2.1 AA standards and ensuring our app is accessible to all users, including those using Assistive Technology and Screen Reader software.</p>

<section>
	<h3>Keyboard Shortcuts</h3>
	<table role="table" aria-label="Keyboard Shortcuts Table">
		<thead>
			<tr>
				<th scope="col">Action</th>
				<th scope="col">Shortcut</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Open Watchlist</td>
				<td>G, W</td>
			</tr>
			<tr>
				<td>Open Portfolio</td>
				<td>G, P</td>
			</tr>
		</tbody>
	</table>
</section>

<section>
	<h3>Accessibility Controls</h3>
	<div>
		<button class="btn accessibility-control" onclick="adjustFontSize(1)">Increase Font Size</button>
		<button class="btn secondary accessibility-control" onclick="adjustFontSize(-1)">Decrease Font Size</button>
		<button class="btn accessibility-control" onclick="toggleHighContrast()">High Contrast Mode</button>
		<button class="btn secondary accessibility-control" onclick="toggleReducedMotion()">Reduced Motion</button>
	</div>
</section>

<section>
	<h3>Feedback</h3>
	<form id="accessibility-feedback-form" method="post" action="#" aria-label="Accessibility Feedback Form">
		<div class="form-group">
			<label for="feedback_email">Email</label>
			<input id="feedback_email" name="email" type="email" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="feedback_message">Comments</label>
			<textarea id="feedback_message" name="message" rows="4" class="form-control" required></textarea>
		</div>
		<button type="submit" class="btn">Submit Feedback</button>
	</form>
</section>

<script>
function adjustFontSize(delta) {
	document.documentElement.style.fontSize = (parseFloat(getComputedStyle(document.documentElement).fontSize) + (delta * 1)) + 'px';
}
function toggleHighContrast() {
	document.body.classList.toggle('high-contrast');
}
function toggleReducedMotion() {
	document.body.classList.toggle('reduced-motion');
}
</script>

<?php get_footer(); ?>