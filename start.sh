#!/bin/bash

apt-get update && apt-get install -y php

php -S 0.0.0.0:${PORT:-8000} Net.php
