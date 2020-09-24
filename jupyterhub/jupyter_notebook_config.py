c.ServerProxy.servers = {
  'EWASP': {
    'command': ['/nesi/project/ga02964/run_ewas_jupyter', '{port}', '{base_url}EWASP'],
    'timeout': 10,
  },
}

# allow proxying to anywhere
def host_whitelist(handler, host):
    return True
c.ServerProxy.host_whitelist = host_whitelist
