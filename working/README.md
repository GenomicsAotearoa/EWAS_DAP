# Development workflow

The process of building the main Docker image takes a long time mostly due to installation of R packages. This is making the script development process very time consuming. In order to speed up R script development, the working/Dockerfile can be used for quick building of Docker image. 


Once there are script changes (src/r_script_LDS.R) from the project source root, execute the following command:

`sudo docker build --no-cache -t ewas1 -f working/Dockerfile .`

This command will build the ewas1 Docker image by reusing the existing ewas image from the Dockerhub repo that already contains all the R packages. It will also copy the latest script/source files into the ewas1 image.

Once the Docker build completes, build the Singularity image:

`singularity build ewas.img docker-daemon:ewas1:latest`

Singularity/Docker images built this way can be used for testing and debugging. Once the development work has been completed and it has been confirmed that the modified scripts are working as expected, execute the following command:

`sudo ./build`

This will perform first the "long" Docker build and then a Singularity image would be built from it.

# Storing the built docker image into the dockerhub repository

Once the Docker image has been built (using `sudo ./build` command) it can be pushed to the dockerhub Docker image repo in the following way:
`sudo docker login`

This command will prompt you for credentials for loging in to the dockerhub account. For Docker image push to registry to succeed, the account you are using should be authorized to push changes to gaewasp/ewasp dockerhub repository. Once authenticated, execute the following commands:

`sudo docker tag ewas gaewasp/ewasp:latest`
`sudo docker push gaewasp/ewasp:latest`

These will push the newly built Docker image to the gaewasp/ewasp dockerhub repository.