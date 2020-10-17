FROM alpine AS certs
WORKDIR /ssl

RUN apk update && \
  apk add --no-cache openssl && \
  rm -rf /var/cache/apk/*

COPY docker/ssl.ext /ssl

RUN openssl rand -base64 48 > /pass
RUN openssl genrsa -des3 -passout file:/pass -out divarsoyrssCA.key 2048
RUN openssl req -x509 -new -passin file:/pass -nodes -key divarsoyrssCA.key -sha256 -days 825 -out divarsoyrssCA.pem \
-subj "/C=UK/O=mdgroup/OU=Domain Control Validated/CN=divarsoyrss.loc"

RUN openssl rsa -in divarsoyrssCA.key -passin file:/pass -out divarsoyrssCA.key

RUN openssl genrsa -passout file:/pass -out divarsoyrss.key 2048
RUN openssl req -new -passin file:/pass -key divarsoyrss.key -out divarsoyrss.csr \
-subj "/C=UK/O=mdgroup/OU=Domain Control Validated/CN=divarsoyrss.loc"

RUN openssl x509 -req -in divarsoyrss.csr -CA divarsoyrssCA.pem -CAkey divarsoyrssCA.key -CAcreateserial \
    -out divarsoyrss.crt -days 825 -sha256 -extfile ssl.ext

FROM php:7.4-apache
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www

COPY --from=certs /ssl /ssl

ENV TZ=Europe/London
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update &&\
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git default-mysql-client zip unzip &&\
    rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY docker/php.ini /usr/local/etc/php/php.ini
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite ssl alias php7 headers

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]
