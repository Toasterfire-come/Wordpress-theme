<?php /* Template Name: Contact */ ?>
<?php get_header(); ?>

<h2>Contact Us</h2>
<p>We typically respond within 1 business day. Our average Response Time is under 4 hours.</p>

<section>
	<h3>Contact Form</h3>
	<form id="contact-form" method="post" action="#">
		<div class="form-group">
			<label for="contact_name">Name</label>
			<input id="contact_name" name="name" type="text" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="contact_email">Email</label>
			<input id="contact_email" name="email" type="email" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="contact_message">Message</label>
			<textarea id="contact_message" name="message" rows="5" class="form-control" required></textarea>
		</div>
		<button type="submit" class="btn">Send Message</button>
	</form>
</section>

<section>
	<h3>Office Locations</h3>
	<ul>
		<li>New York, USA</li>
		<li>London, UK</li>
		<li>Singapore</li>
	</ul>
</section>

<section>
	<h3>Social Media</h3>
	<p>Follow us for updates:</p>
	<ul>
		<li><a href="#">Twitter</a></li>
		<li><a href="#">LinkedIn</a></li>
		<li><a href="#">GitHub</a></li>
	</ul>
</section>

<section>
	<h3>Live Chat</h3>
	<p>Live Chat is available on business days from 9am–6pm.</p>
</section>

<script>
(function() {
	document.getElementById('contact-form').addEventListener('submit', function(e) {
		e.preventDefault();
		var form = this;
		var data = new FormData(form);
		data.append('action', 'submit_contact_form');
		data.append('nonce', (window.StockScan && StockScan.nonce) || '');
		fetch((window.StockScan && StockScan.ajax_url) || '<?php echo admin_url("admin-ajax.php"); ?>', {
			method: 'POST',
			credentials: 'same-origin',
			body: data
		}).then(function(r) { return r.json(); }).then(function(resp) {
			console.log('Contact submit resp', resp);
			var ok = resp && (resp.success || resp.code === 200);
			alert(ok ? 'Message sent successfully' : 'Submission failed');
		}).catch(function(err) { alert('Network error'); });
	});
})();
</script>

<?php get_footer(); ?>