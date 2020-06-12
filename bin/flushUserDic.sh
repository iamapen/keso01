#!/bin/bash
BASE_DIR=$(cd $(dirname $0);pwd)
cd $BASE_DIR

ROOT_DIR=$(cd ../;pwd)
STORAGE_DIR="${ROOT_DIR}/storage"
DIC_DIR="${STORAGE_DIR}/dic"


/usr/libexec/mecab/mecab-dict-index -d "/usr/lib64/mecab/dic/ipadic" \
-u "${DIC_DIR}/user.dic" \
-f utf-8 -t utf-8 \
"${DIC_DIR}/user.dic.csv"
