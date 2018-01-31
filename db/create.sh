#!/bin/sh

if [ "$1" = "travis" ]
then
    psql -U postgres -c "CREATE DATABASE biblioteca_test;"
    psql -U postgres -c "CREATE USER biblioteca PASSWORD 'biblioteca' SUPERUSER;"
else
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists biblioteca
    [ "$1" != "test" ] && sudo -u postgres dropdb --if-exists biblioteca_test
    [ "$1" != "test" ] && sudo -u postgres dropuser --if-exists biblioteca
    sudo -u postgres psql -c "CREATE USER biblioteca PASSWORD 'biblioteca' SUPERUSER;"
    [ "$1" != "test" ] && sudo -u postgres createdb -O biblioteca biblioteca
    sudo -u postgres createdb -O biblioteca biblioteca_test
    LINE="localhost:5432:*:biblioteca:biblioteca"
    FILE=~/.pgpass
    if [ ! -f $FILE ]
    then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE
    then
        echo "$LINE" >> $FILE
    fi
fi
