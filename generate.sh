rm -rf 0.0.0.0:8000
wget --mirror -p --html-extension --level=1 http://0.0.0.0:8000/
echo "Removing index.html"
find ./0.0.0.0:8000 -name "*.html" -print0 | xargs -0 sed -i'' -e 's/index.html//g'
echo "Removing hostname"
find ./0.0.0.0:8000 -name "*.html" -print0 | xargs -0 sed -i'' -e 's/http:\/\/0.0.0.0:8000//g'
