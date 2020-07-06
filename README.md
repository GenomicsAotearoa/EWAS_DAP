# EWAS (Epigenetic-Wide Association Study)  Data Analysis Pipeline

This repository contains the code base for our EWAS pipeline tools.

# To run locally

...

# Building Docker image

Note: to build the Docker image you need to have priviledged access

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

EWAS_OUT
EWAS_UPLOADS
EWAS_RESULTS
EWAS_ROOT
EWAS_EMAIL_FROM 
EWAS_EMAIL_HOST
EWAS_EMAIL_PORT
EWAS_EMAIL_USER
EWAS_EMAIL_PASSWORD

# Running the docker image

1. Modify the .env file to set the correct variable values or set these in the current environment
2. run `sudo ./run_docker`

# Running the singularity image

1. Modify the .env file to set the correct variable values or set these in the current environment
2. run `sudo ./run_docker`

# To run on HPC/singularity

Note: you must first build the singularity image on a system where docker can run in priviledged mode:

1. run "sudo ./build" to build the docker image and produce a corresponding singularity file (ewas.img) 
2. copy the ewas.img file to a location on the cluster where the job will run from

Then to run on the cluster:

1. set up port forwarding, e.g. on your local machine run `ssh -L 8083:localhost:8083 mahuika`
2. set the environment variables (on the cluster)
3. submit the run script to the queue `sbatch run_ewas_slurm` (on the cluster)
4. on your local machine connect to http://localhost:8083/
