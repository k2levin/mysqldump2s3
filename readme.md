# mysqldump2s3

[![Build Status](https://travis-ci.org/k2levin/mysqldump2s3.svg?branch=master)](https://travis-ci.org/k2levin/mysqldump2s3)
[![GitHub issues](https://img.shields.io/github/issues/k2levin/mysqldump2s3.svg)](https://github.com/k2levin/mysqldump2s3/issues)
[![GitHub stars](https://img.shields.io/github/stars/k2levin/mysqldump2s3.svg)](https://github.com/k2levin/mysqldump2s3/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/k2levin/mysqldump2s3.svg)](https://github.com/k2levin/mysqldump2s3/network)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/k2levin/mysqldump2s3/master/LICENSE)

### How to install
- Copy `env.yaml.example` to `env.yaml`
- Put database & S3 credentials into `.env`
- Folder `storage` need to have write access by system
- Run `composer install --no-dev --optimize-autoloader`

### How to run
- create **cron job** to run `php` at `./public/index.php`
