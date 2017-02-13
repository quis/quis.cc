all: generate deploy
wordpress:
	docker-compose down
	docker-compose up -d
generate:
	rm -rf static/*
	wget --mirror -p -nH --directory-prefix=static --level=1000 --html-extension http://localhost:8000/
	echo "Removing index.html"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/index.html//g'
	echo "Removing hostname"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/http:\/\/0.0.0.0:8000//g'
serve-static:
	cd ./static
	python3 -m http.server 5555
deploy:
	aws s3 sync --profile personal --region eu-west-1 ./static s3://quis.cc
backup-images:
	aws s3 sync --profile personal s3://quisimages ./images
