all: theme

theme: clean
	mkdir -p build/stage
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
	         . build/stage
	zip build/tedx.zip build/stage/*
	rm -rf build/stage

.PHONY: clean

clean:
	rm -rf build
