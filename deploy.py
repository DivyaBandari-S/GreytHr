import requests
from requests.auth import HTTPBasicAuth

# Jenkins server details
JENKINS_URL = 'http://localhost:2020'
JENKINS_USERNAME = 'sivareddy'
JENKINS_PASSWORD = 'sivareddy'
JOB_NAME = 'laravel_new_deploy'

# Deployment directory
DEPLOY_DIR = 'C:\\xampp\\htdocs\\python_deploy_server'

# Repository details
REPO_URL = 'https://github.com/sssreddys/GreytHr.git'

# Function to get Jenkins Crumb and Session
def get_jenkins_crumb_and_session():
    crumb_url = f'{JENKINS_URL}/crumbIssuer/api/json'
    session = requests.Session()
    response = session.get(crumb_url, auth=HTTPBasicAuth(JENKINS_USERNAME, JENKINS_PASSWORD))
    response.raise_for_status()
    crumb_data = response.json()
    return crumb_data['crumb'], crumb_data['crumbRequestField'], session

# Get the crumb and session
crumb, crumb_field, session = get_jenkins_crumb_and_session()

# Debugging output for the crumb
print(f"Jenkins Crumb: {crumb}")

# Pipeline script
pipeline_script = f"""
pipeline {{
    agent any
    stages {{
        stage('Clone Repository') {{
            steps {{
                script {{
                    if (isUnix()) {{
                        sh 'git clone {REPO_URL} {DEPLOY_DIR} || (cd {DEPLOY_DIR} && git pull)'
                    }} else {{
                        bat 'git clone {REPO_URL} {DEPLOY_DIR} || (cd {DEPLOY_DIR} && git pull)'
                    }}
                }}
            }}
        }}
        stage('Setup Environment') {{
            steps {{
                script {{
                    if (isUnix()) {{
                        sh 'cd {DEPLOY_DIR} && composer install'
                        sh 'cd {DEPLOY_DIR} && cp .env.example .env'
                        sh 'cd {DEPLOY_DIR} && php artisan key:generate'
                        sh 'cd {DEPLOY_DIR} && php artisan migrate'
                        sh 'cd {DEPLOY_DIR} && php artisan db:seed'
                        sh 'cd {DEPLOY_DIR} && php artisan cache:clear'
                        sh 'cd {DEPLOY_DIR} && php artisan config:clear'
                        sh 'cd {DEPLOY_DIR} && php artisan route:clear'
                        sh 'cd {DEPLOY_DIR} && php artisan view:clear'
                    }} else {{
                        bat 'cd {DEPLOY_DIR} && composer install'
                        bat 'cd {DEPLOY_DIR} && copy .env.example .env'
                        bat 'cd {DEPLOY_DIR} && php artisan key:generate'
                        bat 'cd {DEPLOY_DIR} && php artisan migrate'
                        bat 'cd {DEPLOY_DIR} && php artisan db:seed'
                        bat 'cd {DEPLOY_DIR} && php artisan cache:clear'
                        bat 'cd {DEPLOY_DIR} && php artisan config:clear'
                        bat 'cd {DEPLOY_DIR} && php artisan route:clear'
                        bat 'cd {DEPLOY_DIR} && php artisan view:clear'
                    }}
                }}
            }}
        }}
    }}
}}
"""

# Job configuration XML
job_config = f"""
<flow-definition plugin="workflow-job@2.40">
  <description>Pipeline for Laravel application deployment</description>
  <keepDependencies>false</keepDependencies>
  <properties/>
  <definition class="org.jenkinsci.plugins.workflow.cps.CpsFlowDefinition" plugin="workflow-cps@2.89">
    <script>{pipeline_script}</script>
    <sandbox>true</sandbox>
  </definition>
  <triggers/>
  <disabled>false</disabled>
</flow-definition>
"""

def job_exists(job_name):
    job_url = f"{JENKINS_URL}/job/{job_name}/api/json"
    response = session.get(job_url, auth=HTTPBasicAuth(JENKINS_USERNAME, JENKINS_PASSWORD))
    return response.status_code == 200

def create_job(job_name, job_config, crumb_field, crumb):
    create_job_url = f'{JENKINS_URL}/createItem?name={job_name}'
    headers = {
        'Content-Type': 'application/xml',
        crumb_field: crumb
    }
    response = session.post(create_job_url, data=job_config, headers=headers, auth=HTTPBasicAuth(JENKINS_USERNAME, JENKINS_PASSWORD))

    # Debugging output
    print(f"Status Code: {response.status_code}")
    print(f"Response Text: {response.text}")

    return response.status_code == 200

def trigger_job(job_name, crumb_field, crumb):
    build_url = f"{JENKINS_URL}/job/{job_name}/build"
    headers = {
        crumb_field: crumb
    }
    response = session.post(build_url, headers=headers, auth=HTTPBasicAuth(JENKINS_USERNAME, JENKINS_PASSWORD))
    return response.status_code == 201

def main():
    if not job_exists(JOB_NAME):
        print(f"Job '{JOB_NAME}' does not exist. Creating job.")
        if create_job(JOB_NAME, job_config, crumb_field, crumb):
            print(f"Job '{JOB_NAME}' created successfully.")
        else:
            print(f"Failed to create job '{JOB_NAME}'.")
            return
    else:
        print(f"Job '{JOB_NAME}' already exists.")

    print(f"Triggering job '{JOB_NAME}'...")
    if trigger_job(JOB_NAME, crumb_field, crumb):
        print(f"Job '{JOB_NAME}' triggered successfully.")
    else:
        print(f"Failed to trigger job '{JOB_NAME}'.")

if __name__ == "__main__":
    main()
