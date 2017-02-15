export $UID = $(id -u)
export $GID = $(id -g)

run:
	$(MAKE) dk -- up -d

install:
	$(MAKE) dk -- build
	$(MAKE) dk -- run --no-deps php composer install -d /app

stop:
	$(MAKE) dk down

refresh-containers:
	$(MAKE) dk down
	$(MAKE) dk -- rm -f
	$(MAKE) dk build

dk:
	docker-compose -p awale $(COMMAND_ARGS)

# Utility commands used to pass some arguments (COMMAND_ARGS) to following commands docker
SUPPORTED_COMMANDS := dk
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  COMMAND_ARGS := $(subst :,\:,$(COMMAND_ARGS))
  $(eval $(COMMAND_ARGS):;@:)
endif
