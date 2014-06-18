all: theme

theme: clean
	mkdir -p build/tedx
	rsync -a --exclude build \
	         --exclude assets \
	         --exclude vendor \
	         --exclude '.idea' \
	         --exclude '.git' \
	         --exclude '.bowerrc' \
	         --exclude '.gitignore' \
	         --exclude '.jshintrc' \
	         --exclude package.json \
	         --exclude bower.json \
	         --exclude Gulpfile.js \
	         --exclude node_modules \
	         --exclude README.md \
	         --exclude Makefile \
	         . build/tedx

.PHONY: clean

clean:
	rm -rf build
