pipeline {
    agent any
    environment {
        DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
    }
    stages {
        stage('Clone repository') {
            steps {
                git 'https://github.com/sssreddys/GreytHr.git'
            }
        }
        stage('Prepare .env file') {
            steps {
                script {
                    // Copy .env.example to .env
                    bat 'copy .env.example .env'

                    // Replace placeholders with actual values in .env
                    def envVars = [
                        'DB_CONNECTION': 'mysql',
                        'DB_HOST': 'localhost',
                        'DB_PORT': '3306',
                        'DB_DATABASE': 'your-db-name',
                        'DB_USERNAME': 'your-db-username',
                        'DB_PASSWORD': 'your-db-password'
                    ]

                    envVars.each { key, value ->
                        bat "powershell -Command \"(Get-Content .env) -replace '^${key}=.*', '${key}=${value}' | Set-Content .env\""
                    }
                }
            }
        }
        stage('Install dependencies and generate APP_KEY') {
            steps {
                bat 'composer install'
                bat 'php artisan key:generate'
            }
        }
        stage('Clear caches and run tests') {
            steps {
                bat 'php artisan config:cache'
                bat 'php artisan route:cache'
                bat 'php artisan view:cache'
                bat 'php artisan test'
            }
        }
        stage('Run server') {
            steps {
                bat 'php artisan serve --host=0.0.0.0 --port=8000'
            }
        }
    }
    post {
        always {
            cleanWs()
        }
    }
}
