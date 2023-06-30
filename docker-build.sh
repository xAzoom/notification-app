#!/bin/bash

#COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 is experimental (buildkit)
COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 USER_ID=$(id -u) GROUP_ID=$(id -g) USER_NAME=$(whoami) docker-compose build