#!/usr/bin/env python3
"""
WordPress Theme Pages Testing Script
Tests the StockScan Pro WordPress theme pages by creating static HTML versions
and testing their functionality, forms, and responsiveness.
"""

import os
import sys
import time
import json
from pathlib import Path

def create_static_test_page(template_path, page_name, output_dir):
    """Create a static HTML version of a WordPress template for testing"""
    
    # Read the PHP template
    with open(template_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Read the theme's CSS
    css_path = '/app/Wordpress-theme/stock-scanner-theme/style.css'
    with open(css_path, 'r', encoding='utf-8') as f:
        css_content = f.read()
    
    # Read header and footer
    header_path = '/app/Wordpress-theme/stock-scanner-theme/header.php'
    footer_path = '/app/Wordpress-theme/stock-scanner-theme/footer.php'
    
    with open(header_path, 'r', encoding='utf-8') as f:
        header_content = f.read()
    
    with open(footer_path, 'r', encoding='utf-8') as f:
        footer_content = f.read()
    
    # Simple PHP to HTML conversion for testing
    # Remove PHP tags and replace with static content
    content = content.replace('<?php get_header(); ?>', '')
    content = content.replace('<?php get_footer(); ?>', '')
    content = content.replace('<?php echo home_url(\'/dashboard\'); ?>', '/dashboard')
    content = content.replace('<?php echo home_url(\'/contact\'); ?>', '/contact')
    content = content.replace('<?php echo home_url(\'/security\'); ?>', '/security')
    content = content.replace('<?php echo home_url(\'/accessibility\'); ?>', '/accessibility')
    content = content.replace('<?php echo home_url(\'/paypal-checkout\'); ?>', '/paypal-checkout')
    content = content.replace('<?php echo home_url(\'/payment-success\'); ?>', '/payment-success')
    content = content.replace('<?php echo home_url(\'/payment-cancelled\'); ?>', '/payment-cancelled')
    content = content.replace('<?php echo home_url(\'/premium-plans\'); ?>', '/premium-plans')
    content = content.replace('<?php echo home_url(\'/help-center\'); ?>', '/help-center')
    content = content.replace('<?php echo home_url(\'/faq\'); ?>', '/faq')
    content = content.replace('<?php echo home_url(\'/status\'); ?>', '/status')
    content = content.replace('<?php echo home_url(\'/terms\'); ?>', '/terms')
    content = content.replace('<?php echo home_url(\'/privacy\'); ?>', '/privacy')
    content = content.replace('<?php echo home_url(\'/getting-started\'); ?>', '/getting-started')
    content = content.replace('<?php echo home_url(\'/watchlist\'); ?>', '/watchlist')
    content = content.replace('<?php echo home_url(\'/user-settings\'); ?>', '/user-settings')
    content = content.replace('<?php echo home_url(\'/signup\'); ?>', '/signup')
    content = content.replace('<?php echo home_url(); ?>', '/')
    content = content.replace('<?php echo admin_url("admin-ajax.php"); ?>', '/wp-admin/admin-ajax.php')
    content = content.replace('<?php echo wp_create_nonce("stockscan_nonce"); ?>', 'test_nonce_123')
    content = content.replace('<?php echo date(\'Y\'); ?>', '2024')
    
    # Create basic HTML structure
    html_content = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{page_name} - StockScan Pro</title>
    <style>
    {css_content}
    
    /* Additional test styles */
    .test-mode {{
        position: fixed;
        top: 10px;
        right: 10px;
        background: #ff6b6b;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        z-index: 9999;
    }}
    
    /* Form testing styles */
    .form-success {{
        background: #d4edda;
        color: #155724;
        padding: 1rem;
        border-radius: 0.25rem;
        margin: 1rem 0;
        border: 1px solid #c3e6cb;
    }}
    
    .form-error {{
        background: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border-radius: 0.25rem;
        margin: 1rem 0;
        border: 1px solid #f5c6cb;
    }}
    </style>
</head>
<body class="no-sidebar">
    <div class="test-mode">TEST MODE</div>
    
    <div class="app-container">
        <div class="main-content-area">
            <header class="site-header">
                <div class="header-content">
                    <div class="header-main">
                        <div class="header-left">
                            <a href="/" class="logo">
                                <div class="logo-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                        <polyline points="17 6 23 6 23 12"/>
                                    </svg>
                                </div>
                                <div class="logo-text">
                                    <h1>StockScan Pro</h1>
                                    <p>Professional Stock Analysis</p>
                                </div>
                            </a>
                        </div>
                        <div class="header-actions">
                            <div class="market-status">
                                <div class="market-label">S&P 500</div>
                                <div class="market-value">
                                    <span style="color: var(--emerald-400); font-weight: 500; font-size: 0.875rem;">+0.52%</span>
                                    <span class="live-badge">LIVE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="full-nav">
                        <ul class="nav-list">
                            <li class="nav-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="nav-item"><a href="/market-overview">Markets</a></li>
                            <li class="nav-item"><a href="/stock-scanner">Scanner</a></li>
                            <li class="nav-item"><a href="/watchlist">Watchlist</a></li>
                            <li class="nav-item"><a href="/news">News</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
            
            <main class="main-content">
                <div class="page-content">
                    {content}
                </div>
            </main>
        </div>
    </div>
    
    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div>
                    <a href="/" class="footer-brand">
                        <div class="footer-brand-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/>
                                <polyline points="17 6 23 6 23 12"/>
                            </svg>
                        </div>
                        <div class="footer-brand-text">
                            <h3>StockScan Pro</h3>
                            <p>Professional Stock Analysis</p>
                        </div>
                    </a>
                    <p class="footer-description">
                        Advanced stock scanning and market analysis tools for professional traders and investors.
                    </p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="/dashboard">Dashboard</a></li>
                        <li><a href="/stock-scanner">Stock Scanner</a></li>
                        <li><a href="/market-overview">Market Overview</a></li>
                        <li><a href="/watchlist">Watchlist</a></li>
                        <li><a href="/news">Market News</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Legal</h4>
                    <ul class="footer-links">
                        <li><a href="/terms">Terms of Service</a></li>
                        <li><a href="/privacy">Privacy Policy</a></li>
                        <li><a href="/security">Security</a></li>
                        <li><a href="/accessibility">Accessibility</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-copyright">
                    © 2024 StockScan Pro. All rights reserved. Market data provided by third-party sources.
                </div>
            </div>
        </div>
    </footer>
    
    <script>
    // Test mode JavaScript for form handling
    document.addEventListener('DOMContentLoaded', function() {{
        console.log('Testing {page_name} page');
        
        // Mock AJAX form submissions for testing
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {{
            form.addEventListener('submit', function(e) {{
                e.preventDefault();
                console.log('Form submitted:', form.id || 'unnamed form');
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'form-success';
                successDiv.textContent = 'Form submitted successfully (TEST MODE)';
                form.insertBefore(successDiv, form.firstChild);
                
                // Remove success message after 3 seconds
                setTimeout(() => {{
                    successDiv.remove();
                }}, 3000);
            }});
        }});
        
        // Test accessibility controls
        const accessibilityControls = document.querySelectorAll('.accessibility-control');
        accessibilityControls.forEach(control => {{
            control.addEventListener('click', function() {{
                console.log('Accessibility control clicked:', this.textContent);
            }});
        }});
        
        // Test payment buttons
        const paymentButtons = document.querySelectorAll('#paypal-button-container button, .btn');
        paymentButtons.forEach(button => {{
            if (button.type !== 'submit') {{
                button.addEventListener('click', function(e) {{
                    if (this.textContent.includes('PayPal') || this.textContent.includes('Payment')) {{
                        e.preventDefault();
                        console.log('Payment button clicked:', this.textContent);
                        alert('Payment functionality would work in live environment');
                    }}
                }});
            }}
        }});
    }});
    </script>
