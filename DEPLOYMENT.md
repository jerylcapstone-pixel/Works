# Homeless Dogs Map Deployment Guide

## Option 1: Heroku (Free Tier Available)
1. Create a Heroku account
2. Install Heroku CLI
3. Create app: `heroku create your-app-name`
4. Add MySQL add-on: `heroku addons:create cleardb:ignite`
5. Push code: `git push heroku main`
6. Set environment variables in Heroku dashboard

## Option 2: DigitalOcean App Platform
1. Create DigitalOcean account
2. Use App Platform for PHP/MySQL deployment
3. Connect GitHub repository
4. Configure database and environment

## Option 3: AWS Lightsail or EC2
1. Launch Ubuntu instance
2. Install Apache/PHP/MySQL
3. Clone repository
4. Configure virtual host

## Option 4: Local Development
- Use XAMPP/WAMP for Windows
- Use MAMP for Mac
- Use Docker for containerized deployment

## Environment Variables Needed:
- DB_HOST
- DB_NAME  
- DB_USER
- DB_PASS

## Database Setup:
Run the SQL commands from README.md to create tables.
