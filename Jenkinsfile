pipeline {
    agent any
    environment {
        DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
        GIT_PATH = 'C:\\Users\\SivaKumarSaragada\\AppData\\Local\\Programs\\Git\\cmd\\git.exe'
    }
    stages {
        stage('Create Directory') {
            steps {
                script {
                    // Create the deployment directory if it doesn't exist
                    bat "if not exist \"${DEPLOY_DIR}\" mkdir \"${DEPLOY_DIR}\""
                }
            }
        }
        stage('Check and Update/Clone Repository') {
            steps {
                script {
                    dir(DEPLOY_DIR) {
                        def repoExists = bat(script: "if exist .git (echo true) else (echo false)", returnStdout: true).trim()
                        if (repoExists == 'true') {
                            echo 'Repository exists. Pulling latest changes.'
                            bat "\"${GIT_PATH}\" pull origin main"
                        } else {
                            echo 'Repository does not exist. Cloning repository.'
                            bat "\"${GIT_PATH}\" clone -b main https://github.com/sssreddys/GreytHr.git ."
                        }
                    }
                }
            }
        }
        stage('Prepare .env file') {
            steps {
                script {
                    dir(DEPLOY_DIR) {
                        def envExists = bat(script: "if exist .env (echo true) else (echo false)", returnStdout: true).trim()
                        if (envExists == 'false') {
                            echo '.env file does not exist. Creating from .env.example.'
                            bat 'copy .env.example .env'

                            def envVars = [
                                'DB_CONNECTION': 'mysql',
                                'DB_HOST': 'localhost',
                                'DB_PORT': '3306',
                                'DB_DATABASE': 'greythr',
                                'DB_USERNAME': 'root',
                                'DB_PASSWORD': ''  // Provide the actual password
                            ]

                            envVars.each { key, value ->
                                def keyExists = bat(script: "findstr /C:\"${key}=\" .env", returnStatus: true) == 0
                                if (keyExists) {
                                    bat "powershell -Command \"(Get-Content .env) -replace '^${key}=.*', '${key}=${value}' | Set-Content .env\""
                                } else {
                                    bat "echo ${key}=${value} >> .env"
                                }
                            }
                        } else {
                            echo '.env file already exists.'
                        }
                    }
                }
            }
        }
        stage('Install dependencies and generate APP_KEY') {
            steps {
                script {
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
                    dir(DEPLOY_DIR) {
                        bat 'php artisan optimize:clear'
                        bat 'php artisan route:cache'
                        bat 'php artisan view:cache'
                        // Uncomment the following line to run tests
                        // bat 'php artisan test'
                    }
                }
            }
        }
        stage('Run server') {
            steps {
                script {
                    dir(DEPLOY_DIR) {
                        bat 'php artisan serve'
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