</body>
</html>"""
    
    # Write the HTML file
    output_path = os.path.join(output_dir, f"{page_name}.html")
    with open(output_path, 'w', encoding='utf-8') as f:
        f.write(html_content)
    
    return output_path

def main():
    """Main testing function"""
    print("🧪 WordPress Theme Testing - StockScan Pro")
    print("=" * 50)
    
    # Create output directory
    output_dir = '/app/test_pages'
    os.makedirs(output_dir, exist_ok=True)
    
    # Pages to test (as specified in the review request)
    pages_to_test = [
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-security.php',
            'name': 'security',
            'title': 'Security Page'
        },
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-accessibility.php',
            'name': 'accessibility',
            'title': 'Accessibility Page'
        },
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-contact.php',
            'name': 'contact',
            'title': 'Contact Page'
        },
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-paypal-checkout.php',
            'name': 'paypal-checkout',
            'title': 'PayPal Checkout Page'
        },
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-payment-success.php',
            'name': 'payment-success',
            'title': 'Payment Success Page'
        },
        {
            'template': '/app/Wordpress-theme/stock-scanner-theme/page-templates/page-payment-cancelled.php',
            'name': 'payment-cancelled',
            'title': 'Payment Cancelled Page'
        }
    ]
    
    created_pages = []
    
    # Create static test pages
    print("\n📄 Creating static test pages...")
    for page in pages_to_test:
        try:
            output_path = create_static_test_page(page['template'], page['name'], output_dir)
            created_pages.append({
                'name': page['name'],
                'title': page['title'],
                'path': output_path
            })
            print(f"✅ Created: {page['title']} -> {output_path}")
        except Exception as e:
            print(f"❌ Failed to create {page['title']}: {str(e)}")
    
    # Create index page for easy navigation
    index_content = f"""<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockScan Pro - Test Pages</title>
    <style>
        body {{ font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; margin: 2rem; }}
        .container {{ max-width: 800px; margin: 0 auto; }}
        .page-list {{ list-style: none; padding: 0; }}
        .page-item {{ margin: 1rem 0; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; }}
        .page-link {{ text-decoration: none; color: #059669; font-weight: 600; }}
        .page-link:hover {{ text-decoration: underline; }}
        .test-info {{ background: #f0f9ff; padding: 1rem; border-radius: 0.5rem; margin: 1rem 0; }}
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 StockScan Pro - WordPress Theme Test Pages</h1>
        
        <div class="test-info">
            <h3>Testing Information</h3>
            <p>These are static HTML versions of the WordPress theme pages for testing purposes.</p>
            <p><strong>Features to test:</strong></p>
            <ul>
                <li>Form submissions (will show success messages)</li>
                <li>Responsive design on different screen sizes</li>
                <li>Interactive elements (buttons, modals, etc.)</li>
                <li>Accessibility features</li>
                <li>CSS styling and layout</li>
            </ul>
        </div>
        
        <h2>Available Test Pages</h2>
        <ul class="page-list">
"""
    
    for page in created_pages:
        index_content += f"""
            <li class="page-item">
                <a href="{page['name']}.html" class="page-link">{page['title']}</a>
                <p>Test the {page['title'].lower()} functionality, forms, and responsive design.</p>
            </li>
"""
    
    index_content += """
        </ul>
        
        <div class="test-info">
            <h3>Testing Instructions</h3>
            <ol>
                <li>Open each page in a browser</li>
                <li>Test form submissions (they will show success messages)</li>
                <li>Resize browser window to test responsiveness</li>
                <li>Check accessibility features (font size, high contrast, etc.)</li>
                <li>Verify all interactive elements work</li>
            </ol>
        </div>
    </div>
</body>
</html>"""
    
    index_path = os.path.join(output_dir, 'index.html')
    with open(index_path, 'w', encoding='utf-8') as f:
        f.write(index_content)
    
    print(f"\n📋 Created index page: {index_path}")
    print(f"\n🎯 Test Results Summary:")
    print(f"   • Created {len(created_pages)} test pages")
    print(f"   • Output directory: {output_dir}")
    print(f"   • Index page: {index_path}")
    
    return created_pages

if __name__ == "__main__":
    main()