#!/usr/bin/env bash
# ==============================================================================
# ROLANDERP / BIZCENTER - UBUNTU PRODUCTION SERVER DEPLOYMENT SCRIPT (PORT 2030)
# Supports: Ubuntu 20.04 (Focal), 22.04 (Jammy), 24.04 (Noble), & Dev Releases
# ==============================================================================

set -e

# Default Configuration
APP_DIR="/var/www/bizcenter"
DB_NAME="db_saas_module"
DB_USER="bizcenter_user"
DB_PASS="BizCenter@2026!Secure"
PORT=2030
DOMAIN_OR_IP="${1:-$(curl -s ifconfig.me || echo 'localhost')}"

echo "================================================================="
echo "  🚀 Starting RolandERP / Bizcenter Ubuntu Deployment (Port $PORT)"
echo "  Target URL: http://$DOMAIN_OR_IP:$PORT"
echo "================================================================="

# Clean any broken third-party PPAs first
echo "🧹 Cleaning broken PPA repositories..."
sudo rm -f /etc/apt/sources.list.d/*ondrej* /etc/apt/sources.list.d/ppa_ondrej* 2>/dev/null || true
sudo sed -i '/ondrej/d' /etc/apt/sources.list 2>/dev/null || true
if [ -d "/etc/apt/sources.list.d" ]; then
    sudo grep -l "ondrej" /etc/apt/sources.list.d/* 2>/dev/null | xargs -r sudo rm -f || true
fi

# 1. Update Packages
echo "📦 Step 1: Updating system package index..."
sudo apt clean && sudo apt update -y

# 2. Detect and Install PHP & Extensions
echo "📦 Step 2: Installing Nginx, MySQL Server, and PHP..."
sudo apt install -y nginx mysql-server php php-fpm php-mysql php-curl php-gd php-mbstring php-xml php-zip php-intl php-bcmath php-soap git unzip curl

# Detect active PHP-FPM socket
PHP_SOCK=$(find /var/run/php/ -name "php*-fpm.sock" 2>/dev/null | head -n 1)
if [ -z "$PHP_SOCK" ]; then
    PHP_SOCK="/var/run/php/php-fpm.sock"
fi
echo "Using PHP-FPM socket: $PHP_SOCK"

# 3. Configure MySQL Database & User
echo "🗄️ Step 3: Setting up MySQL database ($DB_NAME)..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';"
sudo mysql -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# 4. Clone or Setup Application Code
echo "📂 Step 4: Setting up application files at $APP_DIR..."
sudo mkdir -p $APP_DIR
if [ -d "$APP_DIR/.git" ]; then
    echo "Updating existing repository..."
    cd $APP_DIR && sudo git pull origin main
else
    echo "Cloning repository..."
    sudo git clone https://github.com/rolandconsultnig/bizcent.git $APP_DIR
fi

# 5. Import Database Schema
if [ -f "$APP_DIR/install/mysql_full_schema.sql" ]; then
    echo "📥 Importing database schema and seed data..."
    sudo mysql "$DB_NAME" < "$APP_DIR/install/mysql_full_schema.sql" || true
fi

# 6. Configure Permissions
echo "🔒 Step 5: Configuring file ownership and permissions..."
sudo chown -R www-data:www-data $APP_DIR
sudo find $APP_DIR -type d -exec chmod 755 {} \;
sudo find $APP_DIR -type f -exec chmod 644 {} \;
sudo chmod -R 775 $APP_DIR/uploads $APP_DIR/application/cache $APP_DIR/application/logs

# 7. Update database.php configuration
echo "⚙️ Step 6: Configuring database connection..."
sudo tee $APP_DIR/application/config/database.php > /dev/null << 'EOF'
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'bizcenter_user',
	'password' => 'BizCenter@2026!Secure',
	'database' => 'db_saas_module',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
EOF

# 8. Configure Nginx Virtual Host on Port 2030
echo "🌐 Step 7: Configuring Nginx virtual host on port $PORT..."
sudo tee /etc/nginx/sites-available/bizcenter > /dev/null << EOF
server {
    listen $PORT;
    server_name _;
    root $APP_DIR;
    index index.php index.html;

    client_max_body_size 128M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:$PHP_SOCK;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg)$ {
        expires max;
        log_not_found off;
    }
}
EOF

sudo ln -sf /etc/nginx/sites-available/bizcenter /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

# Open firewall port 2030 if UFW is active
if command -v ufw > /dev/null; then
    echo "🛡️ Opening UFW firewall port $PORT..."
    sudo ufw allow $PORT/tcp || true
fi

sudo nginx -t
sudo systemctl restart php*-fpm || true
sudo systemctl restart nginx

# 9. Setup Background Cron Job
echo "⏱️ Step 8: Configuring system cron jobs..."
(crontab -l 2>/dev/null | grep -v "$APP_DIR"; echo "* * * * * php $APP_DIR/index.php cron >/dev/null 2>&1") | crontab -

echo "================================================================="
echo "  ✅ RolandERP / Bizcenter is DEPLOYED & ACTIVE on PORT $PORT!"
echo "  🌐 URL: http://$DOMAIN_OR_IP:$PORT"
echo "  🔑 Default Admin: admin / admin123"
echo "================================================================="
