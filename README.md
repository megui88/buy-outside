I buy outside  [![Build Status](https://travis-ci.org/megui88/buy-outside.svg?branch=other)](https://travis-ci.com/megui88/buy-outside)
=======

[http://www.comproafuera.com.ar/](http://www.comproafuera.com.ar/)

### Please, it is necessary to have
* docker:  [Ubuntu](https://docs.docker.com/engine/installation/linux/ubuntu/) or [Mac](https://docs.docker.com/docker-for-mac/install/)
* docker-compose [Ubuntu](https://docs.docker.com/compose/install/) 

## First steps
```
git clone --recursive git@github.com:megui/buy-outside.git
cd buy-outside
cp laradock/.env.dist laradock/.env
echo "APPLICATION=../src" >> laradock/.env
cp src/.env.example src/.env
cd laradock/
docker-compose up -d nginx
docker-compose exec workspace bash
composer install
exit
```
Go to: [localhost](http://localhost/) 

## Usage

Just run `cd laradock; docker-compose up -d nginx`, then:

## When you need to use the artisan console

```
cd laradock/
docker-compose exec workscpace bash
./artisan
```

## Debug

How to config Xdebug? [click me](http://laradock.io/#install-xdebug)

Any problems create issue ♥


Enjoy 😆!
