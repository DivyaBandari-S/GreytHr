pipeline {
    agent any
    environment {
        DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
    }
    stages {
        stage('Clone repository') {
            steps {
                script {
                    // Ensure the deployment directory exists
                    bat "if not exist \"${DEPLOY_DIR}\" mkdir \"${DEPLOY_DIR}\""

                    // Clone the repository directly into the deployment directory
                    bat "git clone -b main https://github.com/sssreddys/GreytHr.git \"${DEPLOY_DIR}\""
                }
            }
        }
        stage('Prepare .env file') {
            steps {
                script {
                    // Change directory to where the repo was cloned
                    dir(DEPLOY_DIR) {
                        // Copy .env.example to .env
                        bat 'copy .env.example .env'

                        // Replace placeholders with actual values in .env
                        def envVars = [
                            'DB_CONNECTION': 'mysql',
                            'DB_HOST': 'localhost',
                            'DB_PORT': '3306',
                            'DB_DATABASE': 'greythr',
                            'DB_USERNAME': 'root',
                            'DB_PASSWORD': ''  // Provide the actual password
                        ]

                        envVars.each { key, value ->
                            bat "powershell -Command \"(Get-Content .env) -replace '^${key}=.*', '${key}=${value}' | Set-Content .env\""
                        }
                    }
                }
            }
        }
        stage('Install dependencies and generate APP_KEY') {
            steps {
                script {
                    // Change directory to where the repo was cloned
                    dir(DEPLOY_DIR) {
                        bat 'composer install'
                        bat 'php artisan key:generate'
                    }
                }
            }
        }
        stage('Clear caches and run tests') {
            steps {
                script {
                    // Change directory to where the repo was cloned
                    dir(DEPLOY_DIR) {
                        bat 'php artisan optimize:clear'
                        bat 'php artisan route:cache'
                        bat 'php artisan view:cache'
                        bat 'php artisan test'
                    }
                }
            }
        }
        stage('Run server') {
            steps {
                script {
                    // Run server command from the repo directory
                    dir(DEPLOY_DIR) {
                        bat 'php artisan serve --host=0.0.0.0 --port=8000'
                    }
                }
            }
        }
    }
    post {
        always {
            cleanWs()
        }
    }
}
