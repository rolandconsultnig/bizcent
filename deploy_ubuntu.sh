#!/usr/bin/env bash
# ==============================================================================
# ROLANDERP / BIZCENTER - UBUNTU SERVER AUTOMATED DEPLOYMENT SCRIPT
# Supported OS: Ubuntu 20.04 LTS / 22.04 LTS / 24.04 LTS
# ==============================================================================

set -e

# Default Configuration
APP_DIR="/var/www/bizcenter"
DB_NAME="db_saas_module"
DB_USER="bizcenter_user"
DB_PASS="BizCenter@2026!Secure"
DOMAIN_OR_IP="${1:-localhost}"

echo "================================================================="
echo "  🚀 Starting RolandERP / Bizcenter Ubuntu Deployment"
echo "  Target Domain/IP: $DOMAIN_OR_IP"
echo "================================================================="

# 1. Update Packages
echo "📦 Step 1: Updating system packages..."
sudo apt update && sudo apt upgrade -y

# 2. Install Nginx, PHP, MySQL and Required Extensions
echo "📦 Step 2: Installing Nginx, MySQL, and PHP 8.3 with extensions..."
sudo apt install -y software-properties-common lsb-release ca-certificates apt-transport-https
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update

sudo apt install -y nginx mysql-server \
  php8.3 php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-mbstring \
  php8.3-xml php8.3-zip php8.3-intl php8.3-bcmath php8.3-soap git unzip curl

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

# 5. Import Database Schema if schema file exists
if [ -f "$APP_DIR/install/mysql_full_schema.sql" ]; then
    echo "📥 Importing database schema..."
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

# 8. Configure Nginx Virtual Host
echo "🌐 Step 7: Configuring Nginx virtual host..."
sudo tee /etc/nginx/sites-available/bizcenter > /dev/null << EOF
server {
    listen 80;
    server_name $DOMAIN_OR_IP;
    root $APP_DIR;
    index index.php index.html;

    client_max_body_size 128M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
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
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl restart php8.3-fpm
sudo systemctl restart nginx

# 9. Setup Background Cron Job
echo "⏱️ Step 8: Configuring system cron jobs..."
(crontab -l 2>/dev/null | grep -v "$APP_DIR"; echo "* * * * * php $APP_DIR/index.php cron >/dev/null 2>&1") | crontab -

echo "================================================================="
echo "  ✅ RolandERP / Bizcenter is DEPLOYED & ONLINE!"
echo "  🌐 URL: http://$DOMAIN_OR_IP"
echo "  🔑 Default Admin: admin / admin123"
echo "================================================================="
