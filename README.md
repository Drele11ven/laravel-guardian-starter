# Laravel Breeze Starter Kit with reCAPTCHA, Google OAuth, Activity Log & More

A robust Laravel starter repository designed to jumpstart new projects with essential features pre-integrated and ready to use.

## Features

- **Laravel Breeze Authentication**  
  Lightweight, modern auth scaffolding with login, registration, password reset, and email verification.

- **Google reCAPTCHA v3 Integration**  
  Protects your forms from spam and bots with invisible reCAPTCHA v3, including backend validation and reusable Blade component.

- **Google OAuth2 Social Login**  
  Login with Google via OAuth2 for seamless social authentication.

- **Advanced Activity Log System**  
  Logs detailed user actions automatically, including:  
  - Controller and route name  
  - Route and request parameters  
  - IP address and user-agent  
  - HTTP method, full URL, and referer URL  
  Includes Blade shortcode partials for easy integration.

- **Inappropriate Content Detection & Logging**  
  Detects and logs user inputs containing custom-defined bad words with details:  
  - User ID & name (if logged in)  
  - IP address  
  - URL, request data, and detected words  
  - Timestamp  
  Comes with shortcode partials for easy use.

- **User Online Status Tracking**  
  Tracks last seen time and dynamically displays online/offline status based on recent activity (e.g., last 5 minutes). Usable in Blade views, controllers, or APIs.

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/laravel-breeze-starter.git
   cd laravel-breeze-starter

2. Install dependencies:

    ```bash
    composer install
    npm install && npm run dev

3. Copy .env.example and configure your environment variables:

    ```bash
    cp .env.example .env
- Set your database credentials
- Add Google OAuth credentials
- Add Google reCAPTCHA site key and secret key

4. Generate application key:

    ```bash
    php artisan key:generate

5. Run migrations and seeders:

    ```bash
    php artisan migrate --seed

6. Serve the application:

    ```bash
    php artisan serve


## Usage

- Users can register and log in using either email/password or Google OAuth.  
- All relevant forms are secured with invisible reCAPTCHA v3 to prevent spam and bot activity.  
- User actions and interactions are logged in detail; you can build your own admin dashboard or API to view these activity logs.  
- Inputs are scanned for inappropriate content based on customizable bad word lists, with automatic logging of any violations.  
- User online/offline status is tracked in real-time and can be displayed anywhere using the included Blade components.

## Blade Components & Shortcodes

- `<x-recaptcha-v3 action="register|login|custom" />` — Inserts the invisible reCAPTCHA v3 token field into forms, with support for specifying different action contexts.  
- Ready-to-use shortcodes are provided for embedding activity logs and inappropriate content reports in your UI.

## Configuration

All settings for Google OAuth and reCAPTCHA keys can be found and customized in `config/services.php`.

## Contributing

Contributions, bug reports, and feature requests are very welcome! Please open issues or pull requests to help improve this project.

## License

This project is licensed under the MIT License © Your Name

---

⭐ If you find this starter kit useful, please give it a star!

Let me know if you want me to generate any other docs or examples!
