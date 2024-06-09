# GreenFingers Online Store Project

## Purpose

This project is designed to provide customers with access to the GreenFingers website for purchasing products online and browsing the store catalog. Additionally, staff members can use the website to manage stock movements across different branches.

# Project Constraints

This project adheres to the following constraints:

- Uses MariaDB and PHP.
- Utilizes WampServer.
- Avoids the use of CSS and JavaScript.
- Does not rely on any PHP framework.

# Architecture Overview

As per the constraints, the project implements a custom framework instead of utilizing existing PHP frameworks. The architecture follows the MVC (Model-View-Controller) pattern for organizing code and files.

## Components

### `config.php`

The `config.php` file contains configuration settings such as database connection details.

### `helpers.php`

The `helpers.php` file includes methods for routine tasks like displaying error messages and HTML tables.

### Controllers

Controllers hold methods and properties specific to each class. For instance, the `ProductController` class includes methods related to product purchase processes.

### `router.php`

The `router.php` file handles routing to methods within each controller.

### Views

Views are responsible for visually presenting data using HTML and embedded PHP code.

# Coolest Tricks

## React-Like State Management

One of the standout features of this project is the implementation of a React-like state management system to handle error and success messages. A custom method has been developed to simulate state management by storing error and success messages in the session state.

Here's how it works:

- When an error occurs or a task is successfully completed, the corresponding message is stored in the session state.
- Upon page reload, the system checks if there are any error or success messages in the state and displays them as labels on the webpage.
- The state is cleared and recreated on each reload to ensure old error messages are removed and new ones can be displayed seamlessly.

This approach allows for efficient handling of error and success messages in a non-single-page application environment, enhancing user experience and providing real-time feedback.

## Database Utilization

### Stored Procedures

The project leverages the power of MariaDB by using stored procedures to perform complex functions. Instead of embedding extensive SQL queries in PHP code, stored procedures with cursors and triggers are utilized. This improves code readability and maintenance.

### Views

Views in the database are used to display data as information. They also offer abstraction, simulating React's behavior wherein the UI changes as state changes. This abstraction layer enhances the project's scalability and organization.

For more detailed implementation details, refer to the codebase and comments within the project files.

THE SQL SCRIPT FOR THE PROJECT IS TITLED "console_1.sql" in the project files.