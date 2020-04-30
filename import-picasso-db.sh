#!/usr/bin/env bash

set -e

FROM_APP_LOCATION=$1
TO_APP_LOCATION=$(grep APP_LOCATION= .env | cut -d "=" -f 2)
SECRET_KEY=$(grep PICASSO_WMPDB_PULL_SECRET= .env | cut -d "=" -f 2)
FROM_URL=$(grep PICASSO_EXTERNAL_URL= .env.$FROM_APP_LOCATION | cut -d "=" -f 2)
TO_URL=$(grep PICASSO_EXTERNAL_URL= .env | cut -d "=" -f 2)

set -x

docker-compose run --rm wp-cli wp migratedb pull $FROM_URL/core $SECRET_KEY --backup=prefix --find=$FROM_URL --replace=$TO_URL --skip-replace-guids

# deactivate image cdn plugin as it will cause fatal errors in local environment without access to s3
docker-compose run --rm wp-cli wp plugin deactivate amazon-s3-and-cloudfront-pro --network
