all: generate deploy
backup-images:
	aws s3 sync --profile personal s3://quisimages ./images
generate:
	rm -rf 0.0.0.0:8000
	wget --mirror -p --html-extension --level=1 http://0.0.0.0:8000/
	echo "Removing index.html"
	find ./0.0.0.0:8000 -name "*.html" -print0 | xargs -0 sed -i'' -e 's/index.html//g'
	echo "Removing hostname"
	find ./0.0.0.0:8000 -name "*.html" -print0 | xargs -0 sed -i'' -e 's/http:\/\/0.0.0.0:8000//g'
serve-static:
	cd ./0.0.0.0:8000
	python3 -m http.server 5555
deploy:
	aws s3 sync --profile personal --region eu-west-1 ./0.0.0.0:8000 s3://www.quis.cc
