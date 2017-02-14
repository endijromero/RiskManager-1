#!/bin/sh
ROOT=`pwd`
bower install
composer install
cd public/assets/plugins-bower/jquery.sparkline
make
cd $ROOT