#!/bin/sh

BASE_DIR=$(dirname $(readlink -f "$0"))
if [ "$1" != "test" ]
then
    psql -h localhost -U biblioteca -d biblioteca < $BASE_DIR/biblioteca.sql
fi
psql -h localhost -U biblioteca -d biblioteca_test < $BASE_DIR/biblioteca.sql
