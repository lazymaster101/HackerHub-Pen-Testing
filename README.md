# HackerHub CTF Vulnerability Assessment

> Portfolio repository for a controlled web-security assignment focused on identifying, documenting, and remediating vulnerabilities in a CTF-style PHP/MySQL application.

## Overview

This project documents my analysis of **HackerHub**, a deliberately vulnerable web application built around common web-security flaws. The goal of the assignment was to investigate the application, identify vulnerabilities, recover hidden CTF flags in an authorized environment, and propose realistic remediation strategies.

The repository is intended to showcase my security-analysis process to employers, including how I inspected application behavior, reviewed source code, identified insecure patterns, validated findings, and explained practical defenses.

## Academic Integrity Notice

This repository is shared **only as a portfolio showcase of my own work and learning**.

If you are a student taking this course or a similar course, **do not copy, submit, or reuse this code, report, payloads, writeup structure, or explanations as your own work**. Doing so may violate your course policies and the **Aggie Code of Honor**:

> “An Aggie does not lie, cheat or steal, or tolerate those who do.”

Use this repository only as a high-level example of how a security project can be documented. Complete your own work independently, follow your instructor’s rules, and respect the Aggie Honor System.

## Project Scope

The assignment focused on a controlled CTF environment and included the following vulnerability classes:

- **Directory traversal** through unsafe file-path handling
- **SQL injection** through unsafe query construction and insufficient input handling
- **Stored XSS** through unsanitized user-generated comments
- **Reflected XSS** through unsafe rendering of search input
- **DOM-based XSS** through unsafe use of `innerHTML`
- **Replay-token weakness** through deterministic token generation

This project does **not** target any real production system. All testing was performed in an authorized academic CTF environment.

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL 8.0
- **Data format:** JSON
- **Security focus:** Web exploitation, source-code review, vulnerability documentation, and remediation planning

## Application Features Reviewed

The attached code represents a small security-research social platform with features such as:

- User registration and login
- Dashboard navigation
- Community comments
- File browser
- User search and filtering
- Profile viewer
- API endpoints for authentication, users, files, comments, and search

## Vulnerability Summary

| Area | Issue Reviewed | Security Impact | Recommended Fix |
|---|---|---|---|
| File browser | Directory traversal | Unauthorized file access outside the intended directory | Canonicalize paths, use an allowlist, and restrict file access to a safe base directory |
| User search | SQL injection | Unauthorized database enumeration or data exposure | Use prepared statements, bind parameters, and avoid string-built SQL queries |
| User filtering | SQL injection | Unsafe query logic from user-controlled input | Enforce strict type validation and bind values |
| Advanced filters | Blind SQL injection risk | Possible inference of database contents | Replace raw filter expressions with predefined safe filters |
| Comments | Stored XSS | Persistent script execution when comments render | Escape output by context and sanitize rich text if HTML is required |
| Search page | Reflected XSS | Script execution through reflected request parameters | Never reflect raw user input; encode before rendering |
| Profile viewer | DOM-based XSS | Client-side script execution through unsafe DOM insertion | Prefer `textContent`, safe DOM APIs, or a trusted sanitizer |
| Authentication | Replayable token design | Session/token reuse risk | Use random, server-generated tokens with expiration and rotation |

## Key Skills Demonstrated

- Manual web application testing in an authorized CTF environment
- Source-code review of PHP and JavaScript security issues
- Understanding of common OWASP-style vulnerability classes
- SQL query-shape reasoning and schema-enumeration awareness
- Client-side and server-side XSS analysis
- Directory traversal investigation
- Secure coding remediation planning
- Clear technical reporting for both offensive findings and defensive fixes

## Responsible Disclosure and Safety

This repository is for **education, portfolio review, and defensive learning**. It does not encourage attacking systems without permission.

To keep the project safe for public viewing:

- Real flags should be redacted or omitted from the public README.
- Sensitive files such as session dumps, database dumps, credential files, and user records should not be committed publicly.
- Payloads should be kept high-level or placed only in private academic submissions when required by the instructor.
- Any copied course-provided starter code should follow the course’s publication rules.

## Files in This Project

Example project files include:

```text
.
├── index.php          # Login and registration page
├── dashboard.php      # Main dashboard and feature navigation
├── config.php         # Database/session configuration
├── api/
│   ├── auth.php       # Authentication and token/session logic
│   ├── users.php      # User search/filter API
│   ├── files.php      # File browser API
│   ├── comments.php   # Comment API
│   └── search.php     # Search API
├── js/
│   └── app.js         # Client-side dashboard/profile logic
```

> Note: The exact structure may differ depending on how the assignment files are organized locally.

## Remediation Highlights

A secure version of this application should include:

1. **Parameterized database queries** for every SQL operation.
2. **Strict input validation** for IDs, filters, filenames, and search fields.
3. **Output encoding** before rendering user-controlled content.
4. **Safe DOM manipulation** instead of direct `innerHTML` insertion.
5. **Path allowlisting and canonical path checks** for file access.
6. **Random, expiring session tokens** with server-side invalidation.
7. **Least-privilege database accounts** and restricted filesystem permissions.
8. **Security logging** for suspicious input patterns and repeated failed access attempts.

## What I Learned

This project helped reinforce that many vulnerabilities come from a small set of insecure patterns: trusting user input, building SQL strings directly, rendering unescaped content, and assuming path checks are sufficient without canonicalization. It also showed the importance of pairing exploit analysis with remediation so that findings become actionable engineering improvements.

## Disclaimer

This work was completed for an authorized academic CTF-style assignment. The code and writeup are shared to demonstrate technical learning and security-analysis ability. Do not use this material to attack systems, bypass access controls, or violate academic integrity policies.

## Demo Video

A short walkthrough of the project is available below:

[![Watch the HackerHub CTF demo](https://img.youtube.com/vi/tk7T0ziCS28/0.jpg)](https://youtu.be/tk7T0ziCS28)
