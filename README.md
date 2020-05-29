## Kalakari Street
Internship Assignment for Tiny Elephant Enterprises

### Tools
- Visual Studio Code (IDE)
- Git & GitHub Desktop (Version Control & Deploying)
- XAMPP for development environment (Apache 2 & PHPMyAdmin)
- Apache2, MySQL on AWS Elastic Compute (Mumbai AZ)
- Cloudflare for CDN, caching, auto-minifying resources and enhanced security.

### Installation and Usage
- Clone this repository
- Start Apache and MySQL servers on localhost (XAMPP can be used)
- Import database from SQL dump
- Rename ```db_config_temp.ini``` to ```db_config.ini``` and configure it for your local environment
- Naviagate to ```localhost/kalakari``` to browse the application

### Available APIs
- PART A - Backend Assignment
  - READ : \[GET\] localhost/kalakari/api/getProduct.php?product_id=VALID_PRODUCT_ID
  - WRITE : \[POST\] localhost/kalakari/api/setProduct.php
  - UPDATE : \[POST\] localhost/kalakari/api/updateProduct.php

- PART B - Frontend Assignment
  - B.1 Input User Form : localhost/kalakari/
  - B.2 Full Page UI for Pop-Out Filter : localhost/kalakari/popout-filter
  - B.3 Image auto-play carousel : localhost/kalakari/carousel
  - B.4 Menu header with motion effects : localhost/kalakari/header

## Deployed Application
- This repository has been hosted, and can be accessed [here](https://ajinkya.space/kalakari/ "Kalakari Assignment")

