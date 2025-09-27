FROM nginx:latest

# Copy custom Nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Optional: wait-for-app script (if needed for startup sequencing)
COPY wait-for-app.sh /wait-for-app.sh
RUN chmod +x /wait-for-app.sh

# Start Nginx directly (skip wait script if not needed)
CMD ["nginx", "-g", "daemon off;"]
