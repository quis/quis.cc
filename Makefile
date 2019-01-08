all: generate deploy

build-docker-image:
	docker build -t wordpress-exif .
stop:
	docker-compose down
wordpress: stop
	docker-compose up -d
frontend:
	cd ./source/themes/quis/ && npm start
preprocess:
	rm -rf static/*
mirror:
	wget --mirror -p -nH --directory-prefix=static --level=1000 --html-extension -q --show-progress http://localhost:8000/
mirror-frontend:
	curl http://localhost:8000/wp-content/themes/quis/css/quis.css > ./static/wp-content/themes/quis/css/quis.css
	curl http://localhost:8000/wp-content/themes/quis/js/quis.js > ./static/wp-content/themes/quis/js/quis.js
postprocess:
	echo "Removing index.html"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/index.html//g'
	echo "Removing hostname"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/http:\/\/localhost:8000//g'
generate: preprocess other-files mirror postprocess
serve-static:
	cd ./static && python3 -m http.server 5555
other-files:
	cp ./source/favicon.ico ./static/
	cp ./source/keybase.txt ./static/
deploy:
	aws s3 sync --profile personal --region eu-west-1 ./static s3://quis.cc
upload-images:
	aws s3 sync --profile personal --region eu-west-1 ./images s3://images.quis.cc
backup-images:
	aws s3 sync --profile personal s3://images.quis.cc ./images
dump-database:
	$(eval DATETIME := $(shell echo $$(date +"%Y-%m-%d %H:%M")))
	docker exec -it wordpressdocker_db_1 mysqldump -u wordpress -pwordpress wordpress > "./dumps/$(DATETIME).sql"
import-database:
	docker exec -i wordpressdocker_db_1 mysql -u wordpress -pwordpress wordpress < $(dump)
sync-database-dumps:
	aws s3 sync --profile personal ./dumps s3://quisdbbackups
pull-database-dumps:
	aws s3 sync --profile personal s3://quisdbbackups ./dumps
backup-database: dump-database sync-database-dumps
