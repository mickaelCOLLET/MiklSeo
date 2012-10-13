#! /bin/sh

clear
rm -rf ../data/*
phpunit --process-isolation --bootstrap Bootstrap.php ./MiklSeo/