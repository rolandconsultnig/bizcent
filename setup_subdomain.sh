#!/usr/bin/env bash
# ==============================================================================
# SUBDOMAIN NGINX & SSL SETUP FOR erp.fastprotectsecsolutions.com
# ==============================================================================

set -e

DOMAIN="erp.fastprotectsecsolutions.com"
APP_DIR="/var/www/bitcent"

echo "================================================================="
echo "  🚀 Configuring Nginx for $DOMAIN"
echo "  Root: $APP_DIR"
echo "================================================================="

# Detect active PHP-FPM socket
PHP_SOCK=$(find /var/run/php/ -name "php*-fpm.sock" 2>/dev/null | head -n 1)
if [ -z "$PHP_SOCK" ]; then
    PHP_SOCK="/var/run/php/php-fpm.sock"
fi
echo "Using PHP-FPM socket: $PHP_SOCK"

# 1. Create Nginx Virtual Host
sudo tee /etc/nginx/sites-available/$DOMAIN > /dev/null << EOF
server {
    listen 80;
    listen 2035;
    server_name $DOMAIN 66.45.231.142;
    root $APP_DIR;
    index index.php index.html;

    client_max_body_size 128M;

    # CodeIgniter URL Rewriting
    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    # PHP-FPM Processing
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:$PHP_SOCK;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }

    # Deny hidden files
    location ~ /\.ht {
        deny all;
    }

    # Static Assets Caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2|ttf|svg)$ {
        expires max;
        log_not_found off;
    }
}
EOF

# 2. Enable Site and remove default
sudo ln -sf /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default 2>/dev/null || true

# 3. Allow Firewall Ports
if command -v ufw > /dev/null; then
    sudo ufw allow 80/tcp 2>/dev/null || true
    sudo ufw allow 443/tcp 2>/dev/null || true
    sudo ufw allow 2035/tcp 2>/dev/null || true
fi

# 4. Test & Restart Nginx
sudo nginx -t
sudo systemctl restart nginx

echo "================================================================="
echo "  ✅ Nginx Virtual Host Active for http://$DOMAIN"
echo "================================================================="
