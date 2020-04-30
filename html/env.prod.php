<?php

define('DB_NAME', getenv('PICASSO_DB_NAME') ?: 'web_picasso');

/** MySQL database username */
define('DB_USER', getenv('PICASSO_DB_USER') ?: 'guernica');

/** MySQL database password */
define('DB_PASSWORD', getenv('PICASSO_DB_PASSWORD') ?: 'c86YHzQcEVu4PQwnSVUjD84ZyWoH44e');

/** MySQL hostname */
define('DB_HOST', getenv('PICASSO_DB_HOST') ?: 'web-aurora.cluster-cs5n7n8fqpho.us-west-2.rds.amazonaws.com');

// WP Migrate DB Pro registration key 
define('WPMDB_LICENCE', getenv('PICASSO_WPMDB_LICENCE') ?: 'b552b9ae-d654-4ccf-92ae-5072a84466df');

// WP Offload Media registration key
define('AS3CFPRO_LICENCE', getenv('PICASSO_AS3CFPRO_LICENCE') ?: '924650d6-9c01-4180-8207-2073962d6a6d');

// WP Offload Media settings
define(
	'AS3CF_SETTINGS',
	serialize(
		array(
			'provider' => 'aws',
			'use-server-roles' => true,
			'access-key-id' => getenv('AWS_ACCESS_KEY_ID') ?: '',
			'secret-access-key' => getenv('AWS_SECRET_ACCESS_KEY') ?: '',
			'bucket' => getenv('PICASSO_AS3CF_BUCKET') ?: 'img.prod.aplaceformom.com',
			'region' => getenv('PICASSO_AS3CF_REGION') ?: 'us-west-2',
			'copy-to-s3' => true,
			'serve-from-s3' => true,
			'use-yearmonth-folders' => true,
			'force-https' => false,
			'remove-local-file' => false,
			'object-versioning' => false,
			'cloudfront' => getenv('PICASSO_AS3CF_CDN_DOMAIN') ?: 'img.prod.aplaceformom.com',
			// 'domain' => getenv('PICASSO_AS3CF_CDN_DOMAIN') ? 'cloudfront' : 'path',
			'domain' => 'cloudfront',
			'enable-object-prefix' => true,
			'object-prefix' => getenv('PICASSO_AS3CF_CDN_OBJECT_PREFIX') ?: 'main/uploads/',
		)
	)
);
