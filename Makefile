run:
	$(MAKE) dk up -d

install:
	$(MAKE) dk build

stop:
	$(MAKE) dk down

dk:
	docker-compose -p awale $(COMMAND_ARGS)

SUPPORTED_COMMANDS := dk
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))
ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  COMMAND_ARGS := $(subst :,\:,$(COMMAND_ARGS))
  $(eval $(COMMAND_ARGS):;@:)
endif
