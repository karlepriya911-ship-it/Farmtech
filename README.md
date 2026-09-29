# FarmTech Rental System

A responsive front-end web application for agricultural equipment rental. This project focuses on the Week 2 front-end development task and includes a landing page, equipment catalog, equipment detail view, and farmer dashboard.

## Project Overview

FarmTech helps farmers rent tractors, tillers, harvesters, sprayers, and other agricultural tools from local equipment owners. The platform is designed for a simple user flow:

- Farmer explores equipment
- Filters equipment by category and location
- Views equipment details and pricing
- Books equipment through a booking panel
- Tracks rental activity in a dashboard

## Features Included

- Responsive landing page
- Equipment catalog with search and filters
- Equipment detail page with pricing and booking form
- Farmer dashboard with statistics and active rentals
- Clean, modern UI using HTML, CSS, and JavaScript
- Accessible and mobile-friendly layout

## Tech Stack

- HTML5
- CSS3
- JavaScript (Vanilla JS)
- Bootstrap 5

## Folder Structure

```text
Farmtech/
├── backend/
├── database/
├── frontend/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   ├── index.html
│   ├── equipment.html
│   ├── equipment-details.html
│   ├── dashboard-farmer.html
│   ├── login.html
│   └── register.html
├── README.md
└── .gitignore
```

## Local Setup

1. Start XAMPP or any local web server.
2. Place the project in your local web root, for example:
   - Windows: `C:\xampp\htdocs\Farmtech`
   - Linux: `/opt/lampp/htdocs/Farmtech`
3. Open the project in a browser:
   - Home page: `http://localhost/Farmtech/frontend/index.html`
   - Equipment page: `http://localhost/Farmtech/frontend/equipment.html`
   - Dashboard: `http://localhost/Farmtech/frontend/dashboard-farmer.html`

## Design Notes

The application follows a modern marketplace layout with:
- clear navigation,
- strong call-to-action buttons,
- responsive cards,
- simple filtering interaction,
- readable dashboards for user activity.

## Development Approach

This front-end was built with modular JavaScript and reusable UI patterns. Data is handled in a lightweight JSON-like structure inside the front-end logic so the pages can run without a live backend during local demonstration.

## Files to Customize

- `frontend/index.html` — landing page
- `frontend/equipment.html` — filtering and equipment listing
- `frontend/equipment-details.html` — detail view for selected product
- `frontend/dashboard-farmer.html` — user dashboard
- `frontend/css/style.css` — theme and layout styles
- `frontend/js/app.js` — reusable data rendering and interactions

## Notes

This version is designed for front-end demonstration and college-level implementation. The backend can be connected later to the existing PHP APIs in this repository.
