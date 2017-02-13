all: generate deploy
wordpress:
	docker-compose down
	docker-compose up -d
preprocess:
	rm -rf static/*
mirror:
	wget --mirror -p -nH --directory-prefix=static --level=1000 --html-extension -q --show-progress http://localhost:8000/
postprocess:
	echo "Removing index.html"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/index.html//g'
	echo "Removing hostname"
	find ./static -name "*.html" -print0 | xargs -0 sed -i'' -e 's/http:\/\/localhost:8000//g'
generate: preprocess mirror postprocess
serve-static:
	cd ./static
	python3 -m http.server 5555
deploy:
	aws s3 sync --profile personal --region eu-west-1 ./static s3://quis.cc
backup-images:
	aws s3 sync --profile personal s3://quisimages ./images
