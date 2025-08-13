#!/bin/bash

SERVICE_NAME="laravel-zero"

CONTAINER_ID=$(docker-compose ps -q "$SERVICE_NAME")

if [ -z "$CONTAINER_ID" ]; then
  echo "Container is not running. Starting docker-compose..."
  docker-compose up -d
  CONTAINER_ID=$(docker-compose ps -q "$SERVICE_NAME")
fi

echo "Connecting to container $CONTAINER_ID..."
docker exec -it "$CONTAINER_ID" bash
