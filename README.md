# Online Computer Store

A full-stack web application for browsing, searching, and purchasing computer products. Built using HTML5, Bootstrap, JavaScript, PHP, and MySQL with full admin management capabilities.

# Presentation
https://drive.google.com/file/d/1yuI4fR6obYoSSvU4nBnktZlqeK9HJcJ0/view?usp=sharing

## Project Description

This web-based computer store allows users to:

- Browse products by category
- Search and filter items
- View product details and reviews
- Add items to cart
- Checkout and view order history

Admins can:

- Manage products (add/edit/delete)
- View all customer orders
- Manage user accounts
- Use a responsive admin dashboard

## Setup Instructions

1. Install XAMPP (if not already)
   - Start Apache and MySQL

2. Place the project folder inside:
```

C:\xampp\htdocs\www\

```

3. Import the SQL file:
- Open phpMyAdmin
- Create a database named `computer_store`
- Import the `computer_store.sql` file from this repository

4. Launch the site in browser:
```
http://localhost
```

## Admin Login (for testing)

| Email            | Password  |
|------------------|-----------|
| admin@store.com  | admin123  |

## Author Info

- Name: Avijeet
- Student ID: 249680600

## Folder Structure

```

/assets
/images       → product images
/css          → custom styles
/includes       → header, footer, db connection
/pages          → main user pages (products, cart, login, etc.)
/admin          → admin-only dashboard & management
/php            → backend handlers (auth, cart, checkout)
computer_store.sql  → database schema and seed data

```

## Tech Stack

| Technology   | Purpose                    |
|--------------|----------------------------|
| HTML5        | Page structure             |
| Bootstrap 5  | Styling and responsive layout |
| JavaScript   | Client-side interaction    |
| PHP          | Server-side processing     |
| MySQL        | Database backend           |
| phpMyAdmin   | Database management        |
| XAMPP        | Local server environment   |


## Features Implemented

- User registration, login, and logout
- Product listing by category
- Search and filter functionality
- Product detail view
- Shopping cart functionality
- Checkout and order placement
- Order history tracking
- Password hashing using `password_hash`
- SQL injection protection using prepared statements
- Responsive design using Bootstrap
- Admin dashboard with product and order management
- Product reviews and rating system
- Inventory updates after purchase
- Session-based cart and login handling
