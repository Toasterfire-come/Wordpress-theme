<?php
/**
 * Template for Contact page
 * Retail Trade Scanner Theme
 */

get_header(); ?>

<main id="main" class="site-main" style="background: #f8fafc;">
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 6rem 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3.5rem; font-weight: bold; margin-bottom: 1.5rem;">
                <?php _e('Get in Touch', 'retail-trade-scanner'); ?>
            </h1>
            <p style="font-size: 1.25rem; color: #cbd5e1; max-width: 600px; margin: 0 auto;">
                <?php _e('Have questions about our platform? Need help with your account? We are here to help.', 'retail-trade-scanner'); ?>
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section style="padding: 6rem 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
                
                <!-- Contact Form -->
                <div class="card" style="padding: 3rem;">
                    <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; color: #0f172a;">
                        <?php _e('Send us a Message', 'retail-trade-scanner'); ?>
                    </h2>
                    <p style="color: #64748b; margin-bottom: 2rem;">
                        <?php _e('Fill out the form below and we will get back to you within 24 hours.', 'retail-trade-scanner'); ?>
                    </p>

                    <form id="contact-form">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                            <div>
                                <label for="first_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                    <?php _e('First Name', 'retail-trade-scanner'); ?> *
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    required
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                >
                            </div>
                            <div>
                                <label for="last_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                    <?php _e('Last Name', 'retail-trade-scanner'); ?> *
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    required
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                                >
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                <?php _e('Email Address', 'retail-trade-scanner'); ?> *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem;"
                            >
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="subject" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                <?php _e('Subject', 'retail-trade-scanner'); ?> *
                            </label>
                            <select 
                                id="subject" 
                                name="subject" 
                                required
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; background: white;"
                            >
                                <option value=""><?php _e('Select a subject...', 'retail-trade-scanner'); ?></option>
                                <option value="general"><?php _e('General Inquiry', 'retail-trade-scanner'); ?></option>
                                <option value="technical"><?php _e('Technical Support', 'retail-trade-scanner'); ?></option>
                                <option value="billing"><?php _e('Billing Question', 'retail-trade-scanner'); ?></option>
                                <option value="account"><?php _e('Account Issues', 'retail-trade-scanner'); ?></option>
                                <option value="enterprise"><?php _e('Enterprise Sales', 'retail-trade-scanner'); ?></option>
                            </select>
                        </div>

                        <div style="margin-bottom: 2rem;">
                            <label for="message" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: #374151;">
                                <?php _e('Message', 'retail-trade-scanner'); ?> *
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5" 
                                required
                                placeholder="<?php _e('Tell us how we can help...', 'retail-trade-scanner'); ?>"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 1rem; resize: vertical; min-height: 120px;"
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            style="width: 100%; justify-content: center; padding: 1rem;"
                        >
                            <?php _e('Send Message', 'retail-trade-scanner'); ?>
                        </button>

                        <div id="contact-success" style="display: none; background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 6px; margin-top: 1rem; text-align: center;">
                            <?php _e('Thank you! Your message has been sent successfully.', 'retail-trade-scanner'); ?>
                        </div>

                        <div id="contact-error" style="display: none; background: #fee2e2; color: #dc2626; padding: 1rem; border-radius: 6px; margin-top: 1rem; text-align: center;">
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <div style="margin-bottom: 3rem;">
                        <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 1rem; color: #0f172a;">
                            <?php _e('Other Ways to Reach Us', 'retail-trade-scanner'); ?>
                        </h2>
                        <p style="color: #64748b; margin-bottom: 2rem;">
                            <?php _e('Choose the method that works best for you.', 'retail-trade-scanner'); ?>
                        </p>
                    </div>

                    <!-- Support Options -->
                    <div style="display: grid; gap: 1.5rem;">
                        <div class="card" style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                    📧
                                </div>
                                <div>
                                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                                        <?php _e('Email Support', 'retail-trade-scanner'); ?>
                                    </h3>
                                    <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                                        <?php _e('Get help via email', 'retail-trade-scanner'); ?>
                                    </p>
                                </div>
                            </div>
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.875rem;">
                                <?php _e('For general inquiries and technical support. We typically respond within 24 hours.', 'retail-trade-scanner'); ?>
                            </p>
                            <a href="mailto:support@retailtradescanner.com" class="btn btn-outline" style="font-size: 0.875rem;">
                                <?php _e('Send Email', 'retail-trade-scanner'); ?>
                            </a>
                        </div>

                        <div class="card" style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                    📚
                                </div>
                                <div>
                                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                                        <?php _e('Knowledge Base', 'retail-trade-scanner'); ?>
                                    </h3>
                                    <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                                        <?php _e('Find answers instantly', 'retail-trade-scanner'); ?>
                                    </p>
                                </div>
                            </div>
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.875rem;">
                                <?php _e('Browse our comprehensive documentation and frequently asked questions.', 'retail-trade-scanner'); ?>
                            </p>
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('faq'))); ?>" class="btn btn-outline" style="font-size: 0.875rem;">
                                <?php _e('Browse FAQ', 'retail-trade-scanner'); ?>
                            </a>
                        </div>

                        <div class="card" style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                <div style="width: 50px; height: 50px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                    🏢
                                </div>
                                <div>
                                    <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #0f172a;">
                                        <?php _e('Enterprise Sales', 'retail-trade-scanner'); ?>
                                    </h3>
                                    <p style="color: #64748b; margin: 0; font-size: 0.875rem;">
                                        <?php _e('Custom solutions for businesses', 'retail-trade-scanner'); ?>
                                    </p>
                                </div>
                            </div>
                            <p style="color: #64748b; margin-bottom: 1rem; font-size: 0.875rem;">
                                <?php _e('Interested in enterprise features? Contact our sales team for custom pricing and solutions.', 'retail-trade-scanner'); ?>
                            </p>
                            <a href="mailto:sales@retailtradescanner.com" class="btn btn-outline" style="font-size: 0.875rem;">
                                <?php _e('Contact Sales', 'retail-trade-scanner'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section style="padding: 6rem 0; background: white;">
        <div class="container" style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #0f172a; margin-bottom: 1rem;">
                <?php _e('Frequently Asked Questions', 'retail-trade-scanner'); ?>
            </h2>
            <p style="font-size: 1.125rem; color: #64748b; margin-bottom: 3rem;">
                <?php _e('Quick answers to common questions about our platform.', 'retail-trade-scanner'); ?>
            </p>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('faq'))); ?>" class="btn btn-primary btn-large">
                <?php _e('View All FAQs', 'retail-trade-scanner'); ?>
            </a>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const successDiv = document.getElementById('contact-success');
    const errorDiv = document.getElementById('contact-error');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const contactData = {
            first_name: formData.get('first_name'),
            last_name: formData.get('last_name'),
            email: formData.get('email'),
            subject: formData.get('subject'),
            message: formData.get('message')
        };
        
        // Hide previous messages
        successDiv.style.display = 'none';
        errorDiv.style.display = 'none';
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = '<?php _e('Sending...', 'retail-trade-scanner'); ?>';
        submitBtn.disabled = true;
        
        // Submit form
        fetch('<?php echo esc_url(rest_url('retail-trade-scanner/v1/proxy/contact/submit')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
            },
            body: JSON.stringify(contactData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successDiv.style.display = 'block';
                form.reset();
            } else {
                errorDiv.textContent = data.message || '<?php _e('Failed to send message. Please try again.', 'retail-trade-scanner'); ?>';
                errorDiv.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Contact form error:', error);
            errorDiv.textContent = '<?php _e('An error occurred. Please try again later.', 'retail-trade-scanner'); ?>';
            errorDiv.style.display = 'block';
        })
        .finally(() => {
            // Reset button state
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
    });
});
</script>

<?php get_footer(); ?>