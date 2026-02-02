# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | ✅                 |
| < 1.0   | ❌                |

## Reporting a Vulnerability

We take security seriously. If you discover a security vulnerability, please follow these steps:

### 🚨 Immediate Action
- **DO NOT** open a public issue
- **DO NOT** disclose the vulnerability publicly until it has been addressed

### 📧 Reporting Process
1. **Email**: Send details to [sakshamguptaqaz@gamil.com]
2. **Subject**: "Security Vulnerability Report - Event Registration Module"
3. **Include**:
   - Type of vulnerability
   - Location in code where vulnerability exists
   - Steps to reproduce
   - Potential impact
   - Possible solutions (if any)

### ⏰ Response Timeline
- **Acknowledgment**: Within 48 hours
- **Initial Assessment**: Within 1 week
- **Fix Timeline**: Within 2-4 weeks (depending on severity)
- **Public Disclosure**: After patch release

### 🏷️ Severity Levels

| Level | Description | Response Time |
|-------|-------------|---------------|
| Critical | Remote code execution, data breach | 24-48 hours |
| High | Privilege escalation, XSS | 1-2 weeks |
| Medium | Information disclosure | 2-4 weeks |
| Low | Minor issues | 1 month |

### 🛡️ Security Best Practices

#### For Users:
- Keep the module updated to the latest version
- Apply Drupal core security patches regularly
- Use strong passwords and proper user permissions
- Regularly backup your site
- Monitor access logs for suspicious activity

#### For Developers:
- Follow Drupal security guidelines
- Sanitize all user inputs
- Use Drupal's form API for validation
- Implement proper access controls
- Regular security code reviews

### 📋 Vulnerability Types We Care About

- **SQL Injection**
- **Cross-Site Scripting (XSS)**
- **Cross-Site Request Forgery (CSRF)**
- **Remote Code Execution**
- **Information Disclosure**
- **Authentication Bypass**
- **Privilege Escalation**
- **File Upload Vulnerabilities**
- **Session Hijacking**

### ❌ Out of Scope

The following are typically **not** considered vulnerabilities:
- Denial of service via resource exhaustion
- Social engineering attacks
- Browser-side vulnerabilities not affecting our code
- Issues in third-party dependencies (unless exploitable through our code)

### 🎯 Responsible Disclosure

We appreciate responsible disclosure and will:
- Acknowledge your contribution in release notes
- Work with you to understand and fix the issue
- Provide updates on the fix progress
- Credit you in security advisories (if you wish)

### 📞 Emergency Contact

For critical vulnerabilities requiring immediate attention:
- Email: [sakshamguptativ@gamil.com](mailto:sakshamguptativ@gamil.com)
- Subject: "URGENT: Critical Security Issue"

### 📖 Additional Resources

- [Drupal Security Team](https://www.drupal.org/security-team)
- [Drupal Security Advisories](https://www.drupal.org/security/advisories)
- [OWASP Top Ten](https://owasp.org/www-project-top-ten/)

### 🔄 Updates

This policy is reviewed quarterly and updated as needed. Last updated: February 2026.

---

**Note**: This security policy applies to the Event Registration Module. For Drupal core security issues, please contact the [Drupal Security Team](https://www.drupal.org/security-team) directly.