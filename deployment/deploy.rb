##
# Basic Config
##

# the name of this app - can be whatever you like
set :application, "bagajob-API"

# the GitHub URL to clone
# make sure you update with your details
set :repo_url, "git@github.com:develop-me/bagajob-API.git"


##
# Linked files/directories
# Some files that aren't in your Git repo need to be
# preserved between deployments, these are "linked"
##

# Keep the .env file around between deployments
set :linked_files, fetch(:linked_files, []).push(".env")

# Keep the storage directory around between deployments
set :linked_dirs, fetch(:linked_dirs, []).push("storage")


##
# Tasks
# On each deployment, run these tasks
##
namespace :deploy do

    # optimize task
    # clears and recaches views/routes/config
    task :optimize do
        on roles(:app) do
            info "Clearing cached views"
            execute "php #{current_path}/artisan view:clear"

            # only works if *all* routes point to a controller
            info "Caching routes"
            execute "php #{current_path}/artisan route:cache"

            info "Caching config"
            execute "php #{current_path}/artisan config:cache"
        end
    end

    # composer task
    # runs composer install
    task :composer do
        on roles(:app) do
            info "Install Composer packages"
            execute "composer install"
        end
    end

    # migrate_db task
    # migrates the database
    task :migrate_db do
        on roles(:app) do
            info "Migrating DB"
            execute "php #{current_path}/artisan migrate"
        end
    end

    # php_reload task
    # reloads PHP-FPM
    # otherwise old content can still appear
    task :php_reload do
        on roles(:app) do
            info "Restarting PHP-FPM"
            execute "sudo service php7.4-fpm reload"
        end
    end

    ##
    # Queue tasks
    # we need to tell them *when* to run
    ###

    # run these tasks once the code has been published
    after :published, "optimize"
    after :published, "composer"
    after :published, "migrate_db"
    after :published, "php_reload"
end