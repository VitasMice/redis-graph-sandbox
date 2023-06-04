start:
	docker-compose up -d

stop:
	docker-compose down

exec:
	docker exec -it php_sandbox sh
