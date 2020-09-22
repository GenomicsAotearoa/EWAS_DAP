# EWAS (Epigenetic-Wide Association Study)  Data Analysis Pipeline

This repository contains the code base for our EWAS pipeline tools.

# To run locally

Build the docker and singularity images, make sure .env file contains the right values and then invoke ./run_ewas script

# Building Docker image

Note: in most cases, to build the Docker image you need to have priviledged access. It is possible to run docker without 'sudo'
if the system is configured appropriately (see https://askubuntu.com/questions/477551/how-can-i-use-docker-without-sudo for reference). Running rootless docker in rootless mode is also possible, more details on: https://docs.docker.com/engine/security/rootless/

1. install docker as described here: https://docs.docker.com/engine/install/ 
2. run `sudo ./build_docker`

# Building Singularity image

Note: to build the Singularity image from the Docker image you need to have priviledged access

1. install singularity as described here: https://sylabs.io/guides/3.3/user-guide/installation.html
2. have the docker image already built
3. run `sudo ./build_singularity`

# Building all together

Note: all pre-requisites for building Docker and Singularity images apply as stated above

To build both Docker and Singularity images run `sudo ./build`

# Environment variables

These are best set in the ewas_config file that should be placed in the user's home folder for security reasons as it contains email password. Sample ewas_config file is available in this project  

EWAS_EMAIL_FROM - "from" email address to be used in the job report email  
EWAS_EMAIL_HOST - email server host to be used for sending the job report email (i.e. smtp.gmail.com)  
EWAS_EMAIL_PORT - email server port to be used for sending the job report email (i.e. 495)  
EWAS_EMAIL_USER - email server's username used for login  
EWAS_EMAIL_PASSWORD - email server's user password - KEEP CONFIDENTIAL !!!  

# Running the docker image

1. Modify the .env file to set the correct variable values or set these in the current environment
2. run `sudo ./run_docker`

# Running the singularity image

1. Modify the .env file to set the correct variable values or set these in the current environment
2. run `sudo ./run_ewas`

# To run on HPC/singularity

Note: you must first build the singularity image on a system where docker can run in priviledged mode:

1. run "sudo ./build" to build the docker image and produce a corresponding singularity file (ewas.img) 
2. copy the ewas.img file to a location on the cluster where the job will run from

Then to run on the cluster:

1. choose a unique port that is not used by somebody else, high port numbers are probably safe,
   e.g. > 10000, here we use 10083, replace it with your chosen port in the commands below
2. set up port forwarding, e.g. on your local machine run `ssh -L 10083:localhost:10083 mahuika`
3. edit the Slurm script run_ewas_slurm (on the cluster)
   * set the environment variables
   * make sure to set `EWAS_PORT` to the port you chose above
   * set the resource requirements (memory, wall time, etc)
3. submit the run script to the queue `sbatch run_ewas_slurm` (on the cluster)
4. check the status of the Slurm job `squeue -u $USER` (on the cluster)
5. once the job is running, on your local machine connect to http://localhost:10083/
