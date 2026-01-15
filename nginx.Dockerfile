# Stage 1: Build assets
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Final Nginx image
FROM nginx:stable-alpine

# Copy custom configuration
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Copy public assets from the app (including built ones)
COPY --from=frontend /app/public /var/www/html/public

WORKDIR /var/www/html
