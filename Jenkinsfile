// upload the the file to the server using ftp transfer using the jenkins pipeline
pipeline {
    agent any

    environment {
        FTP_HOST = 'ftp.yourdomain.com'
        FTP_USER = 'yourftpusername'
        FTP_PASS = 'yourftppassword'
        FTP_REMOTE_DIR = '/path/on/server/'  // Adjust for your server path
        LAST_DEPLOYED_FILE = "${FTP_REMOTE_DIR}/.last_deployed_commit"
    }

    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'main', url: 'https://github.com/yourrepo.git'
            }
        }

        stage('Find Last Deployed Commit') {
            steps {
                script {
                    def lastCommit = sh(script: """
                        lftp -c "
                        open -u ${FTP_USER},${FTP_PASS} ${FTP_HOST}
                        cat ${LAST_DEPLOYED_FILE} || echo ''
                        quit
                        "
                    """, returnStdout: true).trim()

                    env.LAST_DEPLOYED_COMMIT = lastCommit ?: "HEAD~1"
                }
            }
        }

        stage('Find Modified Files') {
            steps {
                script {
                    def changedFiles = sh(script: "git diff --name-only ${env.LAST_DEPLOYED_COMMIT}", returnStdout: true).trim()
                    if (changedFiles) {
                        writeFile file: 'changed_files.txt', text: changedFiles
                    }
                }
            }
        }

        stage('Deploy Only Changed Files') {
            steps {
                script {
                    withCredentials([usernamePassword(credentialsId: 'ftp-credentials', usernameVariable: 'FTP_USER', passwordVariable: 'FTP_PASS')]) {
                        sh """
                        while read file; do
                            lftp -c "
                            open -u ${FTP_USER},${FTP_PASS} ${FTP_HOST}
                            put -O ${FTP_REMOTE_DIR} $file
                            quit
                            "
                        done < changed_files.txt
                        """
                    }
                }
            }
        }

        stage('Update Last Deployed Commit') {
            steps {
                script {
                    def latestCommit = sh(script: "git rev-parse HEAD", returnStdout: true).trim()
                    sh """
                    echo ${latestCommit} | lftp -c "
                    open -u ${FTP_USER},${FTP_PASS} ${FTP_HOST}
                    put -O ${FTP_REMOTE_DIR} - "
                    """
                }
            }
        }
    }
}

// ####################################################### this is the jenkins pipeline script for uploading files in to the server
// pipeline {
//     agent any
//     environment {
//         DEPLOY_DIR = 'C:\\xampp\\htdocs\\deploye_server'
//         GIT_URL = 'https://github.com/sssreddys/GreytHr.git'
//         GIT_BRANCH = 'main'
//         GIT_PATH = 'C:\\Program Files\\Git\\cmd\\git.exe'
//         //         GIT_PATH = 'C:\\Users\\SivaKumarSaragada\\AppData\\Local\\Programs\\Git\\cmd\\git.exe'
//     }
//     triggers {
//         githubPush()
//     }
//     stages {
//         stage('Create Directory') {
//             steps {
//                 bat """
//                 if not exist "${DEPLOY_DIR}" mkdir "${DEPLOY_DIR}"
//                 """
//             }
//         }
//         stage('Check and Update/Clone Repository') {
//             steps {
//                 script {
//                     def gitDirExists = fileExists("${DEPLOY_DIR}\\.git")
//                     if (gitDirExists) {
//                         dir("${DEPLOY_DIR}") {
//                             bat """
//                             "${env.GIT_PATH}" fetch --all
//                             "${env.GIT_PATH}" reset --hard origin/${GIT_BRANCH}
//                             """
//                         }
//                     } else {
//                         def dirNotEmpty = bat(script: "if exist ${DEPLOY_DIR}\\* (echo 1)", returnStatus: true) == 0
//                         if (dirNotEmpty) {
//                             bat """
//                             timeout /t 10
//                             del /Q ${DEPLOY_DIR}\\*.*
//                             rmdir /S /Q ${DEPLOY_DIR}
//                             """
//                         }
//                         bat """
//                         mkdir ${DEPLOY_DIR}
//                         "${env.GIT_PATH}" clone -b ${GIT_BRANCH} ${GIT_URL} ${DEPLOY_DIR}
//                         """
//                     }
//                 }
//             }
//         }
//         stage('Prepare .env file') {
//             steps {
//                 script {
//                     def envFileExists = fileExists("${DEPLOY_DIR}\\.env")
//                     if (envFileExists) {
//                         bat """
//                         del /Q ${DEPLOY_DIR}\\.env
//                         """
//                     }
//                     bat """
//                     copy ${DEPLOY_DIR}\\.env.example ${DEPLOY_DIR}\\.env
//                     """
//                 }
//             }
//         }
//         stage('Install dependencies and generate APP_KEY') {
//             steps {
//                 dir("${DEPLOY_DIR}") {
//                     bat '''
//                     composer install
//                     php artisan key:generate
//                     '''
//                 }
//             }
//         }
//         stage('Clear caches and run tests') {
//             steps {
//                 dir("${DEPLOY_DIR}") {
//                     bat '''
//                     php artisan config:clear
//                     php artisan cache:clear
//                     php artisan route:clear
//                     php artisan view:clear
//                     php artisan optimize:clear
//                     '''
//                 }
//             }
//         }
//         stage('Run server') {
//             steps {
//                 echo 'Deployment steps completed successfully.'
//             }
//         }
//     }
//     post {
//         always {
//             cleanWs()
//         }
//     }
// }
