<?php
namespace Deployer;

require 'recipe/symfony.php';

// Config

set('repository', 'https://github.com/PosAlex73/new_posrtal.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('31.129.100.177')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/portal');

// Hooks

after('deploy:failed', 'deploy:unlock');
