require 'capistrano/ext/multistage'

#set :stages, ["dev", "testenv", "prod"]
set :stages, %w(dev testenv prod)
#set :default_stage, "dev"

# What is the name of the local application?
set :application, "emplayo"

# What user is connecting to the remote server?
set :user, "emplayo"
set :password, "BradCammon2013"  # The deploy user's password

# Where is the local repository?
set :repository,  "git@github.com:intakeha/emplayo.git"

# What is the production server domain?
role :web, "emplayo.com"

# What remote directory hosts the website?
#set :deploy_to,   "/var/www/vhosts/emplayo.com/dev"
#set :shared_path, "#{deploy_to}/shared"
set :shared_children, shared_children + %w{uploads/images/company_logos/temp}
set :shared_children, shared_children + %w{uploads/images/company_profile_pics/temp}

# Is sudo required to manipulate files on the remote server?
set :use_sudo, false

# What version control solution does the project use?
set :scm,        :git
#	set :branch,     'develop'

# How are the project files being transferred?
#set :deploy_via, :copy
set :deploy_via, :remote_cache


# Maintain a local repository cache. Speeds up the copy process.
set :copy_cache, true

# Ignore any local files?
set :copy_exclude, [".git", ".DS_Store"]
