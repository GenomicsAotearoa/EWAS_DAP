#!/bin/bash
# dir                     <-  toString(args[1])
# normalize               <-  toString(args[2])
# email                   <-  toString(args[3])
# snp                     <-  toString(args[4])
# xy_chr                  <-  toString(args[5])
# cr_pro                  <-  toString(args[6])
# pheno                   <-  toString(args[7])
# DM                      <-  toString(args[8])
# data_load_method        <-  toString(args[9])           # 1 for champ and 2 for minfi
# arraytype               <-  toString(args[10])          #"EPIC" and "450K"
# deconv                  <-  toString(args[11])          
# com_type                <-  toString(args[12])
# array_corr              <-  toString(args[13])
# batch_corr              <-  toString(args[14])
# norm_name               <-  toString(args[15])

MODE="web"
EWAS_OUT=""
EWAS_UPLOADS=""
EWAS_RESULTS=""
EWAS_ROOT=""
EWAS_EMAIL_FROM=""
EWAS_EMAIL_HOST=""
EWAS_EMAIL_PORT=""
EWAS_EMAIL_USER=""
EWAS_EMAIL_PASSWORD=""
EWAS_BASE_WEB_PATH=""
EWAS_REPORT_PATH="http://localhost:10083"

POSITIONAL=()
while [[ $# -gt 0 ]]
do
key="$1"

case $key in
    -m|--mode)
    MODE="$2"
    shift # past argument
    shift # past value
    ;;
    -b|--base)
    EWAS_BASE_WEB_PATH="$2"
    shift # past argument
    shift # past value
    ;;
    -e|--report)
    EWAS_REPORT_PATH="$2"
    shift # past argument
    shift # past value
    ;;
    -o|--out)
    EWAS_OUT="$2"
    shift # past argument
    shift # past value
    ;;
    -u|--uploads)
    EWAS_UPLOADS="$2"
    shift # past argument
    shift # past value
    ;;
    -r|--results)
    EWAS_RESULTS="$2"
    shift # past argument
    shift # past value
    ;;
    -t|--root)
    EWAS_ROOT="$2"
    shift # past argument
    shift # past value
    ;;
    -f|--from)
    EWAS_EMAIL_FROM="$2"
    shift # past argument
    shift # past value
    ;;
    -h|--host)
    EWAS_EMAIL_HOST="$2"
    shift # past argument
    shift # past value
    ;;
    -p|--port)
    EWAS_EMAIL_PORT="$2"
    shift # past argument
    shift # past value
    ;;
    -s|--user)
    EWAS_EMAIL_USER="$2"
    shift # past argument
    shift # past value
    ;;
    -w|--password)
    EWAS_EMAIL_PASSWORD="$2"
    shift # past argument
    shift # past value
    ;;
    --default)
    DEFAULT=YES
    echo "DEFAULT"
    shift # past argument
    ;;
    *)    # unknown option
    POSITIONAL+=("$1") # save it in an array for later
    shift # past argument
    ;;
esac
done

echo "MODE = $MODE"
echo "EWAS_OUT = $EWAS_OUT"
echo "EWAS_UPLOADS = $EWAS_UPLOADS"
echo "EWAS_RESULTS = $EWAS_RESULTS"
echo "EWAS_ROOT = $EWAS_ROOT"
echo "EWAS_EMAIL_FROM = $EWAS_EMAIL_FROM"
echo "EWAS_EMAIL_HOST = $EWAS_EMAIL_HOST"
echo "EWAS_EMAIL_PORT = $EWAS_EMAIL_PORT"
echo "EWAS_BASE_WEB_PATH = $EWAS_BASE_WEB_PATH"
echo "EWAS_REPORT_PATH = $EWAS_REPORT_PATH"

if [ "$MODE" = "web" ] 
then
    printf "Subject: EWAS web app started\n\nEWAS web app has started. You can access it via web browser at %s" $EWAS_REPORT_PATH | msmtp --host=$EWAS_EMAIL_HOST --from=$EWAS_EMAIL_FROM --port=$EWAS_EMAIL_PORT --auth=on --tls=on --user=$EWAS_EMAIL_USER --passwordeval="echo $EWAS_EMAIL_PASSWORD" $EWAS_EMAIL_FROM
    cd /var/www/html
    apache2-foreground
    # while true; do sleep 1000; done;
fi
