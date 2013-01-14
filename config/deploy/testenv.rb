server "emplayo.com", :app, :web, :db, :primary => true
set :deploy_to, "/var/www/vhosts/emplayo.com/test"
set :branch, 'testing'
