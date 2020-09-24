#!/bin/bash
#SBATCH --job-name=ewas     # job name in the queue
#SBATCH --time=00:15:00     # wall time
#SBATCH --ntasks=1          # number of tasks (e.g. MPI processes)
#SBATCH --cpus-per-task=1   # number of threads per task (e.g. OpenMP)
#SBATCH --mem=8G            # amount of memory to request

# change to root directory here
export ROOT=/nesi/project/ga02964
#export ROOT=/nesi/project/nesi99999/csco212/ewas_project/rundir
cd $ROOT

if [ -f .env ]
then
  export $(cat .env | xargs)
fi

if [ -f ~/ewas_config ]
then
  export $(cat ~/ewas_config | xargs)
fi

# set input variables here
export EWAS_PORT=${1:-8080}
export EWAS_BASE_WEB_PATH=$2
#export EWAS_BASE_WEB_PATH=${2-/user/${USER}/proxy/$(hostname)/${EWAS_PORT}}
export EWAS_IMG=${ROOT}/ewas.img
export EWAS_ROOT=${ROOT}/ewas_data
export EWAS_OUT=${EWAS_ROOT}/out
export EWAS_UPLOADS=${EWAS_ROOT}/uploads
export EWAS_RESULTS=${EWAS_UPLOADS}/results
export EWAS_TEMP=${ROOT}/temp
export EWAS_REPORT_PATH="https://jupyter.nesi.org.nz/user-redirect/EWASP"

# should not need to edit below this line

# load singularity module
module load Singularity

# report node and port ewasp is running on
echo "EWASP starting on $(hostname) and listening on port ${EWAS_PORT}"
#echo "Proxy via JupyterLab: https://jupyter.nesi.org.nz/user-redirect/proxy/$(hostname)/${EWAS_PORT}/"
echo "Setting EWASP base web path: ${EWAS_BASE_WEB_PATH}"

# make sure directories exist
mkdir -p $EWAS_TEMP
mkdir -p $EWAS_OUT
mkdir -p $EWAS_UPLOADS
mkdir -p $EWAS_RESULTS

# create the myports.conf with custom port
portfile=$(mktemp $PWD/myports.conf.XXXXXX)
cat << EOF > ${portfile}
Listen $EWAS_PORT

<IfModule ssl_module>
        Listen 443
</IfModule>

<IfModule mod_gnutls.c>
        Listen 443
</IfModule>

Alias "/files" "/mnt/data/uploads/results"

<Directory "/mnt/data/uploads/results">
    Require all granted
</Directory>
EOF
echo "Written custom myports.conf to: ${portfile}"

# check email options set, fail otherwise
if [ -z "${EWAS_EMAIL_FROM}" ] || [ -z "${EWAS_EMAIL_HOST}" ] || [ -z "${EWAS_EMAIL_PORT}" ] || [ -z "${EWAS_EMAIL_USER}" ] || [ -z "${EWAS_EMAIL_PASSWORD}" ]; then
    echo "Error: make sure you configure email environment variables such as EWAS_EMAIL_FROM, see the README for instructions"
    exit 1
fi

# run the web app
echo "Running EWASP from: $(pwd)"
singularity run --writable-tmpfs --no-home -B ${PWD},${EWAS_TEMP}:/var/run/apache2/,${EWAS_UPLOADS}:/mnt/data/uploads,${portfile}:/etc/apache2/ports.conf ${EWAS_IMG} /var/www/html/main.sh -o  "${EWAS_OUT}" \
 -u "${EWAS_UPLOADS}" -r "${EWAS_RESULTS}" -t "${EWAS_ROOT}" -f "${EWAS_EMAIL_FROM}" -h "${EWAS_EMAIL_HOST}" -p "${EWAS_EMAIL_PORT}" -s "${EWAS_EMAIL_USER}" -w "${EWAS_EMAIL_PASSWORD}" -b "${EWAS_BASE_WEB_PATH}" -e "${EWAS_REPORT_PATH}" $@

# tidy up
rm ${portfile}
