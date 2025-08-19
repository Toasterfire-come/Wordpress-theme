#!/usr/bin/env python3
"""
Comprehensive WordPress Theme Testing Suite
Retail Trade Scanner Theme - Bug Verification & Quality Assessment
"""

import os
import re
import json
import subprocess
import sys
from pathlib import Path
from typing import Dict, List, Tuple, Any

class WordPressThemeValidator:
    def __init__(self, theme_path: str):
        self.theme_path = Path(theme_path)
        self.results = {
            'syntax_validation': {},
            'functionality_tests': {},
            'integration_tests': {},
            'security_tests': {},
            'performance_tests': {},
            'accessibility_tests': {},
            'overall_score': 0,
            'issues_found': [],
            'recommendations': []
        }
        
    def run_comprehensive_test(self) -> Dict[str, Any]:
        """Run all test suites"""
        print("🔍 Starting Comprehensive WordPress Theme Testing...")
        print(f"📁 Theme Path: {self.theme_path}")
        
        # 1. Code Syntax Validation
        print("\n1️⃣ Running Syntax Validation Tests...")
        self.test_php_syntax()
        self.test_javascript_syntax()
        self.test_css_syntax()
        
        # 2. Functionality Testing
        print("\n2️⃣ Running Functionality Tests...")
        self.test_theme_structure()
        self.test_functions_php()
        self.test_javascript_functionality()
        
        # 3. Integration Testing
        print("\n3️⃣ Running Integration Tests...")
        self.test_wordpress_integration()
        self.test_rest_api_endpoints()
        
        # 4. Security Testing
        print("\n4️⃣ Running Security Tests...")
        self.test_security_vulnerabilities()
        self.test_input_validation()
        
        # 5. Performance Testing
        print("\n5️⃣ Running Performance Tests...")
        self.test_code_efficiency()
        
        # 6. Accessibility Testing
        print("\n6️⃣ Running Accessibility Tests...")
        self.test_accessibility_compliance()
        
        # Calculate overall score
        self.calculate_overall_score()
        
        return self.results
    
    def test_php_syntax(self):
        """Test PHP files for syntax errors"""
        php_files = list(self.theme_path.glob('**/*.php'))
        syntax_results = {'passed': 0, 'failed': 0, 'errors': []}
        
        for php_file in php_files:
            try:
                # Check PHP syntax
                result = subprocess.run(
                    ['php', '-l', str(php_file)], 
                    capture_output=True, 
                    text=True
                )
                
                if result.returncode == 0:
                    syntax_results['passed'] += 1
                else:
                    syntax_results['failed'] += 1
                    syntax_results['errors'].append({
                        'file': str(php_file.relative_to(self.theme_path)),
                        'error': result.stderr.strip()
                    })
                    
            except Exception as e:
                syntax_results['errors'].append({
                    'file': str(php_file.relative_to(self.theme_path)),
                    'error': f"Could not check syntax: {str(e)}"
                })
        
        self.results['syntax_validation']['php'] = syntax_results
        print(f"   ✅ PHP Syntax: {syntax_results['passed']} passed, {syntax_results['failed']} failed")
    
    def test_javascript_syntax(self):
        """Test JavaScript files for syntax errors"""
        js_files = list(self.theme_path.glob('**/*.js'))
        syntax_results = {'passed': 0, 'failed': 0, 'errors': [], 'warnings': []}
        
        for js_file in js_files:
            try:
                with open(js_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Basic syntax checks
                issues = self.check_js_syntax_issues(content, js_file)
                
                if issues:
                    syntax_results['failed'] += 1
                    syntax_results['errors'].extend(issues)
                else:
                    syntax_results['passed'] += 1
                    
            except Exception as e:
                syntax_results['errors'].append({
                    'file': str(js_file.relative_to(self.theme_path)),
                    'error': f"Could not read file: {str(e)}"
                })
        
        self.results['syntax_validation']['javascript'] = syntax_results
        print(f"   ✅ JavaScript Syntax: {syntax_results['passed']} passed, {syntax_results['failed']} failed")
    
    def check_js_syntax_issues(self, content: str, file_path: Path) -> List[Dict]:
        """Check JavaScript for common syntax issues"""
        issues = []
        lines = content.split('\n')
        
        for i, line in enumerate(lines, 1):
            # Check for unclosed brackets/parentheses
            if line.count('(') != line.count(')'):
                if '(' in line and ')' not in line:
                    issues.append({
                        'file': str(file_path.relative_to(self.theme_path)),
                        'line': i,
                        'error': 'Potentially unclosed parentheses'
                    })
            
            # Check for undefined variables (basic check)
            if re.search(r'\bundefined\b', line) and 'typeof' not in line:
                issues.append({
                    'file': str(file_path.relative_to(self.theme_path)),
                    'line': i,
                    'warning': 'Potential undefined variable usage'
                })
            
            # Check for console.log in production code
            if 'console.log' in line and 'debug' not in line.lower():
                issues.append({
                    'file': str(file_path.relative_to(self.theme_path)),
                    'line': i,
                    'warning': 'Console.log found - should be removed for production'
                })
        
        return issues
    
    def test_css_syntax(self):
        """Test CSS files for syntax errors"""
        css_files = list(self.theme_path.glob('**/*.css'))
        syntax_results = {'passed': 0, 'failed': 0, 'errors': [], 'warnings': []}
        
        for css_file in css_files:
            try:
                with open(css_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Basic CSS syntax checks
                issues = self.check_css_syntax_issues(content, css_file)
                
                if issues:
                    syntax_results['failed'] += 1
                    syntax_results['errors'].extend(issues)
                else:
                    syntax_results['passed'] += 1
                    
            except Exception as e:
                syntax_results['errors'].append({
                    'file': str(css_file.relative_to(self.theme_path)),
                    'error': f"Could not read file: {str(e)}"
                })
        
        self.results['syntax_validation']['css'] = syntax_results
        print(f"   ✅ CSS Syntax: {syntax_results['passed']} passed, {syntax_results['failed']} failed")
    
    def check_css_syntax_issues(self, content: str, file_path: Path) -> List[Dict]:
        """Check CSS for common syntax issues"""
        issues = []
        lines = content.split('\n')
        
        brace_count = 0
        for i, line in enumerate(lines, 1):
            brace_count += line.count('{') - line.count('}')
            
            # Check for missing semicolons
            if ':' in line and not line.strip().endswith((';', '{', '}')) and not line.strip().startswith(('/*', '*', '//')):
                if not re.search(r'@\w+', line):  # Skip @media, @keyframes, etc.
                    issues.append({
                        'file': str(file_path.relative_to(self.theme_path)),
                        'line': i,
                        'warning': 'Potentially missing semicolon'
                    })
        
        if brace_count != 0:
            issues.append({
                'file': str(file_path.relative_to(self.theme_path)),
                'error': f'Unmatched braces: {brace_count} unclosed'
            })
        
        return issues
    
    def test_theme_structure(self):
        """Test WordPress theme structure requirements"""
        required_files = [
            'style.css',
            'index.php',
            'functions.php'
        ]
        
        recommended_files = [
            'header.php',
            'footer.php',
            'single.php',
            'page.php',
            'archive.php',
            '404.php'
        ]
        
        structure_results = {
            'required_files': {'missing': [], 'present': []},
            'recommended_files': {'missing': [], 'present': []},
            'custom_templates': []
        }
        
        # Check required files
        for file in required_files:
            if (self.theme_path / file).exists():
                structure_results['required_files']['present'].append(file)
            else:
                structure_results['required_files']['missing'].append(file)
        
        # Check recommended files
        for file in recommended_files:
            if (self.theme_path / file).exists():
                structure_results['recommended_files']['present'].append(file)
            else:
                structure_results['recommended_files']['missing'].append(file)
        
        # Find custom page templates
        page_templates = list(self.theme_path.glob('page-*.php'))
        structure_results['custom_templates'] = [
            str(f.relative_to(self.theme_path)) for f in page_templates
        ]
        
        self.results['functionality_tests']['theme_structure'] = structure_results
        
        missing_required = len(structure_results['required_files']['missing'])
        print(f"   ✅ Theme Structure: {len(required_files) - missing_required}/{len(required_files)} required files present")
    
    def test_functions_php(self):
        """Test functions.php for WordPress best practices"""
        functions_file = self.theme_path / 'functions.php'
        
        if not functions_file.exists():
            self.results['functionality_tests']['functions_php'] = {
                'error': 'functions.php not found'
            }
            return
        
        with open(functions_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        functions_results = {
            'security_checks': [],
            'wordpress_hooks': [],
            'best_practices': [],
            'issues': []
        }
        
        # Security checks
        if 'wp_verify_nonce' in content:
            functions_results['security_checks'].append('Nonce verification implemented')
        else:
            functions_results['issues'].append('Missing nonce verification in AJAX handlers')
        
        if 'sanitize_' in content:
            functions_results['security_checks'].append('Input sanitization found')
        else:
            functions_results['issues'].append('Limited input sanitization detected')
        
        # WordPress hooks
        hooks = ['wp_enqueue_scripts', 'after_setup_theme', 'widgets_init']
        for hook in hooks:
            if hook in content:
                functions_results['wordpress_hooks'].append(f'{hook} hook used')
        
        # Best practices
        if 'add_theme_support' in content:
            functions_results['best_practices'].append('Theme support features added')
        
        if 'register_nav_menus' in content:
            functions_results['best_practices'].append('Navigation menus registered')
        
        self.results['functionality_tests']['functions_php'] = functions_results
        print(f"   ✅ Functions.php: {len(functions_results['security_checks'])} security features, {len(functions_results['issues'])} issues")
    
    def test_javascript_functionality(self):
        """Test JavaScript functionality and best practices"""
        js_files = list(self.theme_path.glob('**/*.js'))
        js_results = {
            'error_handling': 0,
            'api_integration': 0,
            'event_listeners': 0,
            'accessibility': 0,
            'issues': []
        }
        
        for js_file in js_files:
            try:
                with open(js_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Check for error handling
                if 'try' in content and 'catch' in content:
                    js_results['error_handling'] += 1
                
                # Check for API integration
                if 'fetch(' in content or 'XMLHttpRequest' in content:
                    js_results['api_integration'] += 1
                
                # Check for event listeners
                if 'addEventListener' in content:
                    js_results['event_listeners'] += 1
                
                # Check for accessibility features
                if 'aria-' in content or 'role=' in content:
                    js_results['accessibility'] += 1
                
            except Exception as e:
                js_results['issues'].append(f"Could not analyze {js_file.name}: {str(e)}")
        
        self.results['functionality_tests']['javascript'] = js_results
        print(f"   ✅ JavaScript: {js_results['error_handling']} files with error handling, {js_results['api_integration']} with API integration")
    
    def test_wordpress_integration(self):
        """Test WordPress integration features"""
        integration_results = {
            'hooks_and_filters': [],
            'custom_post_types': [],
            'rest_api': [],
            'user_management': [],
            'issues': []
        }
        
        # Check functions.php for WordPress integration
        functions_file = self.theme_path / 'functions.php'
        if functions_file.exists():
            with open(functions_file, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # WordPress hooks
            wp_hooks = ['add_action', 'add_filter', 'remove_action', 'remove_filter']
            for hook in wp_hooks:
                if hook in content:
                    integration_results['hooks_and_filters'].append(hook)
            
            # REST API
            if 'register_rest_route' in content:
                integration_results['rest_api'].append('Custom REST endpoints registered')
            
            # User management
            if 'wp_update_user' in content or 'update_user_meta' in content:
                integration_results['user_management'].append('User management functions implemented')
        
        self.results['integration_tests']['wordpress'] = integration_results
        print(f"   ✅ WordPress Integration: {len(integration_results['hooks_and_filters'])} hooks/filters, REST API: {'Yes' if integration_results['rest_api'] else 'No'}")
    
    def test_rest_api_endpoints(self):
        """Test REST API endpoint definitions"""
        functions_file = self.theme_path / 'functions.php'
        
        if not functions_file.exists():
            return
        
        with open(functions_file, 'r', encoding='utf-8') as f:
            content = f.read()
        
        api_results = {
            'endpoints_defined': [],
            'permission_checks': [],
            'error_handling': [],
            'issues': []
        }
        
        # Find REST route registrations
        rest_routes = re.findall(r"register_rest_route\([^)]+\)", content)
        api_results['endpoints_defined'] = rest_routes
        
        # Check for permission callbacks
        if 'permission_callback' in content:
            api_results['permission_checks'].append('Permission callbacks implemented')
        else:
            api_results['issues'].append('Missing permission callbacks for REST endpoints')
        
        # Check for error handling in API functions
        if 'WP_Error' in content:
            api_results['error_handling'].append('WP_Error handling implemented')
        
        self.results['integration_tests']['rest_api'] = api_results
        print(f"   ✅ REST API: {len(api_results['endpoints_defined'])} endpoints, {len(api_results['permission_checks'])} permission checks")
    
    def test_security_vulnerabilities(self):
        """Test for common security vulnerabilities"""
        security_results = {
            'sql_injection': [],
            'xss_protection': [],
            'csrf_protection': [],
            'input_validation': [],
            'vulnerabilities': []
        }
        
        php_files = list(self.theme_path.glob('**/*.php'))
        
        for php_file in php_files:
            try:
                with open(php_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Check for SQL injection protection
                if '$wpdb->prepare' in content:
                    security_results['sql_injection'].append(f'{php_file.name}: Uses prepared statements')
                elif '$wpdb->query' in content and '$wpdb->prepare' not in content:
                    security_results['vulnerabilities'].append(f'{php_file.name}: Potential SQL injection risk')
                
                # Check for XSS protection
                if 'esc_html' in content or 'esc_attr' in content:
                    security_results['xss_protection'].append(f'{php_file.name}: Output escaping implemented')
                
                # Check for CSRF protection
                if 'wp_verify_nonce' in content:
                    security_results['csrf_protection'].append(f'{php_file.name}: Nonce verification implemented')
                
                # Check for input validation
                if 'sanitize_' in content:
                    security_results['input_validation'].append(f'{php_file.name}: Input sanitization found')
                
            except Exception as e:
                security_results['vulnerabilities'].append(f"Could not analyze {php_file.name}: {str(e)}")
        
        self.results['security_tests'] = security_results
        print(f"   ✅ Security: {len(security_results['vulnerabilities'])} vulnerabilities, {len(security_results['csrf_protection'])} CSRF protections")
    
    def test_input_validation(self):
        """Test input validation and sanitization"""
        validation_results = {
            'sanitization_functions': [],
            'validation_functions': [],
            'missing_validation': []
        }
        
        functions_file = self.theme_path / 'functions.php'
        if functions_file.exists():
            with open(functions_file, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Find sanitization functions
            sanitize_functions = [
                'sanitize_text_field', 'sanitize_email', 'sanitize_url', 
                'sanitize_title', 'wp_kses_post', 'esc_html', 'esc_attr'
            ]
            
            for func in sanitize_functions:
                if func in content:
                    validation_results['sanitization_functions'].append(func)
            
            # Check for validation functions
            validation_functions = ['is_email', 'wp_verify_nonce', 'current_user_can']
            for func in validation_functions:
                if func in content:
                    validation_results['validation_functions'].append(func)
        
        self.results['security_tests']['input_validation'] = validation_results
        print(f"   ✅ Input Validation: {len(validation_results['sanitization_functions'])} sanitization functions")
    
    def test_code_efficiency(self):
        """Test code efficiency and performance"""
        performance_results = {
            'file_sizes': {},
            'optimization_issues': [],
            'best_practices': []
        }
        
        # Check file sizes
        for file_type in ['*.php', '*.js', '*.css']:
            files = list(self.theme_path.glob(f'**/{file_type}'))
            for file in files:
                size_kb = file.stat().st_size / 1024
                performance_results['file_sizes'][str(file.relative_to(self.theme_path))] = f"{size_kb:.1f}KB"
                
                if size_kb > 100:  # Files larger than 100KB
                    performance_results['optimization_issues'].append(
                        f"{file.name} is {size_kb:.1f}KB - consider optimization"
                    )
        
        # Check for performance best practices in functions.php
        functions_file = self.theme_path / 'functions.php'
        if functions_file.exists():
            with open(functions_file, 'r', encoding='utf-8') as f:
                content = f.read()
            
            if 'wp_enqueue_script' in content:
                performance_results['best_practices'].append('Scripts properly enqueued')
            
            if 'wp_enqueue_style' in content:
                performance_results['best_practices'].append('Styles properly enqueued')
        
        self.results['performance_tests'] = performance_results
        print(f"   ✅ Performance: {len(performance_results['optimization_issues'])} optimization issues, {len(performance_results['best_practices'])} best practices")
    
    def test_accessibility_compliance(self):
        """Test accessibility compliance"""
        accessibility_results = {
            'aria_labels': 0,
            'semantic_html': 0,
            'keyboard_navigation': 0,
            'color_contrast': [],
            'issues': []
        }
        
        # Check PHP templates for accessibility features
        php_files = list(self.theme_path.glob('**/*.php'))
        
        for php_file in php_files:
            try:
                with open(php_file, 'r', encoding='utf-8') as f:
                    content = f.read()
                
                # Check for ARIA labels
                if 'aria-' in content:
                    accessibility_results['aria_labels'] += content.count('aria-')
                
                # Check for semantic HTML
                semantic_tags = ['<nav', '<main', '<section', '<article', '<aside', '<header', '<footer']
                for tag in semantic_tags:
                    if tag in content:
                        accessibility_results['semantic_html'] += 1
                
                # Check for keyboard navigation
                if 'tabindex' in content or 'role=' in content:
                    accessibility_results['keyboard_navigation'] += 1
                
            except Exception as e:
                accessibility_results['issues'].append(f"Could not analyze {php_file.name}: {str(e)}")
        
        self.results['accessibility_tests'] = accessibility_results
        print(f"   ✅ Accessibility: {accessibility_results['aria_labels']} ARIA labels, {accessibility_results['semantic_html']} semantic elements")
    
    def calculate_overall_score(self):
        """Calculate overall theme quality score"""
        score = 0
        max_score = 100
        
        # Syntax validation (20 points)
        syntax_score = 0
        for test_type in ['php', 'javascript', 'css']:
            if test_type in self.results['syntax_validation']:
                test_results = self.results['syntax_validation'][test_type]
                if test_results['failed'] == 0:
                    syntax_score += 7
                elif test_results['passed'] > test_results['failed']:
                    syntax_score += 3
        score += min(syntax_score, 20)
        
        # Functionality (25 points)
        functionality_score = 0
        if 'theme_structure' in self.results['functionality_tests']:
            structure = self.results['functionality_tests']['theme_structure']
            if not structure['required_files']['missing']:
                functionality_score += 10
        
        if 'functions_php' in self.results['functionality_tests']:
            functions = self.results['functionality_tests']['functions_php']
            if 'error' not in functions:
                functionality_score += 10
                if len(functions.get('issues', [])) == 0:
                    functionality_score += 5
        score += min(functionality_score, 25)
        
        # Security (25 points)
        security_score = 0
        if 'vulnerabilities' in self.results['security_tests']:
            vulns = len(self.results['security_tests']['vulnerabilities'])
            if vulns == 0:
                security_score += 15
            elif vulns < 3:
                security_score += 10
            else:
                security_score += 5
        
        if 'csrf_protection' in self.results['security_tests']:
            csrf = len(self.results['security_tests']['csrf_protection'])
            if csrf > 0:
                security_score += 10
        score += min(security_score, 25)
        
        # Integration (15 points)
        integration_score = 0
        if 'wordpress' in self.results['integration_tests']:
            wp_integration = self.results['integration_tests']['wordpress']
            if wp_integration['hooks_and_filters']:
                integration_score += 8
            if wp_integration['rest_api']:
                integration_score += 7
        score += min(integration_score, 15)
        
        # Performance & Accessibility (15 points)
        perf_acc_score = 0
        if 'optimization_issues' in self.results['performance_tests']:
            issues = len(self.results['performance_tests']['optimization_issues'])
            if issues == 0:
                perf_acc_score += 8
            elif issues < 3:
                perf_acc_score += 5
        
        if 'aria_labels' in self.results['accessibility_tests']:
            aria_count = self.results['accessibility_tests']['aria_labels']
            if aria_count > 10:
                perf_acc_score += 7
            elif aria_count > 5:
                perf_acc_score += 4
        score += min(perf_acc_score, 15)
        
        self.results['overall_score'] = score
        
        # Generate recommendations
        self.generate_recommendations()
        
        print(f"\n🎯 Overall Theme Quality Score: {score}/{max_score} ({score}%)")
    
    def generate_recommendations(self):
        """Generate recommendations based on test results"""
        recommendations = []
        
        # Syntax issues
        for test_type in ['php', 'javascript', 'css']:
            if test_type in self.results['syntax_validation']:
                if self.results['syntax_validation'][test_type]['failed'] > 0:
                    recommendations.append(f"Fix {test_type.upper()} syntax errors before deployment")
        
        # Security issues
        if len(self.results['security_tests'].get('vulnerabilities', [])) > 0:
            recommendations.append("Address security vulnerabilities immediately")
        
        # Performance issues
        if len(self.results['performance_tests'].get('optimization_issues', [])) > 0:
            recommendations.append("Optimize large files for better performance")
        
        # Accessibility improvements
        if self.results['accessibility_tests'].get('aria_labels', 0) < 5:
            recommendations.append("Add more ARIA labels for better accessibility")
        
        self.results['recommendations'] = recommendations
    
    def generate_report(self) -> str:
        """Generate a comprehensive test report"""
        report = []
        report.append("=" * 80)
        report.append("WORDPRESS THEME TESTING REPORT")
        report.append("Retail Trade Scanner Theme - Bug Verification")
        report.append("=" * 80)
        
        # Overall Score
        score = self.results['overall_score']
        status = "EXCELLENT" if score >= 90 else "GOOD" if score >= 75 else "NEEDS IMPROVEMENT" if score >= 60 else "CRITICAL ISSUES"
        report.append(f"\n🎯 OVERALL SCORE: {score}/100 ({status})")
        
        # Syntax Validation Results
        report.append(f"\n📝 SYNTAX VALIDATION:")
        for test_type, results in self.results['syntax_validation'].items():
            report.append(f"   {test_type.upper()}: {results['passed']} passed, {results['failed']} failed")
            if results['errors']:
                for error in results['errors'][:3]:  # Show first 3 errors
                    report.append(f"      ❌ {error['file']}: {error.get('error', error.get('warning', 'Unknown issue'))}")
        
        # Security Results
        report.append(f"\n🔒 SECURITY ASSESSMENT:")
        security = self.results['security_tests']
        report.append(f"   Vulnerabilities Found: {len(security.get('vulnerabilities', []))}")
        report.append(f"   CSRF Protection: {len(security.get('csrf_protection', []))} files")
        report.append(f"   XSS Protection: {len(security.get('xss_protection', []))} files")
        
        # Integration Results
        report.append(f"\n🔗 WORDPRESS INTEGRATION:")
        if 'wordpress' in self.results['integration_tests']:
            wp = self.results['integration_tests']['wordpress']
            report.append(f"   WordPress Hooks: {len(wp.get('hooks_and_filters', []))}")
            report.append(f"   REST API: {'Implemented' if wp.get('rest_api') else 'Not Found'}")
            report.append(f"   User Management: {'Implemented' if wp.get('user_management') else 'Not Found'}")
        
        # Recommendations
        if self.results['recommendations']:
            report.append(f"\n💡 RECOMMENDATIONS:")
            for i, rec in enumerate(self.results['recommendations'], 1):
                report.append(f"   {i}. {rec}")
        
        # Production Readiness
        report.append(f"\n🚀 PRODUCTION READINESS:")
        if score >= 85:
            report.append("   ✅ READY FOR PRODUCTION")
            report.append("   Theme meets high quality standards and security requirements.")
        elif score >= 70:
            report.append("   ⚠️  READY WITH MINOR FIXES")
            report.append("   Address recommendations before production deployment.")
        else:
            report.append("   ❌ NOT READY FOR PRODUCTION")
            report.append("   Critical issues must be resolved before deployment.")
        
        report.append("\n" + "=" * 80)
        
        return "\n".join(report)

def main():
    """Main function to run the theme validation"""
    theme_path = "/app/Wordpress-theme/retail-trade-scanner-theme-updated"
    
    if not os.path.exists(theme_path):
        print(f"❌ Theme path not found: {theme_path}")
        return 1
    
    # Initialize validator
    validator = WordPressThemeValidator(theme_path)
    
    # Run comprehensive tests
    results = validator.run_comprehensive_test()
    
    # Generate and display report
    report = validator.generate_report()
    print("\n" + report)
    
    # Save results to file
    results_file = "/app/wordpress_theme_test_results.json"
    with open(results_file, 'w') as f:
        json.dump(results, f, indent=2, default=str)
    
    report_file = "/app/wordpress_theme_test_report.txt"
    with open(report_file, 'w') as f:
        f.write(report)
    
    print(f"\n📄 Detailed results saved to: {results_file}")
    print(f"📄 Report saved to: {report_file}")
    
    # Return exit code based on score
    score = results['overall_score']
    if score >= 70:
        return 0  # Success
    else:
        return 1  # Issues found

if __name__ == "__main__":
    sys.exit(main())