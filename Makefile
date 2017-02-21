run:


install:
	composer install
	cp -n phpunit.xml.dist phpunit.xml
	git submodule update --recursive --remote

test:
	phpunit -v

expose:
	ngrok start app --config=ngrok.yml
