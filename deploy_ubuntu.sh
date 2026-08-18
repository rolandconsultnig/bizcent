#!/usr/bin/env bash
# ==============================================================================
# ROLANDERP / BIZCENTER - PRODUCTION DEPLOYMENT (/var/www/bitcent on PORT 2035)
# ==============================================================================

set -e

APP_DIR="/var/www/bitcent"
DB_NAME="db_saas_module"
DB_USER="bizcenter_user"
DB_PASS="BizCenter@2026!Secure"
PORT=2035
DOMAIN_OR_IP="${1:-$(curl -s ifconfig.me || echo 'localhost')}"

echo "================================================================="
echo "  🚀 Deploying to $APP_DIR on Port $PORT"
echo "================================================================="

# Clean any broken third-party PPAs
sudo rm -f /etc/apt/sources.list.d/*ondrej* /etc/apt/sources.list.d/ppa_ondrej* 2>/dev/null || true
sudo sed -i '/ondrej/d' /etc/apt/sources.list 2>/dev/null || true

# 1. Update and ensure PHP extensions are installed
echo "📦 Step 1: Ensuring PHP & extensions are present..."
sudo apt update -y
sudo apt install -y php php-fpm php-mysql php-curl php-gd php-mbstring php-xml php-zip php-intl php-bcmath php-soap git unzip curl

# Detect active PHP-FPM socket
PHP_SOCK=$(find /var/run/php/ -name "php*-fpm.sock" 2>/dev/null | head -n 1)
if [ -z "$PHP_SOCK" ]; then
    PHP_SOCK="/var/run/php/php-fpm.sock"
fi
echo "Using PHP-FPM socket: $PHP_SOCK"

# 2. Configure MySQL Database & User
echo "🗄️ Step 2: Configuring MySQL database ($DB_NAME)..."
sudo mysql -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';"
sudo mysql -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"

# 3. Setup Codebase in /var/www/bitcent
echo "📂 Step 3: Setting up repository in $APP_DIR..."
sudo mkdir -p $APP_DIR
if [ -d "$APP_DIR/.git" ]; then
    cd $APP_DIR && sudo git pull origin main
else
    # If directory has files or is empty, clone or fetch
    if [ "$(ls -A $APP_DIR 2>/dev/null)" ]; then
        cd $APP_DIR
        sudo git init
        sudo git remote add origin https://github.com/rolandconsultnig/bizcent.git 2>/dev/null || sudo git remote set-url origin https://github.com/rolandconsultnig/bizcent.git
        sudo git fetch origin
        sudo git checkout -f main
    else
        sudo git clone https://github.com/rolandconsultnig/bizcent.git $APP_DIR
    fi
fi

# 4. Import Full Database Schema & Seeds
if [ -f "$APP_DIR/install/mysql_full_schema.sql" ]; then
    echo "📥 Step 4: Importing database schema and tables..."
    sudo mysql "$DB_NAME" < "$APP_DIR/install/mysql_full_schema.sql" || true
fi

# 5. Configure Permissions
echo "🔒 Step 5: Setting permissions..."
sudo chown -R www-data:www-data $APP_DIR
sudo find $APP_DIR -type d -exec chmod 755 {} \;
sudo find $APP_DIR -type f -exec chmod 644 {} \;
sudo chmod -R 775 $APP_DIR/uploads $APP_DIR/application/cache $APP_DIR/application/logs

# 6. Database Connection File
echo "⚙️ Step 6: Writing database.php..."
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

# 7. Configure Nginx on Port 2035
echo "🌐 Step 7: Configuring Nginx on port $PORT..."
sudo tee /etc/nginx/sites-available/bitcent > /dev/null << EOF
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

sudo ln -sf /etc/nginx/sites-available/bitcent /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default /etc/nginx/sites-enabled/bizcenter 2>/dev/null || true

# Open Firewall Port 2035
if command -v ufw > /dev/null; then
    sudo ufw allow $PORT/tcp || true
fi

sudo nginx -t
sudo systemctl restart php*-fpm || true
sudo systemctl restart nginx

# 8. Background Cron
(crontab -l 2>/dev/null | grep -v "$APP_DIR"; echo "* * * * * php $APP_DIR/index.php cron >/dev/null 2>&1") | crontab -

echo "================================================================="
echo "  ✅ DEPLOYED TO $APP_DIR ON PORT $PORT!"
echo "  🌐 URL: http://$DOMAIN_OR_IP:$PORT"
echo "  🔑 Default Admin: admin / admin123"
echo "================================================================="
