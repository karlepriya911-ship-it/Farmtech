# Week 6: Deployment, Maintenance, and Project Reflection

## Project Information

- Project: FarmTech Equipment Rental System
- Repository: karlepriya911-ship-it/Farmtech
- Task: Week 6 — Deployment, Maintenance, and Project Reflection
- Author: karlepriya911-ship-it
- Date: 29 September 2026

## 1. Deployment Guide

### 1.1 Objective

The purpose of this deployment guide is to show how the FarmTech application can be prepared for public hosting, deployed to a production-like environment, and verified for functionality after deployment. The guide focuses on a realistic production deployment for a full-stack application consisting of a PHP/MySQL backend, HTML/CSS/JavaScript front-end, and database layer.

### 1.2 Production Readiness Checklist

Before deployment, confirm the following:

- Application code is final and reviewed.
- Database credentials are stored securely in environment variables, not hard-coded in source files.
- No debug output or internal error messages are exposed to end users.
- Production configuration is used instead of local development settings.
- Sessions, API keys, and secret values are not committed to the repository.
- File permissions are correct for public hosting.
- APIs correctly handle invalid input and authentication failures.
- Front-end uses the correct production API URL.
- Database schema is imported and validated.

### 1.3 Recommended Production Configuration

Use environment variables instead of literal values in code.

Example environment variables:

```env
APP_ENV=production
APP_URL=https://farmtech.example.com
DB_HOST=prod-db.internal
DB_NAME=farmtech
DB_USER=farmtech_user
DB_PASSWORD=StrongPassword123!
SESSION_SECRET=your-long-random-session-secret
API_BASE_URL=https://farmtech-api.example.com
```

Recommended security settings:

- Set `APP_ENV=production`
- Disable PHP notice and warning display in browser output
- Force HTTPS only
- Restrict access to admin endpoints using auth and role checks
- Use prepared SQL statements for all database queries
- Set secure cookies with `HttpOnly`, `Secure`, and `SameSite` attributes
- Restrict CORS to authorized domains only

### 1.4 Deployment Option: Heroku (Recommended for Simplicity)

Because the project is PHP-based, Heroku is a suitable public hosting option when paired with a MySQL add-on such as JawsDB or ClearDB.

#### Step 1: Prepare the application

1. Ensure all config values are externalized.
2. Make sure the code references environment variables instead of local paths.
3. Add a `Procfile` if needed for PHP app hosting:

```procfile
web: vendor/bin/heroku-php-apache2 .
```

If the project is not using Composer, configure Apache to serve the app through the correct document root.

#### Step 2: Create the app in Heroku

```bash
heroku login
heroku create farmtech-production
```

#### Step 3: Set production environment variables

```bash
heroku config:set \
  APP_ENV=production \
  APP_URL=https://farmtech-production.herokuapp.com \
  DB_HOST=your-db-host \
  DB_NAME=farmtech \
  DB_USER=farmtech_user \
  DB_PASSWORD=your_secure_password \
  SESSION_SECRET=your_session_secret \
  API_BASE_URL=https://farmtech-production.herokuapp.com/backend
```

#### Step 4: Add a database service

- Add a MySQL add-on such as JawsDB or ClearDB.
- Import the project database schema into the production database.
- Verify database connectivity using the application environment variables.

#### Step 5: Deploy the app

```bash
git add .
git commit -m "Prepare FarmTech for deployment"
git push heroku main
```

If the repository default branch is not `main`, use the correct branch name.

#### Step 6: Run migrations and initialize data

If the project includes a database schema file, import it through the database management tool or deployment script.

```bash
heroku run php -v
heroku run bash
```

Then validate that the schema exists and tables are created correctly.

### 1.5 Deployment Option: AWS EC2 / Elastic Beanstalk

For a more enterprise-like deployment, AWS EC2 or Elastic Beanstalk is a strong alternative.

Typical steps:

1. Launch an Ubuntu EC2 instance.
2. Install Apache, PHP, and MySQL or connect to Amazon RDS.
3. Upload project files to `/var/www/html/Farmtech`.
4. Configure Apache virtual host.
5. Enable SSL via Let's Encrypt or AWS Certificate Manager.
6. Set environment variables in Apache or system configuration.
7. Validate the site and API endpoints through the public domain.

Example Apache virtual host:

