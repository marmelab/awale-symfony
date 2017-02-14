run:
	docker-compose -p awale up -d

install:
	docker-compose -p awale build

dc:
	docker-compose -p awale $(args)

stop:
	docker-compose -p awale down
