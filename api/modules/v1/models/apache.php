<VirtualHost *:80>
    ServerName api.dev.com
    DocumentRoot "/~lincoln/advanced/api/web/"

    <Directory "/~lincoln/advanced/api/web/">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # use index.php as index file
    DirectoryIndex index.php

    # ...other settings...
    # Apache 2.4
    Require all granted

    ## Apache 2.2
    # Order allow,deny
    # Allow from all
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName backend.dev.com
    DocumentRoot "/~lincoln/advanced/backend/web/"

    <Directory "/~lincoln/advanced/backend/web/">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # use index.php as index file
    DirectoryIndex index.php

    # ...other settings...
    # Apache 2.4
    Require all granted

    ## Apache 2.2
    # Order allow,deny
    # Allow from all
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerName frontend.dev.com
    DocumentRoot "/~lincoln/advanced/frontend/web/"

    <Directory "/~lincoln/advanced/frontend/web">
    # use mod_rewrite for pretty URL support
    RewriteEngine on
    # If a directory or a file exists, use the request directly
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # Otherwise forward the request to index.php
    RewriteRule . index.php

    # use index.php as index file
    DirectoryIndex index.php

    # ...other settings...
    # Apache 2.4
    Require all granted

    ## Apache 2.2
    # Order allow,deny
    # Allow from all
    </Directory>
</VirtualHost>