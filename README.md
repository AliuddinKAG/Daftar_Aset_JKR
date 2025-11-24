## Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (for frontend assets)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Daftar_Aset_JKR
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Install package DomPDF**
    ```bash
   composer require barryvdh/laravel-dompdf
    ```
    

5. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=asset_form
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Build Frontend Assets**
   ```bash
   npm run build
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```
