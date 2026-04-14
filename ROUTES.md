# PWD (Personal With Disabilities) - Laravel Routes Documentation

## Overview

This document describes all available routes in the PWD Laravel application, organized by functionality and access level.

---

## Public Routes

### Home & Information

- `GET /` - Home page / Welcome
- `GET /about` - About page
- `GET /contact` - Contact page

### Authentication

- `GET /login` - Login form
- `POST /login` - Submit login credentials
- `GET /register` - Registration form
- `POST /register` - Submit registration
- `POST /logout` - Logout user

---

## Authenticated User Routes (Requires Login)

### Dashboard

- `GET /dashboard` - Main user dashboard

### User Profile

- `GET /profile` - View user profile
- `GET /profile/edit` - Edit profile form
- `PUT /profile` - Update profile data

### Accessibility Settings

- `GET /accessibility` - Main accessibility settings page
- `POST /accessibility` - Update accessibility settings
- `GET /accessibility/font-size` - Font size customization
- `GET /accessibility/color-contrast` - Color contrast settings
- `GET /accessibility/reader` - Screen reader options

### Resources

- `GET /resources` - List all resources
- `GET /resources/{id}` - View specific resource
- `GET /resources/create` - Create resource form
- `POST /resources` - Store new resource

### Support & Services

- `GET /support` - Support hub
- `GET /support/disability-services` - Disability services information
- `GET /support/accommodations` - Accommodations guide
- `GET /support/legal` - Legal information and rights

### Messages

- `GET /messages` - List all messages
- `GET /messages/{id}` - View specific message
- `POST /messages` - Send new message

### Notifications

- `GET /notifications` - View notifications
- `DELETE /notifications/{id}` - Delete notification

### Settings

- `GET /settings` - User settings
- `POST /settings` - Update settings
- `GET /settings/privacy` - Privacy settings
- `GET /settings/notifications` - Notification preferences

---

## Admin Routes (Requires Admin Role)

### Admin Dashboard

- `GET /admin/dashboard` - Admin control panel

### User Management

- `GET /admin/users` - List all users
- `GET /admin/users/{id}` - View user details
- `GET /admin/users/{id}/edit` - Edit user form
- `PUT /admin/users/{id}` - Update user
- `DELETE /admin/users/{id}` - Delete user

### Reports

- `GET /admin/reports` - Reports hub
- `GET /admin/reports/users` - User reports
- `GET /admin/reports/analytics` - Analytics dashboard

### Settings

- `GET /admin/settings` - Admin settings
- `POST /admin/settings` - Update admin settings

---

## API Routes

### Public API Routes

#### Authentication

- `POST /api/auth/login` - API login endpoint
- `POST /api/auth/register` - API registration endpoint

---

### Protected API Routes (Requires Authentication Token)

#### User Profile

- `GET /api/profile` - Get authenticated user profile
- `PUT /api/profile` - Update user profile
- `GET /api/profile/accessibility` - Get accessibility settings
- `PUT /api/profile/accessibility` - Update accessibility settings

#### Resources API

- `GET /api/resources` - List resources
- `POST /api/resources` - Create resource
- `GET /api/resources/{id}` - Get resource details
- `PUT /api/resources/{id}` - Update resource
- `DELETE /api/resources/{id}` - Delete resource
- `POST /api/resources/{id}/share` - Share resource

#### Support API

- `GET /api/support` - List support items
- `POST /api/support` - Create support request
- `GET /api/support/{id}` - Get support item
- `GET /api/support/services/disability-services` - Disability services data
- `GET /api/support/services/accommodations` - Accommodations data

#### Messages API

- `GET /api/messages` - List messages
- `POST /api/messages` - Send message
- `GET /api/messages/{id}` - Get message details
- `PUT /api/messages/{id}` - Update message
- `DELETE /api/messages/{id}` - Delete message
- `POST /api/messages/{id}/mark-as-read` - Mark as read

#### Notifications API

- `GET /api/notifications` - List notifications
- `DELETE /api/notifications/{id}` - Delete notification
- `POST /api/notifications/mark-all-as-read` - Mark all as read

#### Settings API

- `GET /api/settings` - Get user settings
- `PUT /api/settings` - Update settings
- `PUT /api/settings/privacy` - Update privacy settings
- `PUT /api/settings/notifications` - Update notification settings

#### Authentication

- `POST /api/auth/logout` - Logout via API
- `GET /api/user` - Get logged-in user data

---

### Admin API Routes (Requires Admin Role & Authentication Token)

#### User Management API

- `GET /api/admin/users` - List all users
- `GET /api/admin/users/{id}` - Get user details
- `PUT /api/admin/users/{id}` - Update user
- `DELETE /api/admin/users/{id}` - Delete user
- `POST /api/admin/users/{id}/toggle-status` - Toggle user status

#### Reports API

- `GET /api/admin/reports/users` - User reports data
- `GET /api/admin/reports/analytics` - Analytics data
- `GET /api/admin/reports/usage` - Usage statistics

#### Settings API

- `GET /api/admin/settings` - Get admin settings
- `PUT /api/admin/settings` - Update admin settings

---

## Route Parameters

- `{id}` - Resource/User ID (typically an integer)

---

## Authentication Methods

### Web Routes

- Session-based authentication via `auth` middleware
- Users must be logged in to access protected routes

### API Routes

- Token-based authentication via Sanctum (`auth:sanctum`)
- Include token in Authorization header: `Authorization: Bearer {token}`

---

## Middleware Groups

- `web` - Default middleware group for web routes (sessions, CSRF, etc.)
- `api` - Default middleware group for API routes
- `auth` - Requires user to be authenticated
- `admin` - Requires user to have admin role

---

## Usage Examples

### Web Routes

```bash
# Access home page
GET http://localhost:8000/

# Login
POST http://localhost:8000/login

# View dashboard
GET http://localhost:8000/dashboard
```

### API Routes

```bash
# Register
POST http://localhost:8000/api/auth/register
Content-Type: application/json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}

# Get user profile (with token)
GET http://localhost:8000/api/profile
Authorization: Bearer {token}

# Create resource
POST http://localhost:8000/api/resources
Authorization: Bearer {token}
Content-Type: application/json
{
  "title": "Resource Title",
  "description": "Resource Description"
}
```

---

## Getting Started

1. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

2. **Setup Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Database Setup**

    ```bash
    php artisan migrate
    php artisan seed
    ```

4. **Start Development Server**

    ```bash
    php artisan serve
    npm run dev
    ```

5. **Access Application**
    - Web: http://localhost:8000
    - API: http://localhost:8000/api

---

## Notes

- All protected routes require user authentication
- Admin routes require user to have admin role
- API routes use Sanctum tokens for authentication
- All routes are RESTful and follow Laravel conventions
- CSRF protection is enabled for web routes (POST, PUT, DELETE)
