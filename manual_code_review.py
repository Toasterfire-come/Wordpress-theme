#!/usr/bin/env python3
"""
Manual Code Review for WordPress Theme
Focus on real issues, not false positives
"""

import os
import re
from pathlib import Path

def check_php_functions_file():
    """Manual review of functions.php for real issues"""
    functions_file = Path("/app/Wordpress-theme/retail-trade-scanner-theme-updated/functions.php")
    
    print("🔍 Manual Review: functions.php")
    
    if not functions_file.exists():
        print("   ❌ functions.php not found")
        return
    
    with open(functions_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    issues = []
    good_practices = []
    
    # Check for proper PHP opening tag
    if not content.startswith('<?php'):
        issues.append("Missing proper PHP opening tag")
    else:
        good_practices.append("Proper PHP opening tag")
    
    # Check for direct access protection
    if 'ABSPATH' in content and 'exit' in content:
        good_practices.append("Direct access protection implemented")
    else:
        issues.append("Missing direct access protection")
    
    # Check for proper nonce verification in AJAX handlers
    ajax_functions = re.findall(r'function\s+(\w+).*?wp_ajax', content, re.DOTALL)
    nonce_checks = content.count('wp_verify_nonce')
    
    if ajax_functions and nonce_checks > 0:
        good_practices.append(f"AJAX handlers with nonce verification ({nonce_checks} checks)")
    elif ajax_functions:
        issues.append("AJAX handlers found but insufficient nonce verification")
    
    # Check for input sanitization
    sanitize_functions = ['sanitize_text_field', 'sanitize_email', 'esc_html', 'esc_attr', 'wp_kses_post']
    found_sanitization = [func for func in sanitize_functions if func in content]
    
    if len(found_sanitization) >= 3:
        good_practices.append(f"Good input sanitization ({len(found_sanitization)} functions used)")
    else:
        issues.append("Insufficient input sanitization")
    
    # Check for proper WordPress hooks
    required_hooks = ['wp_enqueue_scripts', 'after_setup_theme']
    missing_hooks = [hook for hook in required_hooks if hook not in content]
    
    if not missing_hooks:
        good_practices.append("All required WordPress hooks implemented")
    else:
        issues.append(f"Missing WordPress hooks: {', '.join(missing_hooks)}")
    
    # Check for theme support features
    theme_supports = ['title-tag', 'post-thumbnails', 'html5', 'custom-logo']
    found_supports = [support for support in theme_supports if support in content]
    
    if len(found_supports) >= 3:
        good_practices.append(f"Good theme support features ({len(found_supports)} features)")
    
    # Check for potential security issues
    if '$_POST' in content or '$_GET' in content:
        # Check if they're properly sanitized
        if 'sanitize_' not in content:
            issues.append("Direct $_POST/$_GET usage without sanitization")
        else:
            good_practices.append("Superglobal usage with sanitization")
    
    print(f"   ✅ Good Practices: {len(good_practices)}")
    for practice in good_practices:
        print(f"      • {practice}")
    
    if issues:
        print(f"   ⚠️  Issues Found: {len(issues)}")
        for issue in issues:
            print(f"      • {issue}")
    else:
        print("   ✅ No critical issues found")
    
    return len(issues) == 0

def check_javascript_files():
    """Manual review of JavaScript files"""
    js_dir = Path("/app/Wordpress-theme/retail-trade-scanner-theme-updated/assets/js")
    
    print("\n🔍 Manual Review: JavaScript Files")
    
    if not js_dir.exists():
        print("   ❌ JavaScript directory not found")
        return False
    
    js_files = list(js_dir.glob("*.js"))
    total_issues = 0
    
    for js_file in js_files:
        print(f"\n   📄 {js_file.name}")
        
        with open(js_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        issues = []
        good_practices = []
        
        # Check for proper error handling
        if 'try' in content and 'catch' in content:
            good_practices.append("Error handling implemented")
        
        # Check for proper event listener cleanup
        if 'addEventListener' in content:
            good_practices.append("Event listeners used")
            if 'removeEventListener' in content:
                good_practices.append("Event listener cleanup implemented")
        
        # Check for proper API error handling
        if 'fetch(' in content:
            good_practices.append("Modern fetch API used")
            if '.catch(' in content:
                good_practices.append("API error handling implemented")
        
        # Check for accessibility features
        if 'aria-' in content or 'role=' in content:
            good_practices.append("Accessibility features implemented")
        
        # Check for potential issues
        if 'eval(' in content:
            issues.append("Dangerous eval() function used")
        
        if 'innerHTML' in content and 'sanitize' not in content.lower():
            issues.append("Potential XSS risk with innerHTML usage")
        
        # Check for console.log in production code (not in debug mode)
        console_logs = content.count('console.log')
        if console_logs > 0 and 'debug' not in content.lower():
            issues.append(f"{console_logs} console.log statements (should be removed for production)")
        
        # Check for proper variable declarations
        if re.search(r'\b\w+\s*=\s*[^=]', content) and 'var ' not in content and 'let ' not in content and 'const ' not in content:
            # This is a very basic check - might have false positives
            pass
        
        print(f"      ✅ Good Practices: {len(good_practices)}")
        for practice in good_practices:
            print(f"         • {practice}")
        
        if issues:
            print(f"      ⚠️  Issues: {len(issues)}")
            for issue in issues:
                print(f"         • {issue}")
            total_issues += len(issues)
        else:
            print("      ✅ No critical issues found")
    
    return total_issues == 0

def check_css_file():
    """Manual review of CSS file"""
    css_file = Path("/app/Wordpress-theme/retail-trade-scanner-theme-updated/style.css")
    
    print("\n🔍 Manual Review: CSS File")
    
    if not css_file.exists():
        print("   ❌ style.css not found")
        return False
    
    with open(css_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    issues = []
    good_practices = []
    
    # Check for proper theme header
    if 'Theme Name:' in content and 'Version:' in content:
        good_practices.append("Proper WordPress theme header")
    else:
        issues.append("Missing or incomplete theme header")
    
    # Check for CSS variables (modern approach)
    if ':root' in content and '--' in content:
        good_practices.append("CSS custom properties (variables) used")
    
    # Check for responsive design
    if '@media' in content:
        media_queries = content.count('@media')
        good_practices.append(f"Responsive design with {media_queries} media queries")
    else:
        issues.append("No responsive design media queries found")
    
    # Check for accessibility features
    if ':focus' in content:
        good_practices.append("Focus styles for accessibility")
    else:
        issues.append("Missing focus styles for accessibility")
    
    # Check for potential issues
    if '!important' in content:
        important_count = content.count('!important')
        if important_count > 10:
            issues.append(f"Excessive use of !important ({important_count} instances)")
    
    # Check for vendor prefixes (might indicate older code)
    vendor_prefixes = ['-webkit-', '-moz-', '-ms-', '-o-']
    prefix_count = sum(content.count(prefix) for prefix in vendor_prefixes)
    if prefix_count > 0:
        good_practices.append(f"Vendor prefixes for browser compatibility ({prefix_count} instances)")
    
    print(f"   ✅ Good Practices: {len(good_practices)}")
    for practice in good_practices:
        print(f"      • {practice}")
    
    if issues:
        print(f"   ⚠️  Issues: {len(issues)}")
        for issue in issues:
            print(f"      • {issue}")
    else:
        print("   ✅ No critical issues found")
    
    return len(issues) == 0

def check_template_files():
    """Check key template files for WordPress best practices"""
    theme_dir = Path("/app/Wordpress-theme/retail-trade-scanner-theme-updated")
    
    print("\n🔍 Manual Review: Template Files")
    
    key_templates = ['header.php', 'footer.php', 'index.php', 'page.php']
    issues = []
    good_practices = []
    
    for template in key_templates:
        template_file = theme_dir / template
        
        if not template_file.exists():
            issues.append(f"Missing {template}")
            continue
        
        with open(template_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Check for proper WordPress functions
        if template == 'header.php':
            if 'wp_head()' in content:
                good_practices.append("wp_head() properly called in header.php")
            else:
                issues.append("Missing wp_head() in header.php")
        
        if template == 'footer.php':
            if 'wp_footer()' in content:
                good_practices.append("wp_footer() properly called in footer.php")
            else:
                issues.append("Missing wp_footer() in footer.php")
        
        # Check for proper escaping
        if 'echo' in content or 'print' in content:
            if 'esc_' in content or 'wp_kses' in content:
                good_practices.append(f"Output escaping used in {template}")
            else:
                issues.append(f"Potential XSS risk in {template} - missing output escaping")
    
    print(f"   ✅ Good Practices: {len(good_practices)}")
    for practice in good_practices:
        print(f"      • {practice}")
    
    if issues:
        print(f"   ⚠️  Issues: {len(issues)}")
        for issue in issues:
            print(f"      • {issue}")
    else:
        print("   ✅ No critical issues found")
    
    return len(issues) == 0

def main():
    """Run manual code review"""
    print("🔍 MANUAL CODE REVIEW - WordPress Theme")
    print("=" * 60)
    
    results = []
    
    # Check each component
    results.append(check_php_functions_file())
    results.append(check_javascript_files())
    results.append(check_css_file())
    results.append(check_template_files())
    
    # Summary
    print("\n" + "=" * 60)
    print("📊 MANUAL REVIEW SUMMARY")
    print("=" * 60)
    
    passed = sum(results)
    total = len(results)
    
    print(f"Components Reviewed: {total}")
    print(f"Components Passed: {passed}")
    print(f"Components with Issues: {total - passed}")
    
    if passed == total:
        print("\n✅ MANUAL REVIEW: PASSED")
        print("Theme code quality is good with no critical issues found.")
    elif passed >= total * 0.75:
        print("\n⚠️  MANUAL REVIEW: PASSED WITH WARNINGS")
        print("Theme has minor issues that should be addressed.")
    else:
        print("\n❌ MANUAL REVIEW: FAILED")
        print("Theme has significant issues that must be fixed.")
    
    return passed == total

if __name__ == "__main__":
    main()