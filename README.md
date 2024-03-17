# Progmix CMS

Welcome to Progmix CMS! This repository contains the source code for Progmix CMS, a content management system.

## Getting Started

Follow these steps to set up and run Progmix CMS on your local machine.

### Prerequisites

- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [PHP](https://www.php.net/)
- [MySQL](https://www.mysql.com/)

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/your-username/progmix-cms.git
    ```

2. *Setting up an Empty Database**
   ```bash
   1.  Open the .env.example file.
   2.  Locate the database configuration section.
   3.  Modify the database name to your preference; the default is set to "laravel."
   ```


3. **Install Composer dependencies:**

    ```bash
    composer install
    ```
4. **Migrate the Database**
    ```
    php artisan migrate
    ```
     ```
    php artisan plugin:migrate author/plugin-name
    ```
5. **Install NPM packages:**

    ```bash
    npm install
    ```

6. **Compile assets:**

    ```bash
    npm run build:frontend
    npm run watch:frontend
    npm run build:cms
    npm run build:plugins
    npm run build:plugin --plugin=plugin_name
    ```

7. **Create symbolic link for storage:**

    ```bash
    php artisan storage:link
    ```

8. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

9.  **Admin Control Panel (admin-cp) credentials:**

    ```bash
    php artisan db:seed admin      

    admin@gmail.com
    123456
    ```
    

### Usage

You can now run Progmix CMS locally:

```bash
php artisan serve
# CMS
