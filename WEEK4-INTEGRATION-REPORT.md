# Week 4 Integration Report

## Project Information

- **Project:** FarmTech Equipment Rental System
- **Repository:** [karlepriya911-ship-it/Farmtech](https://github.com/karlepriya911-ship-it/Farmtech)
- **Task:** Week 4 — Integrating Front-End with Back-End
- **Author:** karlepriya911-ship-it
- **Date:** 29 September 2026

## 1. Objective

The objective of Week 4 was to integrate the FarmTech front-end application with the PHP back-end APIs developed during the previous weeks. The integration connects the user interface to authentication, equipment, and booking services so that data can be submitted, retrieved, and displayed dynamically.

The work also focused on asynchronous data fetching, client-side state handling, error management, local testing, and documenting how the complete application can be run.

## 2. Existing Application Structure

The repository contains the following main components:

### Front-end

- `frontend/index.html` — landing page
- `frontend/login.html` — user login page
- `frontend/register.html` — user registration page
- `frontend/equipment.html` — equipment listing page
- `frontend/equipment-details.html` — equipment details page
- `frontend/dashboard-farmer.html` — farmer dashboard
- `frontend/css/` — stylesheets

### Back-end

- `backend/auth/login.php` — authenticates users
- `backend/auth/register.php` — registers new users
- `backend/equipment/view_equipment.php` — retrieves equipment data
- `backend/equipment/add_equipment.php` — adds equipment records
- `backend/booking/create_booking.php` — creates rental bookings
- `backend/config/` — database and application configuration

Additional API information is available in [`API-DOCUMENTATION.md`](API-DOCUMENTATION.md).

## 3. Integration Approach

The integration follows a simple client-server flow:

1. A user interacts with a front-end form or page.
2. JavaScript sends an asynchronous HTTP request using `fetch()`.
3. The PHP API validates the request and communicates with the database.
4. The API returns a JSON response.
5. The front-end parses the response and updates the page without a full reload.
6. Errors are displayed to the user in a readable format.

A shared front-end API layer is recommended for keeping endpoint URLs, request handling, JSON parsing, and error handling in one place. This prevents duplicate request logic across the individual HTML pages.

## 4. API Integration Points

| Feature | Front-end page | Back-end endpoint | HTTP method |
|---|---|---|---|
| Register account | `register.html` | `backend/auth/register.php` | POST |
| Login | `login.html` | `backend/auth/login.php` | POST |
| View equipment | `equipment.html` | `backend/equipment/view_equipment.php` | GET |
| Add equipment | Farmer dashboard/equipment form | `backend/equipment/add_equipment.php` | POST |
| Create booking | Equipment details/booking form | `backend/booking/create_booking.php` | POST |

Requests should use JSON request bodies where supported and should check both the HTTP status code and the `success` value returned by the API.

## 5. Asynchronous Data Fetching and State Management

The front-end integration uses asynchronous requests so that the interface remains responsive while the server processes a request.

The main state values required by the pages are:

- Loading state while an API request is in progress
- Successful response data
- Error message when a request fails
- Logged-in user information, where applicable
- Selected equipment item and booking information

A typical request flow is:

```javascript
async function loadEquipment() {
  showLoadingState();

  try {
    const response = await fetch(`${API_BASE_URL}/equipment/view_equipment.php`);
    const result = await response.json();

    if (!response.ok || result.success === false) {
      throw new Error(result.message || 'Unable to load equipment.');
    }

    renderEquipment(result.data || result);
  } catch (error) {
    showErrorState(error.message);
  }
}
```

This pattern provides clear feedback for loading, success, and failure states.

## 6. User Flows Tested

### Registration

1. Open `register.html`.
2. Enter valid user details.
3. Submit the registration form.
4. Send the form data to `register.php`.
5. Display the success or validation message returned by the API.

### Login

1. Open `login.html`.
2. Enter registered credentials.
3. Submit the login form asynchronously.
4. Display an error for invalid credentials.
5. Redirect the user to the dashboard after successful authentication.

### Equipment listing

1. Open `equipment.html`.
2. Request equipment data from the back end.
3. Show a loading indicator while the request is running.
4. Render equipment cards from the returned data.
5. Show a friendly error message if the API or database is unavailable.

### Equipment details and booking

1. Select an equipment item.
2. Open the details page with the equipment identifier.
3. Display the selected equipment information.
4. Submit booking dates and user details to `create_booking.php`.
5. Display the booking confirmation or validation error.

## 7. Exception Handling

The integration accounts for the following failure scenarios:

- Empty or invalid form fields
- Invalid login credentials
- Duplicate registration details
- Equipment API returning an empty result
- Network connection failures
- PHP or database server errors
- Invalid JSON responses
- Unauthenticated booking requests
- Invalid equipment identifiers

The front end should never expose raw PHP warnings or database errors to users. Technical details can be logged in the browser console during development, while the interface displays a useful message such as “Unable to complete your request. Please try again.”

## 8. Local Setup Instructions

### Prerequisites

Install the following software:

- PHP 7.4 or later
- MySQL or MariaDB
- A local web server such as Apache/XAMPP, or the PHP built-in server
- Python 3 or VS Code Live Server for serving the static front end

### Database setup

1. Create a database using the schema in the `database/` directory.
2. Update the database credentials in the back-end configuration file.
3. Confirm that the configured database server is running.

### Start the back end

Using the PHP built-in server from the repository root:

```bash
php -S localhost:8000 -t backend
```

If the project is run using XAMPP, copy the repository into the Apache `htdocs` directory and start Apache and MySQL. In that setup, the API base URL will normally include the project path, for example:

```text
http://localhost/Farmtech/backend
```

### Start the front end

From the repository root, run a static file server:

```bash
cd frontend
python -m http.server 3000
```

Then open:

```text
http://localhost:3000/index.html
```

Using a static server is preferred over opening HTML files with a `file://` URL because browsers can block cross-origin requests from local files.

### Configure the API URL

Set the front-end API base URL to match the selected back-end setup. For example:

```javascript
const API_BASE_URL = 'http://localhost:8000';
```

When using XAMPP, use the corresponding `/Farmtech/backend` URL instead.

## 9. Validation Checklist

- [ ] Front end loads without console errors.
- [ ] Back end PHP server starts successfully.
- [ ] Database connection is configured correctly.
- [ ] A new user can register.
- [ ] A registered user can log in.
- [ ] Invalid login details display a clear error.
- [ ] Equipment records are loaded dynamically.
- [ ] Empty equipment results are handled gracefully.
- [ ] Equipment details are shown for a selected item.
- [ ] A valid booking can be submitted.
- [ ] Invalid booking input is rejected.
- [ ] Network and server errors display user-friendly messages.
- [ ] API responses are valid JSON.
- [ ] Documentation includes complete setup instructions.

## 10. Challenges and Solutions

### Cross-origin requests

**Challenge:** The front end and PHP API may run on different ports during local development.

**Solution:** Configure CORS response headers on the PHP API for local development. In production, replace a wildcard origin with the exact deployed front-end origin.

### Static pages and dynamic data

**Challenge:** The original front end consists of static HTML pages and does not automatically update when database records change.

**Solution:** Add JavaScript event handlers and asynchronous `fetch()` calls to load and submit data dynamically.

### Inconsistent API failures

**Challenge:** A failed request may return a non-JSON server error instead of the expected response structure.

**Solution:** Check the HTTP status before using the result and provide a fallback error message when JSON parsing fails.

### Local file restrictions

**Challenge:** Opening HTML files directly with `file://` can prevent API requests from working correctly.

**Solution:** Serve the front end through Python’s HTTP server, VS Code Live Server, Apache, or another local static server.

### Security considerations

**Challenge:** Authentication and database endpoints must not trust client-side validation.

**Solution:** Validate all input again on the server, use password hashing, use prepared database statements, and restrict CORS in production.

## 11. Security and Best-Practice Recommendations

- Use `password_hash()` and `password_verify()` for passwords.
- Use PDO or MySQLi prepared statements for all database queries.
- Validate and sanitize all values on the server.
- Do not return database credentials or raw SQL errors to the browser.
- Use HTTPS in production.
- Restrict `Access-Control-Allow-Origin` to the deployed front-end domain.
- Use secure, HttpOnly, and SameSite cookies when sessions are used.
- Keep secrets in environment variables rather than committing them to Git.
- Add server-side authorization checks for equipment management and bookings.

## 12. Deliverables

The Week 4 submission should include:

- Front-end source code in `frontend/`
- Back-end source code in `backend/`
- Database files in `database/`
- Updated `README.md`
- This report: `WEEK4-INTEGRATION-REPORT.md`
- API documentation
- A ZIP archive containing the complete project
- A short screen recording demonstrating registration, login, equipment viewing, and booking

To create the ZIP archive from the repository root:

```bash
zip -r Farmtech-week4-integrated.zip frontend backend database README.md API-DOCUMENTATION.md WEEK4-INTEGRATION-REPORT.md
```

## 13. Conclusion

Week 4 established the integration plan and validation process for connecting the FarmTech front end with the PHP back end. The application now has clearly defined integration points for authentication, equipment management, and booking. Asynchronous requests, loading states, error handling, and local setup instructions provide the foundation for a cohesive full-stack application.

The next recommended step is to complete an end-to-end browser demonstration and include the resulting screen recording with the ZIP submission.
