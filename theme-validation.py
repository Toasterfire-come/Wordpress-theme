#!/usr/bin/env python3
"""
WordPress Theme Validation Script
Validates the updated Retail Trade Scanner theme with PayPal integration
"""

import os
import re

def check_file_exists(file_path):
    """Check if a file exists and return its size"""
    if os.path.exists(file_path):
        size = os.path.getsize(file_path)
        return True, size
    return False, 0

def check_content_in_file(file_path, patterns):
    """Check if specific patterns exist in a file"""
    if not os.path.exists(file_path):
        return False, []
    
    found_patterns = []
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            content = f.read()
            for pattern in patterns:
                if pattern in content:
                    found_patterns.append(pattern)
    except:
        pass
    
    return len(found_patterns) == len(patterns), found_patterns

def main():
    theme_path = '/app/retail-trade-scanner-theme-updated'
    
    print("🔍 WordPress Theme Validation Report")
    print("=" * 50)
    print(f"Theme Path: {theme_path}")
    print()
    
    # Check core files
    core_files = [
        'functions.php',
        'style.css', 
        'page-premium-plans.php',
        'page-billing-history.php',
        'header.php',
        'footer.php',
        'README.md'
    ]
    
    print("📁 Core Theme Files:")
    for file in core_files:
        file_path = os.path.join(theme_path, file)
        exists, size = check_file_exists(file_path)
        status = "✅" if exists else "❌"
        print(f"  {status} {file} ({size} bytes)")
    print()
    
    # Check PayPal integration in functions.php
    functions_path = os.path.join(theme_path, 'functions.php')
    paypal_patterns = [
        'paypal/create-order',
        'paypal/capture-order', 
        'paypal_client_id',
        'retail_trade_scanner_create_paypal_order',
        'retail_trade_scanner_capture_paypal_order'
    ]
    
    print("💳 PayPal Integration Check (functions.php):")
    has_paypal, found = check_content_in_file(functions_path, paypal_patterns)
    for pattern in paypal_patterns:
        status = "✅" if pattern in found else "❌"
        print(f"  {status} {pattern}")
    print()
    
    # Check API URL updates
    api_patterns = [
        'api.retailtradescanner.com',
        'RETAIL_TRADE_SCANNER_API_URL'
    ]
    
    print("🌐 API URL Configuration:")
    has_api, found_api = check_content_in_file(functions_path, api_patterns)
    for pattern in api_patterns:
        status = "✅" if pattern in found_api else "❌" 
        print(f"  {status} {pattern}")
    print()
    
    # Check premium plans page
    plans_path = os.path.join(theme_path, 'page-premium-plans.php')
    plans_patterns = [
        'paypal-basic-button',
        'paypal-pro-button',
        'createPayPalOrder',
        'capturePayPalOrder'
    ]
    
    print("💰 Premium Plans PayPal Integration:")
    has_plans, found_plans = check_content_in_file(plans_path, plans_patterns)
    for pattern in plans_patterns:
        status = "✅" if pattern in found_plans else "❌"
        print(f"  {status} {pattern}")
    print()
    
    # Check CSS enhancements
    css_path = os.path.join(theme_path, 'style.css')
    css_patterns = [
        '--paypal-blue',
        'paypal-container',
        'Version: 2.0.0',
        'notification'
    ]
    
    print("🎨 CSS Enhancements:")
    has_css, found_css = check_content_in_file(css_path, css_patterns)
    for pattern in css_patterns:
        status = "✅" if pattern in found_css else "❌"
        print(f"  {status} {pattern}")
    print()
    
    # Overall assessment
    print("📊 Overall Assessment:")
    total_checks = len(paypal_patterns) + len(api_patterns) + len(plans_patterns) + len(css_patterns)
    passed_checks = len(found) + len(found_api) + len(found_plans) + len(found_css)
    
    success_rate = (passed_checks / total_checks) * 100
    print(f"  ✅ Checks Passed: {passed_checks}/{total_checks} ({success_rate:.1f}%)")
    
    if success_rate >= 90:
        print("  🎉 Theme integration is EXCELLENT!")
    elif success_rate >= 70:
        print("  ✅ Theme integration is GOOD")
    else:
        print("  ⚠️ Theme integration needs improvement")
    
    print()
    print("🚀 Theme Update Summary:")
    print(f"  • PayPal Integration: {'✅ Complete' if has_paypal else '❌ Missing'}")
    print(f"  • API URL Updated: {'✅ Updated' if has_api else '❌ Not Updated'}")
    print(f"  • Premium Plans: {'✅ Enhanced' if has_plans else '❌ Not Enhanced'}")
    print(f"  • CSS Modern: {'✅ Updated' if has_css else '❌ Not Updated'}")
    
if __name__ == "__main__":
    main()