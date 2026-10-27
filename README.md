# What is this repo?

Tools for publishing [quis.cc](http://quis.cc).

# How it works

- Runs Wordpress locally inside a Docker container
- Spiders the local-running site with `wget` to create a static mirror
  of the Wordpress site
- Deploys the static mirror to Amazon S3

# Requires

- Docker
- Python
- AWS CLI

# Getting it running locally

- `make build-docker-image`
- `make wordpress`
- `make pull-images pull-database-dumps` (requires AWS credentials)
- `dump="2000-00-00\\ 00:00.sql" make import-database` (replace with latest `.sql` file as appropriate)
- `make frontend`
- Go to [http://localhost:8000](http://localhost:8000)

# To generate the static mirror into `./static`

- `make generate`

# To see the static site locally

- `make serve-static`
