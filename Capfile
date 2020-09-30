# setup where the Capistrano configuration files live
set :deploy_config_path, 'deployment/deploy.rb'
set :stage_config_path, 'deployment/deploy'

# Load DSL and set up stages
require 'capistrano/setup'

# Include default deployment tasks
require 'capistrano/deploy'
require 'capistrano/console'

# Include the composer module
# Handles installing composer for us
require 'capistrano/composer'

# Use Git
# Other version management systems are available
require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git