run:


install:
	#php composer install -d /app
	cp -n phpunit.xml.dist phpunit.xml
	git submodule update --recursive --remote

test:
	#$(MAKE) dk -- run --no-deps php ./vendor/bin/phpunit -v

expose:
	ngrok start app --config=ngrok.yml
