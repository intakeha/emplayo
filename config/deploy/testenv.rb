server "emplayo.com", :app, :web, :db, :primary => true
set :deploy_to, "/var/www/vhosts/emplayo.com/test"
set :shared_path, "#{deploy_to}/shared"
set :branch, 'testing'

# This task does post deploy configuration for the target environment 
task :post_deploy_config, :roles => :web do
  run "cp #{release_path}/application/config/environment.config.testing #{release_path}/application/config/environment.config"
  run "ln -s #{shared_path}/uploads #{release_path}/uploads"
end
 
# After deployment has successfully completed
# perform the post deploy config task(s)
after "deploy:finalize_update", :post_deploy_config
