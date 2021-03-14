#!/bin/bash

dockerize -wait tcp://mariadb:3306 -timeout 120s

/brg_panel/vendor/bin/phinx migrate -c /brg_panel/config/phinx.php
/brg_panel/vendor/bin/phinx seed:run -c /brg_panel/config/phinx.php
