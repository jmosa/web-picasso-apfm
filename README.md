# picasso

Picasso is the primary WordPress CMS that serves content for the public-facing websites (aplaceformom.com, alzheimers.net, et al).

## Local development

0. Be on a mac/nix machine
1. Install docker
1. Set up automatic custom post type sync on git pull: `cp ./post-merge ./.git/hooks/`
1. Create the docker network: `./build-scripts/create-docker-network.sh`
1. Set your `.env` file: `cp .env.local .env` and replace any "secret" values in it (ask a member on the dev team for the keys)
1. Edit your hosts file `/etc/hosts` and add the line `127.0.0.1 web-picasso.local.aplaceformom.com` to the end
1. Start picasso: `docker-compose up picasso picasso-wp-db` and wait ~30 seconds or so for it to start up
1. Import the initial sql for the database: `docker-compose run --rm wp-cli wp db import initial.sql`
1. Import latest dev db: `./import-picasso-db.sh dev`
1. Picasso should be available on http://web-picasso.local.aplaceformom.com/core/wp-admin
