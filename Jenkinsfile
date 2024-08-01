pipeline {
    agent any
    environment {
        DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
        GIT_URL = 'https://github.com/Nikhithanadiminti/GreytHr.git'
        GIT_BRANCH = 'main'
         GIT_PATH = 'C:\\Program Files\\Git\\cmd\\git.exe'
        //GIT_PATH = 'C:\\Users\\SivaKumarSaragada\\AppData\\Local\\Programs\\Git\\cmd\\git.exe'
    }
    triggers {
        pollSCM('* * * * *') // This will check for changes in the SCM every minute
    }
    stages {
        stage('Create Directory') {
            steps {
                bat """
                if not exist "${DEPLOY_DIR}" mkdir "${DEPLOY_DIR}"
                """
            }
        }
        stage('Check and Update/Clone Repository') {
            steps {
                script {
                    def gitDirExists = fileExists("${DEPLOY_DIR}\\\\.git")
                    if (gitDirExists) {
                        dir("${DEPLOY_DIR}") {
                            bat """
                            "${env.GIT_PATH}" fetch --all
                            "${env.GIT_PATH}" reset --hard origin/${GIT_BRANCH}
                            """
                        }
                    } else {
                        def dirNotEmpty = bat(script: "if exist ${DEPLOY_DIR}\\* (echo 1)", returnStatus: true) == 0
                        if (dirNotEmpty) {
                            bat """
                            timeout /t 10
                            del /Q ${DEPLOY_DIR}\\*.*
                            rmdir /S /Q ${DEPLOY_DIR}
                            """
                        }
                        bat """
                        mkdir ${DEPLOY_DIR}
                        "${env.GIT_PATH}" clone -b ${GIT_BRANCH} ${GIT_URL} ${DEPLOY_DIR}
                        """
                    }
                }
            }
        }
        stage('Prepare .env file') {
            steps {
                script {
                    def envFileExists = fileExists("${DEPLOY_DIR}\\\\.env")
                    if (envFileExists) {
                        bat """
                        del /Q ${DEPLOY_DIR}\\\\.env
                        """
                    }
                    bat """
                    copy ${DEPLOY_DIR}\\\\.env.example ${DEPLOY_DIR}\\\\.env
                    """
                }
            }
        }
        stage('Install dependencies and generate APP_KEY') {
            steps {
                dir("${DEPLOY_DIR}") {
                    bat """
                    composer install
                    php artisan key:generate
                    """
                }
            }
        }
        stage('Clear caches and run tests') {
            steps {
                dir("${DEPLOY_DIR}") {
                    bat """
                    php artisan config:clear
                    php artisan cache:clear
                    php artisan route:clear
                    php artisan view:clear
                    php artisan optimize:clear
                    """
                }
            }
        }
        stage('Run server') {
            steps {
                dir("${DEPLOY_DIR}") {
                    bat 'php artisan serve --host=0.0.0.0 --port=8000'
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
