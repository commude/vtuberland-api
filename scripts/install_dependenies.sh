#!/bin/bash
if ! [ -x "$(command -v apache2)" ]; then sudo apt install apache2;   exit 1; fi # install apache2 if not already installed
if ! [ -x "$(command -v composer)" ]; then php composer-setup.php --install-dir=/usr/local/bin --filename=composer;   exit 1; fi # install composer if not already installed


