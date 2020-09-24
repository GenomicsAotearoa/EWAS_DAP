# Running via JupyterHub on NeSI

There are two ways to run via JupyterHub on NeSI. The first is the simplest but
you are limited to the resources that you can request on the JupyterHub spawner
screen (128 GB RAM at the time of writing). The other option is to submit a
separate Slurm job requesting required resources and proxy to the web app via
JupyterLab.

## Setting up

Set things up (these only need to be done once). These steps are required
whichever of the two following options you choose for running the web app.

1. Configure the environment variables as described in the [main README](../README.md)
2. Copy the jupyter notebook config, e.g. from this directory run:
   ```sh
   $ mkdir -p ~/.jupyter
   $ cp jupyter_notebook_config.py ~/.jupyter/jupyter_notebook_config.py
   ```
3. Edit the notebook config with the correct path to the EWAS run script (i.e.
   this directory). Open *~/.jupyter/jupyter_notebook_config.py* and change
   `/nesi/project/ga02964/run_ewas_jupyter` if required.
4. Make sure the *ewas.img* Singularity image exists in this directory

Following these steps you will need to stop JupyterLab if you have it running
("File menu" -> "Hub control panel" -> "Stop my server") and launch a new one,
to pick up the above changes.

## Running directly via JupyterLab

Once JupyterLab has loaded back up again, you should see an "EWASP" button.
Clicking this will launch the EWASP web app in a new browser tab. Note the
web app will run within the resources you selected on the JupyerHub spawner
screen (CPUs, memory, time limit, etc).

## Running in a separate Slurm job

TODO
