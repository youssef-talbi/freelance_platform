# Freelance Hub - Improved Website Setup (Windows)

This document provides instructions on how to set up and run the improved Freelance Hub website on a Windows machine.

## Prerequisites

Before you begin, ensure you have the following installed on your Windows system:

1.  **Web Server Environment:** A local server stack like XAMPP, WAMP, or Laragon. These packages typically include:
    *   Apache (or Nginx) Web Server
    *   PHP (Version 8.1 or higher recommended)
    *   MySQL (or MariaDB) Database Server
    *   phpMyAdmin (or similar database management tool)
2.  **PHP Configuration:** Ensure the following PHP extensions are enabled in your `php.ini` file (usually accessible through your XAMPP/WAMP control panel):
    *   `pdo_mysql` (for database connection)
    *   `mbstring` (for multi-byte string functions)
    *   `openssl` (often needed for secure connections or token generation)
    *   `fileinfo` (useful for validating uploaded file types)
3.  **Code Editor:** A text editor or IDE like VS Code, Sublime Text, or Notepad++.
4.  **Web Browser:** Chrome, Firefox, Edge, etc.

## Setup Instructions

1.  **Download and Extract Files:**
    *   Download the project files (likely provided as a ZIP archive).
    *   Extract the contents into your web server's document root directory. This is typically:
        *   `C:\xampp\htdocs\` for XAMPP
        *   `C:\wamp\www\` for WAMP
        *   `C:\laragon\www\` for Laragon
    *   You should have a folder structure like `htdocs\improved_freelance_platform\` containing `public_html`, `private`, etc.
    *   **Important:** Ensure file and folder names retain their original case (e.g., `public_html`, `private`, `Helpers.php`). Windows is often case-insensitive, but consistency prevents potential issues.

2.  **Configure Web Server (Virtual Host - Recommended):**
    *   It's recommended to set up a virtual host for the project to use a cleaner URL (e.g., `http://freelance-hub.local`) instead of `http://localhost/improved_freelance_platform/public_html/`.
    *   **XAMPP:** Edit `C:\xampp\apache\conf\extra\httpd-vhosts.conf` and add:
        ```apache
        <VirtualHost *:80>
            DocumentRoot "C:/xampp/htdocs/improved_freelance_platform/public_html"
            ServerName freelance-hub.local
            <Directory "C:/xampp/htdocs/improved_freelance_platform/public_html">
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
        ```
    *   **WAMP/Laragon:** Use the server's menu options to create a new virtual host, pointing the document root to the `public_html` directory.
    *   **Edit Hosts File:** Add the following line to your Windows hosts file (`C:\Windows\System32\drivers\etc\hosts` - requires administrator privileges to edit):
        ```
        127.0.0.1 freelance-hub.local
        ```
    *   **Restart Apache:** Restart your Apache server through the XAMPP/WAMP/Laragon control panel for the changes to take effect.

3.  **Create Database and User:**
    *   Open phpMyAdmin (usually accessible via `http://localhost/phpmyadmin`).
    *   Go to the "User accounts" tab.
    *   Click "Add user account".
    *   **Username:** `freelance_user`
    *   **Host name:** `localhost`
    *   **Password:** `freelance_password` (or choose a strong password and update the config file)
    *   **Check:** "Create database with same name and grant all privileges".
    *   Click "Go". This will create the `freelance_platform` database and the user with full privileges on it.
    *   *Alternatively*, you can create the database manually (`CREATE DATABASE freelance_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`) and then create the user and grant privileges (`GRANT ALL PRIVILEGES ON freelance_platform.* TO 'freelance_user'@'localhost' IDENTIFIED BY 'freelance_password'; FLUSH PRIVILEGES;`).

4.  **Initialize Database Schema and Data:**
    *   Open your web browser and navigate to the initialization script URL:
        *   If using Virtual Host: `http://freelance-hub.local/../private/db/initialize_db.php`
        *   If not using Virtual Host: `http://localhost/improved_freelance_platform/private/db/initialize_db.php`
    *   You should see messages indicating successful database and table creation, and initial data insertion.
    *   **Security Note:** It's recommended to remove or restrict access to the `initialize_db.php` script after the initial setup.
    *   *Alternatively*, you can import the `/private/db/schema.sql` file directly using phpMyAdmin's "Import" tab after selecting the `freelance_platform` database.

5.  **Access the Website:**
    *   Open your web browser and navigate to:
        *   If using Virtual Host: `http://freelance-hub.local/`
        *   If not using Virtual Host: `http://localhost/improved_freelance_platform/public_html/`
    *   The Freelance Hub homepage should load.

## Troubleshooting

*   **Forbidden / Access Denied Error:** Check Apache error logs. Ensure the `<Directory>` permissions in your virtual host configuration are correct (`Require all granted`). Ensure the `public_html` directory and its parent directories have appropriate read permissions for the web server user.
*   **Database Connection Error:** Double-check the database name, username, and password in `private/config/database.php` match the ones you created in MySQL. Ensure the MySQL server is running. Verify the `pdo_mysql` extension is enabled in `php.ini`.
*   **File Not Found Errors (404):** Verify the file paths in your code and URLs. Ensure `.htaccess` files (if any are added later for URL rewriting) are configured correctly and `AllowOverride All` is set in your Apache configuration.
*   **PHP Errors:** Check the Apache and PHP error logs for specific error messages. Ensure all required PHP extensions are enabled.
*   **Images/CSS Not Loading:** Check the paths in your HTML (`<link>`, `<img>`, `<script>`) tags. Use your browser's developer tools (F12) to inspect network requests and console errors.

By following these steps, you should be able to run the Freelance Hub website successfully on your Windows machine.