```apache
<VirtualHost *:80>
    ServerName farmtech.example.com
    DocumentRoot /var/www/html/Farmtech
    <Directory /var/www/html/Farmtech>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 1.6 Front-End Deployment Notes

The front-end pages should be served using a proper web server and not only opened as local files.

Important front-end checks:

- Correct base URL for API calls
- No broken asset paths
- JavaScript can run without local-only assumptions
- HTML pages can load from the production domain

### 1.7 User Acceptance Testing (UAT)

After deployment, verify that the following user journeys work in the public environment:

1. User can access the landing page.
2. User can register with valid details.
3. User can log in successfully.
4. User can view equipment listings and filter results.
5. User can open equipment details and create a booking request.
6. Errors are displayed clearly for invalid inputs.
7. Session behavior works correctly after login/logout.
8. Application still works on mobile and desktop layouts.
9. Admin pages or protected functions are inaccessible without valid authentication.

### 1.8 Troubleshooting Common Deployment Issues

#### Issue: 500 Internal Server Error

Likely causes:

- Incorrect database credentials
- Missing PHP extension
- Broken SQL syntax or missing database table
- Fatal error in code

Checks:

- Review server logs
- Test the DB connection manually
- Ensure all required PHP modules are installed
- Verify file permissions and paths

#### Issue: API requests fail from browser

Likely causes:

- Wrong `API_BASE_URL`
- CORS misconfiguration
- Front-end is served from one domain and API from another

Checks:

- Open browser dev tools and inspect the network tab
- Confirm the request URL matches the deployed backend URL
- Ensure correct response headers are generated

#### Issue: Database connection error

Likely causes:

- Wrong host, username, password, or database name
- Database server not reachable
- Production DB not imported

Checks:

- Confirm environment variables are loaded correctly
- Test DB connectivity with `mysqli_connect` or equivalent
- Import the schema and restart the service if necessary

#### Issue: App loads but styling is broken

Likely causes:

- CSS file path mismatched
- Relative asset paths changed after deployment
- MIME type issues on the server

Checks:

- Inspect browser console for missing file errors
- Use absolute paths for static resources when necessary
- Verify the web server serves CSS correctly

#### Issue: HTTPS/security warnings

Likely causes:

- App is served without valid SSL certificate
- Cookies are missing secure flags
- Mixed content from HTTP resources

Checks:

- Enforce HTTPS redirects
- Update all internal links to use secure URLs
- Remove HTTP references to API endpoints or assets

### 1.9 Deployment Summary

The project is ready for a realistic public deployment when:

- the database is configured securely,
- the app is hosted behind HTTPS,
- admin routes are protected,
- API endpoints respond with valid JSON,
- and user journeys are tested after deployment.

The key principle is to treat deployment as a production environment, not just a local development setup. Security, observability, and user flow validation are essential for real-world operation.

## 2. Maintenance Documentation

### 2.1 Maintenance Objectives

The purpose of maintenance is to keep the FarmTech application available, secure, reliable, and operational after deployment. Maintenance tasks should include monitoring, backups, updates, dependency checks, and incident response.

### 2.2 Logging and Monitoring

Recommended monitoring plan:

- Capture PHP error logs for backend failures.
- Record database errors and slow query issues.
- Monitor application uptime, HTTP errors, and API response time.
- Track failed login attempts and suspicious activity.
- Keep a log of deployment events and configuration changes.

Useful tools:

- Server logs (Apache/Nginx/PHP)
- MySQL logs
- Sentry for error tracking
- LogRocket or similar front-end monitoring for user issues
- Uptime monitoring (e.g., UptimeRobot)

### 2.3 Error Reporting Strategy

The application should report user-friendly errors to the frontend while recording technical details server-side.

Recommended approach:

- Show short, meaningful messages to users.
- Log full stack traces to server logs or an external monitoring service.
- Tag issues with severity, module, and timestamp.
- Review logs regularly to identify recurring defects.

### 2.4 Backup and Recovery Plan

A reliable maintenance strategy must include backups.

Recommended backup process:

- Daily database backups
- Weekly full project snapshots
- Backup retention for at least 30 days
- Secure storage outside the production server
- Restore test performed at least once per month

Example backup command:

```bash
mysqldump -u farmtech_user -p farmtech > backup-farmtech.sql
```

### 2.5 Update Procedure

A planned update procedure protects the application from avoidable downtime.

Suggested update workflow:

1. Create a feature branch or release branch.
2. Test locally or in a staging environment.
3. Review code changes and check for security issues.
4. Run database migration scripts if required.
5. Deploy to staging, then production.
6. Verify user flows after deployment.
7. Record release details and any issues encountered.

### 2.6 Security Maintenance

Ongoing security steps:

- Rotate secrets and API keys regularly.
- Update PHP, database, and server components.
- Review admin access permissions.
- Disable unused ports and services.
- Keep `.env` or config files out of version control.
- Run periodic vulnerability scans.

### 2.7 Performance Maintenance

To keep the platform responsive:

- Optimize frequent SQL queries.
- Add indexes to database columns used in filtering or joins.
- Compress static assets where needed.
- Cache repeated data when appropriate.
- Review server resource usage after traffic growth.

### 2.8 Incident Response and Support

A maintenance plan should define who handles incidents and how the team responds.

Example support policy:

- Severity 1: major outage or public data issue — respond immediately
- Severity 2: key functionality broken — respond within a few hours
- Severity 3: lower-impact issues — respond within 1 business day

All incidents should be recorded in a ticketing or issue log and reviewed after resolution.

### 2.9 Maintenance Summary

Maintenance is not a one-time activity. Successful operation depends on ongoing monitoring, backup management, security updates, and structured release practices. A production-ready application must be maintained as a living system, not just deployed once.

## 3. Project Reflection Report

### 3.1 Overview

The FarmTech project was developed as a full-stack rental marketplace for agricultural equipment. The application covered a complete user journey from landing page and equipment browsing to booking flows and general project documentation. The final stage of the work focused on deployment readiness, maintenance planning, and reflection on the broader development experience.

### 3.2 What Went Well

Several areas of the project were successful:

- The app has a clear and consistent project structure.
- The front-end pages are easy to navigate and visually coherent.
- The backend API design is logically separated and understandable.
- The project includes a strong set of documentation files and reports.
- Core functionality such as login, registration, browsing, and booking workflows could be validated.
- The project demonstrated a realistic understanding of a full-stack application lifecycle.

### 3.3 Challenges Faced

The work also presented several significant challenges:

- Front-end and backend integration required consistent API assumptions.
- Local environment configuration differences created testing friction.
- Some forms and endpoints needed stronger validation and error handling.
- Production deployment required attention to security and environment configuration.
- Deploying to a public environment introduces issues not visible in local testing, such as CORS, HTTPS, and hosting configuration.

### 3.4 Lessons Learned

The project reinforced several important lessons:

- Deployment is not only a technical step; it is a system-level process involving security, configuration, and verification.
- Real-world projects require more defensive coding than prototype development.
- Logging and monitoring are essential for identifying issues before users report them.
- Documentation is valuable because it supports future maintenance and smooth onboarding.
- Validation should continue after development is complete, especially in deployment and production-like environments.

### 3.5 Areas for Improvement

To improve future work, the project could benefit from:

- automated testing for API endpoints and critical user journeys,
- CI/CD pipelines to reduce deployment risk,
- stronger environment variable management,
- better monitoring and alert setup,
- more structured database migration practices,
- a staging environment before production deployment.

### 3.6 Personal Reflection

This project was a valuable learning experience because it combined design, implementation, debugging, testing, and production thinking. It showed that software development is not only about writing code but also about making sure the application is maintainable, deployable, and understandable to others. The most important takeaway is that a strong project is one that balances usability, reliability, and operational readiness.

### 3.7 Final Reflection

The FarmTech project successfully demonstrates a complete approach to full-stack software development. It includes the design of a usable application, a working backend, validation, and realistic planning for deployment and ongoing maintenance. While there were challenges, each one improved the project and contributed to a deeper understanding of how professional web applications are built, tested, and supported in real-world environments.

## 4. Final Submission Note

This Week 6 deliverable is intended to complement the earlier project reports and provide the final deployment and maintenance perspective for the FarmTech application. It should be packaged with the rest of the project materials as a final submission package for review.

## 5. Document Control

- Status: Final
- Version: 1.0
- Prepared for: Academic submission and portfolio review
- Related project: FarmTech Equipment Rental System

---

This report was prepared as part of the Week 6 task covering deployment, maintenance, and project reflection.
