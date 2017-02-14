run:
	docker-compose -p awale up -d

install:
	docker-compose -p awale build

logs:
	docker-compose -p awale logs -f

ps:
	docker-compose -p awale ps

stop:
	docker-compose -p awale down
