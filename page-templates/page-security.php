<?php /* Template Name: Security */ ?>
<?php get_header(); ?>

<h2>Security Overview</h2>
<p>We take the security of your data seriously. Our platform employs industry-standard encryption, rigorous access controls, and continuous monitoring.</p>

<section>
	<h3>Compliance & Certifications</h3>
	<ul>
		<li>SOC 2 Type II</li>
		<li>GDPR Compliance</li>
		<li>HIPAA-ready controls</li>
	</ul>
</section>

<section>
	<h3>Incident Reporting</h3>
	<p>If you believe you have found a security issue, please report it using the form below.</p>
	<form id="security-alerts-form" method="post" action="#">
		<div class="form-group">
			<label for="reporter_email">Your Email</label>
			<input type="email" id="reporter_email" name="email" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="issue_details">Issue Details</label>
			<textarea id="issue_details" name="details" class="form-control" rows="4" required></textarea>
		</div>
		<button type="submit" class="btn">Submit Report</button>
	</form>
</section>

<section>
	<h3>Bug Bounty</h3>
	<p>We run a Security Bug Bounty Program to reward responsible disclosures.</p>
</section>

<?php get_footer(); ?>