pipeline {
    agent any
    environment {
        DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
        GIT_PATH = 'C:\\Users\\SivaKumarSaragada\\AppData\\Local\\Programs\\Git\\cmd\\git.exe'
    }
    stages {
        stage('Check Repository') {
            steps {
                script {
                    def repoExists = bat(script: "if exist \"${DEPLOY_DIR}\\.git\" (echo true) else (echo false)", returnStdout: true).trim()
                    if (repoExists == 'false') {
                        echo 'Repository not found. Cloning repository.'
                        // Proceed to clone repository
                        currentBuild.result = 'SUCCESS' // Ensure the build is marked as successful if the repo exists or is cloned
                        currentBuild.description = 'Cloning repository'
                        currentBuild.displayName = "Cloning ${currentBuild.number}"
                    } else {
                        echo 'Repository already cloned.'
                        // Skip cloning stage
                        currentBuild.result = 'SUCCESS'
                        currentBuild.description = 'Skipping repository clone'
                        currentBuild.displayName = "Skipping clone ${currentBuild.number}"
                    }
                }
            }
        }
        stage('Clone repository') {
            when {
                expression {
                    return bat(script: "if exist \"${DEPLOY_DIR}\\.git\" (echo false) else (echo true)", returnStdout: true).trim() == 'true'
                }
            }
            steps {
                script {
                    // Ensure the deployment directory exists
                    bat "if not exist \"${DEPLOY_DIR}\" mkdir \"${DEPLOY_DIR}\""

                    // Clone the repository directly into the deployment directory
                    bat "\"${GIT_PATH}\" clone -b main https://github.com/sssreddys/GreytHr.git \"${DEPLOY_DIR}\""
                }
            }
        }
        stage('Prepare .env file') {
            when {
                expression {
                    def envExists = bat(script: "if exist \"${DEPLOY_DIR}\\.env\" (echo true) else (echo false)", returnStdout: true).trim()
                    return envExists == 'false'
                }
            }
            steps {
                script {
                    dir(DEPLOY_DIR) {
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
