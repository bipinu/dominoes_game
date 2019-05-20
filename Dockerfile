FROM phpdockerio/php71-cli:latest
ADD . /code
WORKDIR /code

CMD ["php", "start.php"]