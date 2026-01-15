#!/bin/bash

# Configuration
DOCKER_USERNAME="your-username"
IMAGE_NAME="tutoring-app"
TAG="latest"

# Build PHP image
echo "Building PHP image..."
docker build -t $DOCKER_USERNAME/$IMAGE_NAME-php:$TAG -f Dockerfile .

# Build Nginx image
echo "Building Nginx image..."
docker build -t $DOCKER_USERNAME/$IMAGE_NAME-nginx:$TAG -f nginx.Dockerfile .

echo "Build complete!"
echo "To push to Docker Hub, run:"
echo "docker login"
echo "docker push $DOCKER_USERNAME/$IMAGE_NAME-php:$TAG"
echo "docker push $DOCKER_USERNAME/$IMAGE_NAME-nginx:$TAG"
