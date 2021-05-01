Installation
============

To install GLSR, you must meet the following requirements.

## 1. Clone the repo at first

```
git clone https://github.com/Dev-Int/glsr.git
```

## 2. Start the docker stack

The project use [docker](https://docs.docker.com/get-docker/) (_install it, if you don't have it_), and with the `Makefile`
 enter this command in your terminal:

```bash
$ make install
```

All necessary dependencies will be installed, and docker containers get started.

Now, you can open your browser with url:

```
http://localhost/
```

The next section learn you [how to configure the application](setup.md)
