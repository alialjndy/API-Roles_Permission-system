# Roles_Permissions API

## Overview

The **Roles_Permissions API** is a system built with Laravel . The system enables the management of users, roles, and permissions, allowing for flexible control over what actions different users can perform based on their roles.

## Features

-   **CRUD for Users**: Admin can create, read, update, and delete users.
-   **Assign Roles to Users**: Admin can assign roles to users.
-   **CRUD for Roles**: Both Admin and Manager can create, read, update, and delete roles.
-   **Assign Permissions to Roles**: Admin and Manager can assign permissions to roles.
-   **CRUD for Permissions**: Manager can create, read, update, and delete permissions.
-   **Authentication**: Includes registration, login, view user profile (`me`), and logout functionality.

## Requirments

-   PHP Version 8.3 or earlier
-   Laravel Version 11 or earlier
-   composer
-   XAMPP: Local development environment (or a similar solution)

## API Endpoint

### Authentication

    - POST /api/register : Register with name , email and password
    - POST /api/login: Log in with email and password
    - POST /api/logout: Log out the current user
    - GET /api/me: display info currently user

### CRUD Users

    - POST /api/user : Create User by admin
    - GET /api/user : show all Users by admin
    - GET /api/user/{user_id} : show User by ID
    - PUT /api/user/{user_ID} : update User by ID
    - DELETE /api/Role/{user_ID} : delete User by ID
    - POST /api/user/{user_id}/AssignRole : Assign Role to user

## CRUD Roles

    - POST /api/Role : Create Role by admin
    - GET /api/Role : show all Roles by admin
    - GET /api/Role/{role_id} : show Role by ID
    - PUT /api/Role/{role_id} : update Role by ID
    - DELETE /api/Role/{Role_ID} : delete Role by ID
    - POST /api/Role/AssignPermission : Assign permission to role

## CRUD Permissions

    - POST /api/permission : Create permission by admin
    - GET /api/permission : show all permission by admin
    - GET /api/permission/{Permission_id} : show permission by ID
    - PUT /api/permission/{Permission_id} : update permission by ID
    - DELETE /api/permission/{Permissions_ID} : delete permission by ID

## Postman Collection:

You can access the Postman collection for this project by following this [link](https://documenter.getpostman.com/view/37833857/2sAXqy2eQa). The collection includes all the necessary API requests for testing the application.
